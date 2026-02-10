@extends('layouts.app')

@section('content')
<div x-data="{ search: '{{ request('q') }}', isLoading: false }" class="container mx-auto max-w-6xl">
    
    <div class="flex flex-col items-center justify-center text-center mb-10">
        <h1 class="text-4xl font-extrabold text-slate-900 tracking-tight">Surat Edaran Recall Terintegrasi</h1>
        <p class="text-slate-500 mt-3 text-lg max-w-2xl">
            Cari dan validasi data produk yang ditarik dari peredaran.
        </p>
        <div class="mt-4 inline-flex items-center gap-2 bg-blue-50 px-4 py-1.5 rounded-full border border-blue-100">
            <span class="text-xs font-bold text-blue-400 uppercase tracking-wider">Total Data</span>
            <span class="text-sm font-bold text-blue-700">{{ $recalls->total() }} Laporan</span>
        </div>
    </div>

    <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200 mb-8">
        <form action="{{ route('serasi.index') }}" method="GET" @submit="isLoading = true">
            
            <div class="flex flex-col md:flex-row gap-4 items-stretch">
                
                <div class="relative w-full md:w-1/4 min-w-[200px]">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path></svg>
                    </div>
                    <select name="kategori" class="block w-full pl-11 pr-8 py-4 bg-slate-50 border border-slate-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all text-slate-700 font-medium h-14 appearance-none cursor-pointer hover:bg-slate-100">
                        <option value="">-- Semua Kategori --</option>
                        <option value="obat" {{ request('kategori') == 'obat' ? 'selected' : '' }}>Obat</option>
                        <option value="obat_tradisional" {{ request('kategori') == 'obat_tradisional' ? 'selected' : '' }}>Obat Tradisional</option>
                        <option value="kosmetik" {{ request('kategori') == 'kosmetik' ? 'selected' : '' }}>Kosmetik</option>
                        <option value="suplemen_kesehatan" {{ request('kategori') == 'suplemen_kesehatan' ? 'selected' : '' }}>Suplemen Kesehatan</option>
                        <option value="pangan" {{ request('kategori') == 'pangan' ? 'selected' : '' }}>Pangan</option>
                    </select>
                    <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </div>
                </div>

                <div class="relative flex-grow">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <svg class="w-6 h-6 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </div>
                    <input 
                        type="text" 
                        name="q" 
                        value="{{ request('q') }}" 
                        class="block w-full pl-12 pr-4 py-4 bg-slate-50 border border-slate-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all text-lg placeholder-slate-400 h-14" 
                        placeholder="Cari Nama Produk, Bets, atau NIE..."
                    >
                </div>

                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold text-lg px-8 rounded-xl transition-colors shadow-lg shadow-blue-200 flex items-center justify-center gap-2 shrink-0 h-14 min-w-[140px]" :disabled="isLoading">
                    <span x-show="!isLoading">Cari</span>
                    <span x-show="isLoading" x-cloak class="flex items-center gap-2">
                        <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                        ...
                    </span>
                </button>
            </div>
        </form>
    </div>

    <div class="space-y-4">
        @forelse($recalls as $item)
            <div class="bg-white rounded-xl p-6 border border-slate-100 shadow-sm hover:shadow-md transition-shadow group hover:border-blue-300 duration-300">
                <div class="flex flex-col md:flex-row justify-between items-start gap-4">
                    
                    <div class="flex-1">
                        <div class="flex items-center gap-2 mb-2">
                            @if($item->kategori == 'obat')
                                <span class="bg-blue-100 text-blue-700 text-xs font-bold px-2 py-1 rounded uppercase tracking-wide">Obat</span>
                            @elseif($item->kategori == 'obat_tradisional')
                                <span class="bg-emerald-100 text-emerald-700 text-xs font-bold px-2 py-1 rounded uppercase tracking-wide">Obat Tradisional</span>
                            @elseif($item->kategori == 'kosmetik')
                                <span class="bg-pink-100 text-pink-700 text-xs font-bold px-2 py-1 rounded uppercase tracking-wide">Kosmetik</span>
                            @elseif($item->kategori == 'suplemen_kesehatan')
                                <span class="bg-purple-100 text-purple-700 text-xs font-bold px-2 py-1 rounded uppercase tracking-wide">Suplemen</span>
                            @elseif($item->kategori == 'pangan')
                                <span class="bg-orange-100 text-orange-700 text-xs font-bold px-2 py-1 rounded uppercase tracking-wide">Pangan</span>
                            @else
                                <span class="bg-slate-100 text-slate-700 text-xs font-bold px-2 py-1 rounded uppercase tracking-wide">{{ $item->kategori }}</span>
                            @endif

                            <span class="text-slate-400 text-sm font-medium flex items-center gap-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                {{ $item->tanggal_surat ? \Carbon\Carbon::parse($item->tanggal_surat)->format('d M Y') : '-' }}
                            </span>
                        </div>
                        
                        <h3 class="text-xl font-bold text-slate-800 group-hover:text-blue-700 transition-colors">
                            {{ $item->nama_produk }}
                        </h3>
                        <p class="text-slate-500 font-medium mt-1">{{ $item->pabrik_importir }}</p>
                        
                        <div class="mt-4 flex flex-wrap gap-6 text-sm">
                            
                            @if(in_array($item->kategori, ['obat', 'obat_tradisional', 'pangan', 'suplemen_kesehatan']) && $item->detail)
                                <div class="bg-slate-50 px-3 py-2 rounded-lg border border-slate-100">
                                    <span class="block text-slate-400 text-xs uppercase font-bold tracking-wider mb-1">Nomor NIE</span>
                                    <span class="font-mono text-slate-700 font-semibold">{{ $item->detail->nie ?? '-' }}</span>
                                </div>
                            @endif

                            @if($item->kategori == 'kosmetik' && $item->detail)
                                <div class="bg-pink-50 px-3 py-2 rounded-lg border border-pink-100">
                                    <span class="block text-pink-400 text-xs uppercase font-bold tracking-wider mb-1">No Notifikasi</span>
                                    <span class="font-mono text-pink-700 font-semibold">{{ $item->detail->nomor_notifikasi ?? '-' }}</span>
                                </div>
                            @endif

                            <div class="bg-blue-50 px-3 py-2 rounded-lg border border-blue-100">
                                <span class="block text-blue-400 text-xs uppercase font-bold tracking-wider mb-1">Nomor Bets</span>
                                <span class="font-mono font-bold text-blue-700">{{ $item->nomor_bets ?? '-' }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="w-full md:w-auto mt-4 md:mt-0 md:text-right border-t md:border-t-0 border-slate-100 pt-4 md:pt-0">
                        
                        @if(in_array($item->kategori, ['obat', 'obat_tradisional', 'pangan', 'suplemen_kesehatan']) && $item->detail && $item->detail->ed)
                            <span class="block text-slate-400 text-xs uppercase font-bold mb-1">Expired Date</span>
                            <div class="text-lg font-bold text-slate-800 bg-red-50 text-red-600 px-3 py-1 rounded inline-block">
                                {{ \Carbon\Carbon::parse($item->detail->ed)->format('M Y') }}
                            </div>
                        @endif

                        @if($item->kategori == 'kosmetik' && $item->detail && $item->detail->tms_penguji)
                            <span class="block text-slate-400 text-xs uppercase font-bold mb-1">Temuan TMS</span>
                            <div class="text-sm font-bold text-pink-700 bg-pink-50 px-3 py-1 rounded inline-block max-w-[200px] truncate">
                                {{ $item->detail->tms_penguji }}
                            </div>
                        @endif

                    </div>
                </div>
                
                <div class="mt-5 pt-4 border-t border-slate-100 text-sm text-slate-600">
                    <span class="font-bold text-slate-700 block mb-1">Alasan Penarikan:</span> 
                    <p class="leading-relaxed">{{ Str::limit($item->alasan_penarikan, 200) }}</p>
                </div>
            </div>
        @empty
            <div class="text-center py-16 bg-white rounded-2xl border border-dashed border-slate-300">
                <h3 class="text-xl font-bold text-slate-900 mb-2">Data tidak ditemukan</h3>
                <p class="text-slate-500">Belum ada data recall yang tersimpan sesuai kriteria pencarian.</p>
            </div>
        @endforelse
    </div>

    <div class="mt-10 mb-20">
        {{ $recalls->withQueryString()->links() }}
    </div>
</div>
@endsection