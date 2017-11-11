<template>
    <div :class="classes">
        <div class="WarCard__symbol" v-html="symbol"></div>
        <div class="WarCard__face" v-if="face != 'A'">{{ face }}</div>
    </div>
</template>

<script>
    export default {
        props: ['suit','face'],

        computed: {
            color() {
                return ['clubs','spades'].indexOf(this.suit) > -1 ? 'black' : 'red';
            },
            symbol() {
                return {
                    clubs: '&clubs;',
                    diamonds: '&diams;',
                    hearts: '&hearts;',
                    spades: '&spades;'
                }[this.suit];
            },
            classes() {
                return [
                    'WarCard',
                    `WarCard--${this.suit}`,
                    `WarCard--${this.color}`,
                    `WarCard--${this.face}`,
                ];
            }
        }
    }
</script>

<style>
    .WarCard {
        display: flex;
        flex-direction: column;
        justify-content: space-around;
        background-color: white;
        width: 50px;
        height: 80px;
        margin: 5px auto;
        border: 1px solid transparent;
        text-align: center;
    }
    .WarCard__face {
        font-size: 20px;
        font-family: Georgia;
    }
    .WarCard__symbol {
        font-size: 30px;
    }
    .WarCard--red {
        color: #ce0000;
        border-color: #ce0000;
    }
    .WarCard--black {
        color: black;
        border-color: black;
    }
</style>
