<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{
    public function index()
    {
        $id         = auth()->user()->id;
        $dataUser   = User::find($id);

        return view('frontend/profile', compact('dataUser'));
    }

    public function edit(Request $request)
    {
        $data = $request->all();

        Validator::make($data, [
            'name'         => 'required',
            'email'        => 'required|email|unique:user',
            'password'     => 'required',
            'image'        => 'required|image|mimes:jpg,png|max:2048',
        ]);

        
        $getUser   = User::find($data['id']);

        if ($data['password'] == null) {
            $password = $getUser->password;
        } else {
            $password = Hash::make($data['password']);
        }

        if ($request->image == null) {
            $image = $getUser->picture;
        } else {
            $imageName  = time().'.'.$request->image->extension();
            $image      = $request->image->move(public_path('images'), $imageName);
            $oldImage   = public_path('images', $getUser->picture);
            unlink($oldImage);
        }
        

        User::updateOrCreate(
            [
                'id' => $data['id']
            ],
            [
            'name'      => $data['name'],
            'email'     => $data['email'],
            'password'  => $password,
            'role'      => 1,
            'picture'   => $image,
        ]);

        return redirect('profile')->with('success', 'Anda Berhasil Mengubah profile Anda');
    }
}
