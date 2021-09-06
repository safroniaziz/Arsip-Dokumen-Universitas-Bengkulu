<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Controller;
use App\Models\Berkas;
use App\Models\KlasifikasiBerkas;
use Illuminate\Http\Request;

class BerkasController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index(){
        $berkas = Berkas::join('klasifikasi_berkas','klasifikasi_berkas.id','berkas.klasifikasi_id')
                        ->join('users','users.id','berkas.operator_id')
                        ->join('units','units.id','users.unit_id')
                        ->select('berkas.id as id','berkas.nomor_berkas','jenis_berkas','nm_klasifikasi','berkas.created_at','file','file','nm_user as nm_operator','nm_unit','uraian_informasi')
                        ->orderBy('berkas.id','desc')->get();
        $klasifikasis = KlasifikasiBerkas::all();
        return view('administrator/berkas.index',compact('berkas','klasifikasis'));
    }
}
