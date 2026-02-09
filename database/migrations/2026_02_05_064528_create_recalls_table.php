<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('recalls', function (Blueprint $table) {
            $table->ulid('id')->primary();
            
            // KUNCI POLYMORPHIC:
            // Akan membuat kolom 'detail_type' dan 'detail_id'
            $table->ulidMorphs('detail'); 
            
            // DATA UMUM (Yang semua kategori punya):
            $table->string('kategori')->index(); // 'obat', 'kosmetik', dll
            $table->string('nama_produk')->index();
            $table->string('pabrik_importir')->nullable();
            $table->string('nomor_bets')->nullable();
            
            $table->string('no_surat')->nullable();
            $table->date('tanggal_surat')->nullable();
            $table->text('alasan_penarikan')->nullable();
            $table->string('link_file')->nullable(); // Untuk link PDF surat edaran
            
            $table->foreignUlid('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();
        });
    }
};