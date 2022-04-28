<template>
    <div id="hc_home" class="container-fluid">
        <section id="section1" class="row d-flex p-0">
            <img :src="img_bg_green" class="img-fluid">

            <div id="s1_target" class="container-fluid position-absolute w-100">
                <div class="row h-100">
                    <div class="col-12 d-flex justify-content-center align-items-end h-100 p-3 p-lg-4 p-xl-5">
                        
                        <div class="text-center pb-0 pb-xl-5">

                            <div class="row py-0 py-md-4 d-none d-sm-flex">
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

        <section id="section2" class="row bg-light d-flex justify-content-center py-5">
            <div class="col-12 text-center mb-4">
                <span class="hc--description poppins-bold">
                    Recupera tu contraseña
                </span>
            </div>

            <div class="col-12 text-center mb-4">
                <span class="hc--description-sm">
                    Introduce a continuación una nueva contraseña.
                </span>
            </div>

            <!-- <input v-model="token" type="text" class="input hc--description text-center m-1 m-sm-2 p-2 p-sm-3"> -->
    
            <div class="col-11 col-md-7 col-lg-8 text-center mb-5">
                <div @click="changeType()" class="d-inline-block position-absolute h-100 cursor-pointer" style="padding: 0px 10px; right: 20px;">
                    <div class="d-flex justify-content-end align-items-center w-100 h-100">
                        <span class="hc--description-sm">
                            <b-icon-eye font-scale="1.2" style="color: #28a745" v-show="type == 'password'"></b-icon-eye>
                            <b-icon-eye-slash font-scale="1.2" style="color: #28a745"  v-show="type == 'text'"></b-icon-eye-slash>
                        </span>
                    </div>
                </div>
                <input v-model="password" :type="type" name="password" class="input full-width" style="padding-right: 30px;">
            </div>
            

            <!-- <div class="col-12 d-flex justify-content-center py-3">
                <input id="input_token1" v-model="token1" @input="inputToken('1')" type="text" class="input hc--description text-center m-1 m-sm-2 p-2 p-sm-3" 
                    style="max-width: 67px; width: 100%;">
                <input id="input_token2" v-model="token2" @input="inputToken('2')" type="text" class="input hc--description text-center m-1 m-sm-2 p-2 p-sm-3" 
                    style="max-width: 67px; width: 100%;">
                <input id="input_token3" v-model="token3" @input="inputToken('3')" type="text" class="input hc--description text-center m-1 m-sm-2 p-2 p-sm-3" 
                    style="max-width: 67px; width: 100%;">
                <input id="input_token4" v-model="token4" @input="inputToken('4')" type="text" class="input hc--description text-center m-1 m-sm-2 p-2 p-sm-3" 
                    style="max-width: 67px; width: 100%;">
                <input id="input_token5" v-model="token5" @input="inputToken('5')" type="text" class="input hc--description text-center m-1 m-sm-2 p-2 p-sm-3" 
                    style="max-width: 67px; width: 100%;">
                <input id="input_token6" v-model="token6" @input="inputToken('6')" type="text" class="input hc--description text-center m-1 m-sm-2 p-2 p-sm-3" 
                    style="max-width: 67px; width: 100%;">
            </div> -->

            <!-- <div class="col-12">
                <div style="color: blue;  max-width: 500px;">
                    {{token}}    
                </div>
            </div> -->

            <div class="col-12 d-flex justify-content-center py-3">
                <button id="btn_verify" @click="verifyToken()" class="btn btn-success">
                    ENVIAR
                </button>
            </div>
        </section>
        
    </div>
</template>

<script>
    import _Store from '@/store'
    // Images
    import img_bg_green from '../assets/images/backgrounds/bg-green.png'
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
                gif_simb_white,
                s2_img1,
                password: null,

                type: "password"

                // token1: null,
                // token2: null,
                // token3: null,
                // token4: null,
                // token5: null,
                // token6: null
            }
        },
        // props: {
        //     token: String,
        // },
        computed: {
            current_route_name() {
                return this.$route.name;
            },
            current_path() {
                return this.$route.fullPath;
            }

        },
        methods: {
            changeType() {
                this.type = (this.type == 'text') ? 'password' : 'text'
            },
            // onlyNumer(value) {
            //     return value.replace(/[^\d]/, '')
            // },
            // inputToken(i_token) {
            //     this[`token${i_token}`] = this.onlyNumer(this[`token${i_token}`])

            //     if(this[`token${i_token}`] !== null && this[`token${i_token}`].length > 1) {
            //         this[`token${i_token}`] = this[`token${i_token}`][1]
            //     }

            //     if(i_token < 6) {
            //         console.log(`input_token${i_token + 1}`)
            //         document.getElementById(`input_token${Number(i_token) + 1}`).focus()
            //     }
            //     else {
            //         document.getElementById('btn_verify').focus()
            //     }
                
            // },
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
            verifyToken() {
                _Store.commit('setLoad', {
                    show: true,
                    title: 'Cargando',
                    subtitle: "Verificando Token"
                })

                let details = {
                    token: this.token,
                    password: this.password
                }

                fetch(`${CONFIG.server[CONFIG.env].api}/auth/reset-password`, {
                    method: 'POST',
                    headers: {
                        'Accept': 'application/json, text/plain, /',
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify(details)
                }).then(res => res.json())
                .catch(error => {
                    console.error('Error:', error)
                })
                .then(async response => {
                    //console.log('Success:', response)
                    let message = null
                    let variant = 'success'

                    if(response === null) {
                        message = 'La contraseña ha sido cambiada'
                    }
                    else if(response['detail'] !== undefined) {
                        variant = 'danger'

                        if(response['detail'] !== undefined && response['detail']['0'].msg === "field required") {
                            //message = 'El correo es requerido'
                            message = 'Error en la peticion'
                        }
                        if(response['detail'] !== undefined && response['detail']['0'].msg === "value is not a valid email address") {
                            //message = 'Debe escribir un correo valido'
                            message = 'Error en la peticion'
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
                })
            }
        },
        created() {
            $(window).resize(function() {
                let s1_height = $('#section1').height()
                $("#s1_target").css("height", s1_height)
            })

            this.token = this.$route.params.token

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
