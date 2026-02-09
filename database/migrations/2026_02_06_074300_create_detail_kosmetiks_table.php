<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('detail_kosmetiks', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->string('nomor_notifikasi')->nullable();
            $table->string('tms_penguji')->nullable(); // Misal: "Positif Merkuri"
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('detail_kosmetiks');
    }
};
