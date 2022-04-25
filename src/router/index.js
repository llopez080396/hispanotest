import Vue from 'vue'
import VueRouter from 'vue-router'
import Home from '../views/PaymentServices.vue'
//import _Store from '@/store'


Vue.use(VueRouter)
const routes = [
    {
        path: '/',
        name: 'home',
        component: Home
    },
    {
        path: '/inicio_de_sesion',
        name: 'login',
        component: ()=> import('../views/Login.vue')
    },
    {
        path: '/cuenta',
        name: 'home',
        component: Home
    }
]

const router = new VueRouter({
    mode: 'history',
    routes
})


// router.beforeEach(async(to, from, next) => {

//     /*** CHECK SESSION INTERNAL ***/
//     let session = JSON.parse(await _Store.dispatch('existSession'))
//     //console.log(session)

//     if(session !== null) {
        
//     }

//     // Hide views in specifics cases
//     const show_only_with_session = ['dashboard', 'history_payments']
//     const show_only_without_session = ['login', 'register', 'forgot_password']

//     if((session === null || session.access_token === null) && show_only_with_session.includes(to.name)) {
//         next({ name: 'home' })
//         return
//     }
//     else if((session !== null && session.access_token !== null) && show_only_without_session.includes(to.name)) {
//         next({ name: 'dashboard' })
//         return
//     }

//     next()

//     // console.log(_Store.state.lang, '_Store.state.lang')
//     // console.log(_Store, '_Store')


//     // Set language if url changes
//     //await _Store.dispatch('changeLang', 'es')
//     //console.log(_Store, '_Store')    
//     // let new_view = to.name
//     // let old_view = from.name

//     //let lang = await _Store.dispatch('getLang')

//     // loadLanguageAsync(new_view, old_view, lang).then(response => {
//     //     next()
//     // })
// })

export default router
