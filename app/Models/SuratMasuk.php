<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SuratMasuk extends Model
{
    protected $fillable = [
        'nomor_agenda',
        'nomor_surat',
        'tanggal_surat',
        'tanggal_terima',
        'asal_surat',
        'jenis_surat',
        'perihal',
        'isi_ringkas',
        'lampiran',
        'file_surat',
        'keterangan',
        'status',
        'user_id'
    ];

    /**
     * Relasi ke User (Admin yang menginput surat)
     */
public function user(): BelongsTo
{
    return $this->belongsTo(User::class);
}

public function suratKeluars(): HasMany
{
    return $this->hasMany(SuratKeluar::class);
}
}
