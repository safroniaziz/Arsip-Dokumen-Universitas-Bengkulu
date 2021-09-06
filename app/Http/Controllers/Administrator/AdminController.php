<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index(){
        $admins = User::select('users.id','nm_user','email','status')
                            ->where('level','administrator')->orderBy('users.created_at','desc')->get();
        return view('administrator/admin.index',compact('admins'));
    }

    public function post(Request $request){
        $messages = [
            'required' => ':attribute harus diisi',
            'email' => 'The :attribute harus berisi email yang valid.',
            'numeric' => ':attribute harus angka',
        ];
        $attributes = [
            'nm_user'   =>  'Nama Administrator',
            'email'    =>  'Email',
            'password'    =>  'Password',
            'password_ulangi'    =>  'Password Konfirmasi',
        ];
        $this->validate($request,[
            'nm_user'  =>  'required',
            'email'  =>  'required|email',
            'password'  =>  'required|min:6',
            'password_ulangi'  =>  'required|min:6',
        ],$messages,$attributes);
        User::create([
            'nm_user'   =>  $request->nm_user,
            'email'   =>  $request->email,
            'password'   =>  bcrypt($request->password),
            'status'    =>  'aktif',
            'level'    =>  'administrator',
        ]);
        $notification = array(
            'message' => 'Berhasil, administrator baru berhasil ditambahkan!',
            'alert-type' => 'success'
        );
        return redirect()->route('administrator.admin')->with($notification);
    }

    public function edit($id){
        $administrator = User::find($id);
        return $administrator;
    }

    public function update(Request $request){
        User::where('id',$request->id)->update([
            'nm_user'   =>  $request->nm_user,
            'email'   =>  $request->email,
        ]);
        $notification = array(
            'message' => 'Berhasil, Password administrator berhasil diubah!',
            'alert-type' => 'success'
        );
        return redirect()->route('administrator.admin')->with($notification);
    }

    public function delete(Request $request){
        User::destroy($request->id);
        $notification = array(
            'message' => 'Berhasil, data administrator berhasil dihapus!',
            'alert-type' => 'success'
        );
        return redirect()->route('administrator.admin')->with($notification);
    }

    public function updatePassword(Request $request){
        User::where('id',$request->id)->update([
            'password'  =>  bcrypt($request->password),
        ]);
        $notification = array(
            'message' => 'Berhasil, Password administrator berhasil diubah!',
            'alert-type' => 'success'
        );
        return redirect()->route('administrator.admin')->with($notification);
    }

    public function nonaktifkanStatus($id){
        User::where('id',$id)->update([
            'status'    =>  'nonaktif'
        ]);

        $notification = array(
            'message' => 'Berhasil, status administrator berhasil dinonaktifkan!',
            'alert-type' => 'success'
        );
        return redirect()->route('administrator.admin')->with($notification);
    }

    public function aktifkanStatus($id){
        User::where('id',$id)->update([
            'status'    =>  'aktif'
        ]);

        $notification = array(
            'message' => 'Berhasil, status administrator berhasil diakatifkan!',
            'alert-type' => 'success'
        );
        return redirect()->route('administrator.admin')->with($notification);
    }
}
