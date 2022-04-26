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
            <div class="col-12 px-0 px-sm-1">
                <div class="">
                    <div class="row">
                        <div class="col-12 col-md-12 mb-4 px-0 px-sm-1">
                            <div class="row">
                                <div class="col-12 py-3">
                                    <div class="py-1 text-right" style="">
                                        <button @click="logout()" class="btn btn-link text-decoration-none cursor-pointer p-0">
                                            <span class="hc--description-sm align-middle">
                                                Cerrar sesión
                                            </span>
                                            <div class="d-inline-block" style="max-width: 22px;">
                                                <img :src="s2_img2" class="img-fluid align-middle">
                                            </div>
                                        </button>
                                    </div>
                                    <div  class="py-1 text-right" style="">
                                        <button @click="redirect('history_payments')" class="btn btn-link text-decoration-none cursor-pointer p-0">
                                            <span class="hc--description-sm align-middle">
                                                Historial de pagos
                                            </span>
                                            <div class="d-inline-block" style="max-width: 24px;">
                                                <img :src="s2_img3" class="img-fluid align-middle">
                                            </div>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-12 col-md-6 mb-4 px-0 px-sm-1">
                            <div class="row">
                                <div class="col-6 py-3">
                                    <span class="hc--description">
                                        Bienvenido <span class="poppins-bold" v-if="data_session.data !== undefined">{{ data_session.data.full_name }}</span>
                                    </span>
                                </div>
                                <div class="col-6 py-3">
                                    <div style="max-width: 400px">
                                       <img :src="s3_img5" class="img-fluid">    
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-12 col-md-6 mb-4 px-0 px-sm-1">
                            
                            <div class="text-center" style="max-width: 940px;">
                                <span class="hc--title poppins-regular text-black text-center">
                                        Otros Servicios
                                    </span>
                                        <ssr-carousel :slides-per-page="4" 
                                        :responsive='[
                                            {
                                            maxWidth: 1400,
                                            slidesPerPage: 3,
                                            },
                                            {
                                            maxWidth: 1000,
                                            slidesPerPage: 2,
                                            },
                                            {
                                            maxWidth: 800,
                                            slidesPerPage: 1,
                                            },
                                            {
                                            maxWidth: 500,
                                            slidesPerPage: 1,
                                            },
                                            {
                                            maxWidth: 200,
                                            slidesPerPage: 1,
                                            },
                                            {
                                            maxWidth: 100,
                                            slidesPerPage: 1,
                                            }
                                        ]' >
                                            <div class="slide">
                                            <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/8/8c/Logo_neutral_de_la_Comisi%C3%B3n_Federal_de_Electricidad.svg/3814px-Logo_neutral_de_la_Comisi%C3%B3n_Federal_de_Electricidad.svg.png" class="asd">
                                            </div>
                                            <div class="slide">
                                            <img src="https://cdn.worldvectorlogo.com/logos/total-play.svg" class="asd">
                                            </div>
                                            <div class="slide">
                                            <img src="https://www.ranklogos.com/wp-content/uploads/2015/10/Telmex-Vector-Logo.png" class="asd">
                                            </div>
                                            <div class="slide">
                                            <img src="https://slp.gob.mx/irc/Noticias/predial.png" class="asd">
                                            </div>
                                            <div class="slide">
                                            <img src="https://i0.wp.com/geniusitt.com/wp-content/uploads/2019/10/sky-logo.png?ssl=1" class="asd">
                                            </div>
                                            <div class="slide">
                                            <img src="https://logoeps.com/wp-content/uploads/2012/04/telcel-logo-vector-01.png" class="asd">
                                            </div>
                                            <div class="slide">
                                            <img src="https://i0.wp.com/www.vectorizando.com/wp-content/uploads/2021/04/ATT-logo-4929257b.png?fit=512%2C512&ssl=1" class="asd">
                                            </div>
                                            <div class="slide">
                                            <img src="https://iconape.com/wp-content/files/ku/208394/png/208394.png" class="asd">
                                            </div>
                                            <div class="slide">
                                            <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSrpA3fWQVEITtOLpts5-TAPEwwJOsceLCGBg&usqp=CAU" class="asd">
                                            </div>
                                            <div class="slide">
                                            <img src="https://es-mx-media.shopfully.cloud/images/catene/segnalino_palacio-de-hierro@2x.png" class="asd">
                                            </div>
                                            <div class="slide">
                                            <img src="https://d31dn7nfpuwjnm.cloudfront.net/images/valoraciones/0034/9257/Puedo_solicitar_un_credito_Infonavit_Beneficiarios_y_requisitos.png?1566914236" class="asd">
                                            </div>
                                            <div class="slide">
                                            <img src="https://cdn.fing.io/images/isp/MX/logo/megacable_logo.png" class="asd">
                                            </div>
                                            <div class="slide">
                                            <img src="https://serviciosgfi.inbursa.com:4070/multiplataforma/images/autosdos/SEARS.PNG" class="asd">
                                            </div>
                                            <div class="slide">
                                                <img src="https://zzcash.net/img/logo/zzcash/mx/kueski_com.png" class="asd">
                                            </div>
                                            <div class="slide">
                                                <img src="https://media-exp1.licdn.com/dms/image/C4E0BAQGWev53UKhNvQ/company-logo_200_200/0/1646777136085?e=2147483647&v=beta&t=fNAI_DI8jZZ4F8td1eFgZx0gR0Ai01tZaglrEdLwftg" class="asd" />
                                            </div>
                                            <div class="slide">
                                                <img src="data:image/jpeg;base64,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" class="asd"/>
                                            </div>
                                            <div class="slide">
                                                <img src="https://cdn.freebiesupply.com/logos/large/2x/axtel-logo-png-transparent.png" class="asd"/>
                                            </div>
                                        </ssr-carousel> 
                                    </div>
                        </div>

                        <div class="col-12 col-md-6 px-0 px-sm-1">
                            <div class="row d-flex justify-content-end align-items-center">
                                <div class="col-12 py-3">
                                    <span class="hc--description-sm">
                                        Número de referencia:
                                    </span>
                                    <input v-model="reference" type="" name="" class="input full-width">
                                </div>

                                <div class="col-12 d-flex justify-content-end align-items-start py-3">
                                    <button @click="validateReference()" class="btn btn-success">
                                        VALIDAR
                                    </button>
                                </div>

                                <div class="col-12 py-3">
                                    <span class="hc--description-sm">
                                        Monto a pagar (dólares):
                                    </span> <br>
                                    <div id="input_target_1" class="d-inline-block position-absolute" style="padding: 0px 10px;">
                                        <div class="d-flex justify-content-center align-items-center w-100 h-100">
                                            <span class="hc--description-sm">$</span>
                                        </div>
                                    </div>
                                    <input id="input_1" v-model="amount" type="" name="" class="input full-width" style="padding-left: 30px;">
                                </div>
                            </div>

                        </div>

                        <div class="col-12 col-md-6 all_transition" v-if="reference_payment_data !== null">
                            <div class="row h-100 w-100 border border-success hc--rounded py-3 mb-2">
                            <div class="col-12 text-center pb-2"><span class="hc--description poppins-bold">Nombre del Plan</span></div>
                            <div class="col-6 text-right pl-0 pr-2"><span class="hc--description-sm poppins-semibold">Número de referencia:</span></div>
                            <div class="col-6 text-left pl-1 pr-0"><span class="hc--description-sm poppins-light">{{this.reference}}</span></div>
                            <div class="col-6 text-right pl-0 pr-2"><span class="hc--description-sm poppins-semibold">Nombre del cliente:</span></div>
                            <div class="col-6 text-left pl-1 pr-0"><span class="hc--description-sm poppins-light">{{ reference_payment_data.cliente_nombre }}</span></div>
                            <div class="col-6 text-right pl-0 pr-2">
                                    <span class="hc--description-sm poppins-semibold">
                                        Número de contrato:
                                    </span>
                                </div>
                                <div class="col-6 text-left pl-1 pr-0">
                                    <span class="hc--description-sm poppins-light">
                                        {{ reference_payment_data.cliente_contrato }}
                                    </span>
                                </div>

                                <!-- <div class="col-6 text-right">
                                    <span class="hc--description-sm poppins-semibold">
                                        Importe en dólares:
                                    </span>
                                </div>
                                <div class="col-6 text-left">
                                    <span class="hc--description-sm poppins-light">
                                        $200
                                    </span>
                                </div> -->
                            </div>
                        </div>

                        <div class="col-12 d-flex justify-content-end all_transition_slow py-3" v-if="reference_payment_data !== null">
                            <button @click="paymentReference()" class="btn btn-success">
                                PROCEDE AL PAGO
                            </button>
                        </div>

                        <div class="col-12 d-flex justify-content-end all_transition_slow py-3" v-if="reference_payment_data !== null">
                            <div>
                                <div class="d-inline-block mr-4">
                                    <span class="hc--description-sm">
                                        ACEPTAMOS:
                                    </span>
                                </div>

                                <div class="d-inline-block" style="max-width: 150px;">
                                    <img :src="s2_img4" class="img-fluid align-middle">    
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </section>
        

        <hc-modal 
            :showModal="show_modal" 
            @onClose="handleClose()" 
            maxWidth="1200">

            <div id="section_modal" class="hc--rounded-12">
                <img :src="img_bg_green" class="img-fluid hc--rounded-12">

                <div id="sm_target" class="container-fluid position-absolute w-100" style="top: 0px">
                    <div class="row h-100">
                        <div class="col-12 d-flex justify-content-center align-items-center h-100 p-0">
                            
                            <div class="text-center">

                                <div class="row d-none d-sm-flex py-0 py-md-4">
                                    <div class="col-12 d-flex justify-content-center align-items-center">
                                        <div style="max-width: 120px;">
                                            <img :src="sm_img1" class="img-fluid">    
                                        </div>
                                    </div>
                                </div>

                                <div class="row d-flex justify-content-center align-items-end mb-1 mb-sm-1 mb-md-3" v-if="modal_state === 'success'">
                                    <div class="col-12">
                                        <div class="mb-2">
                                            <span class="hc--title poppins-bold text-white">
                                                Pago exitoso
                                            </span>
                                        </div>
                                        <div class="mb-2">
                                            <span class="hc--description text-white">
                                                Te recordamos el recibo será <br class="d-none d-md-flex">
                                                enviado a tu correo electrónico
                                            </span> 
                                        </div>
                                        <div class="mb-2">
                                            <button @click.stop="handleClose()" class="btn btn-outline-light">
                                                CERRAR
                                            </button>
                                        </div>
                                    </div>
                                </div>


                                <div class="row d-flex justify-content-center align-items-end mb-1 mb-sm-1 mb-md-3" v-if="modal_state === 'error'">
                                    <div class="col-12">
                                        <div class="mb-2">
                                            <span class="hc--title poppins-bold text-white">
                                                El pago no ha sido procesado
                                            </span>
                                        </div>
                                        <div class="mb-2">
                                            <span class="hc--description text-white">
                                                Por favor, intentelo más tarde
                                            </span> 
                                        </div>
                                    </div>
                                </div>
                                
                            </div>
                            
                        </div>
                    </div>
                </div> 
            </div>  
        </hc-modal>

        <!-- <section id="pruebaCarrusel">
             <hc-carousel v-if="data_table" :table="data_table" :cantidad="7"></hc-carousel>
        </section> -->
</div>
</template>

<script>
    import _Store from '@/store'
    import { mapGetters } from 'vuex'
    // Components 
    import HcModal from '../components/hc-modal.vue'
    import hcCarousel from '../components/carruselVue.vue'
    // Images
    import img_bg_green from '../assets/images/backgrounds/bg-green.png'
    import img_bg_green_cut from '../assets/images/backgrounds/bg-green-cut.png'
    import s2_img1 from '../assets/images/login/logo-pabs.png'
    import s2_img2 from '../assets/images/dashboard/cerrar-sesion.png'
    import s2_img3 from '../assets/images/dashboard/historial-pagos.png'
    import s2_img4 from '../assets/images/dashboard/tarjertas.png'
    import s3_img5 from '../assets/images/paymentServices/section3/logo-programa.png'
    import sm_img1 from '../assets/images/modal/pabs-logo-blanco.png'

	// Gifs
    import gif_simb_white from '../assets/gifs/simbolo-blanco.gif'    
    
	// jQuery
    import $ from 'jquery'
    var CONFIG = require('../page.config.js')
    
	export default {
		name: 'hc_dashboard',
        components: {
            'hc-modal': HcModal,
            'hc-carousel': hcCarousel
        },
		data() {
			return {
                img_bg_green,
                img_bg_green_cut,
                gif_simb_white,
                s2_img1,
                s2_img2,
                s2_img3,
                s2_img4,
                sm_img1,
                s3_img5,
                data_table: [],

                currency: 'USD',

                reference: null,//'93002474785791',
                amount: null,
                reference_payment_data: null,
                show_modal: false,
                modal_state: null,

                data_user: null,
                url_payment: null
			}
		},
        computed: {
            ...mapGetters([
                'getSession'
            ]),

            current_route_name() {
                return this.$route.name;
            },
            data_session() {
                this.$forceUpdate()
                return this.getSession

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

            async validateReference() {
                _Store.commit('setLoad', {
                    show: true,
                    title: 'Cargando',
                    subtitle: "Validando referencia"
                })

                fetch(`https://pay.pabsmr.org/oxxopay/referencias?referencia=${this.reference}&token_api=${CONFIG.server[CONFIG.env].validate_reference.token_api}`, {
                    method: 'POST',
                    //mode: 'no-cors',
                    headers: {
                        'Accept': 'application/json, text/plain, /',
                        'Content-Type': 'application/json'
                    }
                }).then(res => res.json())
                .catch(error => console.error('Error:', error))
                .then(async response => {
                    //console.log('Success:', response)

                    if(response === undefined) {
                        _Store.commit('setAlert', {
                            open: true,
                            message: 'Ha ocurrido un error intentelo más tarde',
                            variant: 'danger'
                        })
                    }
                    else if(response['cliente_contrato'] !== undefined) {
                        this.reference_payment_data = response
                    }
                    else if(response['result'] !== undefined) {
                        _Store.commit('setAlert', {
                            open: true,
                            message: response['result'],
                            variant: 'danger'
                        })
                    }
                    else if(response['detail'] !== undefined) {
                        if(response['detail'] == "Unauthorized") {
                            _Store.commit('setAlert', {
                                open: true,
                                message: 'La sesión ha expirado',
                                variant: 'danger'
                            })

                            this.logout()
                        }
                    }

                    // console.log('test')
                    _Store.commit('setLoad', {
                        show: false,
                    })
                })
            },

            async paymentReference() {

                if(this.amount == null || !this.amount > 0) {
                    _Store.commit('setAlert', {
                        open: true,
                        message: 'Debes ingresar un monto a pagar valido',
                        variant: 'danger'
                    })
                    return
                }

                _Store.commit('setLoad', {
                    show: true,
                    title: 'Cargando',
                    subtitle: "",
                })

                let session = JSON.parse(await _Store.dispatch('existSession'))

                //console.log(Number(this.amount) * 100)

                let body = {
                    name: 'TEST'
                }

                fetch(`${CONFIG.server[CONFIG.env].api}/payments/stripe/create-payment?currency=${this.currency}&amount=${Number(this.amount) * 100}&reference=${this.reference}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'authorization': `BEARER ${session.access_token}`
                    },
                    body: JSON.stringify(body)
                }).then(res => res.json())
                .catch(error => console.error('Error:', error))
                .then(async response => {
                    //console.log('Success:', response)

                    if(response['url_to_payment'] !== undefined) {
                        this.url_payment = response['url_to_payment']
                        await _Store.dispatch('saveAuthorizationID', response['authorization_id'])
                        this.redirectToPage(this.url_payment)
                    }
                    else if(response['detail'] !== undefined) {
                        if(response['detail'] == "Unauthorized") {
                            _Store.commit('setAlert', {
                                open: true,
                                message: 'La sesión ha expirado',
                                variant: 'danger'
                            })

                            this.logout()
                        }
                    }

                    _Store.commit('setLoad', {
                        show: false,
                    })
                })

            },

            redirectToPage(url, target = "_blank") {
                if(target == "_blank") {
                    window.open(url, '_blank')
                }
                else {
                    window.location.replace(url)
                }
            },

            async logout() {
                await _Store.dispatch('deleteSession')
                this.redirect('login')
            },

            openModal() {
                this.show_modal = true
                
                for(let time = 0; time < 2000; time = time + 100) {
                    setTimeout(function() { 
                        $(window).trigger('resize')
                    }, time)
                }
            },
            handleClose() {
                this.show_modal = false
            },
            async checkStatusPayment() {
                _Store.commit('setLoad', {
                    show: true,
                    title: 'Cargando',
                    subtitle: "Validando estado del pago",
                })

                let session = JSON.parse(await _Store.dispatch('existSession'))

                fetch(`${CONFIG.server[CONFIG.env].api}/payments/stripe/capture-order?authorization_id=${session.authorization_id}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'authorization': `BEARER ${session.access_token}`
                    }
                }).then(res => res.json())
                .catch(error => console.error('Error:', error))
                .then(async response => {
                    //console.log('Success:', response)

                    if(response['payment_status'] !== undefined) {
                        //this.modal_state = 'error'
                        if(response['status'] == 'complete' && response['payment_status'] == 'paid') {
                            this.modal_state = 'success'
                        }
                        else {
                            this.modal_state = 'error'
                        }
                        this.show_modal = true
                    }
                    else if(response['detail'] !== undefined) {
                        if(response['detail'] == "Unauthorized") {
                            _Store.commit('setAlert', {
                                open: true,
                                message: 'La sesión ha expirado',
                                variant: 'danger'
                            })

                            this.logout()
                        }
                    }

                    _Store.commit('setLoad', {
                        show: false,
                    })
                })
            }
        },
        async created() {
            $(window).resize(function() {
                let s1_height = $('#section1').height()
                $("#s1_target").css("height", s1_height)

                let input_1_height = $('#input_1').height()
                $("#input_target_1").css("height", input_1_height + 21)

                let sm_height = $('#section_modal').height()
                $("#sm_target").css("height", sm_height)
            })

            //console.log(this.$route.params.make_payment)

            if(this.$route.params.make_payment) {
                this.checkStatusPayment()
            }

            _Store.commit('setLoad', {
                show: true,
                title: 'Cargando',
                subtitle: "Cargando información...",
            })

            let session = JSON.parse(await _Store.dispatch('existSession'))

            fetch(`${CONFIG.server[CONFIG.env].api}/users/me`, {
                method: 'GET',
                headers: {
                    'Content-Type': 'application/json',
                    'authorization': `BEARER ${session.access_token}`
                }
            }).then(res => res.json())
            .catch(error => console.error('Error:', error))
            .then(async response => {
                //console.log('Success:', response)

                if(response['_id'] !== undefined) {
                    this.data_user = response
                    await _Store.dispatch('updateSession', this.data_user)
                    // this.$forceUpdate()
                }
                else if(response['detail'] !== undefined) {
                    if(response['detail'] == "Unauthorized") {
                        _Store.commit('setAlert', {
                            open: true,
                            message: 'La sesión ha expirado',
                            variant: 'danger'
                        })

                        this.logout()
                    }
                }

                _Store.commit('setLoad', {
                    show: false,
                })
            })

        },
        beforeMount(){
            fetch('http://localhost:3000/services').then(res => res.json())
            .catch(error => console.error('Error:', error))
            .then(async response => {
                if(response.length > 0) {
                    this.data_table = response
                    //console.log(response)
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
	}
</script>

<style lang="scss" scoped>
	.slide {
  box-shadow:inset 0px -2px 18px 7px rgb(99 171 56 / 43%);
  padding: 25px;
  border-radius: 5px;
  margin-right: 30px;
    height: 180px;
    width: 300px;
    background-color: rgb(240 245 238 / 27%);
  
}
.asd{
    width: 100%;
    height: 100%;
}
</style>
