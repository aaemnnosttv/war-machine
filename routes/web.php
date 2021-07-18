<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function (Request $request) {
    // TODO: Move game cache to client.
    Cache::flush();

    $players = [
        $request->player1 ?: 'Player 1',
        $request->player2 ?: 'Player 2'
    ];

    return view('play', compact('players'));
});
