<template>
    <div :class="classes">
        <div class="form-group">
            <input type="text" v-model.lazy="player.name" class="form-control" :placeholder="'Player ' + number">
        </div>
        <div class="wins">
            <a v-for="game in player.wins" href="#" @click.prevent="showGame(game)"><i class="fa fa-fw fa-gg"></i></a>
        </div>
    </div>
</template>

<script>
import Events  from '../util/events';

export default {
    props: ['player','number','wins'],

        methods: {
            showGame(game) {
                Events.$emit('showGame', game);
            }
        },

    computed: {
        classes() {
            return [
                'PlayerInfo',
                `Player_${this.number}`,
                'col-sm-6'
            ];
        }
    }
}
</script>
