<template>
    <div class="main-container">
        <div class="elevator">
            <cabin v-bind:floorHeight="floorHeight"></cabin>
            <floor
                    v-for="item in floors"
                    :key="item.floorNumber"
                    v-bind:offsetTop="item.offsetTop"
                    v-bind:floorNumber="item.floorNumber"
                    v-bind:floorHeight="floorHeight"
            ></floor>
        </div>
        <controlpanel></controlpanel>
    </div>
</template>

<script>
  import Floor from './Elevator/Floor';
  import Cabin from './Elevator/Cabin';
  import ControlPanel from './Elevator/ControlPanel';
  import { mapState } from 'vuex'

  export default {
    name: 'Elevator',
    created () {
      this.$store.dispatch({
        type: 'reset',
        numberOfFloors: 5,
        strategy: 'monkey',
      });
    },
    computed: {
      ...mapState({
        numberOfFloors: state => state.elevator.numberOfFloors,
        targetFloor: state => state.elevator.targetFloor,
        currentFloor: state => state.elevator.currentFloor
      }),
      floorHeight() {
        return Math.ceil(this.totalHeight / this.numberOfFloors);
      },
      floors() {
        let floors = [];
        for (let i = 0; i < this.numberOfFloors; i++) {
          floors.push({
            offsetTop: i * this.floorHeight,
            floorNumber: this.numberOfFloors - i
          });
        };

        return floors;
      }
    },
    data: function (){
      return {
        msg: 'Elevator goes here',
        cabinOffsetTop: 0,
        totalHeight: 600
      }
    },
    watch: {
      targetFloor (oldValue, newValue) {
        console.log('targetFloor', oldValue, newValue)
        if (this.targetFloor === this.currentFloor) {
          this.$store.dispatch('openDoors');
        }
      },
      currentFloor(floor) {
        if (this.targetFloor === this.currentFloor) {
          this.$store.dispatch('openDoors');
        }
      }
    },
    mounted() {

    },
    components: {
      floor: Floor,
      cabin: Cabin,
      controlpanel: ControlPanel
    }
  }
</script>

<style>
    #app {
        text-align:left;
        padding: 0;
        margin: 0;
    }
    .elevator {
        float:left;
    }
</style>