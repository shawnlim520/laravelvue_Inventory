/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

import Vue from 'vue'
import VueRouter from 'vue-router'

Vue.use(VueRouter)

// Router Imported
import {routes} from './routes';


// Import User Class
import User from './helpers/User';
window.User = User


// Sweet Alert Start
import Swal from 'sweetalert2'
window.Swal = Swal;

// Import Notification
import Notification from './helpers/Notification'
window.Notification = Notification;

const Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true,
    didOpen: (toast) => {
      toast.addEventListener('mouseenter', Swal.stopTimer)
      toast.addEventListener('mouseleave', Swal.resumeTimer)
    }
  });

  window.Toast = Toast;


// Sweet Alert End

window.Reload = new Vue();

const router = new VueRouter({
    routes,
    mode: 'history'
})


const app = new Vue({
    el: '#app',
    router
});
