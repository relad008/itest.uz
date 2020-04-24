import axios from 'axios'
import Vue from 'vue'
import {store} from '../store'

// create an axios instance
const service = axios.create({
  baseURL: '/api',
  timeout: 5000
})

// respone interceptor
service.interceptors.response.use(
  response => {
    store.dispatch('setLoading', false)
    return response
  },
  error => {
    store.dispatch('setLoading', false)
    Vue.notify({
      group: 'cabinet',
      text: error.message,
      type: 'alert-danger',
      duration: 5 * 1000
    });
    return Promise.reject(error)
  })

service.interceptors.request.use(config => {
  store.dispatch('setLoading', true)
  return config
})

export default service
