<?php

namespace App\Http\Controllers;

use App\Models\UserHistory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class MachineLearningController extends Controller
{

    public function prediction(Request $request)
    {    

        $limitUserBiasa = 10;
        $limitUserPremium = 50;
        $limitUserDeveloper = 10000;

        $periksa = UserHistory::where('user_id', $request->user()->id)->get();
        $count = 0;
        foreach ($periksa as $d) {
            if (($d->created_at)->isToday()) {
                $count++;
            }
        }


        if (!Auth::check()) {
            return new PostResource(false, "unauthenticated");
        }

        if($request->user()->roles_id = 1 && $count >= $limitUserBiasa){
            return new PostResource(false, "Sudah Mencapai limit harian user biasa");   
        }
        if($request->user()->roles_id = 2 && $count >= $limitUserPremium){
            return new PostResource(false, "Sudah Mencapai limit harian user premium");   
        }
        if($request->user()->roles_id = 3 && $count >= $limitUserDeveloper){
            return new PostResource(false, "Sudah Mencapai limit harian user developer");   
        }

        try {
            $url = "https://flask-production-19e8.up.railway.app/predict"; // Ganti dengan URL API yang sesuai

            $data = [
                "num_sentences" => $request->num_sentences,
                "text" => $request->text
            ];

            $response = Http::post($url, $data);

            $data = $response->json();
            
            $data['count'] = $count;

            $postToHistory = [
                'user_id' => $request->user()->id,
                'text' => $request->text
            ];

            UserHistory::create($postToHistory);
            

            return new PostResource(true, "Berhasil mendapatkan data prediction", $data);
        } catch (\Throwable $th) {
            return new PostResource(false, "Gagal mendapatkan data prediction");
        }
    }

    public function summarize(Request $request)
    {

        $limitUserBiasa = 10;
        $limitUserPremium = 50;
        $limitUserDeveloper = 10000;

        $periksa = UserHistory::where('user_id', $request->user()->id)->get();
        $count = 0;
        foreach ($periksa as $d) {
            if (($d->created_at)->isToday()) {
                $count++;
            }
        }


        if (!Auth::check()) {
            return new PostResource(false, "unauthenticated");
        }

        if($request->user()->roles_id = 1 && $count >= $limitUserBiasa){
            return new PostResource(false, "Sudah Mencapai limit harian user biasa");   
        }
        if($request->user()->roles_id = 2 && $count >= $limitUserPremium){
            return new PostResource(false, "Sudah Mencapai limit harian user premium");   
        }
        if($request->user()->roles_id = 3 && $count >= $limitUserDeveloper){
            return new PostResource(false, "Sudah Mencapai limit harian user developer");   
        }

        try {
            $url = "https://flask-production-19e8.up.railway.app/summarize"; // Ganti dengan URL API yang sesuai

            $data = [
                "text" => $request->text,
                "num_sentences" => $request->num_sentences
            ];

            $response = Http::post($url, $data);

            $data = $response->json();
            $data['count'] = $count;

            $postToHistory = [
                'user_id' => $request->user()->id,
                'text' => $request->text
            ];

            UserHistory::create($postToHistory);

            return new PostResource(true, "Berhasil mendapatkan data Summarize", $data);
        } catch (\Throwable $th) {
            return new PostResource(false, "Gagal mendapatkan data Summarize");
        }
    }

    public function topicModeling(Request $request)
    {

        $limitUserBiasa = 10;
        $limitUserPremium = 50;
        $limitUserDeveloper = 10000;

        $periksa = UserHistory::where('user_id', $request->user()->id)->get();
        $count = 0;
        foreach ($periksa as $d) {
            if (($d->created_at)->isToday()) {
                $count++;
            }
        }


        if (!Auth::check()) {
            return new PostResource(false, "unauthenticated");
        }

        if($request->user()->roles_id = 1 && $count >= $limitUserBiasa){
            return new PostResource(false, "Sudah Mencapai limit harian user biasa");   
        }
        if($request->user()->roles_id = 2 && $count >= $limitUserPremium){
            return new PostResource(false, "Sudah Mencapai limit harian user premium");   
        }
        if($request->user()->roles_id = 3 && $count >= $limitUserDeveloper){
            return new PostResource(false, "Sudah Mencapai limit harian user developer");   
        }

        try {
            $url = "https://flask-production-19e8.up.railway.app/topic-modeling"; // Ganti dengan URL API yang sesuai

            $data = [
                "text" => $request->text,
                "num_topics" => $request->num_topics
            ];

            $response = Http::post($url, $data);

            $data = $response->json();
            $data['count'] = $count;

            $postToHistory = [
                'user_id' => $request->user()->id,
                'text' => $request->text
            ];

            UserHistory::create($postToHistory);

            return new PostResource(true, "Berhasil mendapatkan data Topic modeling", $data);
        } catch (\Throwable $th) {
            return new PostResource(false, "Gagal mendapatkan data Topic modeling");
        }
    }


}


