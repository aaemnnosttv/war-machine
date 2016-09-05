<template>
    <div class="LastResults jumbotron">
        <h3 class="LastResults_Heading"
            style="opacity: 0;"
            :style="{ opacity: results ? 1 : 0 }"
            >{{ results.winner }} won after {{ results.rounds }} rounds.
        </h3>

        <div class="text-xs-center">
            <button class="PlayButton btn btn-lg btn-outline-success" @click="newGame">PLAY!</button>
            <small class="m-t-1 d-block">Click the <i class="fa fa-gg"></i> to watch the replay.</small>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['results'],

        methods: {
            newGame() {
                this.$dispatch('newGame');
            }
        }
    }
</script>
