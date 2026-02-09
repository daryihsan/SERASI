<?php

namespace App\DataTransferObjects;

use Illuminate\Http\Request;

class RecallDto
{
    public function __construct(
        public ?string $noReport,
        public ?string $noSurat,
        public ?string $tanggal,
        public string $namaObat,
        public string $nie,
        public ?string $pemilikNie,
        public ?string $pabrik,
        public ?string $alasanPenarikan,
        public ?string $nomorBets,
        public ?string $ed,
        public ?string $createdBy,
    ) {}

    public static function fromRequest(Request $request): self
    {
        return new self(
            noReport: $request->validated('no_report'),
            noSurat: $request->validated('no_surat'),
            tanggal: $request->validated('tanggal'),
            namaObat: $request->validated('nama_obat'),
            nie: $request->validated('nie'),
            pemilikNie: $request->validated('pemilik_nie'),
            pabrik: $request->validated('pabrik'),
            alasanPenarikan: $request->validated('alasan_penarikan'),
            nomorBets: $request->validated('nomor_bets'),
            ed: $request->validated('ed'),
            createdBy: auth()->id(),
        );
    }

    public function toArray(): array
    {
        return [
            'no_report' => $this->noReport,
            'no_surat' => $this->noSurat,
            'tanggal' => $this->tanggal,
            'nama_obat' => $this->namaObat,
            'nie' => $this->nie,
            'pemilik_nie' => $this->pemilikNie,
            'pabrik' => $this->pabrik,
            'alasan_penarikan' => $this->alasanPenarikan,
            'nomor_bets' => $this->nomorBets,
            'ed' => $this->ed,
            'created_by' => $this->createdBy,
        ];
    }
}