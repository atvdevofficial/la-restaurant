<template>
  <v-container class="ma-0 pa-0">
    <v-row justify="center" align="center">
      <v-col cols="12" sm="10" md="8" lg="6" xl="4">
        <v-list class="pa-0">
          <v-list-item
            three-line
            v-for="(notification, index) in notifications"
            :key="index"
          >
            <v-list-item-content>
              <v-list-item-title class="font-weight-bold">
                {{ notification.data.title }}
              </v-list-item-title>
              <v-list-item-subtitle>
                {{ notification.data.body }}
              </v-list-item-subtitle>
              <v-list-item-subtitle class="font-italic mt-2">
                {{ notification.created_at }}
              </v-list-item-subtitle>
            </v-list-item-content>
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
      notifications: [],
    };
  },
  mounted() {
    this.retrieveNotifications();
  },
  methods: {
    retrieveNotifications() {
      axios
        .get("/api/v1/notifications")
        .then((response) => {
          let data = response.data;
          this.notifications = data;
        })
        .catch((error) => {
          console.log(error);
        })
        .then((_) => {});
    },
  },
};
</script>
