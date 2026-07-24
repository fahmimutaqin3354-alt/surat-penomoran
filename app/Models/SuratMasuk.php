<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SuratMasuk extends Model
{
    protected $fillable=[
        'nomor_agenda',
        'tanggal_terima',
        'tanggal_surat',
        'nomor_surat',
        'pengirim',
        'perihal',
        'isi_ringkas',
        'file_surat',
        'status',
        'user_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
