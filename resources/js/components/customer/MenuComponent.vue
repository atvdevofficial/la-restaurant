<template>
  <v-container fluid class="my-4">
    <v-row>
      <v-col v-for="(product, index) in products" :key="index" cols="6" sm="4" lg="3">
        <v-card :loading="loading" max-width="374">
          <template slot="progress">
            <v-progress-linear
              color="deep-purple"
              height="10"
              indeterminate
            ></v-progress-linear>
          </template>
          <v-img height="150" :src="product.image"></v-img>
          <v-card-title class="ma-0 pb-0 font-weight-bold">{{
            product.name
          }}</v-card-title>
          <v-card-text class="ma-0 pb-0">
            <div class="">Php {{ product.price }} / Order</div>
            <div class="mt-2">{{ product.description }}</div>
          </v-card-text>

          <v-card-actions>
            <v-btn block color="primary" @click="reserve"> Add to Cart </v-btn>
          </v-card-actions>
        </v-card>
      </v-col>
    </v-row>
  </v-container>
</template>
<script>
export default {
  data() {
    return {
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
      ],
    };
  },
};
</script>
