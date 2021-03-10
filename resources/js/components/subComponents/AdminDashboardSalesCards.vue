<template>
        <v-card shaped :color="color" class="mb-5" elevation="5">
            <v-card-text>
                <v-row justify="space-between">
                    <v-col cols="6">
                        <v-row>
                            <div class="display-2 font-weight-black text-center white--text">{{total}}</div>
                        </v-row>
                        <v-row>
                            <div class="ml-2 title font-weight-regular white--text">{{title}}</div>
                        </v-row>
                    </v-col>
                    <v-col cols="6">
                        <div class="text-center"><v-icon id="dashboard-card-icon" size="60px">{{icon}}</v-icon></div>
                    </v-col>
                </v-row>
            </v-card-text>
        </v-card>
</template>

<script>
import LineChart from '../charts/LineChart.vue'

export default {
    components : { LineChart },
    props: ['title', 'total', 'color', 'goto', 'icon'],
}
</script>
