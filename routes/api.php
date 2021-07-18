<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Route;
use War\Dealer;
use War\Deck;
use War\Game;
use War\Player;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('game/play', function(Request $request) {
    $game = new Game(
        new Player($request->player1),
        new Player($request->player2),
        new Dealer(Deck::withAllCards()->shuffle())
    );

    $start = microtime(true);

    $game->play();

    $duration = microtime(true) - $start;

    // TODO: Move game cache to client.
    Cache::forever($hash = uniqid(), $game->rounds()->all());

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
