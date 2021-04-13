<template>
    <v-container>
        <h1>Pusher Component</h1>
        {{ message }}
    </v-container>
</template>

<script>
export default {
    data() {
        return {
            message: null
        };
    },

    computed: {
        //
    },

    mounted() {
        Echo.channel('sample-events')
        .listen('SampleEvent', (e) => {
            console.log(e)
            this.message = e.message
        })
    },

    methods: {
        //
    }
};
</script>
