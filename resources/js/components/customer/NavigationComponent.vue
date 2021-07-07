<template>
  <div>
    <v-app-bar app clipped-left dark class="elevation-0" color="primary">
      <v-toolbar-title>MyRestaurant.com</v-toolbar-title>
      <v-spacer></v-spacer>
      <v-btn icon to="/c/checkout"><v-icon>mdi-cart</v-icon></v-btn>
      <v-btn icon><v-icon>mdi-bell</v-icon></v-btn>
      <v-menu bottom left min-width="150">
        <template v-slot:activator="{ on, attrs }">
          <v-btn dark icon v-bind="attrs" v-on="on">
            <v-icon>mdi-dots-vertical</v-icon>
          </v-btn>
        </template>

        <v-list>
          <v-list-item to="/c/profile">
            <v-list-item-icon>
              <v-icon>mdi-account-circle</v-icon>
            </v-list-item-icon>
            <v-list-item-title>Profile</v-list-item-title>
          </v-list-item>
          <v-list-item to="/c/orders">
            <v-list-item-icon>
              <v-icon>mdi-format-list-bulleted</v-icon>
            </v-list-item-icon>
            <v-list-item-title>Orders</v-list-item-title>
          </v-list-item>
          <v-divider></v-divider>
          <v-list-item>
            <v-list-item-icon>
              <v-icon>mdi-logout-variant</v-icon>
            </v-list-item-icon>
            <v-list-item-title>Sign out</v-list-item-title>
          </v-list-item>
        </v-list>
      </v-menu>
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
  methods: {
    navMenuClicked(menuId) {
      console.log(menuId);
    },
  },
};
</script>
