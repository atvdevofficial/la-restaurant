<template>
  <v-container class="ma-0 pa-0">
    <v-text-field v-model="search" v-show="false"></v-text-field>
    <v-row justify="center" no-gutters>
      <v-col cols="12" sm="10" md="8" lg="6" xl="4">
        <v-list class="pa-0">
          <v-list-item
            two-line
            v-for="(order, index) in filteredOrdersBySearch"
            :key="index"
            @click="viewOrder(order)"
          >
            <v-list-item-content>
              <v-list-item-title class="font-weight-bold">
                {{ order.code }}
              </v-list-item-title>
              <v-list-item-subtitle class="font-italic">
                {{ order.created_at }}
              </v-list-item-subtitle>
            </v-list-item-content>
            <v-list-item-action> {{ order.status }} </v-list-item-action>
          </v-list-item>
        </v-list>
      </v-col>
    </v-row>

    <v-dialog
      v-model="orderInformationDialog"
      width="500"
      :retain-focus="false"
    >
      <v-card>
        <v-card-title class="text-h5 primary white--text">
          Order Information
        </v-card-title>

        <v-card-text>
          <v-row>
            <v-col
              ><div class="caption font-italic mt-2">Code</div>
              <div class="font-weight-bold title">
                {{ viewingOrder.code }}
              </div></v-col
            >
            <v-col
              ><div class="caption font-italic mt-2">Grand Total</div>
              <div class="font-weight-bold title">
                Php {{ viewingOrder.grand_total }}
              </div></v-col
            >
          </v-row>

          <v-divider class="my-2"></v-divider>

          <div class="caption font-italic mt-2">Items</div>
          <v-list dense>
            <v-list-item
              v-for="(item, index) in viewingOrder.order_products"
              :key="index"
            >
              <v-list-item-content>
                <v-list-item-title>{{ item.product.name }}</v-list-item-title>
                <v-list-item-subtitle>
                  Php {{ item.price }} x
                  {{ item.quantity }}</v-list-item-subtitle
                >
              </v-list-item-content>
              <v-list-item-action>
                <div>Php {{ item.price * item.quantity }}</div>
              </v-list-item-action>
            </v-list-item>
          </v-list>

          <v-row>
            <v-col
              ><div class="caption font-italic">Sub Total</div>
              <div>Php {{ viewingOrder.sub_total }}</div></v-col
            >
            <v-col
              ><div class="caption font-italic">Delivey Fee</div>
              <div>Php {{ viewingOrder.delivery_fee }}</div></v-col
            >
          </v-row>

          <div v-if="viewingOrder.note != null">
            <v-divider class="my-2"></v-divider>
            <div class="caption font-italic mt-2">Note</div>
            <div>{{ viewingOrder.note }}</div>
          </div>
        </v-card-text>

        <v-divider></v-divider>

        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="default" text @click="orderInformationDialog = false">
            Close
          </v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </v-container>
</template>

<script>
export default {
  data() {
    return {
      search: this.$route.params.code ?? '',
      orderInformationDialog: false,
      viewingOrder: {
        code: null,
        customer: null,
        address: null,
        sub_total: 0,
        delivery_fee: 0,
        grand_total: 0,
        status: null,
        note: null,
        items: [{ name: null, price: 0, quantity: 0 }],
      },
      orders: [],
    };
  },
  computed: {
    filteredOrdersBySearch() {
      return this.orders.filter((order) => {
        return this.search
          .toLowerCase()
          .split(" ")
          .every((v) => order.code.toLowerCase().includes(v));
      });
    },
  },
  mounted() {
    this.retrieveOrders();
  },
  methods: {
    viewOrder(order) {
      this.viewingOrder = Object.assign({}, order);
      this.orderInformationDialog = true;
    },

    retrieveOrders() {
      axios
        .get("/api/v1/orders")
        .then((response) => {
          this.orders = response.data;
        })
        .catch((error) => {
          console.log(error);
        })
        .finally((_) => {});
    },
  },
};
</script>
