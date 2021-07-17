<template>
    <div class="Replay">
        <h4>
            {{ pause ? 'Replay paused.' : 'Replay in progress...' }}
            <small class="pull-right">Click the progress bar to {{ pause ? 'resume' : 'pause' }}.</small>
        </h4>

        <div class="Round__progress progress" @click="playPause()">
          <div class="progress-bar" role="progressbar"
            :aria-valuenow="current"
            aria-valuemin="0"
            :aria-valuemax="total"
            :style="{ width: current + '%' }"
          ></div>
        </div>

        <div
            class="Round row"
            :class='{ War: round.length > 2 }'
            v-for="round in visibleRounds"
            :key="round.number"
        >
            <div class="Round__number">{{ round.number }}</div>
            <div class="Round__winner" :class="winnerClass(round)"></div>
            <div
                class="col-xs-6 col-sm-6 text-center text-center"
                v-for="card in round"
                :key="card.suit + ':' + card.face"
            >
                <card
                    :suit="card.suit"
                    :face="card.face"
                ></card>
            </div>
        </div>

        <div class="Round__progress progress" @click="playPause()" v-show="played.length > 6">
          <div class="progress-bar" role="progressbar"
            :aria-valuenow="current"
            aria-valuemin="0"
            :aria-valuemax="total"
            :style="{ width: current + '%' }"
          ></div>
        </div>

    </div>
</template>

<script>
import Card from './card.vue';

    export default {
        props: ['rounds'],

        components: {
            Card
        },

        watch: {
            rounds() {
                clearTimeout(this.timer);
                this.current = 0;
                this.pause = false;
                this.queueRound();
            }
        },

        data() {
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
                // If there are an odd number of rounds,
                // it can only be the last battle,
                // and one player is out of cards.
                if (battle.length % 2 !== 0) {
                    // No way to know who won by battle alone here
                    // because battles are just lists of cards played.
                    return;
                }
                // Most rounds only have a single battle
                // which would be a list of 2 cards played.
                // However, if there is a war, there will be
                // additional battles, so we must always base
                // this logic on the _last_ battle.
                const [p1Card, p2Card] = battle.slice(-2);
                if (p1Card.value > p2Card.value) {
                    return '1';
                }
                return '2';
            },
            winnerClass(round) {
                return `Round__winner--${this.winner(round)}`;
            }
        },

        mounted() {
            this.queueRound();
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
    .Round__progress .progress-bar {
        transition: all .3s linear;
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
