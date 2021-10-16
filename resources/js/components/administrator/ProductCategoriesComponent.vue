<template>
  <v-container fluid>
    <v-data-table
      :headers="headers"
      :items="productCategories"
      :items-per-page="10"
      :search="search"
      :loading="retrievingProductCategories"
    >
      <template v-slot:top>
        <v-toolbar flat>
          <v-spacer></v-spacer>
          <v-dialog v-model="dialog" max-width="500px" persistent>
            <template v-slot:activator="{ on, attrs }">
              <v-btn color="primary" dark class="mb-2" v-bind="attrs" v-on="on">
                New Product Category
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
                      <v-col cols="12">
                        <v-text-field
                          :disabled="isProcessing"
                          :rules="[(v) => !!v || 'Field is required']"
                          :error-messages="serverValidationErrors.name"
                          v-model="editedProductCategory.name"
                          label="Name"
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
                Are you sure you want to delete this product category?
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

      <!-- Product Actions -->
      <template v-slot:item.actions="{ item }">
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
      retrievingProductCategories: false,
      dialog: false,
      dialogDelete: false,
      search: "",
      headers: [
        { text: "ID", value: "id" },
        { text: "Name", value: "name" },
        { text: "Actions", value: "actions", sortable: false, align: "center" },
      ],
      editedIndex: -1,
      editedProductCategory: {
        id: null,
        name: null,
      },
      defaultProductCategory: {
        id: null,
        name: null,
      },
      productCategories: [],
      serverValidationErrors: { name: null },
    };
  },
  computed: {
    formTitle() {
      return this.editedIndex === -1
        ? "New Product Category"
        : "Edit Product Category";
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
    this.retrieveProductCategories();
  },
  methods: {
    retrieveProductCategories() {
      this.retrievingProductCategories = true;

      axios
        .get("/api/v1/productCategories")
        .then((response) => {
          let data = response.data;
          this.productCategories = data;
        })
        .catch((error) => {
          this.snackbar = {
            visible: true,
            color: "error",
            message:
              "Something went wrong while retrieving product categories. Please try again.",
          };
        })
        .finally((_) => {
          this.retrievingProductCategories = false;
        });
    },

    editItem(item) {
      this.editedIndex = this.productCategories.indexOf(item);
      this.editedProductCategory = Object.assign({}, item);
      this.dialog = true;
    },

    deleteItem(item) {
      this.editedIndex = this.productCategories.indexOf(item);
      this.editedProductCategory = Object.assign({}, item);
      this.dialogDelete = true;
    },

    deleteItemConfirm() {
      axios
        .delete("/api/v1/productCategories/" + this.editedProductCategory.id)
        .then((response) => {
          this.productCategories.splice(this.editedIndex, 1);
          this.closeDelete();
        })
        .catch((error) => {
          this.snackbar = {
            visible: true,
            color: "error",
            message:
              "Something went wrong while deleting product category. Please try again.",
          };
        })
        .finally((_) => {});
    },

    close() {
      this.dialog = false;
      this.serverValidationErrors = { name: null };
      this.$nextTick(() => {
        this.editedProductCategory = Object.assign(
          {},
          this.defaultProductCategory
        );
        this.editedIndex = -1;
      });
    },

    closeDelete() {
      this.dialogDelete = false;
      this.$nextTick(() => {
        this.editedProductCategory = Object.assign(
          {},
          this.defaultProductCategory
        );
        this.editedIndex = -1;
      });
    },

    save() {
      if (this.$refs.form.validate()) {
        this.isProcessing = true;

        if (this.editedIndex > -1) {
          // Update
          axios
            .put("/api/v1/productCategories/" + this.editedProductCategory.id, {
              ...this.editedProductCategory,
            })
            .then((response) => {
              let data = response.data;

              // Update product categories
              Object.assign(
                this.productCategories[this.editedIndex],
                this.editedProductCategory
              );

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
            .post("/api/v1/productCategories", {
              ...this.editedProductCategory,
            })
            .then((response) => {
              let data = response.data;

              // Add new product
              this.productCategories.push(data);

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
