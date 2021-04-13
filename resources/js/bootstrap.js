window._ = require('lodash');

try {
    window.Popper = require('popper.js').default;
    window.$ = window.jQuery = require('jquery');

    require('bootstrap');
} catch (e) { }

window.axios = require('axios');

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

let token = document.head.querySelector('meta[name="csrf-token"]');

if (token) {
    window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
} else {
    console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
}

// Add a request interceptor to axios
axios.interceptors.request.use(function (config) {
    let authToken = sessionStorage.getItem('user-token') || ''
    if (authToken) {
        config.headers['Authorization'] = `Bearer ${authToken}`
    }
    return config;
}, function (error) {
    return Promise.reject(error);
});

import Echo from "laravel-echo";

window.Pusher = require('pusher-js');

window.Echo = new Echo({
    auth: {
        headers: {
            Authorization: 'Bearer ' + sessionStorage.getItem('user-token'),
        }
    },
    broadcaster: 'pusher',
    key: process.env.MIX_PUSHER_APP_KEY,
    cluster: process.env.MIX_PUSHER_APP_CLUSTER,
    encrypted: true,
});

// import Echo from 'laravel-echo';

// window.Pusher = require('pusher-js');

// window.Echo = new Echo({
//     broadcaster: 'pusher',
//     key: process.env.MIX_PUSHER_APP_KEY,
//     cluster: process.env.MIX_PUSHER_APP_CLUSTER,
//     // encrypted: true,
//     wsHost: window.location.hostname,
//     wsPort: 6001
// });
