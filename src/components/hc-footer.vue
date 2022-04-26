<template>
    <footer id="hy-footer" class="container-fluid bg-white">
        <div class="row">
            <section class="col-12 p-0">
            <div class="container-fluid">
                <!-- Content -->
                <section class="row d-flex justify-content-start justify-content-lg-center py-5">
                    <div class="col-12 col-sm-12 col-lg-3 col-xl-3 justify-content-start align-items-start px-3 px-sm-4 py-3 py-lg-2">
                        <div class="row">
                            <div class="col-12 pl-2 pl-sm-4 pl-lg-5" style="max-width: 330px;" >
                                <img :src="img_hispano" class="img-fluid mb-3">
                            </div>
                            <div class="col-12 pl-2 pl-sm-4 pl-lg-5 my-3">
                                <span class="poppins-light hc--description-sm">855 274 8949</span>
                            </div>
                            <div class="col-12 pl-2 pl-sm-4 pl-lg-5">
                                <span class="poppins-light hc--description-sm">hola@hispanocash.com</span>
                            </div>
                        </div>
                    </div>

                    <div class="col-5 col-sm-5 col-lg-2 col-xl-2 d-flex align-items-start px-3 px-sm-4 px-lg-4 py-3 py-lg-2">
                        
                        <div class="pl-2 pl-sm-4">
                            <div class="cursor-pointer  my-3">
                                <span class="span-link poppins-semibold hc--description">MENÚ</span>
                            </div>
                            <div class="cursor-pointer py-2 my-1">
                                <span @click="redirect('home')" class="span-link poppins-light" style="font-size:15px">INICIO</span>
                            </div>
                            <div class="cursor-pointer py-2 my-1">
                                <span @click="redirect('we_are')" class="span-link poppins-light" style="font-size:15px">SOMOS</span>
                            </div>
                            <div class="cursor-pointer py-2 my-1">
                                <span @click="redirect('how_work')" class="span-link poppins-light" style="font-size:15px">CÓMO FUNCIONA</span>
                            </div>
                            <div class="cursor-pointer py-2 my-1">
                                <span @click="redirect('contact')" class="span-link poppins-light" style="font-size:15px">CONTACTO</span>
                            </div>
                            <div class="cursor-pointer py-2 my-1">
                                <span @click="redirect('payment_services')" class="span-link poppins-light" style="font-size:15px">PAGAR SERVICIOS</span>
                            </div>
                        </div>
                    </div>

                    <div class="col-7 col-sm-7 col-lg-3 col-xl-2 d-flex align-items-star px-0 py-3 py-lg-2">
                        <div>
                            <div class="cursor-pointer  my-3">
                                <span class="span-link poppins-semibold hc--description">LEGAL</span>
                            </div>
                            <div class="cursor-pointer py-2 my-1">
                                <span @click="redirect('privacy')" class="span-link poppins-light" style="font-size:15px">AVISO DE PRIVACIDAD</span>
                            </div>
                            <div class="cursor-pointer py-2 my-1">
                                <span @click="redirect('terms')" class="span-link poppins-light" style="font-size:15px">TÉRMINOS Y CONDICIONES</span>
                            </div>
                            <div class="cursor-pointer py-2 my-1">
                                <span @click="redirect('contact')" class="span-link poppins-light" style="font-size:15px">SOPORTE</span>
                            </div>
                            <div class="py-2 my-1" style="max-width: 350px;">
                                <span clas="poppins-light" style="font-style: italic; font-size: 12px">*Este beneficio de cero cargos por comisión, sólo será aplicable al cobro de servicios funerarios. El cobro de los demás servicios, podrá generar un cargo adicional por comisión.</span>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-lg-3 col-xl-3 d-flex align-items-start px-2 px-sm-4 py-3 py-lg-2">
                        <div class="row">
                            <div class="col-12 cursor-pointer my-3">
                                <span class="span-link poppins-semibold hc--description">SÍGUENOS</span>
                            </div>

                            <div class="col-12">
                                <a href="https://www.facebook.com/HispanoCash" target="_blank">
                                    <img :src="img_facebook" class="invert-color m-1">
                                </a>
                                <a href="https://www.instagram.com/hispanocash/" target="_blank">
                                    <img :src="img_instagram" class="invert-color m-1">
                                </a>
                                <a href="https://www.tiktok.com/@hispanocash" target="_blank">
                                    <img :src="img_tiktok" class="invert-color m-1">
                                </a>
                            </div>
                        </div>
                    </div>
                </section>

                <section class="row justify-content-end bg-light pl-0 pl-lg-5">
                    <div class="col-12 col-sm-11 col-lg-8 justify-content-start align-items-center pl-0 pl-lg-5 py-2">
                        <div class="pl-0 pl-lg-5">
                            <div class="pl-0 pl-lg-5 py-2 ml-5 ml-lg-0">
                                <span class="poppins-light">©2022 HISPANOCASH©/ TODOS LOS DERECHOS RESERVADOS</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-8 col-sm-8 col-lg-4 pt-0 pt-lg-1 pb-2 pb-sm-0 
                        px-0 px-sm-3 px-md-4 px-lg-4 px-xl-4">
                        <div class="px-0 px-xl-5 mt-2 px-0 px-md-5 px-lg-0">
                            <img :src="gif_materialized" class="img-fluid">
                        </div>
                    </div>
                </section>
            </div>
        </section>
        </div>
        
    </footer>
</template>

<script>
    // Gifs
    import gif_materialized from '../assets/gifs/materialized-negro.gif'
    import gif_hispano_orig from '../assets/gifs/footer/hispano-original.gif'
    // Images-Logos
    import img_hispano from '../assets/images/footer/logo-footer.png'
    import img_facebook from '../assets/images/sociality/fb.png'
    import img_instagram from '../assets/images/sociality/ig.png'
    import img_tiktok from '../assets/images/sociality/tk.png'

    export default {
        name: 'hy-footer',
        props: {
            msg: String
        },
        data() {
            return {
                //gifs
                gif_materialized,
                gif_hispano_orig,
                //logos
                img_hispano,
                img_tiktok,
                img_facebook,
                img_instagram
            }
        },
        methods: {
            redirect(name) {
                window.scrollTo( 0, 0 )
                
                this.$router.push({
                    name: name
                })
            }
        },
    }
</script>

<style scoped lang="scss">
    #hy-footer {
        //background-color: #002654;
        //color: white;
        
        .span-link {
            //color: #eee !important;
        }
        .span-link:hover {
            text-decoration: underline;
            text-decoration-style: double;
        }
    }
</style>
