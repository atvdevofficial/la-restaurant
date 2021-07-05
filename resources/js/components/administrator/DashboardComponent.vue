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
            <div class="title">Php {{ item.amount }}</div>
          </v-card-title>
          <v-card-text>
            {{ item.subtitle }}
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
          amount: "10,000.00",
          subtitle: "Total Gross Today | 5 Order(s)",
        },
        {
          icon: "mdi-cash",
          amount: "10,000.00",
          subtitle: "Total Gross Weekly | 10 Order(s)",
        },
        {
          icon: "mdi-cash",
          amount: "10,000.00",
          subtitle: "Total Gross Monthly | 15 Order(s)",
        },
        {
          icon: "mdi-cash",
          amount: "10,000.00",
          subtitle: "Total Gross Yearly | 20 Order(s)",
        },
      ],
      orderStatusTotals: [
        {
          icon: "mdi-sigma",
          title: "Total Orders",
          value: 50,
          color: "primary",
        },
        {
          icon: "mdi-check",
          title: "Completed Orders",
          value: 50,
          color: "green",
        },
        {
          icon: "mdi-cancel",
          title: "Cancelled Orders",
          value: 50,
          color: "red",
        },
        {
          icon: "mdi-information",
          title: "Other Orders",
          value: 50,
          color: "cyan",
        },
      ],
    };
  },
};
</script>
