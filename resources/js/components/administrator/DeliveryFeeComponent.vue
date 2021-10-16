<template>
  <v-container fluid>
    <v-data-table
      :headers="headers"
      :items="deliveryFees"
      :items-per-page="10"
      :loading="retrievingDeliveryFees"
    >
      <template v-slot:top>
        <v-toolbar flat>
          <v-spacer></v-spacer>
          <v-dialog v-model="dialog" max-width="500px" persistent>
            <template v-slot:activator="{ on, attrs }">
              <v-btn color="primary" dark class="mb-2" v-bind="attrs" v-on="on">
                New Delivery Fee
              </v-btn>
            </template>
            <v-card>
              <v-card-title>
                <span class="text-h5">{{ formTitle }}</span>
              </v-card-title>

              <v-card-text>
                <v-container>
                  <v-form ref="form" v-model="valid" lazy-validation>
                    <v-row>
                      <v-col cols="12" sm="6">
                        <v-text-field
                          :disabled="isProcessing"
                          :rules="[(v) => !!v || 'Field is required']"
                          :error-messages="serverValidationErrors.from"
                          v-model="editedDeliveryFee.from"
                          label="From"
                          suffix="Meter(s)"
                          type="number"
                        ></v-text-field>
                      </v-col>
                      <v-col cols="12" sm="6">
                        <v-text-field
                          :disabled="isProcessing"
                          :rules="[(v) => !!v || 'Field is required']"
                          :error-messages="serverValidationErrors.to"
                          v-model="editedDeliveryFee.to"
                          label="To"
                          suffix="Meter(s)"
                          type="number"
                        ></v-text-field>
                      </v-col>
                      <v-col cols="12" sm="6">
                        <v-text-field
                          :disabled="isProcessing"
                          :rules="[(v) => !!v || 'Field is required']"
                          :error-messages="serverValidationErrors.fee"
                          v-model="editedDeliveryFee.fee"
                          label="Fee"
                          prefix="PHP"
                          type="number"
                        ></v-text-field>
                      </v-col>
                    </v-row>
                  </v-form>
                </v-container>
              </v-card-text>

              <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn
                  color="default darken-1"
                  text
                  @click="close"
                  :disabled="isProcessing"
                >
                  Cancel
                </v-btn>
                <v-btn color="primary" @click="save" :loading="isProcessing">
                  Save
                </v-btn>
              </v-card-actions>
            </v-card>
          </v-dialog>

          <v-dialog v-model="dialogDelete" max-width="320">
            <v-card>
              <v-card-text class="pa-4 text-center">
                Are you sure you want to delete this delivery fee?
              </v-card-text>
              <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn color="default" text @click="closeDelete"> No </v-btn>
                <v-btn color="primary darken-1" @click="deleteItemConfirm">
                  Yes
                </v-btn>
                <v-spacer></v-spacer>
              </v-card-actions>
            </v-card>
          </v-dialog>
        </v-toolbar>
      </template>

      <!-- From -->
      <template v-slot:[`item.from`]="{ item }">
        {{ parseFloat(item.from).toFixed(1) }} Meter(s)
      </template>

      <!-- To -->
      <template v-slot:[`item.to`]="{ item }">
        {{ parseFloat(item.to).toFixed(1) }} Meter(s)
      </template>

      <!-- Fee -->
      <template v-slot:[`item.fee`]="{ item }">
        Php {{ parseFloat(item.fee).toFixed(2) }}
      </template>

      <!-- Product Actions -->
      <template v-slot:[`item.actions`]="{ item }">
        <v-icon small class="mr-2" @click="editItem(item)"> mdi-pencil </v-icon>
        <v-icon small @click="deleteItem(item)"> mdi-delete </v-icon>
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
      valid: false,
      isProcessing: false,
      dialog: false,
      dialogDelete: false,
      retrievingDeliveryFees: false,
      editedIndex: -1,
      editedDeliveryFee: {
        id: null,
        from: null,
        to: null,
        fee: null,
      },
      defaultDeliveryFee: {
        id: null,
        from: null,
        to: null,
        fee: null,
      },
      headers: [
        { text: "From", value: "from", align: "center" },
        { text: "To", value: "to", align: "center" },
        { text: "Fee", value: "fee", align: "center" },
        { text: "Actions", value: "actions", sortable: false, align: "center" },
      ],
      deliveryFees: [],

      serverValidationErrors: { from: null, to: null, fee: null },
    };
  },
  computed: {
    formTitle() {
      return this.editedIndex === -1 ? "New Delivery Fee" : "Edit Delivery Fee";
    },
  },
  watch: {
    dialog(val) {
      val || this.close();
    },
    dialogDelete(val) {
      val || this.closeDelete();
    },
  },
  mounted() {
    this.retrieveDeliveryFees();
  },
  methods: {
    retrieveDeliveryFees() {
      this.retrievingDeliveryFees = true;

      axios
        .get("/api/v1/deliveryFees")
        .then((response) => {
          let data = response.data;
          this.deliveryFees = data;
        })
        .catch((error) => {
          this.snackbar = {
            visible: true,
            color: "error",
            message:
              "Something went wrong while retrieving delivery fees. Please try again.",
          };
        })
        .finally((_) => {
          this.retrievingDeliveryFees = false;
        });
    },

    editItem(item) {
      this.editedIndex = this.deliveryFees.indexOf(item);
      this.editedDeliveryFee = Object.assign({}, item);
      this.dialog = true;
    },

    deleteItem(item) {
      this.editedIndex = this.deliveryFees.indexOf(item);
      this.editedDeliveryFee = Object.assign({}, item);
      this.dialogDelete = true;
    },

    deleteItemConfirm() {
      axios
        .delete("/api/v1/deliveryFees/" + this.editedDeliveryFee.id)
        .then((response) => {
          this.deliveryFees.splice(this.editedIndex, 1);
          this.closeDelete();
        })
        .catch((error) => {
          this.snackbar = {
            visible: true,
            color: "error",
            message:
              "Something went wrong while deleting delivery fee. Please try again.",
          };
        })
        .finally((_) => {});
    },

    close() {
      this.dialog = false;
      this.$nextTick(() => {
        this.editedDeliveryFee = Object.assign({}, this.defaultProduct);
        this.editedIndex = -1;
      });
    },

    closeDelete() {
      this.dialogDelete = false;
      this.serverValidationErrors = { from: null, to: null, fee: null };
      this.$nextTick(() => {
        this.editedDeliveryFee = Object.assign({}, this.defaultProduct);
        this.editedIndex = -1;
      });
    },

    save() {
      if (this.$refs.form.validate()) {
        this.isProcessing = true;
        if (this.editedIndex > -1) {
          // Update
          axios
            .put("/api/v1/deliveryFees/" + this.editedDeliveryFee.id, {
              ...this.editedDeliveryFee,
            })
            .then((response) => {
              let data = response.data;
              // Update product
              Object.assign(this.deliveryFees[this.editedIndex], data);
              // Close dialog
              this.close();
            })
            .catch((error) => {
              if (error.response.status == 422) {
                this.serverValidationErrors = error.response.data.errors;
              }
            })
            .finally((_) => {
              this.isProcessing = false;
            });
        } else {
          // Add
          axios
            .post("/api/v1/deliveryFees", {
              ...this.editedDeliveryFee,
            })
            .then((response) => {
              let data = response.data;
              // Add new product
              this.deliveryFees.push(data);
              // Close dialog
              this.close();
            })
            .catch((error) => {
              if (error.response.status == 422) {
                this.serverValidationErrors = error.response.data.errors;
              }
            })
            .finally((_) => {
              this.isProcessing = false;
            });
        }
      }
    },
  },
};
</script>
