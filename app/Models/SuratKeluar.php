<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class SuratKeluar extends Model
{
    use HasFactory;

    /**
     * Nama tabel yang terhubung.
     */
    protected $table = 'surat_keluars';

    /**
     * Atribut yang dapat diisi secara massal (mass assignable).
     */
    protected $fillable = [
        'nomor_surat',
        'instansi_id',
        'tanggal_surat',
        'jenis_surat',
        'tujuan',
        'perihal',
        'isi_surat',
        'lampiran',
        'penandatangan',
        'jabatan_penandatangan',
        'file_surat',
        'status',
        'surat_masuk_id',
        'user_id',
    ];

    /**
     * Type casting atribut.
     */
    protected $casts = [
        'tanggal_surat' => 'date',
    ];

    /**
     * Relasi ke model User (Pembuat / Pemproses Surat).
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi ke model Instansi (Tujuan / Instansi Terkait).
     */
    public function instansi(): BelongsTo
    {
        return $this->belongsTo(Instansi::class, 'instansi_id');
    }

    /**
     * Relasi ke model SuratMasuk (Jika surat keluar ini merupakan balasan dari surat masuk).
     */
    public function suratMasuk(): BelongsTo
    {
        return $this->belongsTo(SuratMasuk::class, 'surat_masuk_id');
    }

    /**
     * Relasi ke model Arsip.
     */
    public function arsip(): HasOne
    {
        return $this->hasOne(Arsip::class, 'surat_keluar_id');
    }
}