<template>
  <v-container>
    <div>
      <v-row justify="center" align="center" no-gutters>
        <v-col cols="12" sm="10" md="8" lg="6" xl="4">
          <v-text-field
            v-model="search"
            placeholder="Search orders"
            append-icon="mdi-magnify"
          ></v-text-field>
        </v-col>
      </v-row>
    </div>
    <v-row justify="center" align="center" no-gutters>
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
            <v-col cols="12">
              <div class="caption font-italic">Notes / Instructions</div>
              <div v-if="viewingOrder.notes != null">
                {{ viewingOrder.notes }}
              </div>
              <div v-else>No Notes / Instructions</div>
            </v-col>
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
          <v-dialog v-model="dialogCancel" max-width="320">
            <template v-slot:activator="{ on, attrs }">
              <v-btn
                color="error"
                text
                v-bind="attrs"
                v-on="on"
                v-show="
                  !statusListWhereCancellationDisabled.includes(
                    viewingOrder.status
                  )
                "
              >
                Cancel Order
              </v-btn>
            </template>
            <v-card>
              <v-card-text class="pa-4 text-center">
                Are you sure you want to cancel this order?
              </v-card-text>
              <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn
                  color="default"
                  text
                  @click="dialogCancel = false"
                  :disabled="isProcessing"
                >
                  No
                </v-btn>
                <v-btn
                  color="primary darken-1"
                  @click="cancelOrderConfirm"
                  :loading="isProcessing"
                >
                  Yes
                </v-btn>
                <v-spacer></v-spacer>
              </v-card-actions>
            </v-card>
          </v-dialog>

          <v-spacer></v-spacer>
          <v-btn color="default" text @click="orderInformationDialog = false">
            Close
          </v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>

    <v-snackbar
      :color="snackbar.color"
      v-model="snackbar.visible"
      timeout="2000"
    >
      {{ snackbar.message }}
    </v-snackbar>
  </v-container>
</template>

<script>
export default {
  data() {
    return {
      snackbar: {
        visible: false,
        color: "primary",
        message: "",
      },
      isProcessing: false,
      dialogCancel: false,
      search: this.$route.params.code ?? "",
      orderInformationDialog: false,
      editedIndex: -1,
      viewingOrder: {
        code: null,
        customer: null,
        address: null,
        sub_total: 0,
        delivery_fee: 0,
        grand_total: 0,
        status: null,
        notes: null,
        items: [{ name: null, price: 0, quantity: 0 }],
      },
      orders: [],
      statusListWhereCancellationDisabled: [
        "CANCELLED",
        "DECLINED",
        "DELIVERED",
      ],
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
      this.editedIndex = this.orders.indexOf(order);
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
          this.snackbar = {
            visible: true,
            color: "error",
            message:
              "Something went wrong while retrieving orders. Please try again.",
          };
        })
        .finally((_) => {});
    },

    cancelOrderConfirm() {
      this.isProcessing = true;
      axios
        .put("/api/v1/orders/" + this.viewingOrder.id, { status: "CANCELLED" })
        .then((response) => {
          this.orders[this.editedIndex].status = "CANCELLED";
          this.dialogCancel = false;
          this.orderInformationDialog = false;
        })
        .catch((error) => {
          this.snackbar = {
            visible: true,
            color: "error",
            message:
              "Something went wrong while cancelling order. Please try again.",
          };
        })
        .finally((_) => {
          this.isProcessing = false;
        });
    },
  },
};
</script>
