<?php

namespace App\Http\Controllers;

use App\Models\UserHistory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\Auth; 
use Illuminate\Support\Facades\Validator;

class UserHistoryController extends Controller
{
    
    public function getUserHistory($id = null){
        try {
            if (isset($id)) {
                $data = UserHistory::where('id', $id)->first();
            } else {
                $data = UserHistory::all();
            }
            return new PostResource(true, "data History Pengguna ditemukan", $data);
        } catch (\Throwable $th) {
            return new PostResource(false, "data History Pengguna tidak ada");
        }
    }

    public function getHistoryByUserId($id){
        try {
            $data = UserHistory::where('user_id', $id)->get();

            return new PostResource(true, "data History Pengguna ditemukan", $data);
        } catch (\Throwable $th) {
            return new PostResource(false, "data History Pengguna tidak ada");
        }
    }
 
    public function addUserHistory(Request $request)
    {

        if (!Auth::check()) {
            return new PostResource(false, "unauthenticated");
        }
        try {
            $rules = [
                'user_id' => 'required',
                'text' => 'required'
            ];

            $validation = Validator::make($request->all(), $rules);
            if ($validation->fails()) {
                return new PostResource(false, "User History gagal ditambahkan", $validation->errors()->all());
            }


            $petugas = User::where('id', $request->user_id)->first();
            if ($petugas == null) {
                return new PostResource(false, "User Tidak ditemukan");
            }

            $data = [
                'user_id' => $request->user_id,
                'text' => $request->text
            ];
            $userHistory = UserHistory::create($data);

            return new PostResource(true, "User History berhasil ditambahkan", $userHistory);
        } catch (\Throwable $th) {
            return new PostResource(false, "User History gagal ditambahkan");
        }
    }
    
    public function deleteUserHistory(Request $request)
    {
        if (!Auth::check()) {
            return new PostResource(false, "unauthenticated");
        }

        try {
            $userHistory = UserHistory::where('id', $request->id_history)->first();
            $userHistory->delete();
            return new PostResource(true, "Data Feedback Berhasil dihapus", $userHistory);
        } catch (\Throwable $th) {
            return new PostResource(false, "Data Feedback Gagal dihapus");
        }
    }

}
