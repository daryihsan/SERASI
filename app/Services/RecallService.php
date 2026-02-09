<?php

namespace App\Services;

use App\Models\DrugRecall;
use App\DataTransferObjects\RecallDto;
use Illuminate\Support\Facades\DB;
use Exception;

class RecallService
{
    public function search(string $keyword)
    {
        return DrugRecall::query()
            ->where('nama_obat', 'LIKE', "%{$keyword}%")
            ->orWhere('nie', 'LIKE', "%{$keyword}%")
            ->orWhere('no_bets', 'LIKE', "%{$keyword}%")
            ->latest()
            ->paginate(10);
    }

    public function store(RecallDto $dto): DrugRecall
    {
        return DB::transaction(function () use ($dto) {
            return DrugRecall::create($dto->toArray());
        });
    }

    /**
     * Fitur Import Excel (Menggunakan Maatwebsite/Excel)
     * Mengacu logika batch process namun disederhanakan
     */
    public function importExcel($filePath)
    {
        // Gunakan library maatwebsite/excel
        // Logic mapping row excel ke DTO lalu save
    }
}