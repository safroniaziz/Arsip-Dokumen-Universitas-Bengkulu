<?php

namespace App\Http\Controllers\Operator;

use App\Http\Controllers\Controller;
use App\Models\KlasifikasiBerkas;
use Illuminate\Http\Request;

class AllKlasifikasiController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index(){
        $klasifikasis = KlasifikasiBerkas::orderBy('id','desc')->get();
        return view('operator/klasifikasi.all_klasifikasi',compact('klasifikasis'));
    }
}
