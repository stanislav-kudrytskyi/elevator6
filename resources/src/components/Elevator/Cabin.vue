<template>
    <div class="cabin" v-bind:style="{'margin-top': offsetTop + 'px', height: height + 'px'}">
        <div class="doors-wrapper" v-bind:class="{closed: !doorsOpened}">
            <div class="door door-left"></div>
            <div class="cabin-opened"></div>
            <div class="door door-right"></div>
        </div>
    </div>
<!--    <rect x="75" :y="offsetTop" width="100" :height="height" style="fill:red"/>-->
</template>

<script>
  import { mapState } from 'vuex'

  export default {
    name: "Cabin",
    props: ['floorHeight'],
    created () {
      this.offsetTop = this.totalHeight - this.height * this.currentFloor;
    },
    data() {
      return {
        offsetTop: 0,
        moveInterval: null
      }
    },
    computed: {
      ...mapState({
        doorsOpened: state => state.elevator.doorsOpened,
        currentFloor: state => state.elevator.currentFloor,
        targetFloor: state => state.elevator.targetFloor,
        numberOfFloors: state =>state.elevator.numberOfFloors,
        strategy: state =>state.elevator.strategy,
        elevatorCalls: state => state.elevator.elevatorCalls
      }),
      height: function () {
        return this.$props.floorHeight
      },
      totalHeight () {
        return this.height * this.numberOfFloors
      },
      targetOffset() {
        if (!this.targetFloor) {
          return null;
        }

        let delta = this.currentFloor > this.targetFloor ? -1 : 1;

        return this.totalHeight - this.height * (this.currentFloor + delta);
      }
    },
    methods: {
      reset() {
        if (this.moveInterval) {
          clearInterval(this.moveInterval);
        }
        this.offsetTop = this.totalHeight - this.height * this.currentFloor;
      }
    },
    watch: {
      strategy () {
        this.reset();
      },
      numberOfFloors () {
        this.reset();
      },
      targetOffset(value) {
        if (null === value) {
          return;
        }

        let step = Math.ceil(this.height / 3);

        if (this.targetOffset < this.offsetTop) {
          step *= -1;
        }

        this.moveInterval = setInterval(() => {
          if (Math.abs(this.offsetTop - this.targetOffset) <= Math.abs(step)) {
            clearInterval(this.moveInterval);
            this.offsetTop = this.targetOffset;

            let delta = this.currentFloor > this.targetFloor ? -1 : 1;

            this.$store.dispatch('setCurrentFloor', {currentFloor: this.currentFloor + delta});
            return;
          }

          this.offsetTop += step;
        }, 1000);
      }
    }
  }
</script>

<style scoped lang="scss">
    .cabin {
        position: absolute;
        width: 200px;
        margin-left: 75px;
        .doors-wrapper {
            width: 130px;
            height: 100%;
            background-color: #9d9d9d;
            float: left;

            .door {
                background: orange;
                width: 50%;
                height: 100%;
                float: left;
                position: relative;
                z-index: 2; /* Places the panels in front of the prize */
                transition: all 1s ease-out; /* Animates the sliding transition */
            }
            .door-left {
                transform: translateX(-100%);
            }

            .door-right {
                transform: translateX(100%);
            }
        }
        /* Slide the first panel in */
        .doors-wrapper.closed {
            .door-left{
                transform: translateX(0);
            }

            /* Slide the second panel in */
            .door-right {
                transform: translateX(0);
            }
        }
        .control-container {
            float:left;
        }
    }
</style>