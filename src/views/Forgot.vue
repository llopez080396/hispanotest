<template>
    <div id="hc_home" class="container-fluid">
        <section id="section1" class="row d-flex p-0">
            <img :src="img_bg_green_cut" class="img-fluid d-none d-sm-flex">
            <img :src="img_bg_green" class="img-fluid d-flex d-sm-none">

            <div id="s1_target" class="container-fluid position-absolute w-100">
                <div class="row h-100">
                    <div class="col-12 d-flex justify-content-center align-items-end h-100 p-1 p-sm-3 p-xl-3">
                        
                        <div class="text-center">

                            <div class="row py-0 py-xl-4 d-none d-lg-flex">
                                <div class="col-12 d-flex justify-content-center align-items-end">
                                    <div style="max-width: 120px;">
                                        <img :src="gif_simb_white" class="img-fluid">    
                                    </div>
                                </div>
                            </div>

                            <div class="row d-flex justify-content-center align-items-end mb-1 mb-sm-1 mb-md-3">
                                <div class="col-12">
                                    <span class="hc--title poppins-regular text-white">
                                        Pago de <span class="poppins-bold">servicios</span>
                                    </span> 
                                </div>
                            </div>
                            
                        </div>
                        
                    </div>
                </div>
            </div>
        </section>

        <section id="section2" class="row bg-light d-flex justify-content-center pt-3 px-2 px-xl-5 pb-5" v-if="!sended">
            <div class="col-12 col-md-12 col-lg-12 col-xl-10 text-left">
                <button @click="redirect('login')" class="btn btn-link text-decoration-none">
                    <b-icon icon="arrow-left" aria-hidden="true" font-scale="1.2" style="color: #28a745"></b-icon>
                    <span class="hc--description-sm poppins-regular align-middle">
                        Atras
                    </span>
                </button>
            </div>

            <div class="col-12 text-center mb-4">
                <span class="hc--description poppins-bold">
                    ¿Olvidaste tu contraseña?
                </span>
            </div>

            <div class="col-12 text-center mb-4">
                <span class="hc--description-sm">
                    Introduce a continuación tu correo electrónico para <br class="d-none d-md-flex">
                    solicitar el restablecimiento de tu contraseña:
                </span>
            </div>

            <div class="col-12 col-md-10 col-lg-9 col-xl-5 py-3">
                <input v-model="email" type="email" name="" class="input full-width">
            </div>

            <div class="col-12 d-flex justify-content-center py-3">
                <button @click="recoveryPasword()" class="btn btn-success">
                    ENVIAR
                </button>
            </div>
        </section>

        <section id="section2" class="row bg-light d-flex justify-content-center py-5" v-if="sended">
            <div class="col-12 text-center mb-4">
                <span class="hc--description poppins-bold">
                    Se ha enviado un una liga a su correo electrónico
                </span>
            </div>
        </section>
        
    </div>
</template>

<script>
    import _Store from '@/store'
    // Images
    import img_bg_green from '../assets/images/backgrounds/bg-green.png'
    import img_bg_green_cut from '../assets/images/backgrounds/bg-green-cut.png'
    import s2_img1 from '../assets/images/login/logo-pabs.png'
    // Gifs
    import gif_simb_white from '../assets/gifs/simbolo-blanco.gif'    
    
    // jQuery
    import $ from 'jquery'
    var CONFIG = require('../page.config.js')
    
    export default {
        name: 'hc_home',
        data() {
            return {
                img_bg_green,
                img_bg_green_cut,
                gif_simb_white,
                s2_img1,

                email: null,
                sended: false
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
            // async test() {
            //     var promise = new Promise(function(resolve, reject) {
            //         setTimeout(function() {
            //             _Store.commit('setAlert', {
            //                 open: true,
            //                 message: 'Simulación, código recibido 123456',
            //                 variant: 'warning',
            //                 timeout: 5000
            //             })

            //             resolve(true)
            //         }, 5000)
            //     })
            //     return promise
            // },
            recoveryPasword() {
                _Store.commit('setLoad', {
                    show: true,
                    title: 'Enviando Correo',
                    subtitle: ""
                })

                let details = {
                    email: this.email
                }

                fetch(`${CONFIG.server[CONFIG.env].api}/auth/forgot-password`, {
                    method: 'POST',
                    headers: {
                        'Accept': 'application/json, text/plain, /',
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify(details)
                }).then(res => res.json())
                .catch(error => {console.error('Error:', error)})
                .then(async response => {
                    //console.log('Success:', response)

                    let message = null
                    let variant = 'success'
                    //let test = false

                    if(response === null) {
                        message = 'El código de verificación ha sido enviado'
                    }
                    else if(response['detail'] !== undefined) {
                        variant = 'danger'

                        if(response['detail'] !== undefined && response['detail']['0'].msg === "field required") {
                            message = 'El correo es requerido'
                        }
                        if(response['detail'] !== undefined && response['detail']['0'].msg === "value is not a valid email address") {
                            message = 'Debe escribir un correo valido'
                        }
                    }
                    _Store.commit('setLoad', {
                        show: false,
                    })

                    _Store.commit('setAlert', {
                        open: true,
                        message: message,
                        variant: variant
                    })

                    // if(test) {
                    //     this.sended = await this.test().then(function(done) {
                    //         return done
                    //     })
                    // }
                })
            }
        },
        created() {
            $(window).resize(function() {
                let s1_height = $('#section1').height()
                $("#s1_target").css("height", s1_height)

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
