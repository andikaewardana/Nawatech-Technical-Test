<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;



class LoginController extends Controller
{
    public function index()
    {
        return view('auth/login');
    }

    public function login(Request $request)
    {

        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials))
        {
            return redirect()->route('product.index');
           
        } 
            return redirect('admin')->with('success', 'Email atau Password anda salah');     
    }

    public function logout()
    {
        Session::flush();
        
        Auth::logout();

        return redirect('admin');
    }
}
