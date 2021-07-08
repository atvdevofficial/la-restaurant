<template>
  <v-container class="my-4">
    <v-row justify="space-between" no-gutters>
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
          <v-img height="150" :src="product.image"></v-img>
          <v-card-title class="ma-0 pb-0 font-weight-bold"
            >{{ product.name }}
          </v-card-title>
          <v-card-text class="ma-0 pb-0">
            <div class="">Php {{ product.price }} / Order</div>
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
        <v-img height="200" :src="viewingProduct.image"></v-img>
        <v-card-title class="ma-0 pb-0 font-weight-bold"
          >{{ viewingProduct.name }}
        </v-card-title>
        <v-card-text class="">
          <div class="">Php {{ viewingProduct.price }} / Order</div>
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
export default {
  data() {
    return {
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
        image: null,
        name: null,
        description: null,
        price: null,
      },
      products: [
        {
          id: 1,
          image:
            "https://www.tasteofhome.com/wp-content/uploads/2020/03/Smash-Burgers_EXPS_TOHcom20_246232_B10_06_10b.jpg",
          name: "Burger",
          description: "The Delicious Burger",
          price: 100,
        },
        {
          id: 2,
          image:
            "https://www.sprinklesandsprouts.com/wp-content/uploads/2021/05/Peri-Peri-Fries-SQ.jpg",
          name: "Fries",
          description: "The Delicious Fries",
          price: 100,
        },
        {
          id: 3,
          image:
            "https://www.lanascooking.com/wp-content/uploads/2012/06/coke-floats-feature.jpg",
          name: "Coke Float",
          description: "The Delicious Coke Float",
          price: 100,
        },
        {
          id: 4,
          image:
            "https://a7m3f5i5.rocketcdn.me/wp-content/uploads/2015/09/moms-spaghetti-sauce-recipe-a-healthy-slice-of-life-6-of-6-800x600.jpg",
          name: "Spaghetti",
          description: "The Delicious Spaghetti",
          price: 100,
        },
      ],
    };
  },
  methods: {
    viewInformation(product) {
      this.viewingProduct = Object.assign({}, product);
      this.dialogInformation = true;
    },

    addToCart(product) {
      this.viewingProduct = Object.assign({}, product);
      this.dialogInformation = false;
      this.snackbar = true;
    },
  },
};
</script>
