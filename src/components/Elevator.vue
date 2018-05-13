<template>
    <div class="elevator">
<!--        <svg width="250" :height="height"
               viewBox="0 0 250 1000"
               xmlns="http://www.w3.org/2000/svg">-->
        <cabin
                v-bind:offsetTop="cabinOffsetTop"
                v-bind:floorHeight="floorHeight"
        ></cabin>
            <floor
                    v-for="item in floors"
                    :key="item.floorNumber"
                    v-bind:offsetTop="item.offsetTop"
                    v-bind:floorNumber="item.floorNumber"
                    v-bind:floorHeight="floorHeight"
            ></floor>

<!--        </svg>-->
        <!--{{msg}}
        <div class="lift-shaft">
            <div class="lift"></div>
        </div>-->
    </div>
</template>

<script>
  import Floor from './Elevator/Floor';
  import Cabin from './Elevator/Cabin';
  import { mapState, mapGetters } from 'vuex'

  export default {
    name: 'Elevator',
    created () {
      this.$store.dispatch({
        type: 'reset',
        height: 1000,
        floorsNumber: 3
      });
    },
    computed: {
      ...mapState({
        height: state => state.elevator.height,
        numberFloors: state => state.elevator.numberFloors,
      }),
      floorHeight() {
        return this.$store.getters.floorHeight
      } ,
      floors() {
        let floors = [];
        for (let i = 0; i < this.numberFloors; i++) {
          floors.push({
            offsetTop: i * this.floorHeight,
            floorNumber: this.numberFloors - i
          });
        }
console.log('floors', floors)
        return floors;
      }
    },
    data: function (){
      return {
        msg: 'Elevator goes here',
        cabinOffsetTop: 0
      }
    },
    mounted() {
      let vm = this;

      /*setInterval(function () {
        vm.cabinOffsetTop += 10;
        console.log(vm.cabinOffsetTop)
      }, 1000)*/
    },
    components: {
      floor: Floor,
      cabin: Cabin
    }
  }
</script>

<style>
    #app {
        /*height:100vh;*/
        text-align:left
    }
    .elevator {
        height: 100vh;
    }
    .lift-shaft {
        min-height: 90vh;
        margin-top: 5vh;
        width: 25%;
        background-color: #e8e9e4;
        border: 2px #000 solid;
    }
</style>