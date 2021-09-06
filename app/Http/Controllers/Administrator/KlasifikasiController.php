<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Controller;
use App\Models\KlasifikasiBerkas;
use Illuminate\Http\Request;

class KlasifikasiController extends Controller
{
    public function index(){
        $klasifikasis = KlasifikasiBerkas::all();
        return view('administrator/klasifikasi.index',compact('klasifikasis'));
    }

    public function post(Request $request){
        $messages = [
            'required' => ':attribute harus diisi',
        ];
        $attributes = [
            'nm_klasifikasi'   =>  'Nama Klasifikasi',
            'keterangan'    =>  'Keterangan',
        ];
        $this->validate($request, [
            'nm_klasifikasi'    =>  'required',
            'keterangan'    =>  'required',
        ],$messages,$attributes);
        $sudah = KlasifikasiBerkas::select('nm_klasifikasi')->get();
        for ($i=0; $i <count($sudah) ; $i++) { 
            if ($request->nm_klasifikasi == $sudah[$i]->nm_klasifikasi) {
                $notification = array(
                    'message' => 'Gagal, nama klasifikasi sudah pernah ditambahkan!',
                    'alert-type' => 'error'
                );
                return redirect()->route('administrator.klasifikasi')->with($notification);
            }
        }
        KlasifikasiBerkas::create([
            'nm_klasifikasi' => $request->nm_klasifikasi,
            'keterangan' => $request->keterangan,
        ]);
        $notification = array(
            'message' => 'Berhasil, nama klasifikasi berhasil ditambahkan!',
            'alert-type' => 'success'
        );
        
        return redirect()->route('administrator.klasifikasi')->with($notification);
    }

    public function edit($id){
        $klasifikasi = KlasifikasiBerkas::find($id);
        return $klasifikasi;
    }

    public function update(Request $request){
        $sudah = KlasifikasiBerkas::select('nm_klasifikasi')->get();
        for ($i=0; $i <count($sudah) ; $i++) { 
            if ($request->nm_klasifikasi == $sudah[$i]->nm_klasifikasi) {
                $notification = array(
                    'message' => 'Gagal, klasifikasi sudah pernah ditambahkan!',
                    'alert-type' => 'error'
                );
                return redirect()->route('administrator.klasifikasi')->with($notification);
            }
        }

        KlasifikasiBerkas::where('id',$request->id)->update([
            'nm_klasifikasi' => $request->nm_klasifikasi,
            'keterangan' => $request->keterangan,
        ]);
        $notification = array(
            'message' => 'Berhasil, klasifikasi berhasil ditambahkan!',
            'alert-type' => 'success'
        );

        return redirect()->route('administrator.klasifikasi')->with($notification);
    }

    public function delete(Request $request){
        $klasifikasi = KlasifikasiBerkas::find($request->id);
        $klasifikasi->delete();
        $notification = array(
            'message' => 'Berhasil, klasifikasi berhasil dihapus!',
            'alert-type' => 'success'
        );

        return redirect()->route('administrator.klasifikasi')->with($notification);
    }
}
