<template>
  <v-container class="my-4">
    <v-row
      justify="center"
      align="center"
      class="100vh"
      no-gutters
      v-if="isRetrievingProducts == true"
    >
      <v-col>
        <div class="caption mb-2">Retrieving products, please wait ...</div>
        <v-progress-linear height="5" indeterminate></v-progress-linear>
      </v-col>
    </v-row>
    <v-row
      justify="space-between"
      no-gutters
      v-if="isRetrievingProducts == false"
    >
      <v-col cols="12" sm="4" lg="3">
        <v-select
          v-model="category"
          :items="categories"
          label="Category"
          dense
          solo
          item-text="name"
        ></v-select>
      </v-col>
      <v-col cols="12" sm="4" lg="3"
        ><v-text-field
          dense
          label="Search"
          append-icon="mdi-magnify"
        ></v-text-field
      ></v-col>
    </v-row>
    <v-row>
      <v-col
        v-for="(product, index) in products"
        :key="index"
        cols="6"
        sm="4"
        md="3"
        lg="2"
        class="d-flex"
        style="flex-direction: column"
      >
        <v-card
          max-width="374"
          class="flex-grow-1"
          height="100%"
          style="position: relative; padding-bottom: 50px"
          @click="viewInformation(product)"
        >
          <template slot="progress">
            <v-progress-linear
              color="deep-purple"
              height="10"
              indeterminate
            ></v-progress-linear>
          </template>
          <v-img height="150" :src="product.image_link"></v-img>
          <v-card-title class="ma-0 pb-0 font-weight-bold"
            >{{ product.name }}
          </v-card-title>
          <v-card-text class="ma-0 pb-0">
            <div class="">
              Php {{ parseFloat(product.price).toFixed(2) }} / Order
            </div>
          </v-card-text>
          <v-card-actions style="position: absolute; bottom: 0; width: 100%">
            <v-btn block color="primary" @click.stop="addToCart(product)">
              Add to Cart
            </v-btn>
          </v-card-actions>
        </v-card>
      </v-col>
    </v-row>

    <v-dialog v-model="dialogInformation" width="500" :retain-focus="false">
      <v-card class="flex-grow-1" height="100%">
        <template slot="progress">
          <v-progress-linear
            color="deep-purple"
            height="10"
            indeterminate
          ></v-progress-linear>
        </template>
        <v-img height="200" :src="viewingProduct.image_link"></v-img>
        <v-card-title class="ma-0 pb-0 font-weight-bold"
          >{{ viewingProduct.name }}
        </v-card-title>
        <v-card-text class="">
          <div class="">
            Php {{ parseFloat(viewingProduct.price).toFixed(2) }} / Order
          </div>
          <div class="mt-2">{{ viewingProduct.description }}</div>
          <div class="mt-4">
            <v-chip small color="primary"> Beef </v-chip>
            <v-chip small color="primary"> Juicy </v-chip>
            <v-chip small color="primary"> Grilled </v-chip>
          </div>
        </v-card-text>

        <v-card-actions>
          <v-btn block color="primary" @click.stop="addToCart(viewingProduct)">
            Add to Cart
          </v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>

    <v-snackbar color="primary" v-model="snackbar" timeout="2000">
      {{ viewingProduct.name }} added to Cart
    </v-snackbar>
  </v-container>
</template>
<script>
import { mapGetters, mapActions } from "vuex";

export default {
  data() {
    return {
      isRetrievingProducts: false,
      category: { id: 0, name: "All" },
      categories: [
        { id: 0, name: "All" },
        { id: 1, name: "Chicken" },
        { id: 2, name: "Beef" },
        { id: 3, name: "Vegan" },
      ],
      snackbar: false,
      dialogInformation: false,
      viewingProduct: {
        id: null,
        image_link: null,
        name: null,
        description: null,
        price: null,
      },
      products: [],
    };
  },
  mounted() {
    this.retrieveProducts();
  },
  methods: {
    ...mapActions(["addCartProduct"]),

    viewInformation(product) {
      this.viewingProduct = Object.assign({}, product);
      this.dialogInformation = true;
    },

    addToCart(product) {
      this.viewingProduct = Object.assign({}, product, { quantity: 1 });
      this.dialogInformation = false;
      this.snackbar = true;

      this.addCartProduct(this.viewingProduct);
    },

    retrieveProducts() {
      this.isRetrievingProducts = true;

      axios
        .get("/api/v1/products")
        .then((response) => {
          this.products = response.data;
        })
        .catch((error) => {
          console.log(error.response.data);
        })
        .finally((fin) => {
          this.isRetrievingProducts = false;
        });
    },
  },
};
</script>
