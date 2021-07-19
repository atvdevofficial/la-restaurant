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
        <!-- Dashboard -->
        <v-list-item to="/a/dashboard">
          <v-list-item-icon>
            <v-icon>mdi-view-dashboard</v-icon>
          </v-list-item-icon>
          <v-list-item-content>
            <v-list-item-title>Dashboard</v-list-item-title>
          </v-list-item-content>
        </v-list-item>

        <!-- Orders -->
        <v-list-item to="/a/orders">
          <v-list-item-icon>
            <v-icon>mdi-format-list-bulleted</v-icon>
          </v-list-item-icon>
          <v-list-item-content>
            <v-list-item-title>Orders</v-list-item-title>
          </v-list-item-content>
        </v-list-item>

        <!-- Product Group -->
        <v-list-group no-action prepend-icon="mdi-food">
          <template v-slot:activator>
            <v-list-item-title>Products</v-list-item-title>
          </template>

          <v-list-item to="/a/products">
            <v-list-item-icon>
              <v-icon>mdi-format-list-bulleted</v-icon>
            </v-list-item-icon>
            <v-list-item-content>
              <v-list-item-title>List</v-list-item-title>
            </v-list-item-content>
          </v-list-item>

          <v-list-item to="/a/productCategories">
            <v-list-item-icon>
              <v-icon>mdi-group</v-icon>
            </v-list-item-icon>
            <v-list-item-content>
              <v-list-item-title>Categories</v-list-item-title>
            </v-list-item-content>
          </v-list-item>
        </v-list-group>

        <!-- Customers -->
        <v-list-item to="/a/customers">
          <v-list-item-icon>
            <v-icon>mdi-account-group</v-icon>
          </v-list-item-icon>
          <v-list-item-content>
            <v-list-item-title>Customers</v-list-item-title>
          </v-list-item-content>
        </v-list-item>

        <!-- Delivery -->
        <v-list-item to="/a/deliveryFees">
          <v-list-item-icon>
            <v-icon>mdi-map-marker-distance</v-icon>
          </v-list-item-icon>
          <v-list-item-content>
            <v-list-item-title>Delivery Fees</v-list-item-title>
          </v-list-item-content>
        </v-list-item>
      </v-list>

      <template v-slot:append>
        <v-list>
          <v-list-item-group color="primary">
            <v-list-item @click="signout">
              <v-list-item-icon>
                <v-icon>mdi-logout-variant</v-icon>
              </v-list-item-icon>
              <v-list-item-content>
                <v-list-item-title>Sign Out</v-list-item-title>
              </v-list-item-content>
            </v-list-item>
          </v-list-item-group>
        </v-list>
      </template>
    </v-navigation-drawer>
  </div>
</template>

<script>
export default {
  data() {
    return {
      toggler: true,
    };
  },
  methods: {
    signout() {
      // Clear session storage
      sessionStorage.clear();

      // Push to sign in
      this.$router.push("/signin");
    },
  },
};
</script>
