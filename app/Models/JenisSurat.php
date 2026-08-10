<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JenisSurat extends Model
{
    protected $fillable = [
        'nama',
        'kode_surat',
        'form_type',
        'template',
    ];
}

