<template>
    <div id="hc_loading" class="loading position-fixed h-100" v-show="data_load.show">
        <div class="row loading__container d-flex justify-content-center align-items-center h-100">
            <div class="col-12 p-0">
                <div class="row text-center p-0">
                    <div class="col-12 p-0 d-flex justify-content-center align-items-center">
                        <div style="max-width:150px;">
                            <img class="img-fluid" :src="load_gif2" alt=""/>
                        </div>
                    </div>
                    <div class="col-12 p-0">
                        <span class="hc--title-sm poppins-semibold text-white">
                            {{data_load.title}} 
                            <b-spinner class="mb-1 mr-2" style="width: .4rem; height: .4rem;" type="grow"></b-spinner>
                            <b-spinner class="mb-1 mr-2" style="width: .4rem; height: .4rem;" type="grow"></b-spinner>
                            <b-spinner class="mb-1 mr-1" style="width: .4rem; height: .4rem;" type="grow"></b-spinner>
                        </span>
                    </div>
                    <div class="col-12 p-0">
                        <span class="hc--description poppins-regular text-white">{{data_load.subtitle}}</span>
                    </div>
                </div>
            </div>            
        </div>
    </div>
</template>

<script>
    //import _Store from '@/store'
	import { mapGetters } from 'vuex'

    // Gifs
	import load_gif1 from '../assets/gifs/símbolo-hispano.gif'
    import load_gif2 from '../assets/gifs/simbolo-blanco.gif'  

    export default {
        name: 'hc-loading',
        data() {
            return {
                load_gif1,
                load_gif2
            }
        },
        computed: {
        ...mapGetters([
				'getLoad'
		]),

            data_load() {
            return this.getLoad
            }
        },
        methods: {
            
        },
        created() {
        },
        mounted() {
        }
    }
</script>

<style lang="scss" scoped>
    .loading {
        width: 100%;
        justify-content: center;
        align-items: center;
        background-color: #000000bb;
        z-index: 9999;

        &__container {
            width: 100%;
            z-index: 10000;
        }
    }
</style>