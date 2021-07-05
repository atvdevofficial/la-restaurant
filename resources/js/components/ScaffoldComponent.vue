<template>
  <v-app id="inspire">
    <administrator-navigation
      v-if="role == 'ADMINISTRATOR'"
    ></administrator-navigation>

    <customer-navigation
      v-if="role == 'CUSTOMER'"
    ></customer-navigation>

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
  data() {
    return {
      role: "CUSTOMER",
    };
  },
};
</script>
