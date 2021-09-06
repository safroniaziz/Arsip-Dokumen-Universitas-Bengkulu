<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Controller;
use App\Models\Unit;
use Illuminate\Http\Request;

class UnitController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index(){
        $units = Unit::leftJoin('units as unit_induk','unit_induk.id','units.unit_id_induk')
                        ->select('units.id as id','units.nm_unit','unit_induk.nm_unit as nm_unit_induk')
                        ->orderBy('units.id','desc')->get();
        $unit_induks = Unit::all();
        return view('administrator/unit.index',compact('units','unit_induks'));
    }

    public function post(Request $request){
        $messages = [
            'required' => ':attribute harus diisi',
            'numeric' => ':attribute harus angka',
        ];
        $attributes = [
            'nm_unit'   =>  'Nama Unit',
            'unit_id_induk'    =>  'Unit Induk',
        ];
        $this->validate($request, [
            'nm_unit'    =>  'required',
        ],$messages,$attributes);
        $sudah = Unit::select('nm_unit')->get();
        for ($i=0; $i <count($sudah) ; $i++) { 
            if ($request->nm_unit == $sudah[$i]->nm_unit) {
                $notification = array(
                    'message' => 'Gagal, unit sudah pernah ditambahkan!',
                    'alert-type' => 'error'
                );
                return redirect()->route('administrator.unit')->with($notification);
            }
        }
        Unit::create([
            'nm_unit' => $request->nm_unit,
            'unit_id_induk' => $request->unit_id_induk,
        ]);
        $notification = array(
            'message' => 'Berhasil, unit berhasil ditambahkan!',
            'alert-type' => 'success'
        );
        
        return redirect()->route('administrator.unit')->with($notification);
    }

    public function edit($id){
        $unit = Unit::find($id);
        return $unit;
    }

    public function update(Request $request){
        $sudah = Unit::select('nm_unit')->get();
        for ($i=0; $i <count($sudah) ; $i++) { 
            if ($request->nm_unit == $sudah[$i]->nm_unit) {
                $notification = array(
                    'message' => 'Gagal, unit sudah pernah ditambahkan!',
                    'alert-type' => 'error'
                );
                return redirect()->route('administrator.unit')->with($notification);
            }
        }

        Unit::where('id',$request->id)->update([
            'nm_unit' => $request->nm_unit,
            'unit_id_induk' => $request->unit_id_induk,
        ]);
        $notification = array(
            'message' => 'Berhasil, unit berhasil ditambahkan!',
            'alert-type' => 'success'
        );

        return redirect()->route('administrator.unit')->with($notification);
    }

    public function delete(Request $request){
        $unit = Unit::find($request->id);
        $unit->delete();
        $notification = array(
            'message' => 'Berhasil, unit berhasil dihapus!',
            'alert-type' => 'success'
        );

        return redirect()->route('administrator.unit')->with($notification);
    }
}
