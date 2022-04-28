<template>
	<div id="hc_home" class="container-fluid">
		<section id="s1_video_main" class="d-flex p-0">
            <video playsinline="playsinline" autoplay="autoplay" muted="muted" loop="loop" class="video-fluid">
                <source :src="video_main" type="video/mp4">
            </video>

            <div id="s1_target_video_main" class="container-fluid position-absolute w-100">
                <div class="row h-100">
                    <div class="col-12 d-flex justify-content-center align-items-end h-100 p-3 p-lg-4 p-xl-5">
                        
                        <div class="text-center pb-0 pb-lg-5">
                            <div class="d-none d-sm-flex justify-content-center align-items-center mb-3">
                                <div style="max-width: 120px;">
                                    <img :src="s1_img1" class="img-fluid">
                                </div>
                            </div>

                            <div class="mb-2 mb-sm-2">
                                <span class="hc--title text-white">
                                    Contacto y Soporte
                                </span>
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

        <section id="section2" class="row py-5">
        <div class="col-12 col-md-6 d-flex justify-content-end align-items-center mb-4">
        <div class="pr-5" style="max-width: 400px;"><img :src="img_logo_original" class="img-fluid"></div>
        </div>
        <div class="col-12 col-md-6">
        <div class="border-left pl-5" style="max-width: 500px;">
        <span class="hc--description">Si tienes alguna duda comunícate con nosotros y nuestro equipo te ayudará a resolverla</span>
        </div>
        </div>
            <div class="col-12 py-5 mt-5">
                <div class="row d-flex justify-content-center align-items-center">

                    <div class="col-12 col-md-6 col-lg-3 d-flex justify-content-center align-items-center py-3">
                        <div>
                            <a href="mailto:hola@hispanocash.com?subject=Hola%20Hispano" target="_blank" class="align-middle a_none_decoration">
                                <div class="d-flex justify-content-center align-items-center mb-2">
                                    <div style="max-width: 80px;">
                                        <img :src="img_mail" class="img-fluid">    
                                    </div>
                                </div>
                                <span class="hc--description">
                                    hola@hispanocash.com
                                </span>
                            </a>
                        </div>
                    </div>

                    <div class="col-12 col-md-6 col-lg-3 d-flex justify-content-center align-items-center py-3">
                        <div>
                            <a href="tel:8552748949" target="_blank" class="align-middle a_none_decoration">
                                <div class="d-flex justify-content-center align-items-center mb-2">
                                    <div style="max-width: 80px;">
                                        <img :src="img_phone" class="img-fluid">    
                                    </div>
                                </div>
                                <span class="hc--description">
                                    855 274 8949
                                </span>
                            </a>
                        </div>
                    </div>

                    <div class="col-12 col-md-6 col-lg-3 d-flex justify-content-center align-items-center py-3">
                        <div>
                            <a href="https://api.whatsapp.com/send?phone=+523326178500&text=Hola%20Hispano" target="_blank" class="align-middle a_none_decoration">
                                <div class="d-flex justify-content-center align-items-center mb-2">
                                    <div style="max-width: 80px;">
                                        <img :src="img_whats" class="img-fluid">    
                                    </div>
                                </div>
                                <span class="hc--description">
                                    33 2617 8500
                                </span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section id="section3" class="row d-flex p-0">
            <div class="col-12 mb-4 px-4 px-xl-4 py-5" :style="{ 'background-image': 'url(' + img_bg_green + ')' }">
                <div class="row px-0 px-xl-5 py-0 py-xl-4">
                    <div class="col-12 text-center mb-4 py-2 py-xl-3">
                        <span class="hc--description text-white">
                            O si deseas puedes enviarnos un mensaje a través del siguiente formulario:
                        </span>
                    </div>
                    <div class="col-12 d-flex justify-content-center align-items-center">
                        <div style="max-width: 800px">
                            <div class="row">
                                <div class="col-12 py-2 py-xl-3">
                                    <input v-model="form.name" type="text" name="name" placeholder="Nombre completo*" class="input full-width">
                                </div>
                                <div class="col-12 col-sm-6 py-2 py-xl-3">
                                    <input v-model="form.phone" type="text" name="phone" placeholder="Teléfono*" class="input full-width">
                                </div>
                                <div class="col-12 col-sm-6 py-2 py-xl-3">
                                    <input v-model="form.email" type="text" name="email" placeholder="Correo electrónico*" class="input full-width">
                                </div>
                                <div class="col-12 col-sm-6 py-2 py-xl-3">
                                    <input v-model="form.city" type="text" name="city" placeholder="Ciudad*" class="input full-width">
                                </div>
                                <div class="col-12 col-sm-6 py-2 py-xl-3">
                                    <input v-model="form.federative_entity" type="text" name="federative_entity" placeholder="Estado*" class="input full-width">        
                                </div>
                                <div class="col-12 d-flex justify-content-end align-items-center pt-4 pt-xl-5">
                                    <button @click="sendMail()" class="btn btn-light">
                                        <span class="hc--description-sm">
                                            ENVIAR MENSAJE
                                        </span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                </div>
                
            </div>



            <!-- <img :src="img_bg_green" class="img-fluid">

            <div id="s3_target" class="container-fluid position-absolute w-100">
                <div class="row h-100">
                    <div class="col-12 d-flex justify-content-center align-items-center h-100 p-5">
                        
                        <div class="text-center">

                            <div class="row d-none d-xl-flex justify-content-center align-items-end mb-3">
                                <div class="col-12 mb-3 mb-xl-5">
                                    <span class="hc--description text-white ">
                                        O si deseas puedes enviarnos un mensaje a tréves del siguiente formulario:
                                    </span>
                                </div>

                                <div class="col-12 col-lg-8 col-xl-6">
                                    <div class="row">
                                        <div class="col-12 py-2 py-xl-3">
                                            <input type="" name="" placeholder="Nombre completo*" class="input full-width">
                                        </div>
                                        <div class="col-12 col-sm-6 py-2 py-xl-3">
                                            <input type="" name="" placeholder="Teléfono*" class="input full-width">
                                        </div>
                                        <div class="col-12 col-sm-6 py-2 py-xl-3">
                                            <input type="" name="" placeholder="Correo electrónico*" class="input full-width">
                                        </div>
                                        <div class="col-12 col-sm-6 py-2 py-xl-3">
                                            <input type="" name="" placeholder="Ciudad*" class="input full-width">
                                        </div>
                                        <div class="col-12 col-sm-6 py-2 py-xl-3">
                                            <input type="" name="" placeholder="Estado*" class="input full-width">        
                                        </div>
                                        <div class="col-12 d-flex justify-content-end align-items-center pt-4 pt-xl-5">
                                            <button class="btn btn-light">
                                                <span class="hc--description-sm">
                                                    ENVIAR MENSAJE
                                                </span>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div> -->
        </section>
</div>
</template>

<script>
	// Videos
	import video_main from '../assets/videos/contact/section1/loop-contacto.mp4'

	// Gifs
    import s1_gif1 from '../assets/gifs/símbolo-hispano.gif'
    import s1_img1 from '../assets/images/simbolo-hispano.png'
    import gif_logo_original from '../assets/gifs/hispano-original.gif'
    import img_logo_original from '../assets/images/logo-hisp.png'
    
    // Images
    import img_mail from '../assets/images/contact/icon-mail.png'
    import img_phone from '../assets/images/contact/icon-phone.png'
    import img_whats from '../assets/images/contact/icon-whats.png'

    import img_fb from '../assets/images/sociality/fb.png'
    import img_tk from '../assets/images/sociality/tk.png'
    import img_ig from '../assets/images/sociality/ig.png'
    import img_bg_green from '../assets/images/backgrounds/bg-green.png'
    import img_logo_white from '../assets/images/logo-hispano-blanco.png'
    
	// jQuery
    import $ from 'jquery'
    var CONFIG = require('../page.config.js')
    
	export default {
		name: 'hc_home',
		data() {
			return {
				video_main,

				s1_gif1,
                s1_img1,
                gif_logo_original,
                img_logo_original,

                img_mail,
                img_phone,
                img_whats,

                img_fb,
                img_tk,
                img_ig,
                img_bg_green,
                img_logo_white,

                form: {
                    name: null,
                    phone: null,
                    email: null,
                    city: null,
                    federative_entity: null,
                    message: null
                },
                sended_email: false
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
            },
            sendMail() {
                this.sended_email = true
                
                fetch(`${CONFIG.server[CONFIG.env].page_url}/send_email.php`, {
                    method: 'POST',
                    headers: {
                        'Accept': 'application/json, text/plain, /',
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({ 
                        name: this.form.name, 
                        phone: this.form.phone, 
                        email: this.form.email,
                        city: this.form.city,
                        federative_entity: this.form.federative_entity, 
                        message: this.form.message 
                    })
                }).then(res => res.json())
                .catch(error => console.error('Error:', error))
                .then(response => console.log('Success:', response));

                $(document).ready(function() {
                    $("body").children().each(function() {
                        $(this).html($(this).html().replace(/&#8232;/g," "))
                    })
                })
            }
        },
        created() {
            $(window).resize(function() {
                // Image main
                let s1_video_main_height = $('#s1_video_main').height()
                $("#s1_target_video_main").css("height", s1_video_main_height)

                let s3_height = $('#section3').height()
                $("#s3_target").css("height", s3_height)

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
