<template>
    <div class="cabin" v-bind:style="{'margin-top': offsetTop + 'px', height: height + 'px'}">
        <div class="doors-wrapper" v-bind:class="{closed: isClosed}">
            <!-- The checkbox hack! -->
            <!-- The left curtain panel -->
            <div class="door door-left"></div> <!-- curtain__panel -->

            <!-- The prize behind the curtain panels -->
            <div class="cabin-opened"></div> <!-- curtain__prize -->
            <div class="door door-right"></div>
        </div> <!-- curtain__wrapper -->
    </div>
<!--    <rect x="75" :y="offsetTop" width="100" :height="height" style="fill:red"/>-->
</template>

<script>
  export default {
    name: "Cabin",
    props: ['floorHeight', 'offsetTop'],
    created () {
      console.log('created cabin',this.$data, this.$props);
      let self = this;
      setTimeout(function () {
        self.isClosed = false;
      }, 5000)
    },
    data() {
      return {
        isClosed: true
      }
    },
    computed: {
      aDouble: function () {
        return this.a * 2
      },
      height: function () {
        return this.$props.floorHeight
      },
/*      isClosed: function () {
        return true;
      }*/
    }
  }
</script>

<style scoped lang="scss">
    .cabin {
        position: absolute;
        background-color: red;
        width: 100px;
        margin-left: 75px;
        .doors-wrapper {
            width: 100%;
            height: 100%;
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
    }
</style>