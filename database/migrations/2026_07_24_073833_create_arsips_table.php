<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Jalankan migration.
     */
    public function up(): void
    {
        Schema::create('arsips', function (Blueprint $table) {
            $table->id();
            $table->string('no_surat')->unique();
            $table->enum('jenis', ['masuk', 'keluar']);
            $table->string('judul');
            $table->string('pengirim_penerima');
            $table->date('tanggal_surat');
            $table->year('tahun');
            $table->string('kategori')->nullable();
            $table->string('status')->default('Arsip');
            $table->string('arsip_oleh')->nullable();
            $table->string('lampiran')->nullable();
            $table->timestamps();

            $table->index(['jenis', 'tahun']);
            $table->index('status');
        });
    }

    /**
     * Batalkan migration.
     */
    public function down(): void
    {
        Schema::dropIfExists('arsips');
    }
};