<template>
    <!--<g>
        <rect x="0" :y="offsetTop" width="250" :height="floorHeight" style="fill:rgb(244,244,254);stroke-width:1;stroke:rgb(0,0,0)"/>
        <text x="2" :y="offsetTopText" font-family="sans-serif" font-size="20px" fill="black">{{floorNumber}}</text>
    </g>-->
    <div class="floor" v-bind:style="{height: floorHeight + 'px'}">
        <div class="call-buttons">
            <div class="arrow-up" v-on:click="callUp"></div>
            <div class="arrow-down" v-on:click="callDown"></div>
        </div>
    </div>
</template>

<script>
  export default {
    name: "Floor",
    props: ['offsetTop', 'floorHeight', 'floorNumber'],
    created () {
      console.log('Floor created', this.$props)
    },
    data () {
      return {
        //offsetTop: this.offsetTop,
        offsetTopText: this.offsetTop + 20
      }
    },
    methods: {
      callUp () {
        this.$store.dispatch('addCall', {
          direction: 'up',
          fromFloor: this.floorNumber
        });
        console.log('up', this.floorNumber)
      },
      callDown () {
        this.$store.dispatch('addCall', {
          direction: 'down',
          fromFloor: this.floorNumber
        });
        console.log('down', this.floorNumber)
      }
    }
  }
</script>

<style scoped lang="scss">
 .floor {
     width: 250px;
     border: 1px solid black;
     display: flex;
     .call-buttons {
         border-left: 1px #000 solid;
         width: 25%;
         margin-left: 75%;
     }
 }

    .arrow-up {
        width: 0;
        height: 0;
        border-left: 10px solid transparent;
        border-right: 10px solid transparent;

        border-bottom: 20px solid red;

        display: table;
        margin: 80% auto;
    }

    .arrow-down {
        width: 0;
        height: 0;
        border-left: 10px solid transparent;
        border-right: 10px solid transparent;

        border-top: 20px solid #f00;
        display: table;
        margin: 10% auto;
    }
</style>