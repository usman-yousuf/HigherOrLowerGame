<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Http;

class GameController extends Controller
{
    public function startGame(Request $request)
    {
        // Check if the game has been initialized or refreshed
        if (!$request->session()->has('deck')) {
            $apiUrl = "https://higherorlower-api.netlify.app/json";

            $data = file_get_contents($apiUrl);
            $response = json_decode($data);

            // Shuffle the deck and store it in the session
            $shuffledDeck = collect($response)->shuffle();
            $request->session()->put('deck', $shuffledDeck->values()->all());
        }

        // Shuffle the deck on each refresh
        $shuffledDeck = collect($request->session()->get('deck'))->shuffle();
        $request->session()->put('deck', $shuffledDeck->values()->all());

        // Get the current card
        $currentCard = $request->session()->get('deck')[0];
        // dd($currentCard);
        return view('game', compact('currentCard'));

    }

    
    public function makeGuess(Request $request)
    {
        $guess = $request->input('guess');
        $deck = $request->session()->get('deck');
        // dd($deck);
        
        // Initialize correct_guesses to 0 if not set
        $correctGuesses = $request->session()->get('correct_guesses', 0);
    
        
    
        // Remove the current card from the deck
        array_shift($deck);
        
        // Get the next card
        $nextCard = $deck[0];
        // dd($nextCard);
        
        // Check if the guess is correct
        if (($guess == 'higher' && $nextCard->value > $request->input('currentCardValue')) ||
            ($guess == 'lower' && $nextCard->value < $request->input('currentCardValue'))) {
            $correctGuesses++;
            $request->session()->put('correct_guesses', $correctGuesses);

        } else {
            
            // Game over, reset the deck and correct guesses counter
            $request->session()->forget('deck');
            $request->session()->forget('correct_guesses');
            return redirect()->route('startGame');
        }
    
        return redirect()->route('startGame')->with(['currentCard' => $nextCard, 'correctGuesses' => $correctGuesses]);
    }
}
