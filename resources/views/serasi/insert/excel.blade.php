@extends('layouts.app')

@section('content')
<div class="container mx-auto max-w-2xl">
    <div class="bg-white p-8 rounded-2xl shadow border border-slate-100">
        
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-green-100 text-green-600 mb-4">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
            </div>
            <h2 class="text-2xl font-bold text-slate-800">Upload Data Excel</h2>
            <p class="text-slate-500 mt-2">Pastikan Excel hanya terdiri dari 1 sheet dan mendata 1 jenis kategori yang sesuai.</p>
        </div>

        @if ($errors->any())
            <div class="mb-6 bg-red-50 text-red-700 p-4 rounded-lg text-sm">
                {{ $errors->first() }}
            </div>
        @endif

        <form action="{{ route('serasi.insert.import') }}" method="POST" enctype="multipart/form-data" x-data="{ fileName: null }">
            @csrf

            <div class="mb-6">
                <label class="block text-sm font-bold text-slate-700 mb-2">Kategori Data Excel Ini</label>
                <select name="kategori" class="w-full border-slate-300 rounded-xl px-4 py-3 bg-slate-50 focus:ring-2 focus:ring-green-500 font-medium">
                    <option value="obat">Obat</option>
                    <option value="obat_tradisional">Obat Tradisional</option>
                    <option value="kosmetik">Kosmetik</option>
                    <option value="pangan">Pangan</option>
                    <option value="suplemen_kesehatan">Suplemen Kesehatan</option>
                </select>
                <p class="text-xs text-slate-400 mt-2">Sistem akan menyesuaikan penyimpanan data berdasarkan kategori ini.</p>
            </div>

            <label class="block mb-6 cursor-pointer">
                <div class="border-2 border-dashed border-slate-300 rounded-xl p-8 text-center hover:bg-slate-50 hover:border-green-400 transition-colors group">
                    <input type="file" name="file" class="hidden" accept=".xlsx, .xls" @change="fileName = $event.target.files[0].name">
                    
                    <svg class="w-12 h-12 text-slate-300 group-hover:text-green-500 mx-auto mb-3 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path></svg>
                    
                    <p class="text-slate-600 font-medium" x-show="!fileName">Klik untuk pilih file Excel (.xlsx)</p>
                    <p class="text-green-600 font-bold break-all" x-show="fileName" x-text="fileName"></p>
                </div>
            </label>

            <div class="flex justify-end gap-3">
                <a href="{{ route('serasi.index') }}" class="px-6 py-3 rounded-xl border border-slate-300 text-slate-600 font-bold hover:bg-slate-50">
                    Batal
                </a>
                <button type="submit" class="px-8 py-3 rounded-xl bg-green-600 text-white font-bold hover:bg-green-700 shadow-lg shadow-green-200 transition-transform hover:-translate-y-1">
                    Upload & Proses
                </button>
            </div>
        </form>
    </div>
</div>
@endsection