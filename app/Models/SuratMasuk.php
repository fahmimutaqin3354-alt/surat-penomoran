<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SuratMasuk extends Model
{
    protected $table = 'surat_masuks';

    protected $fillable = [
        'nomor_surat',
        'asal_surat',
        'perihal',
        'tanggal_surat',
        'lampiran'
    ];
}
