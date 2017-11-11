@extends('layouts.master')

@section('content')
    <h1 class="m-y-1">Let's have a War...</h1>

    <div class="Players row">
        <player-info v-for="(player, index) in players"
            :key="index"
            :number="index + 1"
            :player.sync="player"
        ></player-info>
    </div>

    <div class="rules jumbotron info-background" v-show="! lastResults">
        <h3 class="display-3">Game Rules</h3>
        <ul>
            <li>Each player is dealt half of a shuffled deck.</li>
            <li>Both players play one card at a time to do battle, high card wins. (Ace high)</li>
            <li>In the event both cards are of equal value... WAR!</li>
            <li>In war, each player "pays" an additional card, and then both players battle again.</li>
            <li>Whoever wins the final battle wins the "war".</li>
            <li>The game ends when one player no longer has any cards to play.</li>
        </ul>

        <hr class="m-y-2">

        <p class="lead">Ready?</p>
        <p class="text-xs-center">
            <button class="PlayButton btn btn-lg btn-outline-success" @click="play">PLAY!</button>
        </p>
    </div>

    <last-results v-show="lastResults"
        :results="lastResults"
    ></last-results>

    <replay v-if="results.length"
        :rounds="resultsCopy"
    ></replay>
@stop

@section('scripts')
    <script>
        var Players = {!! json_encode($players) !!};
    </script>
@stop
