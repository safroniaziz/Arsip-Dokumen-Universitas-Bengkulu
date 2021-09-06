<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BerkasKlasifikasi extends Model
{
    use HasFactory;
    protected $fillable = [
        'klasifikasi_id','berkas_id'
    ];
}
