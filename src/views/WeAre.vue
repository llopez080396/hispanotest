<template>
    <div id="hc_we-are" class="container-fluid">
		<section id="s1_video_main" class="d-flex">
            <video playsinline="playsinline" autoplay="autoplay" muted="muted" loop="loop" class="video-fluid">
                <source :src="video_main" type="video/mp4">
            </video>
            <div id="s1_target_video_main" class="container-fluid position-absolute w-100">
                <div class="row h-100">
                    <div class="col-12 d-flex justify-content-center align-items-end h-100 pb-2 pb-sm-3 pb-md-4 pb-lg-4 pb-xl-5">
                        <div class="text-center pb-0 pb-md-3 pb-lg-3 pb-xl-3">
                        <div class="d-none d-sm-block mb-0 mb-md-1 mb-lg-1 mb-xl-2">
                        <img :src="s1_img1" style="max-width:100px">
                        </div>
                        <div class="mb-0 mb-md-1 mb-lg-1 mb-xl-1">
                        <span class="hc--title poppins-regular text-white">Es momento de estar </span>	
                        </div>
                        <div class="mb-0 mb-md-1 mb-lg-1 mb-xl-4">
                        <span class="hc--title poppins-bold text-white">más cerca de los tuyos</span>	
                        </div>
                        </div>
                    </div>
                    <div class="position-absolute d-none d-sm-block" style="position: absolute; bottom: 0px; right: 10px;">
                        <ul style="list-style-type: none;">
                            <li class="my-2">
                                <a href="https://www.facebook.com/HispanoCash" target="_blank">
                                    <img :src="img_fb" class="m-1">
                                </a>
                            </li>
                            <li class="my-2">
                                <a href="https://www.tiktok.com/@hispanocash" target="_blank">
                                    <img :src="img_tk" class="m-1">
                                </a>
                            </li>
                            <li class="my-2">
                                <a href="https://www.instagram.com/hispanocash/" target="_blank">
                                    <img :src="img_ig" class="m-1">
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </section>
        <section id="section2" class="d-flex">
            <img :src="bg_green_left" class="img-fluid">

            <div id="s2_target" class="container-fluid position-absolute w-100 pt-3 pt-md-5 ">
                <div class="row h-100">
                    <div class="col-6 col-sm-6 col-md-6 col-lg-6 col-xl-6 d-flex justify-content-center align-items-center h-100 px-0 pt-3 px-sm-0 pt-sm-3 px-md-0 pt-md-3 pt-lg-3 pt-lx-5">
                        <div style="max-width: 680px;">
                            <video playsinline="playsinline" autoplay="autoplay" muted="muted" loop="loop" class="video-fluid pl-1 pl-sm-3 pl-md-5">
                                <source :src="s2_vid1" type="video/mp4">
                            </video>
                        </div>
                    </div>
                    <div class="col-6 col-sm-6 col-md-6 col-lg-6 col-xl-6 d-flex justify-content-center align-items-center h-100 px-2 pl-1 pt-4 px-sm-2 pl-sm-3 pt-sm-4 pt-md-4 pl-md-5 pt-lg-0 pl-lg-1">

                        <div style="max-width: 650px;" class="pl-sm-5 pl-md-3 pt-lg-0 pl-lg-5 pt-lg-5 pt-xl-5 px-xl-0">
                            <div class="d-none d-sm-block mb-3 mb-md-1 mb-lg-3" style="max-width: 500px;">
                                <span class="hc--title poppins-regular">
                                    Pagos seguros <span class="poppins-bold">desde EUA a cualquier parte de México</span>
                                </span>    
                            </div>

                            <div class="d-none d-lg-flex mb-4" style="max-width: 410px;">
                                <span class="hc--description">
                                    HispanoCash© te permite realizar 
                                    pagos de servicios desde EUA a tus 
                                    seres queridos en México,
                                    entregándoles bienestar y 
                                    tranquilidad a su vida.
                                </span>    
                            </div>

                            <div>
                                <button @click="redirect('payment_services')" class="btn hc--btn-gradient text-white mx-1">
                                    PAGAR SERVICIOS
                                </button>       
                            </div>  
                        </div>

                    </div>
                </div>
            </div>
        </section>
        <section id="section3" class="d-flex p-0">
            <div class="container-fluid w-100">
                <div class="row h-100">
                    <div class="col-12 d-flex justify-content-center align-items-center h-100 p-5">
                        <div class="text-center">
                            <div class="row d-none d-xl-flex justify-content-center align-items-end mb-3">
                                <span class="hc--title poppins-semibold text-secondary" >
                                    ¿Por qué elegir a 
                                    <div class="d-inline-block" style="max-width: 300px;">
                                        <img :src="s3_img_title" class="img-fluid">
                                    </div>?
                                </span>
                            </div>
                            
                            <div class="row d-flex justify-content-center align-items-end py-4">
                                <div class="col-7 col-sm-4" v-for="col in s3_data" :key="col.title">
                                    <div class="row d-flex justify-content-center align-items-center mb-1">
                                        <div style="max-width: 180px;">
                                            <img :src="col.image" class="img-fluid">
                                        </div>
                                    </div>

                                    <div class="row d-flex justify-content-center align-items-center mb-2">
                                        <div style="max-width: 200px;">
                                            <span class="hc--description poppins-semibold text-success">
                                                {{ col.title }}
                                            </span>
                                        </div>
                                    </div>

                                    <div class="row d-none d-xl-flex justify-content-center align-items-center">
                                        <div style="max-width: 270px;">
                                            <span class="hc--description poppins-regular text-dark">
                                                {{ col.subtitle }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>
        </section>
        <section id="s4_video" class="d-flex p-0">
            <video playsinline="playsinline" autoplay="autoplay" muted="muted" loop="loop" class="video-fluid">
                <source :src="s4_vid1" type="video/mp4">
            </video>

            <div id="s4_target_video" class="container-fluid position-absolute w-100 pt-1">
                <div class="row h-100">
                    <div class="col-12 d-flex justify-content-start align-items-center h-100 p-2 p-sm-5 p-xl-5">
                        
                        <div class="w-100 px-0 pt-1 px-xl-5">

                            <div class="row d-flex justify-content-start align-items-center px-0 pt-1 p-xl-5">
                                <div class="col-12">
                                    <div class="px-0 pt-1 px-xl-5" style="max-width: 680px;">
                                        <div style="max-width: 100px;" class="d-none d-sm-block border-left">
                                            <img :src="s1_img1" class="img-fluid  ml-5">
                                        </div>

                                        <div class="mt-2" style="max-width: 500px;">
                                            <span class="hc--title poppins-regular text-white">
                                                Hacemos que las
                                                familias méxicanas,
                                                <span class=" poppins-bold">vivan más seguras</span>
                                            </span>
                                        </div>
                                         <div class="d-none d-md-block" style="max-width: 380px;">
                                            <span class="hc--description-sm poppins-regular text-white">
                                                A través de pagos de diferentes servicios
                                                para que tus seres queridos en México
                                                vivan más seguros y tranquilos.
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                        </div>
                        
                    </div>
                </div>
            </div>
        </section>
        <section id="section5" class="d-flex p-0 bg-diagonal-top-left-green-30">
            <div class="container mt-5">
                <div class="row">
                    <div class="col-12 col-sm-6 mb-5" v-for="(col, index_col) in s5_data" :key="index_col">
                        
                        <video :id="`s5_col_${index_col}_video`" playsinline="playsinline" autoplay="autoplay" muted="muted" loop="loop" class="video-fluid">
                            <source :src="col.video" type="video/mp4">
                        </video>

                        <div :id="`s5_col_${index_col}_target_video`" class="row position-absolute" style="top: 0px;">
                            <!-- <div class="row d-flex justify-content-center align-items-center h-100"> -->
                                
                                    <div class="col-12 d-flex justify-content-center align-items-center p-0">
                                        <div class="p-0 p-sm-2">
                                            <div class="d-flex justify-content-center align-items-center w-100 mb-1 mb-lg-3">
                                                <div :style="{ 'max-width': `${col.max}px` }">
                                                    <img :src="col.gif" class="img-fluid">
                                                </div>    
                                            </div>

                                            <div class="d-block d-sm-none d-md-block text-center">
                                                <span class="hc--description poppins-regular text-white">SERVICIOS</span>
                                            </div>
                                            <div class="d-block d-sm-none d-md-block text-center">
                                                <span class="hc--description poppins-bold text-success mb-0 mb-lg-5">{{col.title}}</span>
                                            </div>
                                            <div class="d-block d-sm-none d-md-block text-center pt-4">
                                                <span class="hc--description-sm poppins-regular text-monospace text-white mt-5">{{col.subtitle}}</span>
                                            </div>
                                        </div>
                                    </div>
                            
                            <!-- </div> -->
                        </div>
                        
                    </div>
                    <div class="col-12 d-flex justify-content-center align-items-center">
                        <div class=" ml-auto ml-sm-auto ml-md-auto ml-lg-0 ml-xl-0 pr-lg-4 text-center">
                            <button @click="redirect('payment_services')" class="btn hc--btn-gradient text-white poppins-semibold px-2 mx-lg-3 mx-lx-5" style="max-width: 300px;">
                                PAGAR SERVICIOS
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</template>

<script>
    // Videos
	import video_main from '../assets/videos/we-are/section1/loop-somos.mp4'
    import s2_vid1 from '../assets/videos/we-are/section2/loop-familia.mp4'
    import s4_vid1 from '../assets/videos/we-are/section4/loop-feliz.mp4'

    import s5_vid1 from '../assets/videos/we-are/section5/funerarios.mp4'
    import s5_vid2 from '../assets/videos/we-are/section5/telefonia.mp4'
    import s5_vid3 from '../assets/videos/we-are/section5/basicos.mp4'
    import s5_vid4 from '../assets/videos/we-are/section5/internet.mp4'

    // Gifs
	import s1_gif1 from '../assets/gifs/símbolo-hispano.gif'
    import s1_img1 from '../assets/images/simbolo-hispano.png'

    import s3_gif_title from '../assets/gifs/hispano-original.gif'
    import s3_img_title from '../assets/images/logo-hisp.png'

    import s3_gif1 from '../assets/gifs/weare/section3/inmediatos.gif'
    import s3_gif2 from '../assets/gifs/weare/section3/seguros.gif'
    import s3_gif3 from '../assets/gifs/weare/section3/sin-comisiones.gif'

    import s5_gif1 from '../assets/gifs/weare/section5/funerarios.gif'
    import s5_gif2 from '../assets/gifs/weare/section5/telefonia.gif'
    import s5_gif3 from '../assets/gifs/weare/section5/basicos.gif'
    import s5_gif4 from '../assets/gifs/weare/section5/internet.gif'

    // Images
    import img_fb from '../assets/images/sociality/fb.png'
    import img_tk from '../assets/images/sociality/tk.png'
    import img_ig from '../assets/images/sociality/ig.png'

    //Background
    import bg_green_left from '../assets/images/backgrounds/bg-green-left.png'

    // jQuery
    import $ from 'jquery'
    
    export default {
        name: 'hc_we-are',
        data() {
            return {
                video_main,
                s2_vid1,
                s1_gif1,
                s1_img1,
                s3_gif_title,
                s3_img_title,
                s4_vid1,
                img_fb,
                img_tk,
                img_ig,
                bg_green_left,
                s3_data: [
                    { image: s3_gif1, title: 'PAGOS INMEDIATOS', subtitle: 'Tu dinero estará en su destino en tan sólo unos minutos.' },
                    { image: s3_gif2, title: 'PAGOS SEGUROS', subtitle: 'Protegemos tu dinero gracias a nuestro sistema de pagos.' },
                    { image: s3_gif3, title: 'PAGOS SIN COMISIONES', subtitle: 'No tenemos comisiones* ni costo por suscripción.' }
                ],
                s5_data: [
                    { video: s5_vid1, gif:s5_gif1, max: 85, title: 'FUNERARIOS', subtitle: '' },
                    { video: s5_vid2, gif:s5_gif2, max: 80, title: 'TELEFONÍA', subtitle: 'P R Ó X I M A M E N T E' },
                    { video: s5_vid3, gif:s5_gif3, max: 85, title: 'BÁSICOS', subtitle: 'P R Ó X I M A M E N T E' },
                    { video: s5_vid4, gif:s5_gif4, max: 85, title: 'INTERNET', subtitle: 'P R Ó X I M A M E N T E' },
                ],
            };
        },
        computed: {
            current_route_name() {
                return this.$route.name;
            }
        },
        methods: {
            redirect(name_route) {
                if(this.current_route_name !== name_route ) {
                    window.scrollTo(0, 0)

                    this.$router.push({
                        name: name_route
                    })
                }
            }
        },
        created() {
            $(window).resize(function() {
                // Image main
                let s1_video_main_height = $('#s1_video_main').height()
                $("#s1_target_video_main").css("height", s1_video_main_height)

                let s4_height = $('#s4_video').height()
                $("#s4_target_video").css("height", s4_height)

                for(let c = 0; c < 4; c++) {
                    let s5_height = $(`#s5_col_${c}_video`).height()
                    let s5_width = $(`#s5_col_${c}_video`).width()
                    $(`#s5_col_${c}_target_video`).css("height", s5_height)
                    $(`#s5_col_${c}_target_video`).css("width", s5_width)
                }
            })
        },
        mounted() {
            for(let time = 0; time < 2000; time = time + 100) {
                setTimeout(function() { 
                    $(window).trigger('resize')
                }, time)
            }
        }
    };
</script>

<style lang="scss" scoped>

</style>