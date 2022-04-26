<template>
	<div id="hc_home" class="container-fluid">
		<section id="s1_video_main" class="d-flex p-0">
            <video playsinline="playsinline" autoplay="autoplay" muted="muted" loop="loop" class="video-fluid">
                <source :src="video_main" type="video/mp4">
            </video>
            <div id="s1_target_video_main" class="container-fluid position-absolute w-100">
                <div class="row h-100">
                    <div class="col-12 d-flex justify-content-center align-items-end h-100 p-2 p-sm-5">
                        <div class="text-center pb-0 pb-lg-5">
                        <div class="mb-1">
                        <span class="hc--title poppins-regular text-white">Estamos aquí</span>	
                        </div>
                        <div class="mb-0 mb-sm-3"><span class="hc--title text-white">Para que tú estés ahí.</span></div>
                        <div class="d-none d-sm-block text-center pb-0 pb-lg-5"><span class="hc--description-sm text-white">TU PLATAFORMA DE PAGOS A MÉXICO</span></div>
                        </div>
                    </div>
                    <div class="d-none d-sm-block position-absolute" style="position: absolute; bottom: 0px; right: 10px;">
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
        <section id="section2" class="row py-5">
        <div class="col-12 col-md-5 d-flex justify-content-start justify-content-md-end align-items-center mb-4">
        <div style="max-width: 120px;"><img :src="s2_gif1" class="img-fluid"></div>
        </div>
        <div class="col-12 col-md-7  mb-4">
        <div class="border-left pl-5" style="max-width: 580px;"><span class="hc--description">HispanoCash© es la plataforma de pagos por internet más <span class="poppins-bold">rápida, confiable y segura</span>, para pagar los servicios de tus seres queridos en México.</span></div></div>
        </section>
        <section id="section3" class="d-flex justify-content-center align-items-center p-0" :style="{ 'background-image': `url(${s3_img1})` }" style="min-height: 650px;">
            <div class="container-fluid position-absolute w-100">
                <div class="row h-100">
                    <div class="col-12 d-flex justify-content-center align-items-center h-100 p-1 p-xl-5">
                        
                        <div class="row d-flex justify-content-center align-items-center text-center h-100">

                            <div class="col-12 d-none d-sm-flex justify-content-center align-items-end my-3">
                                <span class="hc--title poppins-regular text-white">
                                    ¿Por qué elegir a 
                                    <div class="d-inline-block" style="max-width: 300px;">
                                        <img :src="img_logo_white" class="img-fluid">
                                    </div>?
                                </span>
                            </div>
                            <div class="col-12 py-4">
                                <div class="row d-flex justify-content-center align-items-center">
                                    <div class="col-7 col-sm-4 col-xl-3" v-for="col in s3_data" :key="col.id">
                                        <div class="row d-flex justify-content-center align-items-center mb-1">
                                            <div class="col-12 d-flex justify-content-center align-items-center">
                                                <div style="max-width: 180px;">
                                                    <img :src="col.image" class="img-fluid">
                                                </div>
                                            </div>

                                            <div class="col-12 d-flex justify-content-center align-items-center mb-2">
                                                <div style="max-width: 200px;">
                                                    <span class="hc--description poppins-bold text-white">
                                                        {{ col.title }}
                                                    </span>
                                                </div>
                                            </div>
                                            
                                            <div class="col-12 d-none d-xl-flex justify-content-center align-items-center">
                                                <div style="max-width: 270px;">
                                                    <span class="hc--description poppins-regular text-white">
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
                </div>
            </div>
        </section>

        <section id="section4" class="d-flex p-0">
            <video playsinline="playsinline" autoplay="autoplay" muted="muted" loop="loop" class="video-fluid">
                <source :src="s4_vid1" type="video/mp4">
            </video>

            <div id="s4_target" class="container-fluid position-absolute w-100">
                <div class="row h-100">
                    <div class="col-12 d-flex justify-content-end align-items-center align-items-md-start h-100 p-1 p-sm-3 p-md-5">
                        
                        <div class="w-100 p-0 p-xl-5">

                            <div class="row d-flex justify-content-end align-items-center">
                                <div style="max-width: 680px;">
                                    <span class="d-none d-sm-block hc--title poppins-regular text-white">
                                        Paga los servicios de tus seres queridos desde EUA <span class=" poppins-bold">a cualquier parte de México</span>
                                    </span>

                                    <div class="mt-4">
                                        <button @click="redirect('how_work')" class="btn btn-success m-1">
                                            COMO FUNCIONA
                                        </button>

                                        <button @click="redirect('payment_services')" class="btn btn-success m-1">
                                            PAGAR SERVICIOS
                                        </button>
                                    </div>
                                </div>
                            </div>
                            
                        </div>
                        
                    </div>
                </div>
            </div>
        </section>

        <section id="section5" class="d-flex p-0 pb-5">
            <img :src="bg_green_right" class="img-fluid">

            <div id="s5_target" class="container-fluid position-absolute w-100">
                <div class="row h-100">
                    <div class="col-6 d-flex justify-content-center align-items-center h-100 p-5">

                        <div style="max-width: 680px;">
                            <div class="d-none d-sm-flex mb-3" style="max-width: 300px;">
                                <span class="hc--title poppins-regular">
                                    Envía paz y tranquilidad <span class="poppins-bold">a los tuyos</span>
                                </span>    
                            </div>

                            <div class="d-none d-lg-flex mb-4" style="max-width: 410px;">
                                <span class="hc--description">
                                    Con HispanoCash© ayuda a los 
                                    tuyos previniendo y 
                                    solucionando desde hoy los 
                                    problemas que inevitablemente 
                                    enfrentaremos el día de mañana.
                                </span>
                            </div>

                            <div>
                                <button @click="redirect('payment_services')" class="btn btn-success mx-1">
                                    PAGAR SERVICIOS
                                </button>
                            </div>
                        </div>

                    </div>
                    <div class="col-6 d-flex justify-content-center align-items-center h-100 p-1 p-sm-3 p-lg-5">
                        <div style="max-width: 680px;">
                            <video playsinline="playsinline" autoplay="autoplay" muted="muted" loop="loop" class="video-fluid">
                                <source :src="s5_vid1" type="video/mp4">
                            </video>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section id="section6" class="d-flex p-0">
            <img :src="s6_img1" class="img-fluid">

            <div id="s6_target" class="container-fluid position-absolute w-100">
                <div class="row h-100">
                    <div class="col-12 d-flex justify-content-end align-items-center h-100 p-5 p-xl-5">
                        
                        <div class="w-100 p-0 px-xl-5">

                            <div class="row d-flex justify-content-end align-items-center p-0 p-xl-5">
                                <div class="p-0 px-xl-5" style="max-width: 680px;">
                                    <div class="d-none d-sm-flex" style="max-width: 350px;">
                                        <img :src="gif_logo_color" class="img-fluid">
                                    </div>

                                    <div class="mt-4" style="max-width: 350px;">
                                        <span class="hc--title poppins-regular text-white">
                                            Aseguramos <span class=" poppins-bold">el bienestar de los tuyos</span>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            
                        </div>
                        
                    </div>
                </div>
            </div>
        </section>
</div>
</template>

<script>
	// Videos
	import video_main from '../assets/videos/home/section1/loop-index.mp4'
    import s4_vid1 from '../assets/videos/home/section4/loop-lap.mp4'
    import s5_vid1 from '../assets/videos/home/section5/loop-madre.mp4'

	// Gifs
	import s2_gif1 from '../assets/images/home/simbolo-hispano.png'

    import s3_gif1 from '../assets/gifs/home/section3/inmediatos.gif'
    import s3_gif2 from '../assets/gifs/home/section3/seguros.gif'
    import s3_gif3 from '../assets/gifs/home/section3/sin-comisiones.gif'

    import gif_logo_color from '../assets/gifs/hispano-verde-blanco.gif'
    

    // Images
    import img_fb from '../assets/images/sociality/fb.png'
    import img_tk from '../assets/images/sociality/tk.png'
    import img_ig from '../assets/images/sociality/ig.png'

    import s3_img1 from '../assets/images/backgrounds/bg-green.png'
    import img_logo_white from '../assets/images/logo-hispano-blanco.png'

    import bg_green_right from '../assets/images/backgrounds/bg-green-right.png'

    import s6_img1 from '../assets/images/home/section6/aseguramos-fondo.jpg'
    
	// jQuery
    import $ from 'jquery'
    
	export default {
		name: 'hc_home',
		data() {
			return {
				video_main,
                img_fb,
                img_tk,
                img_ig,

				s2_gif1,

                s3_img1,
                img_logo_white,

                s3_data: [
                    { id:'1',image: s3_gif1, title: 'PAGOS INMEDIATOS', subtitle: 'Tu dinero estará en su destino en tan sólo unos minutos.' },
                    { id:'2',image: s3_gif2, title: 'PAGOS SEGUROS', subtitle: 'Protegemos tu dinero gracias a nuestro sistema de pagos.' },
                    { id:'3',image: s3_gif3, title: 'PAGOS SIN COMISIONES', subtitle: 'No tenemos comisiones* ni costo por suscripción.' }
                ],

                s4_vid1,

                bg_green_right,

                s5_vid1,

                s6_img1,

                gif_logo_color
			}
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

                // let s3_height = $('#section3').height()
                // $("#s3_target").css("height", s3_height)

                let s4_height = $('#section4').height()
                $("#s4_target").css("height", s4_height)

                let s5_height = $('#section5').height()
                $("#s5_target").css("height", s5_height)

                let s6_height = $('#section6').height()
                $("#s6_target").css("height", s6_height)
                
            })
        },
        mounted() {
            for(let time = 0; time < 2000; time = time + 100) {
                setTimeout(function() { 
                    $(window).trigger('resize')
                }, time)
            }
        }
	}
</script>

<style lang="scss" scoped>
	
</style>
