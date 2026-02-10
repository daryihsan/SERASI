<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Recall;
use App\Models\DetailObat;
use App\Models\DetailKosmetik;
use App\Models\DetailObatTradisional;

use Maatwebsite\Excel\Facades\Excel;
use App\Imports\RecallImport;
use Maatwebsite\Excel\HeadingRowImport;

class InsertController extends Controller
{
    public function manual()
    {
        return view('serasi.insert.manual');
    }

    public function excel()
    {
        return view('serasi.insert.excel');
    }

    public function import(Request $request)
    {
        $request->validate([
            'kategori' => 'required',
            'file'     => 'required|mimes:xlsx,xls,csv'
        ]);

        try {
            // Panggil Class Import, kirim kategori yang dipilih user
            Excel::import(new RecallImport($request->kategori), $request->file('file'));

            return redirect()->route('serasi.index')->with('success', 'Data Excel berhasil diimport!');
        } catch (\Exception $e) {
            return back()->withErrors(['file' => 'Gagal import: ' . $e->getMessage()]);
        }
    }

    private function detectHeaderRow($file)
    {
        // Baca 10 baris pertama saja untuk scanning
        $headings = (new HeadingRowImport)->toArray($file);
        
        // $headings[0] adalah sheet pertama
        foreach ($headings[0] as $rowIndex => $row) {
            // Ubah semua jadi huruf kecil biar pencarian fleksibel
            $rowValues = array_map(fn($val) => strtolower($val ?? ''), $row);

            // Cek apakah baris ini mengandung kata kunci wajib (misal: 'no surat' dan 'nama produk')
            if (in_array('no surat', $rowValues) && in_array('nama produk', $rowValues)) {
                return $rowIndex + 1; // Ditambah 1 karena Excel mulai dari baris 1, Array mulai dari 0
            }
        }

        return 3; 
    }

    public function store(Request $request)
    {
        // 1. Validasi Array
        $request->validate([
            'kategori'             => 'required',
            'no_surat'             => 'required',
            'pabrik_importir'      => 'required',
            // Validasi Array Items
            'items'                => 'required|array|min:1',
            'items.*.nama_produk'  => 'required',
            'items.*.nomor_bets'   => 'required',
        ]);

        DB::transaction(function () use ($request) {
            
            // Loop setiap Item yang diinput user
            foreach ($request->items as $item) {
                
                $detail = null;

                // A. Simpan Detail Anak (Sesuai Kategori)
                if ($request->kategori == 'obat') {
                    $detail = DetailObat::create([
                        'nie' => $item['nie'] ?? null,
                        'ed'  => $item['ed'] ?? null,
                    ]);
                } 
                elseif ($request->kategori == 'kosmetik') {
                    $detail = DetailKosmetik::create([
                        'nomor_notifikasi' => $item['nomor_notifikasi'] ?? null,
                        'tms_penguji'      => $item['tms_penguji'] ?? null,
                    ]);
                }

                elseif ($request->kategori == 'obat_tradisional') {
                    $detail = \App\Models\DetailObatTradisional::create([
                        'nie' => $item['nie'] ?? null,
                        'ed'  => $item['ed'] ?? null,
                    ]);
                }
                // Jika kategori lain, $detail tetap null atau buat model lain

                // B. Simpan Parent (Recall)
                // Data Header (Surat, Pabrik, Alasan) diduplikasi untuk setiap item
                Recall::create([
                    'kategori'         => $request->kategori,
                    'pabrik_importir'  => $request->pabrik_importir, // Header
                    'no_surat'         => $request->no_surat,        // Header
                    'tanggal_surat'    => $request->tanggal_surat,   // Header
                    'alasan_penarikan' => $request->alasan_penarikan,// Header
                    
                    'nama_produk'      => $item['nama_produk'],      // Item Spesifik
                    'nomor_bets'       => $item['nomor_bets'],       // Item Spesifik
                    
                    // Polymorphic Link
                    'detail_type'      => $detail ? get_class($detail) : null,
                    'detail_id'        => $detail ? $detail->id : null,
                ]);
            }
        });

        $count = count($request->items);
        return redirect()->route('serasi.index')->with('success', "Berhasil menyimpan $count data recall sekaligus!");
    }
}