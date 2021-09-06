<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KlasifikasiBerkas extends Model
{
    use HasFactory;
    protected $fillable = [
        'nm_klasifikasi','keterangan','user_id','status'
    ];
}
