<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class loginController extends Controller
{
    public function index(){
        return view('layout.Login', ['title' => 'login']);
    }

    public function authenticate(Request $request){
        $credentials = $request->validate([
            'username' => 'required|min:3',
            'password' => 'required|min:3',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            Alert::success('Login Success!', 'Welcome to Simple!');
            return redirect()->intended(route('beranda'));
        }

        return back()->with('loginError', 'Username atau Password salah!');
    }

    public function logout(Request $request){
        Auth::logout();

        $request->session()->invalidate();
   
        $request->session()->regenerateToken();

        Alert::success('Good Job!', 'Anda berhasil keluar dari sistem!');
        return redirect('/home');
    }
}
