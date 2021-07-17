<template>
  <v-container fluid>
    <div class="caption font-italic ma-1">
      Note: Click the status of the corresponding order to update.
    </div>
    <v-data-table
      :headers="headers"
      :items="orders"
      :items-per-page="5"
      :search="search"
      :loading="isRetrievingOrders"
    >
      <template v-slot:top>
        <v-dialog
          v-model="orderInformationDialog"
          width="500"
          :retain-focus="false"
        >
          <v-card>
            <v-card-title class="text-h5 primary white--text">
              Order Information ({{ viewingOrder.code }})
            </v-card-title>

            <v-card-text>
              <v-list>
                <v-subheader>Products</v-subheader>
                <v-list-item
                  v-for="(item, index) in viewingOrder.order_products"
                  :key="index"
                >
                  <v-list-item-content>
                    <v-list-item-title class="font-weight-bold">{{
                      item.product.name
                    }}</v-list-item-title>
                    <v-list-item-subtitle>
                      Php {{ parseFloat(item.price).toFixed(2) }} x
                      {{ item.quantity }}</v-list-item-subtitle
                    >
                  </v-list-item-content>
                  <v-list-item-action>
                    <div class="font-weight-bold">
                      Php
                      {{ parseFloat(item.price * item.quantity).toFixed(2) }}
                    </div>
                  </v-list-item-action>
                </v-list-item>
                <div v-if="viewingOrder.note != null">
                  <v-subheader>Note</v-subheader>
                  <v-list-item>
                    <v-list-item-content>
                      <v-list-item-subtitle>
                        {{ viewingOrder.note }}</v-list-item-subtitle
                      >
                    </v-list-item-content>
                  </v-list-item>
                </div>
              </v-list>
            </v-card-text>

            <v-divider></v-divider>

            <v-card-actions>
              <v-spacer></v-spacer>
              <v-btn
                color="default"
                text
                @click="orderInformationDialog = false"
              >
                Close
              </v-btn>
            </v-card-actions>
          </v-card>
        </v-dialog>
      </template>

      <template v-slot:[`item.customer`]="props">
        {{ props.item.customer.last_name }},
        {{ props.item.customer.first_name }}
      </template>

      <template v-slot:[`item.sub_total`]="props">
        {{ parseFloat(props.item.sub_total).toFixed(2) }}
      </template>

      <template v-slot:[`item.delivery_fee`]="props">
        {{ parseFloat(props.item.delivery_fee).toFixed(2) }}
      </template>

      <template v-slot:[`item.grand_total`]="props">
        {{ parseFloat(props.item.grand_total).toFixed(2) }}
      </template>

      <template v-slot:[`item.status`]="props">
        <v-progress-circular
          size="20"
          width="2"
          indeterminate
          color="primary"
          v-if="props.item.status == null"
        ></v-progress-circular>
        <v-edit-dialog
          :return-value.sync="props.item.status"
          large
          persistent
          @save="updateStatus(props.item)"
          @open="initialOrderStatus = props.item.status"
          v-if="props.item.status != null"
        >
          <div>{{ props.item.status }}</div>
          <template v-slot:input>
            <div class="mt-4">Update Status</div>
            <v-select
              :items="statusList"
              v-model="props.item.status"
            ></v-select>
          </template>
        </v-edit-dialog>
      </template>

      <template v-slot:[`item.actions`]="{ item }">
        <v-btn icon @click="viewOrder(item)">
          <v-icon small> mdi-information </v-icon>
        </v-btn>
      </template>
    </v-data-table>
  </v-container>
</template>

<script>
export default {
  data() {
    return {
      isRetrievingOrders: false,
      orderInformationDialog: false,
      search: "",
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
      headers: [
        { text: "Code", value: "code" },
        { text: "Customer", value: "customer" },
        { text: "Address", value: "address" },
        { text: "Sub Total", value: "sub_total" },
        { text: "Delivery Fee", value: "delivery_fee" },
        { text: "Grand Total", value: "grand_total" },
        { text: "Status", value: "status" },
        { text: "Actions", value: "actions", sortable: false, align: "center" },
      ],
      orders: [],
      initialOrderStatus: null,
      statusList: ["PENDING", "PROCESSING", "ON-THE-WAY", "DELIVERED"],
    };
  },
  mounted() {
    this.retrieveOrders();
  },
  methods: {
    retrieveOrders() {
      this.isRetrievingOrders = true;
      axios
        .get("/api/v1/orders")
        .then((response) => {
          let data = response.data;
          this.orders = data;
        })
        .catch((error) => {
          console.log(error);
        })
        .then((_) => {
          this.isRetrievingOrders = false;
        });
    },

    viewOrder(item) {
      this.viewingOrder = Object.assign({}, item);
      this.orderInformationDialog = true;
    },

    updateStatus(item) {
      let status = item.status;
      item.status = null;

      axios
        .put("/api/v1/orders/" + item.id, { status })
        .then((response) => {
          let data = response.data;
          item.status = data.status;
        })
        .catch((error) => {
          item.status = this.initialOrderStatus;
        })
        .finally((_) => {
          this.initialOrderStatus = null;
        });
    },
  },
};
</script>
