<template>
  <div>
    <v-app-bar app clipped-left dark class="elevation-0" color="primary">
      <v-toolbar-title>MyRestaurant.com</v-toolbar-title>
      <v-spacer></v-spacer>
      <v-btn icon to="/c/checkout"><v-icon>mdi-cart</v-icon></v-btn>
      <v-btn icon><v-icon>mdi-dots-vertical</v-icon></v-btn>
    </v-app-bar>
  </div>
</template>

<script>
export default {
  data() {
    return {
      toggler: true,
      categories: [
        { id: 1, name: "Chicken" },
        { id: 2, name: "Beef" },
        { id: 3, name: "Vegan" },
      ],
    };
  },
};
</script>
