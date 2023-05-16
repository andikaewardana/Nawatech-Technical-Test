<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;
use App\Models\UserVerify;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class LoginController extends Controller
{
    public function index()
    {
        return view('frontend/login');
    }

    public function login(Request $request)
    { 

        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials))
        {
            if (auth()->user()->is_email_verified == 0) {
                return redirect('login')->with('success', 'Email Anda Belum Verified');      
            } else {
                return redirect()->route('home.index');    
            }
        } 
        
        return redirect('login')->with('success', 'Email atau Password anda salah');     
    }

    public function show()
    {
        return view('frontend/register');
    }

    public function register(Request $request)
    {
        $data = $request->all();

        Validator::make($data, [
            'name'         => 'required',
            'email'        => 'required|email|unique:user',
            'password'     => 'required',
            'image'        => 'required|image|mimes:jpg,png|max:2048',
        ]);
        
        $imageName = time().'.'.$request->image->extension();
        $request->image->move(public_path('images'), $imageName);

        $createUser = User::create([
            'name'      => $data['name'],
            'email'     => $data['email'],
            'password'  => Hash::make($data['password']),
            'role'      => 1,
            'picture'   => $imageName,
        ]);

        $token = Str::random(64);
  
        UserVerify::create([
              'user_id' => $createUser->id, 
              'token' => $token
            ]);
  
        Mail::send('email.emailverify', ['token' => $token], function($message) use($request){
              $message->to($request->email);
              $message->subject('Email Verification Mail');
        });

        return redirect('login')->with('success', 'Selamat Anda Berhasil Registrasi, Silahkan Chek Email Untuk Verified');
    }

    public function logout()
    {
        Session::flush();
        Auth::logout();

        return redirect('login');
    }

    public function verifyAccount($token)
    {
        $verifyUser = UserVerify::where('token', $token)->first();
  
        $message = 'Sorry your email cannot be identified.';
  
        if(!is_null($verifyUser) ){
            $user = $verifyUser->user;
              
            if(!$user->is_email_verified) {
                $verifyUser->user->is_email_verified = 1;
                $verifyUser->user->save();
                $message = "Your e-mail is verified. You can now login.";
            } else {
                $message = "Your e-mail is already verified. You can now login.";
            }
        }
  
      return redirect()->route('login.show')->with('message', $message);  
    }
}
