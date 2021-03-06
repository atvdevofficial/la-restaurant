<template>
  <v-container fluid>
    <v-data-table
      :headers="headers"
      :items="products"
      :items-per-page="10"
      :search="search"
      :loading="isRetrievingProducts"
    >
      <template v-slot:top>
        <v-toolbar flat>
          <v-spacer></v-spacer>
          <v-dialog v-model="dialog" max-width="500px" persistent>
            <template v-slot:activator="{ on, attrs }">
              <v-btn color="primary" dark class="mb-2" v-bind="attrs" v-on="on">
                New Product
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
                          :rules="rules.required"
                          :error-messages="serverValidationErrors.name"
                          v-model="editedProduct.name"
                          label="Name"
                        ></v-text-field>
                      </v-col>
                      <v-col cols="12" sm="6">
                        <v-text-field
                          :disabled="isProcessing"
                          :rules="rules.required"
                          :error-messages="serverValidationErrors.price"
                          v-model="editedProduct.price"
                          label="Price"
                          prefix="PHP"
                          type="number"
                        ></v-text-field>
                      </v-col>
                      <v-col cols="12">
                        <v-textarea
                          :disabled="isProcessing"
                          :rules="rules.required"
                          :error-messages="serverValidationErrors.description"
                          v-model="editedProduct.description"
                          label="Description"
                        ></v-textarea>
                      </v-col>

                      <v-col cols="12">
                        <v-select
                          :disabled="isProcessing"
                          :rules="[(v) => !!v.length || 'Category is required']"
                          :error-messages="
                            serverValidationErrors.product_categories
                          "
                          v-model="editedProduct.product_categories"
                          :items="categories"
                          label="Categories"
                          multiple
                          chips
                          return-object
                          item-text="name"
                        ></v-select>
                      </v-col>

                      <v-col cols="12">
                        <v-file-input
                          :disabled="isProcessing"
                          :rules="rules.maximumSize"
                          :error-messages="serverValidationErrors.image"
                          v-model="imageName"
                          persistent-hint
                          show-size
                          accept="image/*"
                          label="Image"
                          @change="imageUpload"
                        >
                        </v-file-input>
                      </v-col>

                      <v-col
                        cols="12"
                        class="d-flex justify-center align-center"
                        v-if="!!editedProduct.image"
                      >
                        <v-img
                          width="150"
                          :src="editedProduct.image"
                          aspect-ratio="1"
                          class="grey lighten-2"
                        >
                          <template v-slot:placeholder>
                            <v-row
                              class="fill-height ma-0"
                              align="center"
                              justify="center"
                            >
                              <v-progress-circular
                                indeterminate
                                color="primary"
                              ></v-progress-circular>
                            </v-row>
                          </template>
                        </v-img>
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
                Are you sure you want to delete this product?
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

      <!-- Product Image -->
      <template v-slot:item.image="{ item }">
        <v-img
          width="75"
          :src="item.image"
          aspect-ratio="1"
          class="grey lighten-2"
        >
          <template v-slot:placeholder>
            <v-row class="fill-height ma-0" align="center" justify="center">
              <v-progress-circular
                indeterminate
                color="primary"
              ></v-progress-circular>
            </v-row>
          </template>
        </v-img>
      </template>

      <!-- Product Price -->
      <template v-slot:item.price="{ item }"> Php {{ item.price }} </template>

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
      rules: {
        required: [(v) => !!v || "Field is required"],
        maximumSize: [
          (v) =>
            !v || v.size < 2000000 || "Photo size should be less than 2 MB!",
        ],
      },
      valid: false,
      imageName: null,
      imageData: null,
      isProcessing: false,
      isRetrievingProducts: false,
      dialog: false,
      dialogDelete: false,
      search: "",
      headers: [
        { text: "ID", value: "id" },
        { text: "Image", value: "image" },
        { text: "Name", value: "name" },
        { text: "Description", value: "description", width: "50%" },
        { text: "Price", value: "price" },
        { text: "Actions", value: "actions", sortable: false, align: "center" },
      ],
      editedIndex: -1,
      editedProduct: {
        id: null,
        image: null,
        name: null,
        description: null,
        price: 0,
        product_categories: [],
      },
      defaultProduct: {
        id: null,
        image: null,
        name: null,
        description: null,
        price: 0,
        product_categories: [],
      },
      products: [],
      categories: [],
      serverValidationErrors: {
        name: null,
        description: null,
        price: null,
        image: null,
        product_categories: null,
      },
    };
  },
  computed: {
    formTitle() {
      return this.editedIndex === -1 ? "New Product" : "Edit Product";
    },
    selectedCategoryIds() {
      return this.editedProduct.product_categories.map((x) => {
        return x.id;
      });
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
    this.retrieveProducts();
  },
  methods: {
    retrieveProducts() {
      this.isRetrievingProducts = true;

      axios
        .get("/api/v1/products")
        .then((response) => {
          this.products = response.data;
        })
        .catch((error) => {
          this.snackbar = {
            visible: true,
            color: "error",
            message:
              "Something went wrong while retrieving products. Please try again.",
          };
        })
        .finally((_) => {
          this.isRetrievingProducts = false;
        });
    },

    retrieveProductCategories() {
      axios
        .get("/api/v1/productCategories")
        .then((response) => {
          let data = response.data;
          this.categories.push(...data);
        })
        .catch((error) => {
          this.snackbar = {
            visible: true,
            color: "error",
            message:
              "Something went wrong while retrieving product categories. Please try again.",
          };
        })
        .finally((_) => {});
    },

    editItem(item) {
      this.editedIndex = this.products.indexOf(item);
      this.editedProduct = Object.assign({}, item);
      this.dialog = true;
    },

    deleteItem(item) {
      this.editedIndex = this.products.indexOf(item);
      this.editedProduct = Object.assign({}, item);
      this.dialogDelete = true;
    },

    deleteItemConfirm() {
      axios
        .delete("/api/v1/products/" + this.editedProduct.id)
        .then((response) => {
          this.products.splice(this.editedIndex, 1);
          this.closeDelete();
        })
        .catch((error) => {
          this.snackbar = {
            visible: true,
            color: "error",
            message:
              "Something went wrong while deleting product. Please try again.",
          };
        })
        .finally((_) => {});
    },

    close() {
      this.dialog = false;
      this.serverValidationErrors = {
        name: null,
        description: null,
        price: null,
        image: null,
        product_categories: null,
      };
      this.$nextTick(() => {
        this.editedProduct = Object.assign({}, this.defaultProduct);
        this.editedIndex = -1;
      });
    },

    closeDelete() {
      this.dialogDelete = false;
      this.$nextTick(() => {
        this.editedProduct = Object.assign({}, this.defaultProduct);
        this.editedIndex = -1;
      });
    },

    save() {
      if (this.$refs.form.validate()) {
        this.isProcessing = true;
        if (this.editedIndex > -1) {
          // Update
          axios
            .put("/api/v1/products/" + this.editedProduct.id, {
              ...this.editedProduct,
              product_categories: this.selectedCategoryIds,
              image: this.imageData,
            })
            .then((response) => {
              let data = response.data;

              // Update product
              Object.assign(this.products[this.editedIndex], data);

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
            .post("/api/v1/products", {
              ...this.editedProduct,
              product_categories: this.selectedCategoryIds,
              image: this.imageData,
            })
            .then((response) => {
              let data = response.data;

              // Add new product
              this.products.push(data);

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

    imageUpload() {
      try {
        let reader = new FileReader();
        reader.onload = () => {
          this.imageData = reader.result;
        };
        reader.readAsDataURL(this.imageName);
      } catch (error) {
        this.imageName = null;
        this.imageData = null;
      }
    },
  },
};
</script>
