<template>
    <div class="floor" v-bind:style="{height: floorHeight + 'px'}">
        <div class="floor-number">{{floorNumber}}</div>
        <div class="call-buttons">
            <div class="arrow">
                <div v-if="floorNumber < numberOfFloors" v-bind:class="{'active': upActive, 'arrow-up': true}" v-on:click="callUp"></div>
                <div v-if="floorNumber > 1" v-bind:class="{'active': downActive, 'arrow-down' : true}" v-on:click="callDown"></div>
            </div>
        </div>
    </div>
</template>

<script>
  import { mapState } from 'vuex'

  export default {
    name: "Floor",
    props: ['offsetTop', 'floorHeight', 'floorNumber'],
    computed: {
      ...mapState({
        numberOfFloors: state =>state.elevator.numberOfFloors,
        elevatorCalls: state => state.elevator.calls
      }),
      upActive () {
        return this.elevatorCalls.filter(call => {
          return call.from === this.floorNumber && call.direction === 'up'
        }).length > 0
      },
      downActive () {
        return this.elevatorCalls.filter(call => {
          return call.from === this.floorNumber && call.direction === 'down'
        }).length > 0
      }
    },
    methods: {
      callUp () {
        this.$store.dispatch('addCall', {
          direction: 'up',
          fromFloor: this.floorNumber
        });
      },
      callDown () {
        this.$store.dispatch('addCall', {
          direction: 'down',
          fromFloor: this.floorNumber
        });
      }
    }
  }
</script>

<style scoped lang="scss">
 .floor {
     width: 500px;
     border: 1px solid black;
     box-sizing: border-box;
     -moz-box-sizing: border-box;
     -webkit-box-sizing: border-box;
     display: flex;
     .floor-number {
         width: 95%;
     }
     .call-buttons {
         border-left: 1px #000 solid;
         width: 5%;
         display: table;
         height: 100%;
         .arrow {
             padding: 3% 0;
             display: table-cell;
             vertical-align: middle;

             .arrow-up {
                 width: 0;
                 height: 0;
                 border-left: 10px solid transparent;
                 border-right: 10px solid transparent;
                 border-bottom: 20px solid #ff8c93;
                 margin: 2px 0;
             }

             .arrow-down {
                 width: 0;
                 height: 0;
                 border-left: 10px solid transparent;
                 border-right: 10px solid transparent;

                 border-top: 20px solid #ff8c93;
                 margin: 2px 0;
             }

             .arrow-up.active {
                 border-bottom: 20px solid #f00;
             }

             .arrow-down.active {
                 border-top: 20px solid #f00;
             }
         }
     }
 }


</style>