<template>
    <div class="LastResults jumbotron">
        <h3 class="LastResults_Heading"
            style="opacity: 0;"
            :style="{ opacity: results ? 1 : 0 }"
        >
            {{ results.winner }} won after {{ results.rounds }} rounds.
        </h3>

        <div class="text-xs-center m-y-1">
            <button @click.prevent="showGame(results)" class="btn btn-sm btn-outline-secondary">Watch the replay</button>
        </div>

        <div class="text-xs-center">
            <button class="PlayButton btn btn-lg btn-outline-success" @click="newGame">PLAY!</button>
            <small class="m-t-1 d-block">Click the <i class="fa fa-gg"></i> to watch any replay.</small>
        </div>
    </div>
</template>

<script>
import Events from '../util/events';

    export default {
        props: ['results'],

        methods: {
            newGame() {
                Events.$emit('newGame');
            },
            showGame(game) {
                Events.$emit('showGame', this.results);
            }
        }
    }
</script>
