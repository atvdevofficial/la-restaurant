<template>
  <v-container fluid>
    <v-row justify="end" align="center" no-gutters>
      <v-col cols="12" sm="10" md="8" lg="6" xl="4">
        <v-text-field
          v-model="search"
          placeholder="Search orders"
          append-icon="mdi-magnify"
        ></v-text-field>
      </v-col>
    </v-row>
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
                <div v-if="viewingOrder.notes != null">
                  <v-subheader>Notes / Instructions</v-subheader>
                  <v-list-item>
                    <v-list-item-content>
                      <v-list-item-subtitle>
                        {{ viewingOrder.notes }}</v-list-item-subtitle
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
        <div v-if="statusListWhereUpdateDisabled.includes(props.item.status)">
          {{ props.item.status }}
        </div>
        <div v-if="!statusListWhereUpdateDisabled.includes(props.item.status)">
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
            @cancel="editCancel(props.item)"
            @open="onOpenEditOrderStatus(props.item)"
            @close="onCloseEditOrderStatus(props.item)"
            v-if="props.item.status != null"
          >
            <div>{{ props.item.status }}</div>
            <template v-slot:input>
              <div class="mt-4">Update Status</div>
              <v-select
                :items="statusList"
                v-model="viewingOrder.status"
              ></v-select>
            </template>
          </v-edit-dialog>
        </div>
      </template>

      <template v-slot:[`item.actions`]="{ item }">
        <v-btn icon @click="viewOrder(item)">
          <v-icon small> mdi-information </v-icon>
        </v-btn>
      </template>
    </v-data-table>

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
      editedIndex: -1,
      isRetrievingOrders: false,
      orderInformationDialog: false,
      search: this.$route.params.code,
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
      statusList: [
        "DECLINED",
        "PENDING",
        "PROCESSING",
        "ON-THE-WAY",
        "DELIVERED",
      ],
      statusListWhereUpdateDisabled: ["CANCELLED", "DELIVERED"],
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
          this.snackbar = {
            visible: true,
            color: "error",
            message:
              "Something went wrong while retrieving orders. Please try again.",
          };
        })
        .finally((_) => {
          this.isRetrievingOrders = false;
        });
    },

    viewOrder(item) {
      this.viewingOrder = Object.assign({}, item);
      this.orderInformationDialog = true;
    },

    editCancel(item) {
      // Intentionally left blank
    },

    onCloseEditOrderStatus(item) {
      // Intentionally left blank
    },

    onOpenEditOrderStatus(item) {
      this.viewingOrder = Object.assign({}, item);
    },

    updateStatus(item) {
      let originalStatus = item.status;
      item.status = null;

      axios
        .put("/api/v1/orders/" + item.id, { status: this.viewingOrder.status })
        .then((response) => {
          let data = response.data;
          item.status = data.status;
        })
        .catch((error) => {
          item.status = originalStatus;
          this.snackbar = {
            visible: true,
            color: "error",
            message:
              "Something went wrong while updating order status. Please try again.",
          };
        })
        .finally((_) => {});
    },
  },
};
</script>
