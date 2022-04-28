<template>
	<div id="hc_home" class="container-fluid">
		<section id="s1_video_main" class="row d-flex p-0">
            <video playsinline="playsinline" autoplay="autoplay" muted="muted" loop="loop" class="video-fluid">
                <source :src="video_main" type="video/mp4">
            </video>

            <div id="s1_target_video_main" class="container-fluid position-absolute w-100">
                <div class="row h-100">
                    <div class="col-12 d-flex justify-content-center align-items-end h-100 p-1 p-sm-3 p-md-5">
                        
                        <div class="text-center pb-0 pb-lg-5">
                        <div class="mb-2 d-flex justify-content-center align-items-end align-items-xl-center">
                        <div class="d-none d-sm-block mb-0 mb-xl-3" style="max-width: 120px;">
                        <img :src="s1_img1" class="img-fluid">  
                        </div>
                        </div>
                        <div class="mb-2">
                        <span class="hc--title text-white">¿Cómo funciona?</span>
                        </div>

                        <div class="pb-0 pb-xl-5">
                        <span class="hc--description-sm text-white">TU PLATAFORMA DE PAGOS A MÉXICO</span>
                        </div>
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

        <section id="section2" class="row d-flex p-0">
            <img :src="img_bg_green" class="img-fluid">

            <div id="s2_target" class="container-fluid position-absolute w-100">
                <div class="row h-100">
                    <div class="col-12 d-flex justify-content-center align-items-center h-100 p-2 p-md-5">
                        <div class="row d-flex justify-content-center align-items-end">
                            <div class="col-12 text-center">
                                <span class="hc--title text-white">
                                    Sigue estos pasos para <br class="d-none d-md-flex">
                                    realizar tus pagos a través de
                                </span> 
                            </div>

                            <div class="col-12 d-none d-sm-flex justify-content-center align-items-end py-0 pt-sm-2 pt-md-5">
                                <div>
                                    <img :src="img_logo_white" class="img-fluid">    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section id="section3" class="row d-flex p-0">

            <div data-aos="fade-right" class="col-12 d-flex justify-content-start align-items-center py-5 px-2 px-lg-5">
                <img id="s3_img1" :src="s3_img1" class="img-fluid">

                <div id="s3_target_1" class="position-absolute p-3 p-lg-5">
                    <img :src="s3_img_line_r" class="img-fluid position-absolute d-none d-xxl-block" style="right: -112px; bottom: -48px">

                    <div class="mb-3">
                        <span class="hc--title-xl text-white float-left mr-3">
                            01
                        </span>
                        <div class="pt-2">
                            <span class="hc--title-sm poppins-bold text-white">
                                Solicita un <br class="d-none d-md-flex">
                                número de <br class="d-none d-md-flex">
                                referencia
                            </span>
                        </div>
                    </div>

                    <div class="d-none d-sm-block">
                        <span class="hc--description text-white">
                            Llama a nuestro Call Center al <br class="d-none d-md-flex">
                            855 274 8949, y solicita un número de <br class="d-none d-md-flex">
                            referencia para realizar tu pago.
                        </span>    
                    </div>
                </div>
            </div>

            <div data-aos="fade-left" class="col-12 d-flex justify-content-end align-items-center pb-5 px-2 px-lg-5">
                <img id="s3_img2" :src="s3_img2" class="img-fluid">

                <div id="s3_target_2" class="position-absolute p-3 p-lg-5">
                    <img :src="s3_img_line_l" class="img-fluid position-absolute d-none d-xxl-block" style="left: -112px; bottom: -48px">

                    <div class="mb-3">
                        <span class="hc--title-xl text-white float-left mr-3" style="margin-bottom: 4em">
                            02
                        </span>
                        <div class="pt-2">
                            <span class="hc--title-sm poppins-bold text-white">
                                Ingresa al <br class="d-none d-md-flex">
                                portal de <br class="d-none d-md-flex">
                                pagos <span class="d-none d-sm-block">o <br class="d-none d-md-flex">
                                escanea <br class="d-none d-md-flex">
                                directamente <br class="d-none d-md-flex">
                                el código QR</span>
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <div data-aos="fade-right" class="col-12 d-flex justify-content-start align-items-center pb-5 px-2 px-lg-5">
                <img id="s3_img3" :src="s3_img3" class="img-fluid">

                <div id="s3_target_3" class="position-absolute p-3 p-lg-5">
                    <img :src="s3_img_line_r" class="img-fluid position-absolute d-none d-xxl-block" style="right: -112px; bottom: -48px">

                    <div class="mb-3 mb-sm-5 mb-md-3 mb-lg-5">
                        <span class="hc--title-xl text-white float-left mr-3">
                            03
                        </span>
                        <div class="pt-2">
                            <span class="hc--title-sm poppins-bold text-white">
                                Inicia sesión <br class="d-none d-md-flex">
                                en tu cuenta
                            </span>
                        </div>
                    </div>

                    <div class="d-none d-sm-block">
                        <span class="hc--description text-white">
                            Selecciona el pago de servicios que <br class="d-none d-md-flex">
                            deseas realizar e Inicia Sesión en tu <br class="d-none d-md-flex">
                            cuenta.
                        </span>
                    </div>
                </div>
            </div>

            <div data-aos="fade-left" class="col-12 d-flex justify-content-end align-items-center pb-5 px-2 px-lg-5">
                <img id="s3_img4" :src="s3_img4" class="img-fluid">

                <div id="s3_target_4" class="position-absolute p-3 p-lg-5">
                    <!-- <img :src="s3_img_line_l" class="img-fluid position-absolute d-none d-xxl-block" style="left: -112px; bottom: -48px"> -->

                    <div class="mb-3 mb-sm-5 mb-md-3 mb-lg-5">
                        <span class="hc--title-xl text-white float-left mr-3">
                            04
                        </span>
                        <div class="pt-2">
                            <span class="hc--title-sm poppins-bold text-white">
                                Realiza <br class="d-none d-md-flex">
                                tu pago
                            </span>    
                        </div>
                    </div>

                    <div class="d-none d-sm-block">
                        <span class="hc--description text-white">
                            Captura el número de referencia <br class="d-none d-md-flex">
                            que te proporcionaron y realiza <br class="d-none d-md-flex">
                            tu pago.
                        </span>    
                    </div>
                </div>
            </div>
        </section>

        <section id="section4" class="row d-flex p-0">
            <img :src="s4_img1" class="img-fluid">

            <div id="s4_target" class="container-fluid position-absolute w-100">
                <div class="row h-100">
                    <div class="col-12 d-flex justify-content-end align-items-center h-100 p-4 p-lg-4 p-xl-5">
                        
                        <div class="w-100 p-0 px-xl-5">

                            <div class="row d-flex justify-content-end align-items-center p-0 p-xl-5">
                                <div class="p-0 px-xl-5" style="max-width: 680px;">
                                    <div style="max-width: 120px;">
                                        <img :src="s1_img1" class="img-fluid d-none d-md-flex">
                                    </div>

                                    <div class="mt-2 mt-xl-4 d-none d-sm-block" style="max-width: 550px;">
                                        <span class="hc--title poppins-regular text-white">
                                            Comienza hoy mismo
                                            a realizar <span class=" poppins-bold">tus pagos
                                            a cualquier parte de México</span>
                                        </span>
                                    </div>

                                    <div class="mt-2 mt-xl-4" style="max-width: 350px;">
                                        <button @click="redirect('payment_services')" class="btn btn-success mx-1">
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
</div>
</template>

<script>
	// Videos
	import video_main from '../assets/videos/howWork/loop-como-funciona.mp4'

	// Gifs
	import s1_gif1 from '../assets/gifs/símbolo-hispano.gif'
    import s1_img1 from '../assets/images/simbolo-hispano.png'

    // Images
    import img_fb from '../assets/images/sociality/fb.png'
    import img_tk from '../assets/images/sociality/tk.png'
    import img_ig from '../assets/images/sociality/ig.png'

    import img_bg_green from '../assets/images/backgrounds/bg-green.png'
    import img_logo_white from '../assets/images/logo-hispano-blanco.png'

    import s3_img1 from '../assets/images/howWork/section3/step-01.png'
    import s3_img2 from '../assets/images/howWork/section3/step-02.png'
    import s3_img3 from '../assets/images/howWork/section3/step-03.png'
    import s3_img4 from '../assets/images/howWork/section3/step-04.png'
    import s3_img_line_l from '../assets/images/howWork/section3/line-l.png'
    import s3_img_line_r from '../assets/images/howWork/section3/line-r.png'

    import s4_img1 from '../assets/images/howWork/section4/foto-comienza.jpg'
    
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

				s1_gif1,
                s1_img1,

                img_bg_green,
                img_logo_white,

                s3_img1,
                s3_img2,
                s3_img3,
                s3_img4,
                s3_img_line_l,
                s3_img_line_r,
                
                s4_img1,
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

                let s2_height = $('#section2').height()
                $("#s2_target").css("height", s2_height)

                for(let c = 1; c <= 4; c++) {
                    let s3_height = $(`#s3_img${c}`).height()
                    let s3_width = $(`#s3_img${c}`).width()
                    $(`#s3_target_${c}`).css("height", s3_height)
                    $(`#s3_target_${c}`).css("width", s3_width)
                }

                let s4_height = $('#section4').height()
                $("#s4_target").css("height", s4_height)
                
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
    @media (min-width: 1640px) {
        .d-xxl-block {
            display: block !important;
        }
    }
</style>
