<template>
  <div id="app">
    <hc-loading></hc-loading>
    <hc-alert></hc-alert>
    <hc-navbar></hc-navbar>
    <!-- <hc-home></hc-home> -->
    <router-view/>
    <hc-footer></hc-footer>
  </div>
</template>

<script>
 //import Home from './views/Home.vue'
 //import hc_home from './views/PaymentServices.vue'
//import CarouselGood from './components/CarouselBoot.vue'
 //import PruebaPagoAsd from './components/carruselVue.vue'
//import CarouselSplide  from './components/CarouselSplide.vue'
import Loading from './components/hc-loading.vue'
import Alert from './components/hc-alert.vue'
import Navbar from './components/hc-navbar.vue'
import Footer from './components/hc-footer.vue'



export default {
  name: 'App',
  components: {
    'hc-navbar': Navbar,
    'hc-footer': Footer,
    'hc-alert': Alert,
    'hc-loading': Loading
    // 'hc-home':Home
    //HelloWorld,
    //Home:hc_home
   // Carousel:CarouselGood,
   // Carousel2:PruebaPagoAsd
  }
}
</script>

<style>
  /* #app {
  font-family: Avenir, Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  text-align: center;
  color: #2c3e50;
  margin-top: 60px;
}   */
</style>

