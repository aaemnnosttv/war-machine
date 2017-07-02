import Vue from 'vue';
import HTTP from 'vue-resource';
import { event }  from './util/events';
import LastResults from './components/last-results.vue';
import PlayerInfo from './components/player-info.vue';
import Replay from './components/replay.vue';
import _ from 'lodash';

Vue.use(HTTP);
Vue.http.headers.common['X-CSRF-TOKEN'] = App.csrfToken;

// Initialize event bus
event.init();

/**
 * Register a global `tail` filter, similar to the bash function.
 */
Vue.filter('tail', (items, number) => _.takeRight(items, number));
/**
 * Load the root Vue instance
 */
new Vue({

  el: '#app',

  components: {
    LastResults,
    PlayerInfo,
    Replay
  },

  data: {
    players: [
        { name: Players[0], wins: [] },
        { name: Players[1], wins: [] },
    ],
    lastPlayed: {},
    results: []
  },

  computed: {
    lastResults() {
        if (_.isEmpty(this.lastPlayed)) {
            return false;
        }
        let results = _.merge({}, this.lastPlayed);
        results.winner = this.players[results.winner].name;
        return results;
    },
    /**
     * We need a copy of results because it's mutated within the component
     * and its length is used for conditional rendering of the replay.
     */
    resultsCopy() {
        return _.slice(this.results);
    }
  },

  methods: {

    play() {
        let postData = {
            player1: 0,
            player2: 1
        };

        this.$http.post('api/game/play', postData).then(response => {
            let results = response.json();
            this.lastPlayed = results;
            this.players[results.winner].wins.push(results);
        });
    },
    stopReplay() {
        event.emit('stopReplay');
    }
  },

  mounted() {
      event.on({
          newGame() {
              this.play();
          },
          showGame(game) {
              this.$set('results', []);

              this.$http.get('api/game/' + game.hash).then(response => {
                  this.results = response.json();
              });
          }
      })
  }

});
