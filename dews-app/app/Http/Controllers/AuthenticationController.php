<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Http\Resources\PostResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class AuthenticationController extends Controller
{
    //
    public function login(Request $request){
        $rules = [
            'username'         => 'required',
            'password'      => 'required|min:6',
        ];
        $messages = [
            'username.required'        => 'Username wajib diisi',
            'password.required'     => 'Password wajib diisi',
            'password.min'          => 'Password minimal 6 karakter',
            'password.confirmed'    => 'Password tidak sama dengan konfirmasi password',
        ];
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return new PostResource(false, $validator->errors()->first());
        }
        $credentials = request(['username', 'password']);
        if (!Auth::attempt($credentials)) {
            return new PostResource(false, "username atau password salah");
        }

        $user = User::where('username', $request->username)->first();
        if (!Hash::check($request->password, $user->password, [])) {
            return new PostResource(false, "password anda salah");
        }

        $tokenResult = $user->createToken('D3ws-H4cketh0n')->plainTextToken;

        $data = [
            'access_token' => $tokenResult,
            'token_type' => 'Bearer',
            'user' => $user
        ];
        return new PostResource(true, "login berhasil", $data);
    
    }


   

    

}