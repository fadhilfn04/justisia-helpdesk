<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PembatalanSertifikat extends Model
{
    use HasFactory;

    protected $table = 'pembatalan_sertifikat';

    protected $fillable = [
        'id_pembatalan',
        'no_sertifikat',
        'pemilik',
        'lokasi',
        'jenis',
        'status',
        'penanggung_jawab',
        'target_selesai',
    ];
}
