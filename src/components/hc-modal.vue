<template>
    <div id="hc_modal" :class="['modal ', `${showModal ? 'd-flex' : 'd-none'}`]" @click.stop="closeModal('overlay')">
        <div :class="['row modal__container',`bg-${bgColor}`]" @click.stop="closeModal('content')"
            :style="`max-width: ${maxWidth}px !important;`">

            <div class="col-12 p-0">
                <div class="row">
                    <button @click.stop="closeModal('button')" class="modal__container--button bg-transparent position-absolute" style="right: 0px; z-index: 1;">
                        <span class="hc--title-sm text-white close">&times;</span>
                    </button>

                    <slot>
                        <!-- Slot default -->
                    </slot>    
                </div>
            </div>            
        </div>
    </div>
</template>

<script>
    // jQuery
    import $ from 'jquery'

    export default {
        name: 'mt-modal',
        props: {
            showModal: {
                require: true,
                type: Boolean,
                default: false
            },
            overlayClose: {
                require: false,
                type: Boolean,
                default: true
            },
            bgColor: {
                require: false,
                type: String,
                default: 'transparent',
                validator: function (value) {
                    // El valor debe coincidir con una de estas cadenas de texto
                    return ['transparent', 'white', 'primary', 'secondary', 'success', 'info', 'warning', 'danger', 'light', 'dark'].indexOf(value) !== -1
                }
            },
            maxWidth: {
                require: false,
                type: String,
                default: '900'
            },
        },
        data() {
            return {
                
            }
        },
        methods: {
            closeModal(type) {
                if(type === 'content') {
                    return
                }
                if(type === 'overlay') {
                    if(!this.overlayClose) {
                        return
                    }
                }
                console.log(type)
                this.$emit('onClose')
            }
        },
        created() {
            $(window).resize(function() {
                if($('#modal_image_title')) {
                    let height_ref = $('#modal_image_title').height()
                    let width_ref = $('#modal_image_title').width()
                    $("#modal_button_title").css("height", height_ref)
                    $("#modal_button_title").css("width", width_ref)
                }
            })
        }
    }
</script>

<style lang="scss" scoped>
    .modal {
        justify-content: center;
        align-items: center;
        background-color: #000000bb;
        z-index: 9999;

        &__container {
            border-radius: 12px;
            width: 100%;
            z-index: 10000;

            &--button {
                position: relative; 
                // top: -60px;
                // right: -250px !important;
                border-radius: 0.25rem !important;
                border: 0px;
                cursor: pointer;
            }
        }
    }
</style>



<!-- PARENT VIEW -->
<!-- <template>
    <pr-modal 
        :showModal="show_modal" 
        @onClose="handleClose()" 
        bgColor="primary"
        :imageTitle="select_image"
        sourceVideo="https://player.vimeo.com/video/640047602"
        maxWidth="500">

        <span class="hc--description-sm text-white">asd</span>
        
    </pr-modal>
</template> -->

<!-- <script>
    // Components 
    import PrModal from '../components/pr-modal.vue'

    export default {
        name: 'view',
        components: {
            'pr-modal': PrModal
        },
        data() {
            return {
                show_modal: false,
                select_image: null,
                element_select: null,
            }
        },
        methods: {
            openModal(image = null, index) {
                this.show_modal = true
                this.select_image = image
                this.element_select = index
            },
            handleClose() {
                this.show_modal = false
            }
        }
    }
</script> -->
    