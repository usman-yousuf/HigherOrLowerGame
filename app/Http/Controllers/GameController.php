<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;


class GameController extends Controller
{
    public function startGame(Request $request)
    {
        // Check if the game has been initialized or refreshed
        if(!$request->session()->has('deck'))
        {
            $apiUrl = "https://higherorlower-api.netlify.app/json";

            $data = file_get_contents($apiUrl);
            $response = json_decode($data);
            // dd($response);

            // Shuffle the deck and store it in the session
            $shuffledDeck = collect($response)->shuffle();
        }

        // Shuffle the deck on each refresh
        $shuffledDeck = collect($request->session()->get('deck'))->shuffle();
        $request->session()->put('deck', $shuffledDeck->values()->all());

        // Get the current card
        $currentCard = $request->session()->get('deck')[0];
        dd($currentCard);
    }
}
