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

        <section id="section2" class="row bg-light d-flex py-5">
            <div class="col-12 text-center mb-4">
                <span class="hc--title poppins-regular">
                    Bienvenido a 
                    <div class="d-inline-block" style="max-width: 200px;">
                        <img :src="s2_img1" class="img-fluid">
                    </div>
                </span>
            </div>

            <div class="col-12 col-md-6">
                <div class="row d-flex justify-content-end align-items-center">
                    <div class="col-12 col-md-10 col-lg-9 col-xl-7 py-3">
                        <span class="hc--description poppins-bold">
                            Inicia sesión con tu cuenta:
                        </span>
                    </div>

                    <div class="col-12 col-md-10 col-lg-9 col-xl-7 py-3">
                        <span class="hc--description-sm">
                            Correo electrónico
                        </span>
                        <input v-model="username" type="text" name="username" class="input full-width">
                    </div>

                    <div class="col-12 col-md-10 col-lg-9 col-xl-7 py-3">
                        <span class="hc--description-sm">
                            Contraseña
                        </span>

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

                        <div @click="redirect('forgot_password')" class="d-flex justify-content-end cursor-pointer pt-1">
                            <span class="hc--description-sm text-decoration-underline">
                                Olvidaste tu contraseña?
                            </span>    
                        </div>
                    </div>

                    <div class="col-12 col-md-10 col-lg-9 col-xl-7 py-3">
                        <button @click="login()"  class="btn btn-success">
                            INICIAR SESIÓN
                        </button>
                    </div>
                </div>

            </div>

            <div class="col-12 col-md-6 d-flex justify-content-start align-items-end border-left">
                <div class="row">
                    <div class="col-12 py-3">
                        <span class="hc--description poppins-bold">
                            ¿Aún no tienes una cuenta?
                        </span>
                    </div>

                    <div class="col-12 py-3">
                        <div style="max-width: 400px;">
                            <span class="hc--description-sm">
                                Por favor da click en el siguiente botón
                                para crear una cuenta:
                            </span>    
                        </div>
                    </div>

                    <div class="col-12 py-3">
                        <button @click="redirect('register')" class="btn btn-success">
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
    
	// jQuery
    import $ from 'jquery'
    var  CONFIG = require('../page.config.js')
    
	export default {
		name: 'hc_home',
		data() {
			return {
                img_bg_green,
                img_bg_green_cut,
                gif_simb_white,
                s2_img1,

                username: null,
                password: null,
                // username: "user@example.com",
                // password: "pabsword",
                type: 'password'
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
            login() {
                _Store.commit('setLoad', {
                    show: true,
                    title: 'Cargando',
                    subtitle: "Iniciando Sesión",
                })
                let details = { 
                    username: this.username, 
                    password: this.password
                }

                let formBody = []
                for (var property in details) {
                    var encodedKey = encodeURIComponent(property)
                    var encodedValue = encodeURIComponent(details[property])
                    formBody.push(encodedKey + "=" + encodedValue)
                }
                formBody = formBody.join("&")


                fetch(`${CONFIG.server[CONFIG.env].api}/auth/jwt/login`, {
                    method: 'POST',
                    headers: {
                        'Accept': 'application/json, text/plain, /',
                        'Content-Type': 'application/x-www-form-urlencoded'
                    },
                    body: formBody
                }).then(res => res.json())
                .catch(error => console.error('Error:', error))
                .then(async response => {
                    //console.log('Success:', response)

                    if(response['access_token'] !== undefined) {
                        await _Store.dispatch('createSession', response)

                        this.redirect('dashboard')

                        _Store.commit('setAlert', {
                            open: true,
                            message: '¡Bienvenido!'
                        })
                    }
                    else if(response['detail'] !== undefined) {
                        if(response['detail'] == 'LOGIN_BAD_CREDENTIALS') {
                            _Store.commit('setAlert', {
                                open: true,
                                message: 'Usuario o contraseña incorrecto',
                                variant: 'danger'
                            })
                        }
                    }
                    else {
                        _Store.commit('setAlert', {
                            open: true,
                            message: 'Ha ocurrido un error intente más tarde'
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

<style lang="scss" scoped>
	
</style>
