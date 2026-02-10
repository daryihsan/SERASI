<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithCalculatedFormulas;
use App\Models\Recall;
use App\Models\DetailObat;
use App\Models\DetailObatTradisional;
use App\Models\DetailKosmetik;
use Carbon\Carbon;

class RecallImport implements ToCollection, WithHeadingRow, WithCalculatedFormulas
{
    protected $kategori;

    // Kita terima kategori dari Controller (Dropdown)
    public function __construct($kategori)
    {
        $this->kategori = $kategori;
    }

    public function headingRow(): int
    {
        return 3;
    }

    public function collection(Collection $rows)
    {
        // Variabel "Sticky" untuk menyimpan data baris sebelumnya (handle merged cells)
        $last_no_surat = null;
        $last_tanggal = null;
        $last_nama_produk = null;
        $last_nie = null;
        $last_pemilik = null;
        $last_pabrik = null;
        $last_alasan = null;
        $last_link = null;

        foreach ($rows as $row) {
            // 1. LOGIKA STICKY (Mengisi data kosong akibat Merge Cell)
            // Jika row kosong, pakai nilai terakhir ($last_...). Jika ada isi, update $last_...
            
            $no_surat = $row['no_surat'] ?? $last_no_surat;
            $last_no_surat = $no_surat;

            // Handle Tanggal Excel (kadang integer, kadang string)
            $raw_tanggal = $row['tanggal'] ?? $last_tanggal;
            $tanggal_surat = $this->transformDate($raw_tanggal);
            $last_tanggal = $raw_tanggal;

            // Nama Produk & NIE kadang di-merge, kadang tidak. Kita asumsikan sticky juga
            $nama_produk = $row['nama_produk'] ?? $last_nama_produk;
            $last_nama_produk = $nama_produk;

            $nie_raw = $row['nie_no_notifikasi'] ?? $last_nie; // Sesuaikan dengan header excel
            $last_nie = $nie_raw;

            $pemilik = $row['pemilik_nie'] ?? $last_pemilik;
            $last_pemilik = $pemilik;

            $pabrik = $row['pabrik_produsen'] ?? $last_pabrik;
            $last_pabrik = $pabrik;

            $alasan = $row['alasan_penarikan'] ?? $last_alasan;
            $last_alasan = $alasan;

            $link_se = $row['link_se'] ?? $last_link;
            $last_link = $link_se;

            // Jika Nama Produk kosong sampai sini, berarti baris kosong total, skip.
            if (!$nama_produk) continue;

            // 2. LOGIKA SPLIT BATCH & ED
            // Format Excel: "1234F/Desember 2026"
            $raw_batch_ed = $row['no_batched'] ?? '';
            $parts = explode('/', $raw_batch_ed);
            
            $nomor_bets = trim($parts[0] ?? '-');
            $ed_string = trim($parts[1] ?? null);
            
            // Konversi ED string ke Date (Y-m-d) sebisa mungkin
            $ed_date = $this->parseED($ed_string);

            // 3. SIMPAN KE DATABASE (POLYMORPHIC)
            
            $detail = null;

            // A. Simpan Anak (Sesuai Kategori Dropdown)
            if ($this->kategori == 'obat') {
                $detail = DetailObat::create([
                    'nie' => $nie_raw,
                    'ed'  => $ed_date,
                ]);
            } 
            elseif ($this->kategori == 'obat_tradisional') {
                $detail = DetailObatTradisional::create([
                    'nie' => $nie_raw,
                    'ed'  => $ed_date,
                ]);
            }
            elseif ($this->kategori == 'kosmetik') {
                // Untuk kosmetik, kolom NIE di excel dianggap No Notifikasi
                // ED Kosmetik biasanya tidak ada/tidak wajib, tapi kalau ada di excel, abaikan atau mapping
                $detail = DetailKosmetik::create([
                    'nomor_notifikasi' => $nie_raw,
                    'tms_penguji'      => $alasan, // Atau kosongkan jika TMS tidak ada di excel
                ]);
            }

            // B. Simpan Parent (Recall)
            Recall::create([
                'kategori'         => $this->kategori,
                'nama_produk'      => $nama_produk,
                'nomor_bets'       => $nomor_bets,
                'pabrik_importir'  => $pabrik ?? $pemilik, // Prioritas Pabrik, fallback Pemilik
                'no_surat'         => $no_surat,
                'tanggal_surat'    => $tanggal_surat,
                'alasan_penarikan' => $alasan,
                'link_file'        => $link_se, // Kolom Link SE
                
                'detail_type'      => $detail ? get_class($detail) : null,
                'detail_id'        => $detail ? $detail->id : null,
            ]);
        }
    }

    // Helper: Mengubah Serial Date Excel ke Y-m-d
    private function transformDate($value)
    {
        try {
            if (is_numeric($value)) {
                return \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($value)->format('Y-m-d');
            }
            // Jika string "1 Januari 2026", coba parse (butuh locale ID)
            return Carbon::parse($value)->format('Y-m-d');
        } catch (\Exception $e) {
            return null;
        }
    }

    // Helper: Parsing ED "Desember 2026" atau "Agustus 2024"
    private function parseED($value)
    {
        if (!$value) return null;
        try {
            // Coba parse bahasa Indonesia sederhana
            $mapBulan = [
                'Januari' => 'January', 'Februari' => 'February', 'Maret' => 'March',
                'April' => 'April', 'Mei' => 'May', 'Juni' => 'June',
                'Juli' => 'July', 'Agustus' => 'August', 'September' => 'September',
                'Oktober' => 'October', 'November' => 'November', 'Desember' => 'December'
            ];
            $value = strtr($value, $mapBulan);
            return Carbon::parse($value)->endOfMonth()->format('Y-m-d'); // Ambil akhir bulan
        } catch (\Exception $e) {
            return null;
        }
    }
}