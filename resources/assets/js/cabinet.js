import './bootstrap'
import Vue from 'vue'
import Vuex from 'vuex'
import App from './App'
import request from './utils/request'
import router from './router'
import Notifications from 'vue-notification'
import { store } from './store'
// import VueMaterial from 'vue-material'

import { MdField, MdMenu, MdList, MdButton } from 'vue-material/dist/components'
// import 'vue-material/dist/vue-material.min.css'

import Navigation from './views/components/header/navigation'
import MaterialPagination from './views/components/pagination/material'
import iCollapse from './views/components/collapse/collapse'

window.Vue = Vue

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.prototype.trans = (key) => {
    return window.globalTrans(key)
};

Vue.use(Vuex)
Vue.use(Notifications)
// Vue.use(VueMaterial)
Vue.use(MdField)
Vue.use(MdMenu)
Vue.use(MdList)
Vue.use(MdButton)
Vue.use(MdButton)
Vue.use(Navigation)
Vue.use(MaterialPagination)

Vue.component('i-navigation', Navigation)
Vue.component('i-pagination', MaterialPagination)
Vue.component('i-collapse', iCollapse)

store.dispatch('loadUser').then(res => {
    const app = new Vue({
        el: '#cabinet',
        router,
        store,
        components: { App },
        template: '<App/>',
        // created () {
        //     this.$store.dispatch('loadUser')
        // }
    })
})


