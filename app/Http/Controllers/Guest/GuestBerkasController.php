<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use App\Models\Berkas;
use App\Models\PrevilagesGuest;
use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GuestBerkasController extends Controller
{
    public function index(){
        $tgl=date('Y-m-d');
        $hak = PrevilagesGuest::where('guest_id',Auth::user()->id)->select('unit_id')->where('status','aktif')->where('waktu_selesai','<=',$tgl)->pluck('unit_id');
        $units = Unit::select('id','nm_unit')->whereIn('id',$hak)->get();
        $berkas = Berkas::join('klasifikasi_berkas','klasifikasi_berkas.id','berkas.klasifikasi_id')
                        ->join('users','users.id','berkas.operator_id')
                        ->join('units','units.id','berkas.unit_id')
                        ->select('berkas.id as id','berkas.nomor_berkas','nm_klasifikasi','klasifikasi_id','nm_unit',
                                'jenis_berkas','berkas.created_at','file','nm_user as nm_operator','nm_unit','uraian_informasi')
                        ->orderBy('berkas.id','desc')
                        ->whereIn('units.id',$hak)
                        ->get();
        return view('guest/berkas.index',compact('berkas','units'));
    }
}
