<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Higher or Lower Game</title>
</head>
<body>
    <h1>Higher or Lower Game</h1>

    <p>Current Card: {{ $currentCard->value }} of {{ $currentCard->suit }}</p>

    @if (session('correctGuesses') > 0)
        <p>Correct Guesses: {{ session('correctGuesses') }}</p>
    @endif

    <form method="post" action="{{ route('makeGuess') }}">
        @csrf
        <input type="hidden" name="currentCardValue" value="{{ $currentCard->value }}">
        
        <label for="guess">Will the next card be higher or lower?</label>
        <select name="guess" id="guess">
            <option value="higher">Higher</option>
            <option value="lower">Lower</option>
        </select>

        <button type="submit">Submit Guess</button>
    </form>
    
</body>
</html>
