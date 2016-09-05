<?php

use War\Deck;
use War\Game;
use War\Dealer;
use War\Player;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::get('/', function(Request $request) {
    Cache::flush();

    $players = [
        $request->player1 ?: 'Player 1',
        $request->player2 ?: 'Player 2'
    ];

    return view('play', compact('players'));
});


Route::group(['prefix' => 'api'], function () {

    Route::post('game/play', function(Request $request) {

        $game = new Game(
            new Player($request->player1),
            new Player($request->player2),
            new Dealer(Deck::withAllCards()->shuffle()->shuffle()->shuffle()->shuffle())
        );

        $start = microtime(true);

        $game->play();

        $duration = microtime(true) - $start;

        Cache::forever($hash = uniqid(), $game->rounds()->toArray());

        return json_encode([
            'hash'     => $hash,
            'winner'   => $game->winner()->name,
            'rounds'   => $game->rounds()->count(),
            'duration' => round($duration * 1000)
        ]);
    });

    Route::get('/game/{hash}', function($hash) {
        return Cache::get($hash);
    });
});


