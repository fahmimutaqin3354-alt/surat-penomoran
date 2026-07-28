<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class SuratKeluar extends Model
{
    protected $fillable = [
        'nomor_surat',
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
        'user_id',
    ];

    /**
     * Relasi ke User
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
