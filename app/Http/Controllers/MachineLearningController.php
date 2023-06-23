<?php

namespace App\Http\Controllers;

use App\Models\UserHistory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;
use Illuminate\Support\Facades\Http;

class MachineLearningController extends Controller
{
   
    public function prediction(Request $request)
    {
        try {
            $url = "https://flask-production-19e8.up.railway.app/predict"; // Ganti dengan URL API yang sesuai
    
            $data = [
                "news" => $request->news,
            ];

            $response = Http::post($url, $data);
            
            $data = $response->json();
            // Mengakses data di dalam "data"
            // $recom = $data['data'];

            // // Menambahkan key "is_favourite" pada setiap data
            // $recomWithFavourite = array_map(function ($item) use ($request) {
            //     $item['is_favourite'] = Favourite::where('user_id', $request->user_id)->where('food_id', $item['id_food'])->exists();
            //     return $item;
            // }, $recom);
        
            // Menggabungkan data yang telah ditambahkan "is_favourite" ke dalam "data"
            // $result = $recomWithFavourite;

            return new PostResource(true, "Berhasil mendapatkan data prediction", $data);
        } catch (\Throwable $th) {
            return new PostResource(false, "Gagal mendapatkan data prediction");
        }
    }

    public function summarize(Request $request)
    {
        try {
            $url = "https://flask-production-19e8.up.railway.app/summarize"; // Ganti dengan URL API yang sesuai
    
            $data = [
                "text" => $request->text,
                "num_sentences" => $request->num_sentences
            ];
            
            $response = Http::post($url, $data);
            
            $data = $response->json();
            // Mengakses data di dalam "data"
            // $recom = $data['data'];

            // // Menambahkan key "is_favourite" pada setiap data
            // $recomWithFavourite = array_map(function ($item) use ($request) {
            //     $item['is_favourite'] = Favourite::where('user_id', $request->user_id)->where('food_id', $item['id_food'])->exists();
            //     return $item;
            // }, $recom);
        
            // Menggabungkan data yang telah ditambahkan "is_favourite" ke dalam "data"
            // $result = $recomWithFavourite;

            return new PostResource(true, "Berhasil mendapatkan data Topic modeling", $data);
        } catch (\Throwable $th) {
            return new PostResource(false, "Gagal mendapatkan data Topic modeling");
        }
    }

}
