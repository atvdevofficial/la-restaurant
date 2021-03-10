import Vue from 'vue'
import * as VueGoogleMaps from 'vue2-google-maps'

Vue.use(VueGoogleMaps, {
    load: {
        key: 'AIzaSyCTtgC7N8qY_76MrE0fgdZM9_C4dHOcpEw',
        libraries: 'places',
    },
    installComponents: true
})
