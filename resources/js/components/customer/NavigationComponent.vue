<template>
  <div>
    <v-app-bar app clipped-left dark class="elevation-0" color="primary">
      <v-app-bar-nav-icon @click="toggler = !toggler"></v-app-bar-nav-icon>
      <v-toolbar-title>MyRestaurant.com</v-toolbar-title>
      <v-spacer></v-spacer>
      <v-btn icon><v-icon>mdi-bell</v-icon></v-btn>
    </v-app-bar>

    <v-navigation-drawer v-model="toggler" app clipped>
      <v-list>
        <v-subheader>Categories</v-subheader>
        <v-list-item v-for="(category, index) in categories" :key="index">
          <v-list-item-content>
            <v-list-item-title class="pl-4">{{ category.name }}</v-list-item-title>
          </v-list-item-content>
        </v-list-item>
      </v-list>
    </v-navigation-drawer>
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
