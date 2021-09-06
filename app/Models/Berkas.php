<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Berkas extends Model
{
    use HasFactory;
    protected $fillable = [
        'nomor_berkas','jenis_berkas','klasifikasi_id','file','operator_id','unit_id','uraian_informasi'
    ];
}
