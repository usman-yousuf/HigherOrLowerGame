<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class GameController extends Controller
{
    public function callApi()
    {
        $apiUrl = "https://higherorlower-api.netlify.app/json";

        $data = file_get_contents($apiUrl);
        $response = json_decode($data);
        dd($response);
    }
}
