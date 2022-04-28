import Vue from 'vue'
import VueRouter from 'vue-router'
import Home from '../views/Home.vue'
import _Store from '@/store'

Vue.use(VueRouter)

const routes = [
    {
        path: '/',
        name: 'home',
        component: Home
    },
    {
        path: '/como_funciona',
        name: 'how_work',
        component: () => import('../views/HowWork.vue')
    },
    {
        path: '/nosotros',
        name: 'we_are',
        component: () => import('../views/WeAre.vue')
    },
    {
        path: '/contactanos',
        name: 'contact',
        component: () => import('../views/Contact.vue')
    },
    {
        path: '/pago_de_servicios',
        name: 'payment_services',
        component: () => import('../views/PaymentServices.vue')
    },
    {
        path: '/inicio_de_sesion',
        name: 'login',
        component: () => import('../views/Login.vue')
    },
    {
        path: '/olvide_contrasena',
        name: 'forgot_password',
        component: () => import('../views/Forgot.vue')
    },
    // {
    //     path: '/auth/reset-password/callback',
    //     name: 'reset_password',
    //     props: (route) => ({ token: route.query.token }),
    //     component: () => import('../views/ResetPassword.vue')
    // },
    {
        path: '/auth/reset-password/callback/:token',
        name: 'reset_password',
        component: () => import('../views/ResetPassword.vue')
    },
    {
        path: '/registro',
        name: 'register',
        component: () => import('../views/Register.vue')
    },
    {
        path: '/cuenta',
        // alias: '/stripe/success',
        name: 'dashboard',
        component: () => import('../views/Dashboard.vue')
    },
    {
        path: '/stripe/success',
        redirect: () => {
            // the function receives the target route as the argument
            // we return a redirect path/location here.
            return { name: 'dashboard', params: { make_payment: true } }
        },
    },
    {
        path: '/historial_de_pagos',
        name: 'history_payments',
        component: () => import('../views/HistoryPayments.vue')
    },
    {
        path: '/aviso_de_privacidad',
        name: 'privacy',
        component: () => import('../views/Privacy.vue')
    },
    {
        path: '/terminos_y_condiciones',
        name: 'terms',
        component: () => import('../views/Terms.vue')
    }
]

const router = new VueRouter({
    mode: 'history',
    base: process.env.BASE_URL,
    routes
})


router.beforeEach(async(to, from, next) => {

    /*** CHECK SESSION INTERNAL ***/
    let session = JSON.parse(await _Store.dispatch('existSession'))
    //console.log(session)

    // if(session !== null) {
        
    // }

    // Hide views in specifics cases
    const show_only_with_session = ['dashboard', 'history_payments']
    const show_only_without_session = ['login', 'register', 'forgot_password']

    if((session === null || session.access_token === null) && show_only_with_session.includes(to.name)) {
        next({ name: 'home' })
        return
    }
    else if((session !== null && session.access_token !== null) && show_only_without_session.includes(to.name)) {
        next({ name: 'dashboard' })
        return
    }

    next()

    // console.log(_Store.state.lang, '_Store.state.lang')
    // console.log(_Store, '_Store')


    // Set language if url changes
    //await _Store.dispatch('changeLang', 'es')
    //console.log(_Store, '_Store')    
    // let new_view = to.name
    // let old_view = from.name

    //let lang = await _Store.dispatch('getLang')

    // loadLanguageAsync(new_view, old_view, lang).then(response => {
    //     next()
    // })
})

export default router
