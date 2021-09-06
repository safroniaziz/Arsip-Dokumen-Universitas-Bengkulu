<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Controller;
use App\Models\Unit;
use App\Models\User;
use Illuminate\Http\Request;

class GuestController extends Controller
{
    public function index(){
        $guests = User::join('units','units.id','users.unit_id')
                            ->select('users.id','nm_user','nm_unit','email','status')
                            ->where('level','guest')->orderBy('users.created_at','desc')->get();
        $units = Unit::all();
        return view('administrator/guest.index',compact('guests','units'));
    }

    public function post(Request $request){
        // return $request->all();
        $messages = [
            'required' => ':attribute harus diisi',
            'email' => 'The :attribute harus berisi email yang valid.',
            'numeric' => ':attribute harus angka',
        ];
        $attributes = [
            'nm_user'   =>  'Nama guest',
            'email'    =>  'Email',
            'unit_id'    =>  'Unit',
            'password'    =>  'Password',
            'password_ulangi'    =>  'Password Konfirmasi',
        ];
        $this->validate($request,[
            'nm_user'  =>  'required',
            'email'  =>  'required|email',
            'unit_id'  =>  'required',
            'password'  =>  'required|min:6',
            'password_ulangi'  =>  'required|min:6',
        ],$messages,$attributes);
        User::create([
            'nm_user'   =>  $request->nm_user,
            'email'   =>  $request->email,
            'password'   =>  bcrypt($request->password),
            'unit_id'   =>  $request->unit_id,
            'status'    =>  'aktif',
            'level'    =>  'guest',
        ]);
        $notification = array(
            'message' => 'Berhasil, guest baru berhasil ditambahkan!',
            'alert-type' => 'success'
        );
        return redirect()->route('administrator.guest')->with($notification);
    }

    public function edit($id){
        $guest = User::find($id);
        return $guest;
    }

    public function update(Request $request){
        User::where('id',$request->id)->update([
            'nm_user'   =>  $request->nm_user,
            'email'   =>  $request->email,
            'unit_id'   =>  $request->unit_id_edit,
        ]);
        $notification = array(
            'message' => 'Berhasil, data guest berhasil diubah!',
            'alert-type' => 'success'
        );
        return redirect()->route('administrator.guest')->with($notification);
    }

    public function delete(Request $request){
        User::destroy($request->id);
        $notification = array(
            'message' => 'Berhasil, data guest berhasil dihapus!',
            'alert-type' => 'success'
        );
        return redirect()->route('administrator.guest')->with($notification);
    }

    public function updatePassword(Request $request){
        User::where('id',$request->id)->update([
            'password'  =>  bcrypt($request->password),
        ]);
        $notification = array(
            'message' => 'Berhasil, Password guest berhasil diubah!',
            'alert-type' => 'success'
        );
        return redirect()->route('administrator.guest')->with($notification);
    }

    public function nonaktifkanStatus($id){
        User::where('id',$id)->update([
            'status'    =>  'nonaktif'
        ]);

        $notification = array(
            'message' => 'Berhasil, status guest berhasil dinonaktifkan!',
            'alert-type' => 'success'
        );
        return redirect()->route('administrator.guest')->with($notification);
    }

    public function aktifkanStatus($id){
        User::where('id',$id)->update([
            'status'    =>  'aktif'
        ]);

        $notification = array(
            'message' => 'Berhasil, status guest berhasil diakatifkan!',
            'alert-type' => 'success'
        );
        return redirect()->route('administrator.guest')->with($notification);
    }
}
