<?php

namespace App\Http\Controllers;

use App\Models\Recall;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;

class RecallController extends Controller
{
    public function index(Request $request)
    {
        $query = Recall::query()->with('detail');

        // 1. LOGIKA FILTER KATEGORI (BARU)
        if ($request->has('kategori') && $request->kategori != '') {
            $query->where('kategori', $request->kategori);
        }

        // 2. LOGIKA PENCARIAN (EXISTING)
        if ($request->has('q') && $request->q != '') {
            $keyword = $request->q;
            
            $query->where(function ($q) use ($keyword) {
                $q->where('nama_produk', 'LIKE', "%{$keyword}%")
                  ->orWhere('nomor_bets', 'LIKE', "%{$keyword}%")
                  ->orWhere('pabrik_importir', 'LIKE', "%{$keyword}%")
                  ->orWhere('alasan_penarikan', 'LIKE', "%{$keyword}%");

                $q->orWhereHasMorph(
                    'detail', 
                    ['App\Models\DetailObat', 'App\Models\DetailKosmetik'],
                    function (Builder $childQuery, $type) use ($keyword) {
                        if ($type === 'App\Models\DetailObat') {
                            $childQuery->where('nie', 'LIKE', "%{$keyword}%");
                        }
                        if ($type === 'App\Models\DetailKosmetik') {
                            $childQuery->where('nomor_notifikasi', 'LIKE', "%{$keyword}%");
                        }
                    }
                );
            });
        }

        $recalls = $query->latest()->paginate(10);

        // Append query string agar saat pindah halaman (pagination), filter tetap terbawa
        $recalls->appends($request->all());

        return view('serasi.index', compact('recalls'));
    }
}