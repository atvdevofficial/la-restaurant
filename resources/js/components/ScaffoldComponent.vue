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
        <!-- Dashboard -->
        <v-list-item to="/dashboard">
          <v-list-item-icon>
            <v-icon>mdi-view-dashboard</v-icon>
          </v-list-item-icon>
          <v-list-item-content>
            <v-list-item-title>Dashboard</v-list-item-title>
          </v-list-item-content>
        </v-list-item>

        <!-- Orders -->
        <v-list-item to="/orders">
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

          <v-list-item to="/products">
            <v-list-item-icon>
              <v-icon>mdi-format-list-bulleted</v-icon>
            </v-list-item-icon>
            <v-list-item-content>
              <v-list-item-title>List</v-list-item-title>
            </v-list-item-content>
          </v-list-item>

          <v-list-item to="/productCategories">
            <v-list-item-icon>
              <v-icon>mdi-group</v-icon>
            </v-list-item-icon>
            <v-list-item-content>
              <v-list-item-title>Categories</v-list-item-title>
            </v-list-item-content>
          </v-list-item>
        </v-list-group>
      </v-list>

      <!-- Customers -->
        <v-list-item to="/customers">
          <v-list-item-icon>
            <v-icon>mdi-account-group</v-icon>
          </v-list-item-icon>
          <v-list-item-content>
            <v-list-item-title>Customers</v-list-item-title>
          </v-list-item-content>
        </v-list-item>

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
        {
          group: false,
          icon: "mdi-view-dashboard",
          text: "Dashboard",
          linkTo: "/dashboard",
        },
        {
          group: false,
          icon: "mdi-format-list-bulleted",
          text: "Orders",
          linkTo: "/orders",
        },
        {
          group: true,
          icon: "mdi-food",
          text: "Products",
          children: [
            {
              group: false,
              icon: "mdi-format-list-bulleted",
              text: "List",
              linkTo: "/products",
            },
            {
              group: false,
              icon: "mdi-group",
              text: "Categories",
              linkTo: "/categories",
            },
          ],
        },
        {
          group: false,
          icon: "mdi-account-group",
          text: "Customers",
          linkTo: "/customers",
        },
      ],
      drawerBottomList: [
        { icon: "mdi-logout-variant", text: "Sign out", linkTo: "/signout" },
      ],
    };
  },
};
</script>
