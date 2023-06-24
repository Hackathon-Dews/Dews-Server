<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Http\Resources\PostResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

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

    public function register(Request $request)
    {
        $rules = [
            'username' => 'required|unique:users',
            'name' => 'required|min:4|max:32',
            'password' => 'required|min:6|confirmed',
            'roles_id' => 'required',

        ];

        $messages = [
            'username.required'        => 'Email wajib diisi',
            'username.unique'          => 'Email sudah terdaftar',
            'name.required' => 'Nama Lengkap wajib diisi',
            'name.min'      => 'Nama lengkap minimal 4 karakter',
            'name.max'      => 'Nama lengkap maksimal 32 karakter',
            'password.required'     => 'Password wajib diisi',
            'password.min'          => 'Password minimal 6 karakter',
            'password.confirmed'    => 'Password tidak sama dengan konfirmasi password',
            'roles_id.required'     => 'Roles tidak tersedia',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return new PostResource(false, $validator->errors()->first());
        }
        $data = [
            'username' => strtolower($request->username),
            'name' => strtolower($request->name),
            'password' => Hash::make($request->password),
            'roles_id' => $request->roles_id,
        ];
        try {
            $user = User::create($data);
            return new PostResource(true, "User berhasil teregistrasi", $user);
        } catch (\Throwable $th) {
            return new PostResource(false, $th->getMessage());
        }
    }

    public function logout(Request $request){
        try {
            $user = $request->user();
            $user->tokens()->where('id', $user->id)->delete();
            $request->user()->currentAccessToken()->delete();
            return new PostResource(true, "logout berhasil", $user);
        } catch (\Throwable $th) {
            return new PostResource(false, "logout gagal");
        }
    }
    
     public function changePassword(Request $request){
        try {
            if(Auth::check()){
                $rules = [
                    'password'      => 'required|min:6',
                ];
                $messages = [
                    'password.required'     => 'Password wajib diisi',
                    'password.min'          => 'Password minimal 6 karakter',
                ];
                $validator = Validator::make($request->all(), $rules, $messages);
                if ($validator->fails()) {
                    return new PostResource(false, $validator->errors()->first());
                }
                $user = $request->user();
                $user = User::where('id',$user->id)->first();
                try {
                $user->update([
                    'password' => Hash::make($request->password)
                ]);
                return new PostResource(true, "Password Berhasil diperbarui");
                } catch (\Throwable $th) {
                    return new PostResource(false, "Password Gagal diperbarui");
                }
            }
        } catch (\Throwable $th) {
            return new PostResource(false,"unauthenticated");
        }
    }




}