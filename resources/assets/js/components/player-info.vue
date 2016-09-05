<template>
    <div class="PlayerInfo Player_{{ number }} col-sm-6">
        <div class="form-group">
            <input type="text" v-model="player.name" class="form-control" placeholder="Player {{ number }}">
        </div>
        <div class="wins">
            <a v-for="game in player.wins" href="#" @click.prevent="showGame(game)"><i class="fa fa-fw fa-gg"></i></a>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['player','number','wins'],

        methods: {
            showGame(game) {
                this.$dispatch('showGame', game);
            }
        }
    }
</script>
