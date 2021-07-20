<template>
  <v-app id="inspire">
    <administrator-navigation
      v-if="userRole == 'ADMINISTRATOR'"
    ></administrator-navigation>

    <customer-navigation v-if="userRole == 'CUSTOMER'"></customer-navigation>

    <v-main class="px-4 py-0">
      <router-view></router-view>
    </v-main>

    <v-snackbar
      color="primary"
      v-model="showSnackbar"
      timeout="3000"
      absolute
      top
      right
    >
      <div class="font-weight-bold">{{ snackbar.title }}</div>
      <div>{{ snackbar.body }}</div>
    </v-snackbar>
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
      showSnackbar: false,
      snackbar: {
        title: null,
        body: null,
      },
    };
  },
  computed: {
    userRole() {
      return sessionStorage.getItem("userRole") ?? "GUEST";
    },
  },
  mounted() {
    Echo.private("App.User." + sessionStorage.getItem("userId")).notification(
      (notification) => {
        console.log(notification);

        this.snackbar.title = notification.title;
        this.snackbar.body = notification.body;

        this.showSnackbar = true;
      }
    );
  },
};
</script>
