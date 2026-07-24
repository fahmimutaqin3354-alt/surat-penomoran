<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
{
    Schema::create('surat_keluars', function (Blueprint $table) {
        $table->id();

        $table->string('nomor_surat')->unique();
        $table->date('tanggal_surat');

        $table->string('tujuan');
        $table->string('perihal');

        $table->text('isi_surat')->nullable();

        $table->string('file_surat')->nullable();

        $table->enum('status', [
            'Draft',
            'Dikirim',
            'Selesai'
        ])->default('Draft');

        $table->foreignId('user_id')
              ->constrained()
              ->cascadeOnDelete();

        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('surat_keluars');
    }
};
