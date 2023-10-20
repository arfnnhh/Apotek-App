<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    public function index() {
        if (auth()->check()) {
            return redirect()->route('apotek.home');
        }
        return view('auth.login');
    }

    public function login(Request $request) {
    $request->validate([
        'email' => 'required',
        'password' => 'required'
    ], [
        'email.required' => 'Email tidak boleh kosong',
        'password.required' => 'Password tidak boleh kosong'
    ]);

    $credentials = $request->only('email', 'password');
    if (auth()->attempt($credentials)) {
        return redirect()->route('apotek.home')->with('messageLogin', 'Login Sukses!');
    }

    return redirect()->route('login')->with('loginError', 'Identitas tidak valid');
    }

    public function dashboard() {
        if(Auth::check()){
            return view('apotek.dashboard');
        }
        return redirect()->route('login');
    }

    public function signOut() {
        Session::flush();
        auth()->logout();
        return redirect()->route('login');
    }
}
