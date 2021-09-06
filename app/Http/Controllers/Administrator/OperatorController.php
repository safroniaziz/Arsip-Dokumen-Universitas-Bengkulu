<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Controller;
use App\Models\Unit;
use App\Models\User;
use Illuminate\Http\Request;

class OperatorController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index(){
        $operators = User::join('units','units.id','users.unit_id')
                            ->select('users.id','nm_user','nm_unit','email','status')
                            ->where('level','operator')->orderBy('users.created_at','desc')->get();
        $units  = Unit::all();
        return view('administrator/operator.index',compact('operators','units'));
    }

    public function post(Request $request){
        $messages = [
            'required' => ':attribute harus diisi',
            'email' => ':attribute harus berisi email yang valid.',
            'numeric' => ':attribute harus angka',
        ];
        $attributes = [
            'nm_user'   =>  'Nama Operator',
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
            'level'    =>  'operator',
        ]);
        $notification = array(
            'message' => 'Berhasil, Operator baru berhasil ditambahkan!',
            'alert-type' => 'success'
        );
        return redirect()->route('administrator.operator')->with($notification);
    }

    public function edit($id){
        $operator = User::find($id);
        return $operator;
    }

    public function update(Request $request){
        User::where('id',$request->id)->update([
            'nm_user'   =>  $request->nm_user,
            'email'   =>  $request->email,
            'unit_id'   =>  $request->unit_id_edit,
        ]);
        $notification = array(
            'message' => 'Berhasil, Password operator berhasil diubah!',
            'alert-type' => 'success'
        );
        return redirect()->route('administrator.operator')->with($notification);
    }

    public function delete(Request $request){
        User::destroy($request->id);
        $notification = array(
            'message' => 'Berhasil, data operator berhasil dihapus!',
            'alert-type' => 'success'
        );
        return redirect()->route('administrator.operator')->with($notification);
    }

    public function updatePassword(Request $request){
        User::where('id',$request->id)->update([
            'password'  =>  bcrypt($request->password),
        ]);
        $notification = array(
            'message' => 'Berhasil, Password operator berhasil diubah!',
            'alert-type' => 'success'
        );
        return redirect()->route('administrator.operator')->with($notification);
    }

    public function nonaktifkanStatus($id){
        User::where('id',$id)->update([
            'status'    =>  'nonaktif'
        ]);

        $notification = array(
            'message' => 'Berhasil, status operator berhasil dinonaktifkan!',
            'alert-type' => 'success'
        );
        return redirect()->route('administrator.operator')->with($notification);
    }

    public function aktifkanStatus($id){
        User::where('id',$id)->update([
            'status'    =>  'aktif'
        ]);

        $notification = array(
            'message' => 'Berhasil, status operator berhasil diakatifkan!',
            'alert-type' => 'success'
        );
        return redirect()->route('administrator.operator')->with($notification);
    }
}
