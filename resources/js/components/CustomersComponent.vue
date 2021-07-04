<template>
  <v-container fluid>
    <v-data-table
      :headers="headers"
      :items="customers"
      :items-per-page="5"
      :search="search"
    >
      <template v-slot:top>
        <v-dialog
          v-model="customerInformationDialog"
          width="500"
          :retain-focus="false"
        >
          <v-card>
            <v-card-title class="text-h5 primary white--text">
              Customer Information ({{ viewingCustomer.name }})
            </v-card-title>

            <v-card-text class="mt-4">
              <v-row>
                <v-col cols="4">
                  <v-card>
                    <v-card-title class="justify-center">
                      <div class="title">
                        {{ viewingCustomer.orders.total }}
                      </div>
                    </v-card-title>
                    <v-card-text class="text-center"> Orders </v-card-text>
                  </v-card>
                </v-col>
                <v-col cols="4">
                  <v-card>
                    <v-card-title class="justify-center">
                      <div class="title">
                        {{ viewingCustomer.orders.delivered }}
                      </div>
                    </v-card-title>
                    <v-card-text class="text-center"> Delivered </v-card-text>
                  </v-card>
                </v-col>
                <v-col cols="4">
                  <v-card>
                    <v-card-title class="justify-center">
                      <div class="title">
                        {{ viewingCustomer.orders.cancelled }}
                      </div>
                    </v-card-title>
                    <v-card-text class="text-center"> Cancelled </v-card-text>
                  </v-card>
                </v-col>
              </v-row>
            </v-card-text>

            <v-divider></v-divider>

            <v-card-actions>
              <v-spacer></v-spacer>
              <v-btn
                color="default"
                text
                @click="customerInformationDialog = false"
              >
                Close
              </v-btn>
            </v-card-actions>
          </v-card>
        </v-dialog>

        <v-dialog v-model="dialogDelete" max-width="320">
            <v-card>
              <v-card-title class="caption">
                Are you sure you want to delete this customer?
              </v-card-title>
              <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn color="default" text @click="closeDelete"> No </v-btn>
                <v-btn color="primary darken-1" @click="deleteCustomerConfirm">
                  Yes
                </v-btn>
                <v-spacer></v-spacer>
              </v-card-actions>
            </v-card>
          </v-dialog>
      </template>

      <template v-slot:item.actions="{ item }">
        <v-icon small class="mr-2" @click="viewCustomer(item)">
          mdi-information
        </v-icon>
        <v-icon small @click="deleteCustomer(item)"> mdi-delete </v-icon>
      </template>
    </v-data-table>
  </v-container>
</template>

<script>
export default {
  data() {
    return {
      customerInformationDialog: false,
      dialogDelete: false,
      search: "",
      headers: [
        { text: "ID", value: "id" },
        { text: "Name", value: "name" },
        { text: "Address", value: "address" },
        { text: "Phone Number", value: "phone_number" },
        { text: "Actions", value: "actions", sortable: false, align: "center" },
      ],
      customers: [
        {
          id: 1,
          name: "John Doe",
          address: "Mapple Street",
          phone_number: "999-9999",
          orders: {
            total: 0,
            delivered: 0,
            cancelled: 0,
          },
        },
        {
          id: 2,
          name: "Mila Ei",
          address: "Apple Corner",
          phone_number: "999-9999",
          orders: {
            total: 0,
            delivered: 0,
            cancelled: 0,
          },
        },
        {
          id: 3,
          name: "Robert Bob",
          address: "Oakwood Drive",
          phone_number: "999-9999",
          orders: {
            total: 0,
            delivered: 0,
            cancelled: 0,
          },
        },
      ],
      viewingCustomer: {
        id: null,
        name: null,
        address: null,
        phone_number: null,
        orders: {
          total: 0,
          delivered: 0,
          cancelled: 0,
        },
      },
     defaultCustomer: {
        id: null,
        name: null,
        address: null,
        phone_number: null,
        orders: {
          total: 0,
          delivered: 0,
          cancelled: 0,
        },
      },
      editedIndex: -1,
    };
  },
  watch: {
    dialogDelete(val) {
      val || this.closeDelete();
    },
  },
  methods: {
    viewCustomer(item) {
      this.viewingCustomer = Object.assign({}, item);
      this.customerInformationDialog = true;
    },

    deleteCustomer(item) {
      this.editedIndex = this.customers.indexOf(item);
      this.viewingCustomer = Object.assign({}, item);
      this.dialogDelete = true;
    },

    deleteCustomerConfirm() {
      this.customers.splice(this.editedIndex, 1);
      this.closeDelete();
    },

    close() {
      this.customerInformationDialog = false;
      this.$nextTick(() => {
        this.viewingCustomer = Object.assign({}, this.defaultCustomer);
        this.editedIndex = -1;
      });
    },

    closeDelete() {
      this.dialogDelete = false;
      this.$nextTick(() => {
        this.viewingCustomer = Object.assign({}, this.defaultCustomer);
        this.editedIndex = -1;
      });
    },
  },
};
</script>
