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
              Customer Information ({{ viewingCustomer.last_name }},
              {{ viewingCustomer.first_name }})
            </v-card-title>

            <v-card-text class="mt-4">
              <v-row>
                <v-col cols="12"> --- Insert Map Here --- </v-col>
                <v-col cols="12"><v-divider></v-divider></v-col>
                <v-col cols="4">
                  <v-card>
                    <v-card-title class="justify-center">
                      <div class="title">0</div>
                    </v-card-title>
                    <v-card-text class="text-center"> Orders </v-card-text>
                  </v-card>
                </v-col>
                <v-col cols="4">
                  <v-card>
                    <v-card-title class="justify-center">
                      <div class="title">0</div>
                    </v-card-title>
                    <v-card-text class="text-center"> Delivered </v-card-text>
                  </v-card>
                </v-col>
                <v-col cols="4">
                  <v-card>
                    <v-card-title class="justify-center">
                      <div class="title">0</div>
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
            <v-card-text class="pa-4 text-center">
              Are you sure you want to delete this customer?
            </v-card-text>
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

      <template v-slot:item.name="{ item }">
        {{ item.last_name }}, {{ item.first_name }}
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
        { text: "Email", value: "user.email" },
        { text: "Name", value: "name" },
        { text: "Address", value: "address" },
        { text: "Contact Number", value: "contact_number" },
        { text: "Actions", value: "actions", sortable: false, align: "center" },
      ],
      viewingCustomer: {
        id: null,
        first_name: null,
        last_name: null,
        contact_number: null,
        address: null,
        latitude: null,
        longitude: null,
        user: {
          id: null,
          email: null,
        },
        orders: {
          total: 0,
          delivered: 0,
          cancelled: 0,
        },
      },
      defaultCustomer: {
        id: null,
        first_name: null,
        last_name: null,
        contact_number: null,
        address: null,
        latitude: null,
        longitude: null,
        user: {
          id: null,
          email: null,
        },
        orders: {
          total: 0,
          delivered: 0,
          cancelled: 0,
        },
      },
      editedIndex: -1,
      customers: [],
    };
  },
  watch: {
    dialogDelete(val) {
      val || this.closeDelete();
    },
  },
  mounted() {
    this.retrieveCustomers();
  },
  methods: {
    retrieveCustomers() {
      this.isRetrievingCustomers = true;

      axios
        .get("/api/v1/customers")
        .then((response) => {
          let data = response.data;

          this.customers = data;
        })
        .catch((error) => {
          console.log(error);
        })
        .finally((_) => {
          this.isRetrievingCustomers = false;
        });
    },

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
      axios
        .delete("/api/v1/customers/" + this.viewingCustomer.id)
        .then((response) => {
          this.customers.splice(this.editedIndex, 1);
          this.closeDelete();
        })
        .catch((error) => {
          console.log(error);
        })
        .finally((_) => {});
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
