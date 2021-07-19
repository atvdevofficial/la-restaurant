<template>
  <v-container fluid>
    <div class="mb-4">Gross Profit</div>
    <v-row>
      <v-col
        v-for="(item, index) in totalGross"
        :key="index"
        cols="12"
        sm="6"
        md="3"
      >
        <v-card>
          <v-card-title>
            <v-icon v-text="item.icon" large color="primary"></v-icon>
            <v-spacer></v-spacer>
            <div class="title">
              Php <animated-integer :value="item.amount"></animated-integer>
            </div>
          </v-card-title>
          <v-card-text>
            {{ item.subtitle }} | {{ item.orders }} Order(s)
          </v-card-text>
        </v-card>
      </v-col>
    </v-row>
    <v-divider class="my-4"></v-divider>
    <div class="mb-4">Orders</div>
    <v-row>
      <v-col
        v-for="(item, index) in orderStatusTotals"
        :key="index"
        cols="12"
        sm="6"
        md="2"
      >
        <v-card dark :color="item.color">
          <v-card-title>
            <v-icon v-text="item.icon"></v-icon>
            <v-spacer></v-spacer>
            <div class="title">{{ item.value }}</div>
          </v-card-title>
          <v-card-text>
            {{ item.title }}
          </v-card-text>
        </v-card>
      </v-col>
    </v-row>
    <v-divider class="my-4"></v-divider>
  </v-container>
</template>

<script>
export default {
  data() {
    return {
      totalGross: [
        {
          icon: "mdi-cash",
          amount: 0.00,
          orders: 0,
          subtitle: "Total Gross Today",
        },
        {
          icon: "mdi-cash",
          amount: 0.00,
          orders: 0,
          subtitle: "Total Gross Weekly",
        },
        {
          icon: "mdi-cash",
          amount: 0.00,
          orders: 0,
          subtitle: "Total Gross Monthly",
        },
        {
          icon: "mdi-cash",
          amount: 0.00,
          orders: 0,
          subtitle: "Total Gross",
        },
      ],
      orderStatusTotals: [
        {
          icon: "mdi-sigma",
          title: "Total Orders",
          value: 0,
          color: "primary",
        },
        {
          icon: "mdi-check",
          title: "Completed Orders",
          value: 0,
          color: "green",
        },
        {
          icon: "mdi-cancel",
          title: "Cancelled Orders",
          value: 0,
          color: "red",
        },
        {
          icon: "mdi-information",
          title: "Other Orders",
          value: 0,
          color: "cyan",
        },
      ],
    };
  },
  mounted() {
      this.retrieveDashboard();
  },
  methods: {
    retrieveDashboard() {
      axios
        .get("/api/v1/dashboard")
        .then((response) => {
            let data = response.data

            this.totalGross[0].amount = data.sales.daily.sum
            this.totalGross[0].orders = data.sales.daily.count

            this.totalGross[1].amount = data.sales.weekly.sum
            this.totalGross[1].orders = data.sales.weekly.count

            this.totalGross[2].amount = data.sales.monthly.sum
            this.totalGross[2].orders = data.sales.monthly.count

            this.totalGross[3].amount = data.sales.overall.sum
            this.totalGross[3].orders = data.sales.overall.count

            this.orderStatusTotals[0].value = data.orders.total
            this.orderStatusTotals[1].value = data.orders.delivered
            this.orderStatusTotals[2].value = data.orders.cancelled
            this.orderStatusTotals[3].value = data.orders.others
        })
        .catch((error) => {
          console.log(error);
        })
        .finally((_) => {});
    },
  },
};
</script>
