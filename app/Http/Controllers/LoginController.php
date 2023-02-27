<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Models\User;

class LoginController extends Controller
{
    public function index()
    {
        return view('login');
    }

    public function prosesLogin(Request $request)
    {  
        if (Auth::attempt(['username'=>$request->username,'password'=>$request->password]))
        {
            if (Auth::User()->jabatan == "Penyidik" && Auth::User()->status == 'Aktif'){
                return \Redirect::to('/penyidik/home');
            }elseif (Auth::User()->jabatan == "Petugas" && Auth::User()->status == 'Aktif'){
                return \Redirect::to('/petugas/home');
            }
            else
            {
                \Session::flash('msg_login','Username Atau Password Salah!');
                return \Redirect::to('/');
            }

        }
        else
        {
            \Session::flash('msg_login','Username Atau Password Salah!');
            return \Redirect::to('/');
        }
    }
}
