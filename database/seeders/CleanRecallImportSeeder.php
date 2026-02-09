<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\RecallObat;
use Carbon\Carbon;
use Illuminate\Support\Str;

class CleanRecallImportSeeder extends Seeder
{
    public function run(): void
    {
        if (!DB::getSchemaBuilder()->hasTable('drug_recalls')) {
            $this->command->error('Tabel raw "drug_recalls" BELUM ADA! Import file SQL dulu.');
            return;
        }

        $rawData = DB::table('drug_recalls')->get();
        $this->command->info('Memproses split data ' . $rawData->count() . ' baris raw...');

        DB::transaction(function () use ($rawData) {
            foreach ($rawData as $row) {
                // 1. Bersihkan Data Umum
                $cleanTanggal = $this->parseStandardDate($row->tanggal);
                $cleanEd = $this->parseExpiredDate($row->ed);

                // 2. LOGIKA SPLIT BATCH NUMBER
                // Ganti titik koma (;) dan Enter (\n) jadi koma (,) biar seragam
                $betsRaw = str_replace([';', "\n", "\r"], ',', $row->nomor_bets);
                
                // Pecah jadi array berdasarkan koma
                $betsArray = explode(',', $betsRaw);

                // 3. Loop setiap nomor bets yang sudah dipecah
                foreach ($betsArray as $singleBet) {
                    $cleanBet = trim($singleBet); // Hapus spasi depan/belakang

                    // Jika kosong (misal gara-gara "A,,B"), skip
                    if (empty($cleanBet) || $cleanBet == '-') continue;

                    // 4. Simpan Row Baru untuk SETIAP Batch Number
                    RecallObat::create([
                        'no_report'         => $row->no_report,
                        'no_surat'          => $row->no_surat,
                        'tanggal'           => $cleanTanggal,
                        'nama_obat'         => $row->nama_obat,
                        'nie'               => $row->nie,
                        'pemilik_nie'       => $row->pemilik_nie,
                        'pabrik'            => $row->pabrik,
                        'alasan_penarikan'  => $row->alasan_penarikan,
                        'nomor_bets'        => $cleanBet, // <--- Ini yang unik per baris
                        'ed'                => $cleanEd,
                        'created_by'        => null, 
                    ]);
                }
            }
        });

        $count = RecallObat::count();
        $this->command->info("Sukses! Total data bersih sekarang: $count baris (setelah di-split).");
    }

    // --- HELPER FUNCTIONS (Sama seperti sebelumnya) ---

    private function parseStandardDate($value)
    {
        if (empty($value)) return null;
        try {
            if (Str::contains($value, ',')) {
                $parts = explode(',', $value);
                $value = trim(end($parts));
            }
            return Carbon::parse($value)->format('Y-m-d');
        } catch (\Exception $e) { return null; }
    }

    private function parseExpiredDate($value)
    {
        if (empty($value) || $value == '-') return null;
        $value = trim($value);
        $months = [
            'Januari' => 'January', 'Februari' => 'February', 'Maret' => 'March',
            'April' => 'April', 'Mei' => 'May', 'Juni' => 'June',
            'Juli' => 'July', 'Agustus' => 'August', 'September' => 'September',
            'Oktober' => 'October', 'November' => 'November', 'Desember' => 'December',
            'Agst' => 'August', 'Sept' => 'September', 'Okt' => 'October', 'Des' => 'December'
        ];
        foreach ($months as $indo => $eng) {
            if (stripos($value, $indo) !== false) {
                $value = str_ireplace($indo, $eng, $value);
                break;
            }
        }
        try {
            if (preg_match('/^(\d{1,2})\s+(\d{4})$/', $value, $matches)) {
                return Carbon::createFromDate($matches[2], $matches[1], 1)->format('Y-m-d');
            }
            $date = Carbon::parse($value);
            return $date->startOfMonth()->format('Y-m-d');
        } catch (\Exception $e) { return null; }
    }
}