<template>
  <v-container class="pa-2">
    <v-row justify="center" no-gutters>
      <v-col cols="12">
        <div class="caption font-italic text-center">
          Note: Click the order to view information.
        </div>
      </v-col>
      <v-col cols="12" sm="10" md="8" lg="6" xl="4">
        <v-list class="pa-0">
          <v-list-item
            two-line
            v-for="(order, index) in orders"
            :key="index"
            @click="viewOrder(order)"
          >
            <v-list-item-content>
              <v-list-item-title class="font-weight-bold">
                {{ order.code }}
              </v-list-item-title>
              <v-list-item-subtitle class="font-italic">
                July 05, 2021 11:00 AM
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
              v-for="(item, index) in viewingOrder.items"
              :key="index"
            >
              <v-list-item-content>
                <v-list-item-title>{{ item.name }}</v-list-item-title>
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
      orders: [
        {
          code: "159753451",
          customer: "John Doe Jr.",
          address: "Mapple Drive, Honey Drive, ASU",
          sub_total: 700.0,
          delivery_fee: 70.0,
          grand_total: 770.0,
          status: "PENDING",
          note: "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus consectetur vehicula aliquet. Sed porttitor ut sapien nec pretium. Pellentesque rutrum, lacus in placerat semper, sem nisl vestibulum sem.",
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
    };
  },
  methods: {
    viewOrder(order) {
      this.viewingOrder = Object.assign({}, order);
      this.orderInformationDialog = true;
    },
  },
};
</script>
