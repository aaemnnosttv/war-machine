<template>
    <div class="Replay">
        <h4>
            {{ pause ? 'Replay paused.' : 'Replay in progress...' }}
            <small class="pull-right">Click the progress bar to {{ pause ? 'resume' : 'pause' }}.</small>
        </h4>

        <progress class="Round__progress progress"
            :value="current" :max="total"
            @click="playPause()"
        ></progress>

        <div class="Round row" v-for="round in visibleRounds" :class='{ War: round.length > 2 }'>
            <div class="Round__number">{{ round.number }}</div>
            <div class="Round__winner" :class="winnerClass(round)"></div>
            <div class="col-xs-6 col-sm-6 text-center text-xs-center" v-for="card in round">
                <card
                    :suit="card.suit"
                    :face="card.face"
                ></card>
            </div>
        </div>

        <progress class="Round__progress progress"
            :value="current" :max="total"
            v-show="played.length > 6"
            @click="playPause()"
        ></progress>

    </div>
</template>

<script>
import Card from './card.vue';

    export default {
        props: ['rounds'],

        components: {
            Card
        },

        data: function () {
            return {
                timer: {},
                current: 0,
                pause: false
            }
        },

        computed: {
            visibleRounds() {
                return _.takeRight(this.played, 6);
            },
            played() {
                return this.rounds.slice(0, this.current + 1);
            },
            total() {
                return this.rounds.length;
            }
        },

        methods: {
            queueRound() {
                if (this.current <= this.total && ! this.pause) {
                    this.playRound();
                    this.current++; // advance pointer
                }
            },
            playRound() {
                this.timer = setTimeout(() => this.queueRound(), 250);
            },
            playPause() {
                if (this.current >= this.total) {
                    this.current = 0; // replay!
                    this.pause = false;
                    this.queueRound();
                    return;
                }

                this.pause = ! this.pause;
                if (! this.pause) {
                    this.queueRound(); // resume!
                }
            },
            winner(battle) {
                if (battle[0].value > battle[1].value) {
                    return '1';
                }
                return '2';
            },
            winnerClass(round) {
                return `Round__winner--${this.winner(round)}`;
            }
        },

        mounted() {
            _.each(this.rounds, (round, index) => {
                round.number = index + 1;
                return round;
            });
            this.queueRound();
        },

        events: {
            stopReplay() {
                this.pause = true;
            }
        },

        filters: {

        }
    }
</script>

<style>
    .Round {
        margin: 1em 0;
        padding: 1em 0;
        position: relative;
    }
    .Round:nth-child(even) {
        background-color: #f7f7f7;
    }
    .Round.War {
        background-color: #883030;
    }
    .Round__number {
        position: absolute;
        left: 0;
        width: 100%;
        text-align: center;
        font-size: 50px;
        color: #dedede;
    }
    .Round__progress {
        cursor: pointer;
    }
    .Round__progress::-webkit-progress-value {
        transition: all .2s linear;
    }
    .Round__winner::before {
        position: absolute;
        font-size: 50px;
        color: #dedede;
    }
    .Round__winner--1::before {
        left: 0;
        content: '\2190';
    }
    .Round__winner--2::before {
        right: 0;
        content: '\2192';
    }
</style>
