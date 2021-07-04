<template>
  <v-app id="inspire">
    <v-app-bar app clipped-left dark class="elevation-0" color="primary">
      <v-app-bar-nav-icon @click="drawer = !drawer"></v-app-bar-nav-icon>
      <v-toolbar-title>MyRestaurant.com</v-toolbar-title>
      <v-spacer></v-spacer>
      <v-btn icon><v-icon>mdi-bell</v-icon></v-btn>
    </v-app-bar>

    <v-navigation-drawer v-model="drawer" app clipped>
      <v-list>
        <v-list-item-group v-model="selectedDrawerItem" color="primary">
          <v-list-item v-for="(item, index) in drawerTopList" :key="index" :to="item.linkTo">
            <v-list-item-icon>
              <v-icon v-text="item.icon"></v-icon>
            </v-list-item-icon>
            <v-list-item-content>
              <v-list-item-title v-text="item.text"></v-list-item-title>
            </v-list-item-content>
          </v-list-item>
        </v-list-item-group>
      </v-list>

      <template v-slot:append>
        <v-list>
          <v-list-item-group color="primary">
            <v-list-item v-for="(item, index) in drawerBottomList" :key="index">
              <v-list-item-icon>
                <v-icon v-text="item.icon"></v-icon>
              </v-list-item-icon>
              <v-list-item-content>
                <v-list-item-title v-text="item.text"></v-list-item-title>
              </v-list-item-content>
            </v-list-item>
          </v-list-item-group>
        </v-list>
      </template>
    </v-navigation-drawer>

    <v-main class="px-4 py-0">
      <router-view></router-view>
    </v-main>
  </v-app>
</template>

<script>
export default {
  data() {
    return {
      drawer: true,
      selectedDrawerItem: null,
      drawerTopList: [
        { icon: "mdi-view-dashboard", text: "Dashboard", linkTo: '/dashboard' },
        { icon: "mdi-format-list-bulleted", text: "Orders", linkTo: '/orders' },
        { icon: "mdi-food", text: "Products", linkTo: '/products' },
        { icon: "mdi-account-group", text: "Customers", linkTo: '/customers' },
      ],
      drawerBottomList: [
        { icon: "mdi-logout-variant", text: "Sign out", linkTo: '/signout' },
      ],
    };
  },
};
</script>
