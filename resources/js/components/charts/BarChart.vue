<script>
import { Bar } from 'vue-chartjs'

export default {
  extends: Bar,
  props: ['data', 'labels'],
  data: () => ({
    chartdata: {
      labels: [],
      datasets: [
        {
          fill: true,
          backgroundColor: '#F74B34',
          data: []
        }
      ]
    },
    options: {
      legend: {
        display: false,
      },
      responsive: true,
      maintainAspectRatio: false,
    }
  }),

  watch: {
      data () {
        this.chartdata.labels = this.labels
        this.chartdata.datasets[0].data = this.data
        this.renderChart(this.chartdata, this.options)
        console.log(this.data);
      },
  },

  mounted () {
    this.chartdata.labels = this.labels
    this.chartdata.datasets[0].data = this.data
    this.renderChart(this.chartdata, this.options)
  }
}

</script>
