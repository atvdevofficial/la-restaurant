<template>
    <div>
        <v-card color="primary" class="mb-5" elevation="1">
            <v-card-text class="d-flex justify-space-between">
                <span class="headline font-weight-black white--text">{{title}}</span>
                <div>
                    <span class="font-weight-bold white--text" >{{saleAndDifferencePercentage.differenceValue}}%</span>
                    <v-icon v-if="saleAndDifferencePercentage.salesHasIncreased" small color="white">fa-arrow-up</v-icon>
                    <v-icon v-if="!saleAndDifferencePercentage.salesHasIncreased" small color="error">fa-arrow-down</v-icon>
                </div>
            </v-card-text>
        </v-card>
        <v-card>
            <v-card-text>
                <LineChart
                    v-if="loaded"
                    :data="saleAndDifferencePercentage.chartData"
                    :labels="saleAndDifferencePercentage.chartLabels" />
            </v-card-text>
        </v-card>
    </div>
</template>

<script>
import LineChart from '../charts/LineChart.vue'

export default {
    components : { LineChart },
    props: ['title', 'saleAndDifferencePercentage', 'loaded'],
}
</script>
