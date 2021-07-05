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
                <v-subheader>Items</v-subheader>
                <v-list-item
                  v-for="(item, index) in viewingOrder.items"
                  :key="index"
                >
                  <v-list-item-content>
                    <v-list-item-title class="font-weight-bold">{{
                      item.name
                    }}</v-list-item-title>
                    <v-list-item-subtitle>
                      Php {{ item.price }} x
                      {{ item.quantity }}</v-list-item-subtitle
                    >
                  </v-list-item-content>
                  <v-list-item-action>
                    <div class="font-weight-bold">
                      Php {{ item.price * item.quantity }}
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

      <template v-slot:item.status="props">
        <v-edit-dialog
          :return-value.sync="props.item.status"
          large
          persistent
          @save="updateStatus"
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

      <template v-slot:item.actions="{ item }">
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
      orders: [
        {
          code: "159753451",
          customer: "John Doe Jr.",
          address: "Mapple Drive, Honey Drive, ASU",
          sub_total: 700.0,
          delivery_fee: 70.0,
          grand_total: 770.0,
          status: "PENDING",
          note: "the quick brown fox jumps over the lazy dog.",
          items: [
            { name: "Burger", price: 100, quantity: 1 },
            { name: "Fries", price: 50, quantity: 2 },
            { name: "Coke Float", price: 150, quantity: 3 },
          ],
        },
        {
          code: "159753452",
          customer: "John Doe Jr.",
          address: "Mapple Drive, Honey Drive, ASU",
          sub_total: 700.0,
          delivery_fee: 70.0,
          grand_total: 770.0,
          status: "PENDING",
          note: null,
          items: [
            { name: "Burger", price: 100, quantity: 4 },
            { name: "Fries", price: 50, quantity: 5 },
            { name: "Coke Float", price: 150, quantity: 6 },
          ],
        },
        {
          code: "159753453",
          customer: "John Doe Jr.",
          address: "Mapple Drive, Honey Drive, ASU",
          sub_total: 700.0,
          delivery_fee: 70.0,
          grand_total: 770.0,
          status: "PROCESSING",
          note: null,
          items: [
            { name: "Burger", price: 100, quantity: 7 },
            { name: "Fries", price: 50, quantity: 8 },
            { name: "Coke Float", price: 150, quantity: 9 },
          ],
        },
        {
          code: "159753454",
          customer: "John Doe Jr.",
          address: "Mapple Drive, Honey Drive, ASU",
          sub_total: 700.0,
          delivery_fee: 70.0,
          grand_total: 770.0,
          status: "DELIVERED",
          note: null,
          items: [
            { name: "Burger", price: 100, quantity: 10 },
            { name: "Fries", price: 50, quantity: 11 },
            { name: "Coke Float", price: 150, quantity: 12 },
          ],
        },
      ],
      statusList: ["PENDING", "PROCESSING", "ON-THE-WAY", "DELIVERED"],
    };
  },
  methods: {
    viewOrder(item) {
      this.viewingOrder = Object.assign({}, item);
      this.orderInformationDialog = true;
    },

    updateStatus() {
      console.log("Status Updated");
    },
  },
};
</script>
