<template>
    <div class="LastResults jumbotron">
        <h3 class="LastResults_Heading"
            style="opacity: 0;"
            :style="{ opacity: results ? 1 : 0 }"
        >
            {{ results.winner }} won after {{ results.rounds }} rounds.
        </h3>

        <div class="text-center my-1">
            <button @click.prevent="showGame" class="btn btn-sm btn-outline-secondary">Watch the replay</button>
            <button class="PlayButton btn btn-outline-primary" @click="newGame">Play Again</button>
            <small class="mt-1 d-block">Click the <i class="fa fa-gg"></i> to watch any replay.</small>
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
        showGame() {
            Events.$emit('showGame', this.results);
        }
    }
}
</script>
