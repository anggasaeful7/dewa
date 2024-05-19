<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penduduk extends Model
{
    use HasFactory;

    protected $fillable = [
        'No_KK',
        'NIK',
        'pas_foto', // Add this line
        'Nama_lengkap',
        'Hbg_kel',
        'JK',
        'tmpt_lahir',
        'tgl_lahir',
        'Agama',
        'Pendidikan_terakhir',
        'Jenis_bantuan',
        'Penerima_bantuan',
        'Jenis_bantuan_lain'
    ];
}
