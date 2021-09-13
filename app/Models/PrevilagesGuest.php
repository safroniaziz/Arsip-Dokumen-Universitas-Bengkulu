<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PrevilagesGuest extends Model
{
    use HasFactory;
    protected $fillable = [
        'guest_id','unit_id','waktu_selesai','status'
    ];
}
