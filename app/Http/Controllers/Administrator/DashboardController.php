<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Controller;
use App\Models\Berkas;
use App\Models\KlasifikasiBerkas;
use App\Models\Unit;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function dashboard(){
        $berkas = count(Berkas::all());
        $klasifikasi = count(KlasifikasiBerkas::where('status','aktif')->get());
        $units = count(Unit::all());
        $users = count(User::where('status','aktif')->get());

        $perUnit = Berkas::join('units','units.id','berkas.unit_id')->select(DB::raw('COUNT(nomor_berkas) as jumlah'),'nm_unit')->groupBy('unit_id')->get();
        $perKlasifikasi = Berkas::join('klasifikasi_berkas','klasifikasi_berkas.id','berkas.klasifikasi_id')->select(DB::raw('COUNT(nomor_berkas) as jumlah'),'nm_klasifikasi')->groupBy('klasifikasi_id')->get();
        return view('administrator/dashboard',compact('berkas','klasifikasi','units','users','perUnit','perKlasifikasi'));
    }
}
