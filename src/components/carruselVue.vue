<!-- Please remove this file from your project -->
<template>
  <div >
  <section>
    <ssr-carousel :slides-per-page="cantidad"  
   :responsive='[
    {
      maxWidth: 900,
      slidesPerPage: 8,
    },
    {
      maxWidth: 800,
      slidesPerPage: 3,
    },
    {
      maxWidth: 700,
      slidesPerPage: 1
    },
    {
      maxWidth: 200,
      slidesPerPage: 1
    }
  ]' >
    <div class="slide" v-for="item in table" :key="item.id">
        <img :src="item.imagen" :alt="item.descripcion" class="asd"/>
    </div>
</ssr-carousel>
</section>
  </div>
</template>

<script>
export default {
  name: 'hcCarousel',
  props: {
    cantidad:{
      type: Number
    },
    table: {
      type: Array
    }
  }//,
  // created() {
  //   fetch('http://localhost:3000/services').then(res => res.json())
  //   .catch(error => console.error('Error:', error))
  //   .then(async response => {
  //   if(response.length > 0) {
  //       this.table = response
  //                   //console.log("Creado")
  //     }
  //   })
  // },
  // mounted() {
  //   console.log("Montado")
  //   fetch('http://localhost:3000/services').then(res => res.json())
  //   .catch(error => console.error('Error:', error))
  //   .then(async response => {
  //   if(response.length > 0) {
  //       this.table = response
  //                   //console.log("Creado")
  //     }
  //   })
  // }
}
</script>
<style scoped>
.slide {
  box-shadow: 0 6px 15px -3px rgb(0 0 0/0.3);
  padding: 25px;
  border-radius: 5px;
    height: 180px;
    width: 300px;
  
}
.asd{
    width: 100%;
    height: 100%;
}


</style>
