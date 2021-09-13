<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function login(Request $request){
        $input = $request->all();
        $messages = [
            'required' => ':attribute harus diisi',
            'email' => ':attribute harus berisi email yang valid.',
        ];
        $attributes = [
            'email'    =>  'Email',
            'password'    =>  'Password',
        ];
        $this->validate($request,[
            'email' =>  'required|email',
            'password' =>  'required',
        ],$messages,$attributes);

        if (auth()->attempt(array('email'   =>  $input['email'], 'password' =>  $input['password'], 'status'    =>  'aktif'))) {
           if (Auth::check()) {
                if (auth()->user()->level == "administrator") {
                    $notification1 = array(
                        'message' => 'Berhasil, akun login sebagai administrator!',
                        'alert-type' => 'success'
                    );
                    return redirect()->route('administrator.dashboard')->with($notification1);;
                }elseif (auth()->user()->level == "operator") {
                    $notification2 = array(
                        'message' => 'Berhasil, akun login sebagai administrator!',
                        'alert-type' => 'success'
                    );
                    return redirect()->route('operator.dashboard')->with($notification2);;
                }elseif (auth()->user()->level == "guest") {
                    $notification2 = array(
                        'message' => 'Berhasil, akun login sebagai administrator!',
                        'alert-type' => 'success'
                    );
                    return redirect()->route('guest.dashboard')->with($notification2);;
                }else {
                    Auth::logout();
                    $notification = array(
                        'message' => 'Gagal, akun anda tidak dikenali!',
                        'alert-type' => 'error'
                    );
                    return redirect()->route('login')->with($notification);
                }
           } else {
                return redirect()->route('login')->with('error','Password salah atau akun sudah tidak aktif');
           }
        }else{
            $notification = array(
                'message' => 'Gagal, Password salah atau akun sudah tidak aktif!',
                'alert-type' => 'error'
            );
            return redirect()->route('login')->with($notification);
        }
    }
}
