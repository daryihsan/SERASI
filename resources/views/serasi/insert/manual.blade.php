@extends('layouts.app')

@section('content')
<div class="container mx-auto max-w-5xl">
    <div class="bg-white p-8 rounded-2xl shadow border border-slate-100">
        
        <h2 class="text-2xl font-bold mb-6 text-slate-800">Input Data Recall (Multi-Item)</h2>

        @if ($errors->any())
            <div class="mb-6 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg relative">
                <strong class="font-bold">Gagal Menyimpan!</strong>
                <ul class="mt-2 list-disc list-inside text-sm">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('serasi.insert.store') }}" method="POST" 
              x-data="recallForm()">
            @csrf

            <div class="bg-slate-50 p-6 rounded-2xl border border-slate-200 mb-8">
                <h3 class="text-sm font-bold text-slate-500 uppercase tracking-wider mb-4 border-b border-slate-200 pb-2">
                    1. Data Surat & Pabrik (Header)
                </h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-5">
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Kategori Produk</label>
                        <select name="kategori" x-model="kategori" class="w-full border-slate-300 rounded-xl px-4 py-3 bg-white focus:ring-2 focus:ring-blue-500 font-medium">
                            <option value="obat">Obat</option>
                            <option value="obat_tradisional">Obat Tradisional</option>
                            <option value="kosmetik">Kosmetik</option>
                            <option value="suplemen_kesehatan">Suplemen Kesehatan</option>
                            <option value="pangan">Pangan</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Pabrik / Importir</label>
                        <input type="text" name="pabrik_importir" class="w-full border-slate-300 rounded-xl px-4 py-3 bg-white focus:ring-2 focus:ring-blue-500" placeholder="Nama perusahaan..." required>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-5">
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Nomor Surat Edaran</label>
                        <input type="text" name="no_surat" class="w-full border-slate-300 rounded-xl px-4 py-3 bg-white focus:ring-2 focus:ring-blue-500" placeholder="Nomor surat resmi..." required>
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Tanggal Surat</label>
                        <input type="date" name="tanggal_surat" class="w-full border-slate-300 rounded-xl px-4 py-3 bg-white focus:ring-2 focus:ring-blue-500">
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Alasan Penarikan (Berlaku untuk semua item)</label>
                    <textarea name="alasan_penarikan" rows="3" class="w-full border-slate-300 rounded-xl px-4 py-3 bg-white focus:ring-2 focus:ring-blue-500" placeholder="Jelaskan alasan umum penarikan..."></textarea>
                </div>
            </div>

            <div class="mb-8">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-sm font-bold text-slate-500 uppercase tracking-wider">
                        2. Daftar Item Produk
                    </h3>
                    <button type="button" @click="addItem()" class="text-sm font-bold text-blue-600 hover:text-blue-800 flex items-center gap-1">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                        Tambah Baris
                    </button>
                </div>

                <div class="space-y-4">
                    <template x-for="(item, index) in items" :key="item.id">
                        <div class="bg-white border border-slate-300 rounded-xl p-5 relative group hover:border-blue-400 transition-colors shadow-sm">
                            
                            <div class="absolute -left-3 -top-3 bg-slate-800 text-white text-xs font-bold w-6 h-6 flex items-center justify-center rounded-full shadow" x-text="index + 1"></div>
                            
                            <button type="button" @click="removeItem(index)" x-show="items.length > 1" class="absolute top-4 right-4 text-slate-300 hover:text-red-500 transition-colors" title="Hapus Baris Ini">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                            </button>

                            <div class="grid grid-cols-1 md:grid-cols-12 gap-4">
                                
                                <div class="md:col-span-4">
                                    <label class="block text-xs font-bold text-slate-500 mb-1">Nama Produk *</label>
                                    <input type="text" :name="`items[${index}][nama_produk]`" class="w-full border-slate-300 rounded-lg px-3 py-2 text-sm focus:ring-blue-500" required placeholder="Nama item...">
                                </div>

                                <div class="md:col-span-3">
                                    <label class="block text-xs font-bold text-slate-500 mb-1">No. Batch *</label>
                                    <input type="text" :name="`items[${index}][nomor_bets]`" class="w-full border-slate-300 rounded-lg px-3 py-2 text-sm focus:ring-blue-500 font-mono" required placeholder="Batch No...">
                                </div>

                                <template x-if="kategori === 'obat'">
                                    <div class="md:col-span-5 grid grid-cols-2 gap-4">
                                        <div>
                                            <label class="block text-xs font-bold text-blue-600 mb-1">Nomor NIE</label>
                                            <input type="text" :name="`items[${index}][nie]`" class="w-full border-blue-200 bg-blue-50 rounded-lg px-3 py-2 text-sm focus:ring-blue-500" placeholder="DKL...">
                                        </div>
                                        <div>
                                            <label class="block text-xs font-bold text-blue-600 mb-1">Exp. Date</label>
                                            <input type="date" :name="`items[${index}][ed]`" class="w-full border-blue-200 bg-blue-50 rounded-lg px-3 py-2 text-sm focus:ring-blue-500">
                                        </div>
                                    </div>
                                </template>

                                <template x-if="kategori === 'kosmetik'">
                                    <div class="md:col-span-5 grid grid-cols-2 gap-4">
                                        <div>
                                            <label class="block text-xs font-bold text-pink-600 mb-1">No. Notifikasi</label>
                                            <input type="text" :name="`items[${index}][nomor_notifikasi]`" class="w-full border-pink-200 bg-pink-50 rounded-lg px-3 py-2 text-sm focus:ring-pink-500" placeholder="NA...">
                                        </div>
                                        <div>
                                            <label class="block text-xs font-bold text-pink-600 mb-1">TMS Penguji</label>
                                            <input type="text" :name="`items[${index}][tms_penguji]`" class="w-full border-pink-200 bg-pink-50 rounded-lg px-3 py-2 text-sm focus:ring-pink-500" placeholder="Parameter...">
                                        </div>
                                    </div>
                                </template>
                                
                                <template x-if="!['obat', 'kosmetik'].includes(kategori)">
                                     <div class="md:col-span-5">
                                        <div class="p-2 bg-slate-100 rounded text-xs text-slate-400 italic text-center mt-4">
                                            Detail spesifik untuk kategori ini belum diset.
                                        </div>
                                     </div>
                                </template>

                            </div>
                        </div>
                    </template>
                </div>
                
                <button type="button" @click="addItem()" class="w-full mt-4 py-3 border-2 border-dashed border-slate-300 rounded-xl text-slate-500 font-bold hover:border-blue-500 hover:text-blue-600 transition-colors flex items-center justify-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    Tambah Item Lain
                </button>
            </div>

            <div class="flex justify-end pt-6 border-t border-slate-100">
                <button type="submit" class="bg-blue-600 text-white font-bold py-3 px-8 rounded-xl hover:bg-blue-700 shadow-lg shadow-blue-200 transition-all transform hover:-translate-y-1 w-full md:w-auto">
                    Simpan Semua Data (<span x-text="items.length"></span> Item)
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function recallForm() {
        return {
            kategori: 'obat',
            items: [
                { id: Date.now() } // Baris pertama default
            ],
            addItem() {
                this.items.push({ id: Date.now() + Math.random() });
            },
            removeItem(index) {
                this.items.splice(index, 1);
            }
        }
    }
</script>
@endsection