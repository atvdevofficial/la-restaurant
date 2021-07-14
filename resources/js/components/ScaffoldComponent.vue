<template>
  <v-app id="inspire">
    <administrator-navigation
      v-if="userRole == 'ADMINISTRATOR'"
    ></administrator-navigation>

    <customer-navigation v-if="userRole == 'CUSTOMER'"></customer-navigation>

    <v-main class="px-4 py-0">
      <router-view></router-view>
    </v-main>
  </v-app>
</template>

<script>
import AdministratorNavigation from "./administrator/NavigationComponent.vue";
import CustomerNavigation from "./customer/NavigationComponent.vue";

export default {
  components: {
    AdministratorNavigation,
    CustomerNavigation,
  },
  computed: {
    userRole() {
      return sessionStorage.getItem("userRole") ?? "GUEST";
    },
  },
};
</script>
