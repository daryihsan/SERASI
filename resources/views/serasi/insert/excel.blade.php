@extends('layouts.app')

@section('content')
<div class="container mx-auto max-w-4xl">
    <div class="bg-white p-8 rounded-2xl shadow border border-slate-100">
        
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-green-100 text-green-600 mb-4">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
            </div>
            <h2 class="text-2xl font-bold text-slate-800">Upload Data Excel</h2>
            <p class="text-slate-500 mt-2">Import data recall obat dalam jumlah banyak sekaligus.</p>
        </div>

        <div class="border-2 border-dashed border-slate-300 rounded-xl p-10 text-center hover:bg-slate-50 transition-colors cursor-pointer group">
            <svg class="w-12 h-12 text-slate-400 mx-auto mb-4 group-hover:text-blue-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path></svg>
            <p class="text-slate-600 font-medium">Klik untuk memilih file Excel (.xlsx)</p>
            <p class="text-slate-400 text-sm mt-1">atau tarik file ke sini</p>
        </div>

        <div class="mt-8 flex justify-end gap-3">
            <a href="{{ route('serasi.index') }}" class="px-6 py-2.5 rounded-xl border border-slate-300 text-slate-600 font-semibold hover:bg-slate-50 transition-colors">
                Batal
            </a>
            <button class="px-6 py-2.5 rounded-xl bg-blue-600 text-white font-bold hover:bg-blue-700 transition-colors shadow-lg shadow-blue-200">
                Upload & Proses
            </button>
        </div>

    </div>
</div>
@endsection