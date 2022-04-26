<template>
    <div>
        <!-- Navbar -->
        <b-navbar id="hy_navbar" toggleable="lg" type="light" variant="transparent" class="all_transition_slow fixed-top py-3">
            <b-navbar-brand id="mt_navbar__title" @click="redirect('home')" class="mb-1 px-1 px-sm-3 px-md-0 px-lg-0 px-xl-0 mx-xl-4" style=" max-width: 200px; cursor: pointer;">
                <img id="logo_white" :src="(current_route_name == 'home' || current_route_name == 'how_work' || current_route_name == 'we_are' || current_route_name == 'contact') ? gif_logo_white : img_logo_white" class="img-fluid"> 
            </b-navbar-brand>
            <div class="ml-auto py-3 d-none d-sm-none d-md-none d-lg-block d-xl-block">
                <b-navbar-nav class="">
                    <b-nav-item @click="redirect('home')" style="max-width: 350px;" ><span class="text-center text-white px-lg-1 px-xl-3">INICIO</span></b-nav-item>
                    <b-nav-item @click="redirect('we_are')" style="max-width: 350px;" ><span class="text-center text-white px-lg-1 px-xl-3">NOSOTROS</span></b-nav-item>
                    <b-nav-item @click="redirect('how_work')" style="max-width: 350px;" ><span class="text-center text-white px-lg-1 px-xl-3">CÓMO FUNCIONA</span></b-nav-item>
                    <b-nav-item @click="redirect('contact')" style="max-width: 350px;" ><span class="text-center text-white px-lg-1 px-xl-3">CONTACTO</span></b-nav-item>
                </b-navbar-nav>
            </div>
            <div class="d-none d-sm-block ml-auto ml-sm-auto ml-md-auto ml-lg-0 ml-xl-0 pr-lg-4">
                <button @click="redirect('payment_services')" class="btn hc--btn-gradient text-white poppins-semibold px-2 mx-lg-3 mx-lx-5" style="max-width: 300px;">
                    PAGAR SERVICIOS
                </button>
            </div>

            <b-button v-b-toggle.ab_sidebar variant="link" class="d-block d-sm-block d-md-block d-lg-none d-xl-none">
                <b-icon id="mt_navbar__menu_icon" icon="list" scale="2" variant="white"></b-icon>
            </b-button>
            
        </b-navbar>

        <!-- Sidebar -->
        <b-sidebar id="ab_sidebar" bg-variant="dark" class="text-right" right backdrop shadow>
            <div class="item hc--description py-3 px-5 mt-2 d-sm-none">
                <button @click="redirect('payment_services')" class="btn hc--btn-gradient text-white poppins-semibold px-2 mx-lg-3 mx-lx-5" style="max-width: 300px;">
                    PAGAR SERVICIOS
                </button>
            </div>

            <div class="item hc--description py-3 px-5 mt-2">
                <span @click="redirect('home')"> INICIO </span>
            </div>
            <div class="item hc--description py-3 px-5">
                <span @click="redirect('we_are')"> NOSOTROS </span>
            </div>
            <div class="item hc--description py-3 px-5">
                <span @click="redirect('how_work')"> CÓMO FUNCIONA</span>
            </div>
            <div class="item hc--description py-3 px-5">
                <span @click="redirect('contact')"> CONTACTO</span>
            </div>

            <div class="pt-3">
                <div class="p-5">
                    <div class="w-50 mb-3">
                        <!-- <img :src="img_logo_white" class="img-fluid"> -->
                    </div>
                    <span class="mt-description-sm text-white">
                        <span class="hc--description-sm text-white">
                            <!-- <img :src="icon_ig" class="img-fluid mx-2" style="max-width: 32px;">
                            <img :src="icon_fb" class="img-fluid mx-2" style="max-width: 32px;">
                            <img :src="icon_wpp" class="img-fluid ml-2" style="max-width: 32px;"> <span class="hc--description-sm text-white">Whatsapp</span> -->
                            <!-- © 2022 American Border Insurance Services, Inc. | CA Lic. #0748120 | All Rights Reserved -->
                        </span>
                    </span>
                </div>
            </div>
        </b-sidebar>
    </div>
</template>

<script>
    // Gifs
     import gif_logo_white from '../assets/gifs/navbar/hispano-verde-blanco.gif'
    // Images
    import img_logo_white from '../assets/images/logo-hispano-blanco.png'
    import img_logo_color from '../assets/images/logo-hisp.png'
    // import icon_wpp from '../assets/gifs/icons/wpp.gif'
    // import icon_ig from '../assets/gifs/icons/ig.gif'
    // import icon_fb from '../assets/gifs/icons/fb.gif'
    
    
    // jQuery
    import $ from 'jquery'

    export default {
        name: 'ab-navbar',
        props: {
            msg: String
        },
        data() {
            return {
                gif_logo_white, 
                img_logo_white,
                img_logo_color
                // icon_wpp,
                // icon_ig,
                // icon_fb
            }
        },
        computed: {
            current_route_name() {
                return this.$route.name;
            }
        },
        methods: {
            redirect(name_route) {
                //console.log(`redirect to: ${name_route}`)
                if(this.$route.name !== name_route ) {
                    window.scrollTo(0, 0)

                    this.$router.push({
                        name: name_route
                    })
                }
            },
            redirectToSamePageSimple(name_route, element_id) {
                //console.log('redirectToSamePageSimple')
                document.getElementById(element_id).scrollIntoView({ 
                    behavior: 'smooth', 
                    block: 'start', 
                    inline: 'start' 
                })
            },
            redirectToSamePage(name_route, element_id) {
                //console.log('redirectToSamePage')
                if(this.$route.name !== name_route) {
                    this.redirect(name_route)    
                }

                setTimeout(function() {
                    window.scrollTo(0, 0)
                    const top = document.getElementById(element_id).getBoundingClientRect().top
                    const height_navbar = $('#hy_navbar').height()
                    const y = (top - window.pageYOffset) - height_navbar - 40;

                    if(y >= 0) {
                        window.scrollTo({ top: y, behavior: 'smooth' });
                    }    
                }, 300);
            },
            redirectToPage(url, target = "_blank") {
                if(target == "_blank") {
                    window.open(url, '_blank')
                }
                else {
                    window.location.replace(url)
                }
            }
        },
        created() {
            $(window).scroll(function() {
                //console.log(`scroll: ${$(document).scrollTop()}`)

                if($(document).scrollTop() > 10) {
                    $('#hy_navbar').removeClass('bg-transparent');
                    $('#hy_navbar').addClass('bg-dark');
                    $('#hy_navbar').addClass('navbar__scroll');
                    // Position
                    // $('#mt_navbar').addClass('fixed-top');
                    // $('#mt_navbar').removeClass('fixed-top-custom');
                    // Logo
                    // $('#mt_logo_white').addClass('d-none');
                    // $('#mt_logo_white').removeClass('d-flex');
                    // $('#mt_logo_gray').addClass('d-flex');
                    // $('#mt_logo_gray').removeClass('d-none');
                    // Text
                    // $('#mt_navbar__title').addClass('text-black');
                    // $('#mt_navbar__title').removeClass('text-white');
                    // $('#mt_navbar__menu_icon').addClass('text-black');
                    // $('#mt_navbar__menu_icon').removeClass('text-white');
                }
                else {
                    $('#hy_navbar').addClass('bg-transparent');
                    $('#hy_navbar').removeClass('bg-dark');
                    $('#hy_navbar').removeClass('navbar__scroll');
                    // Position
                    // $('#mt_navbar').addClass('fixed-top-custom');
                    // $('#mt_navbar').removeClass('fixed-top');
                    // Logo
                    // $('#mt_logo_white').addClass('d-flex');
                    // $('#mt_logo_white').removeClass('d-none');
                    // $('#mt_logo_gray').addClass('d-none');
                    // $('#mt_logo_gray').removeClass('d-flex');
                    // Text
                    // $('#mt_navbar__title').addClass('text-white');
                    // $('#mt_navbar__title').removeClass('text-black');
                    // $('#mt_navbar__menu_icon').addClass('text-white');
                    // $('#mt_navbar__menu_icon').removeClass('text-black');
                }
            })
        }
    }
</script>

<style lang="scss" >

    .navbar__scroll {
        box-shadow: 1px 4px 26px 5px rgba(0,0,0,0.71);
        -webkit-box-shadow: 1px 4px 26px 5px rgba(0,0,0,0.71);
        -moz-box-shadow: 1px 4px 26px 5px rgba(0,0,0,0.71);
    }

    #ab_sidebar {
        .item {
            cursor: pointer;

            span {
                color: white !important;
            }
            span:hover {
                text-decoration: underline;
                text-decoration-style: double;
            }
        }
    }

    .b-sidebar {
        width: 450px !important;

        .b-sidebar-header {

            button {
                color: white !important;

                svg {
                    font-size: 40px;
                }
            }
        }
    }
</style>
