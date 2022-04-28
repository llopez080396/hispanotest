<template>
    <div id="hc_register" class="container-fluid">
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

        <section id="section2" class="row bg-light d-flex justify-content-center pt-3 px-2 px-xl-5">
            <div class="col-12 col-md-12 col-lg-12 col-xl-10 text-left">
                <button @click="redirect('login')" class="btn btn-link text-decoration-none">
                    <b-icon icon="arrow-left" aria-hidden="true" font-scale="1.2" style="color: #28a745"></b-icon>
                    <span class="hc--description-sm poppins-regular align-middle">
                        Atras
                    </span>
                </button>
            </div>
            <div class="col-12 col-md-8 col-lg-8 col-xl-7 text-left mb-4">
                <span class="hc--description poppins-bold">
                    Crea una nueva cuenta
                </span>
            </div>
        </section>

        


        <section id="section3" class="row bg-light d-flex justify-content-center pb-5 px-2 px-xl-5">
            <div class="col-12 col-md-8 col-lg-8 col-xl-7 hc--rounded mb-4 px-2 px-md-4 py-5" :style="{ 'background-image': 'url(' + img_bg_green + ')' }">
                <div class="row px-0 px-xl-5 py-0 py-xl-4">
                    <div class="col-12 py-2 py-xl-3">
                        <span class="hc--description-sm text-white">
                            Nombre completo
                        </span>
                        <input v-model="full_name" type="text" name="" class="input full-width">
                    </div>
                    <div class="col-12 py-2 py-xl-3">
                        <span class="hc--description-sm text-white">
                            Contraseña
                        </span>
                        <!-- <input v-model="password" type="password" name="" class="input full-width"> -->
                        <div class="row">
                            <div class="col-12 p-0">
                                <div @click="changeType()" class="d-inline-block position-absolute h-100 cursor-pointer" style="padding: 0px 10px; right: 0px;">
                                    <div class="d-flex justify-content-end align-items-center w-100 h-100">
                                        <span class="hc--description-sm">
                                            <b-icon-eye font-scale="1.2" style="color: #28a745" v-show="type == 'password'"></b-icon-eye>
                                            <b-icon-eye-slash font-scale="1.2" style="color: #28a745"  v-show="type == 'text'"></b-icon-eye-slash>
                                        </span>
                                    </div>
                                </div>
                                <input v-model="password" :type="type" name="password" class="input full-width" style="padding-right: 30px;">
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-sm-12 py-2 py-xl-3">
                        <span class="hc--description-sm text-white">
                            Teléfono
                        </span>

                        <vue-phone-number-input 
                            v-model="phone" 
                            :translations="translations" 
                            @update="functionP($event)"
                            default-country-code="US"
                            :preferred-countries="['MX', 'US']"
                            valid-color="#07a835"
                            size="lg"
                            no-example
                            loader>
                        </vue-phone-number-input>

                        <!-- <input v-model="phone" type="text" name="" class="input full-width"> --> 
                    </div>
                    <div class="col-12 col-sm-6 py-2 py-xl-3">
                        <span class="hc--description-sm text-white">
                            Correo electrónico
                        </span>
                        <input v-model="email" type="email" name="" class="input full-width">    
                    </div>
                    <!-- <div class="col-12 col-sm-6 py-2 py-xl-3">
                        <span class="hc--description-sm text-white">
                            Pais
                        </span>
                        <input v-model="country" type="" name="" class="input full-width">        
                    </div> -->
                    <div class="col-12 col-sm-6 py-2 py-xl-3">
                        <span class="hc--description-sm text-white">
                            Ciudad
                        </span>
                        <input v-model="city" type="" name="" class="input full-width">        
                    </div>
                    <div class="col-12 d-flex justify-content-center align-items-center pt-4 pt-xl-5">
                        <button @click="register()" class="btn btn-outline-light">
                            CREAR CUENTA
                        </button>
                    </div>
                </div>
                
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
    // Components 
    import VuePhoneNumberInput from 'vue-phone-number-input';
    import 'vue-phone-number-input/dist/vue-phone-number-input.css';
    
    // jQuery
    import $ from 'jquery'
    var CONFIG = require('../page.config.js')
    
    export default {
        name: 'hc_home',
        components: {
            'vue-phone-number-input': VuePhoneNumberInput
        },
        data() {
            return {
                img_bg_green,
                img_bg_green_cut,
                gif_simb_white,
                s2_img1,

                full_name: null,
                phone: null,
                phone_formated: null,
                email: null,
                password: null,
                country: null,
                city: null,
                
                type: 'password',

                translations: {
                    countrySelectorLabel: 'País',
                    countrySelectorError: '',
                    phoneNumberLabel: 'Número telefónico',
                    example: ''
                }

                // full_name: 'asd',
                // phone: '+52 3312345678',
                // email: 'test@test.com.mx',
                // password: 'asd',
                // city: 'asd',
                // state: 'asd'
            }
        },
        computed: {
            current_route_name() {
                return this.$route.name;
            }
        },
        methods: {
            changeType() {
                this.type = (this.type == 'text') ? 'password' : 'text'
            },
            redirect(name_route) {
                if(this.current_route_name !== name_route ) {
                    window.scrollTo(0, 0)

                    this.$router.push({
                        name: name_route
                    })
                }
            },
            functionP(evnt) {
                //console.log(evnt)

                if(evnt && evnt.nationalNumber) {
                    console.log(`+${evnt.countryCallingCode} ${evnt.nationalNumber}`)
                    this.phone_formated = `+${evnt.countryCallingCode}${evnt.nationalNumber}`
                }
            },
            register() {
                _Store.commit('setLoad', {
                    show: true,
                    title: 'Creando cuenta',
                    subtitle: "Espere un momento, por favor"
                })

                let details = { 
                    full_name: this.full_name, 
                    password: this.password,
                    phone_number: this.phone_formated, 
                    email: this.email, 
                    is_active: true, 
                    is_superuser: false, 
                    is_verified: false, 
                    roles: [
                        "role:finances"
                    ],
                    origin: 'USA'
                }

                //let formBody = []
                // for (var property in details) {
                //     var encodedKey = encodeURIComponent(property)
                //     var encodedValue = encodeURIComponent(details[property])
                //     formBody.push(encodedKey + "=" + encodedValue)
                // }
                // formBody = formBody.join("&")

                fetch(`${CONFIG.server[CONFIG.env].api}/auth/register`, {
                    method: 'POST',
                    headers: {
                        'Accept': 'application/json, text/plain, /',
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify(details)
                    //body: formBody
                }).then(res => res.json())
                .catch(error => {
                    console.error('Error:', error)
                })
                .then(async response => {
                    //console.log('Success:', response)

                    if(response['_id'] !== undefined) {
                        _Store.commit('setAlert', {
                            open: true,
                            message: 'Usuario ha sido registrado'
                        })
                    }
                    else if(response['detail'] !== undefined) {
                        let message = []

                        if(response['detail'] === "REGISTER_USER_ALREADY_EXISTS") {
                            message = 'El usuario ya se encuentra registrado'
                        }
                        else if(response['detail']['0'].msg === 'Invalid phone number, country code and phone number must be valid.') {
                            message = 'Número teléfonico invalido, debe contener código de país.'
                        }
                        else if(response['detail']['0'].msg === 'Please provide a valid mobile phone number') {
                            message = 'Por favor, coloca un teléfono valido.'
                        }
                        
                        else if(response['detail']['0'].msg === 'value is not a valid email address') {
                            message = 'Correo electrónico invalido, debe de contener un valor'
                        }
                        else if(response['detail']['0'].msg === 'none is not an allowed value' ) {
                            // message = 'Número teléfonico invalido, debe de contener un valor'
                            message = 'Todos los campos son requeridos'
                        }


                        _Store.commit('setAlert', {
                            open: true,
                            message: message,
                            variant: 'danger'
                        })
                    }

                    _Store.commit('setLoad', {
                        show: false,
                    })
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

<style lang="scss">
    #hc_register {
        .country-selector__input {
            -moz-border-radius-topleft: 10px !important;
            border-top-left-radius: 10px !important;
            -moz-border-radius-bottomleft: 10px !important;
            border-bottom-left-radius: 10px !important;
            height: 46px;
            min-height: 46px;
        }
        .input-tel__input {
            -moz-border-radius-topright: 10px !important;
            border-top-right-radius: 10px !important;
            -moz-border-radius-bottomright: 10px !important;
            border-bottom-right-radius: 10px !important;
            height: 46px;
            min-height: 46px;
        }
        .country-selector__input, .input-tel__input {
            border: 1px solid black;
        }
    }
</style>
