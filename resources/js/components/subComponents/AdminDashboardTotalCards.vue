<template>
        <v-card shaped :color="color" class="mb-5" elevation="5">
            <v-card-text>
                <v-row justify="start">
                    <div class="ml-2 title font-weight-regular white--text">{{title}}</div>
                </v-row>
                <v-row justify="center">
                    <div class="text-center"><v-icon id="dashboard-card-icon" size="60px">{{icon}}</v-icon></div>
                </v-row>
                <v-row justify="center">
                    <div class="display-2 font-weight-black text-center white--text">{{total}}</div>
                </v-row>
            </v-card-text>
            <!-- <v-card-actions>
                <v-btn :to="goto" text color="white">
                    See More
                </v-btn>
            </v-card-actions> -->
        </v-card>
</template>

<script>
import LineChart from '../charts/LineChart.vue'

export default {
    components : { LineChart },
    props: ['title', 'total', 'color', 'goto', 'icon'],
}
</script>
