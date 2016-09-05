<template>
    <div class="Replay">
        <h4>
            {{ pause ? 'Replay paused.' : 'Replay in progress...' }}
            <small class="pull-right">Click the progress bar to {{ pause ? 'resume' : 'pause' }}.</small>
        </h4>

        <progress class="Round__progress progress" value="{{ playing.number }}" max="{{ total }}" @click="playPause()"></progress>

        <div class="Round row" v-for="round in played | tail 6" :class='{ War: round.length > 2 }'>
            <div class="Round__number">{{ round.number }}</div>
            <div class="Round__winner Round__winner--{{ round | tail 2 | winner }}"></div>
            <div class="col-xs-6 col-sm-6 text-center text-xs-center" v-for="card in round">
                <card
                    :suit="card.suit"
                    :face="card.face"
                ></card>
            </div>
        </div>

        <progress class="Round__progress progress"
            value="{{ playing.number }}" max="{{ total }}"
            v-show="played.length > 6"
            @click="playPause()"></progress>

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
                total: '',
                timer: {},
                playing: { number: 0 },
                played: [],
                pause: false
            }
        },

        methods: {
            queueRound() {
                if (this.rounds.length && ! this.pause) {
                    this.playRound();
                }
            },
            playRound() {
                this.timer = setTimeout(() => {
                    let round = this.rounds.shift();
                    round.number = this.played.length + 1;
                    this.playing = round;
                    this.played.push(round);
                    this.queueRound();
                }, 250);
            },
            playPause() {
                this.pause = ! this.pause;
                if (! this.pause) {
                    this.queueRound(); // resume!
                }
            }
        },

        ready() {
            this.total = this.rounds.length;
            this.queueRound();
        },

        events: {
            stopReplay() {
                this.pause = true;
            }
        },

        filters: {
            winner(battle) {
                if (battle[0].value > battle[1].value) {
                    return '1';
                }
                return '2';
            }
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
