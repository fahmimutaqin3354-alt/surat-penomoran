<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Arsip extends Model
{
    protected $table = 'arsips';

    protected $fillable = [
        'no_surat',
        'jenis',
        'judul',
        'pengirim_penerima',
        'tanggal_surat',
        'tahun',
        'kategori',
        'status',
        'arsip_oleh',
        'lampiran',
    ];

    protected $casts = [
        'tanggal_surat' => 'date',
    ];
}