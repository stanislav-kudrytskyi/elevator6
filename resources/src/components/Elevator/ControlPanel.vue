<template>
    <div class="control-panel">
        <div class="floor-tiles">
            <div class="floor-number" v-for="floor in floors" v-bind:class="{'active': floor.current}">{{floor.number}}</div>
        </div>
        <div class="get-in-out">
            <div class="button" v-on:click="getInCabin" v-if="doorsOpened">
                <i class="arrow left"></i>
                <span>Get in</span>
            </div>
            <div class="button" v-on:click="getOutCabin" v-if="doorsOpened && personsInside > 0">
                <span>Get out</span>
                <i class="arrow right"></i>
            </div>
        </div>

        <div class="call-from-cabin">
            <ul v-if="personsInside > 0">
                <li type="none" v-for="floor in floors" v-bind:class="{'active': floor.selected}" v-on:click="addCall(floor.number)">{{floor.number}}</li>
            </ul>
        </div>

        <div class="state-block">
            <div class="row">
                <div class="column">Strategy:</div>
                <div class="column">
                    <select v-model="currentStrategy">
                        <option>monkey</option>
                    </select>
                </div>
            </div>
            <div class="row">
                <div class="column">Amount of floors:</div>
                <div class="column"><input type="text" v-model="currentNumberOfFloor"/></div>
            </div>
            <div class="row">
                <div class="column">People in the cabin:</div>
                <div class="column">{{personsInside}}</div>
            </div>
            <div class="elevator-calls"></div>
        </div>
    </div>
</template>

<script>
  import { mapState } from 'vuex'
  export default {
    name: "ControlPanel",
    created () {
      this.currentStrategy = this.strategy;
      this.currentNumberOfFloor = this.numberOfFloors
    },
    computed: {
      ...mapState({
        strategy: state => state.elevator.strategy,
        doorsOpened: state => state.elevator.doorsOpened,
        currentFloor: state => state.elevator.currentFloor,
        targetFloor: state => state.elevator.targetFloor,
        numberOfFloors: state => state.elevator.numberOfFloors,
        elevatorCalls: state => state.elevator.elevatorCalls,
        personsInside: state => state.elevator.personsInside,
      }),
      floors () {
        let floors = [];

        for (let i = 1; i <= this.numberOfFloors; i++) {
          floors.push({
            number: i,
            current: i === this.currentFloor,
            selected: this.elevatorCalls.filter(call => {
              return call.to === i;
            }).length > 0
          });
        }

        return floors;
      }
    },
    methods: {
      getInCabin () {
        this.$store.dispatch('getInCabin');
      },
      getOutCabin () {
        this.$store.dispatch('getOutCabin');
      },
      reset () {
        this.$store.dispatch({
          type: 'reset',
          numberOfFloors: this.currentNumberOfFloor,
          strategy: this.currentStrategy,
        });
        this.$forceUpdate();
      },
      addCall (floor) {
        this.$store.dispatch('addCall', {
          toFloor: floor
        });
        console.log('to floor', floor)
      },

    },
    watch : {
      currentStrategy (newVal, oldVal) {
        if (!oldVal) return;
        this.reset();
      },
      currentNumberOfFloor (newVal, oldVal) {
        if (!oldVal) return;
        this.reset();
        console.log('currentNumberOfFloor', newVal, oldVal);
      },
    },
    data() {
      return {
        currentStrategy: '',
        currentNumberOfFloor: ''
      }
    }
  }
</script>

<style scoped lang="scss">
    .control-panel {
        margin-left: 50px;
        float: left;

        .floor-tiles {
            .floor-number {
                text-align: center;
                line-height: 50px;
                margin: 0 auto;
                display: inline-block;
                width: 50px;
                height: 50px;
                border: 1px solid #9d9d9d;
                background-color: #bababa;
                box-sizing: border-box;
                -moz-box-sizing: border-box;
                -webkit-box-sizing: border-box;
            }
            .floor-number.active {
                background-color: #f1b832;
            }
        }

        .get-in-out {
            height: 100px;

            .button {
                padding: 10px 20px;
                cursor: pointer;
            }

            i {
                border: solid black;
                border-width: 0 3px 3px 0;
                display: inline-block;
                padding: 3px;
            }

            .right {
                transform: rotate(-45deg);
                -webkit-transform: rotate(-45deg);
            }

            .left {
                transform: rotate(135deg);
                -webkit-transform: rotate(135deg);
            }
        }

        .call-from-cabin {
            ul {
                width: 120px;
                -moz-column-count: 2;
                -moz-column-gap: 20px;
                -moz-column-fill: auto;
                -webkit-column-count: 2;
                -webkit-column-gap: 20px;
                -webkit-column-fill: auto;
                column-count: 2;
                column-gap: 20px;
                column-fill: auto;
                list-style-position: inside;

                li {
                    text-align: center;
                    line-height: 50px;
                    margin: 0 auto;
                    width: 50px;
                    height: 50px;
                    border: 1px solid #9d9d9d;
                    box-sizing: border-box;
                    -moz-box-sizing: border-box;
                    -webkit-box-sizing: border-box;
                }

                li.active {
                    background-color: #f1b832;
                }
            }
        }

        .state-block {
            margin-top: 50px;

            .row {
                .column {
                    padding: 10px 20px;
                    display: inline-block;
                }
            }

        }
    }
</style>