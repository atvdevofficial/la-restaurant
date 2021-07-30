<template>
  <v-container class="ma-0 pa-0">
    <v-row justify="center" align="center">
      <v-col cols="12" class="my-4" v-if="isRetrievingNotifications == true">
        <div class="caption mb-2">
          Retrieving notifications, please wait ...
        </div>
        <v-progress-linear height="5" indeterminate></v-progress-linear>
      </v-col>

      <v-col
        cols="12"
        sm="10"
        md="8"
        lg="6"
        class="my-4"
        v-if="isRetrievingNotifications == false && notifications.length == 0"
      >
        You currently do not have any notifications.
      </v-col>

      <v-col cols="12" sm="10" md="8" lg="6">
        <v-list class="pa-0">
          <v-list-item
            two-line
            v-for="(notification, index) in notifications"
            :key="index"
            @click="viewOrder(notification.data.data.code)"
          >
            <v-list-item-content>
              <v-list-item-title class="font-weight-bold">
                {{ notification.data.title }} ({{
                  notification.data.data.code
                }})
              </v-list-item-title>
              <v-list-item-subtitle>
                {{ notification.data.body }}
              </v-list-item-subtitle>

            </v-list-item-content>

            <v-list-item-action>
              {{ notification.created_at }}
            </v-list-item-action>
          </v-list-item>
        </v-list>
      </v-col>
    </v-row>
  </v-container>
</template>

<script>
export default {
  data() {
    return {
      isRetrievingNotifications: false,
      notifications: [],
    };
  },
  mounted() {
    this.retrieveNotifications();
  },
  methods: {
    retrieveNotifications() {
      this.isRetrievingNotifications = true;
      axios
        .get("/api/v1/notifications")
        .then((response) => {
          let data = response.data;
          this.notifications = data;
        })
        .catch((error) => {
          console.log(error);
        })
        .then((_) => {
          this.isRetrievingNotifications = false;
        });
    },

    viewOrder(code) {
      let userRole = sessionStorage.getItem("userRole");
      if (userRole == "ADMINISTRATOR")
        this.$router.push({ name: "orders", params: { code } });
      else if (userRole == "CUSTOMER")
        this.$router.push({ name: "customerOrders", params: { code } });
    },
  },
};
</script>
