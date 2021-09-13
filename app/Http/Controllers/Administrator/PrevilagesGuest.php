<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Controller;
use App\Models\PrevilagesGuest as ModelsPrevilagesGuest;
use App\Models\Unit;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class PrevilagesGuest extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index(){
        $guests = User::where('level','guest')
                        ->select('id','nm_user','email','status')
                        ->get();
        return view('administrator/hak.index',compact('guests'));
    }

    public function detail($id){
        $guest = User::find($id);
        $details = ModelsPrevilagesGuest::join('users','users.id','previlages_guests.guest_id')
                                        ->join('units','units.id','previlages_guests.unit_id')
                                        ->select('previlages_guests.id','nm_user','nm_unit','previlages_guests.status','waktu_selesai')
                                        ->where('users.id',$id)
                                        ->get();
        return view('administrator/hak.detail',compact('guest','details','id'));
    }

    public function add($id){
        $guest = User::find($id);
        $sudah = ModelsPrevilagesGuest::select('unit_id')->where('guest_id',$id)->where('status','aktif')->pluck('unit_id');
        $units = Unit::select('id','nm_unit')->whereNotIn('id',$sudah)->get();
        return view('administrator/hak.add',compact('id','units','guest'));
    }

    public function post(Request $request){
        $messages = [
            'required' => ':attribute harus diisi',
        ];
        $attributes = [
            'unit_id'   =>  'Unit',
            'waktu_selesai'    =>  'Waktu Selesai',
        ];
        $this->validate($request, [
            'unit_id'    =>  'required',
            'waktu_selesai'    =>  'required',
        ],$messages,$attributes);

        ModelsPrevilagesGuest::create([
            'unit_id' => $request->unit_id,
            'guest_id' => $request->guest_id,
            'waktu_selesai' => $request->waktu_selesai,
            'status'        =>  'aktif',
        ]);

        $notification = array(
            'message' => 'Berhasil, previlage berhasil ditambahkan!',
            'alert-type' => 'success'
        );
        
        return redirect()->route('administrator.hak.detail',[$request->guest_id])->with($notification);
    }

    public function nonaktifkanStatus($id,$id_guest){
        ModelsPrevilagesGuest::where('id',$id)->update([
            'status'    =>  'nonaktif'
        ]);

        $notification = array(
            'message' => 'Berhasil, previlage berhasil dinonaktifkan!',
            'alert-type' => 'success'
        );
        return redirect()->route('administrator.hak.detail',[$id_guest])->with($notification);
    }

    public function delete($id,$id_guest){
        ModelsPrevilagesGuest::destroy($id);
        $notification = array(
            'message' => 'Berhasil, previlage berhasil dihapus!',
            'alert-type' => 'success'
        );
        return redirect()->route('administrator.hak.detail',[$id_guest])->with($notification);
    }
}
