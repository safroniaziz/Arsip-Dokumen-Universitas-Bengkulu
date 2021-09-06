<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Controller;
use App\Models\Berkas;
use App\Models\KlasifikasiBerkas;
use Illuminate\Http\Request;

class BerkasController extends Controller
{
    public function index(){
        $berkas = Berkas::join('klasifikasi_berkas','klasifikasi_berkas.id','berkas.klasifikasi_id')
                        ->join('users','users.id','berkas.operator_id')
                        ->join('units','units.id','users.unit_id')
                        ->select('berkas.id as id','berkas.nomor_berkas','jenis_berkas','nm_klasifikasi','berkas.created_at','file','file','nm_user as nm_operator','nm_unit','uraian_informasi')
                        ->orderBy('berkas.id','desc')->get();
        $klasifikasis = KlasifikasiBerkas::all();
        return view('administrator/berkas.index',compact('berkas','klasifikasis'));
    }

    public function post(Request $request){
        $messages = [
            'required' => ':attribute harus diisi',
            'numeric' => ':attribute harus angka',
        ];
        $attributes = [
            'nm_berkas'   =>  'Nama berkas',
            'berkas_id_induk'    =>  'berkas Induk',
        ];
        $this->validate($request, [
            'nm_berkas'    =>  'required',
        ],$messages,$attributes);
        $sudah = Berkas::select('nm_berkas')->get();
        for ($i=0; $i <count($sudah) ; $i++) { 
            if ($request->nm_berkas == $sudah[$i]->nm_berkas) {
                $notification = array(
                    'message' => 'Gagal, berkas sudah pernah ditambahkan!',
                    'alert-type' => 'error'
                );
                return redirect()->route('administrator.berkas')->with($notification);
            }
        }
        Berkas::create([
            'nm_berkas' => $request->nm_berkas,
            'berkas_id_induk' => $request->berkas_id_induk,
        ]);
        $notification = array(
            'message' => 'Berhasil, berkas berhasil ditambahkan!',
            'alert-type' => 'success'
        );
        
        return redirect()->route('administrator.berkas')->with($notification);
    }

    public function edit($id){
        $berkas = Berkas::find($id);
        return $berkas;
    }

    public function update(Request $request){
        $sudah = Berkas::select('nm_berkas')->get();
        for ($i=0; $i <count($sudah) ; $i++) { 
            if ($request->nm_berkas == $sudah[$i]->nm_berkas) {
                $notification = array(
                    'message' => 'Gagal, berkas sudah pernah ditambahkan!',
                    'alert-type' => 'error'
                );
                return redirect()->route('administrator.berkas')->with($notification);
            }
        }

        Berkas::where('id',$request->id)->update([
            'nm_berkas' => $request->nm_berkas,
            'berkas_id_induk' => $request->berkas_id_induk,
        ]);
        $notification = array(
            'message' => 'Berhasil, berkas berhasil ditambahkan!',
            'alert-type' => 'success'
        );

        return redirect()->route('administrator.berkas')->with($notification);
    }

    public function delete(Request $request){
        $berkas = Berkas::find($request->id);
        $berkas->delete();
        $notification = array(
            'message' => 'Berhasil, berkas berhasil dihapus!',
            'alert-type' => 'success'
        );

        return redirect()->route('administrator.berkas')->with($notification);
    }
}
