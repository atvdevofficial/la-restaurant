<template>
  <v-container class="ma-0 pa-0">
    <v-row justify="center" align="center">
      <v-col cols="12" sm="10" md="8" lg="6" xl="4">
        <v-list class="pa-0">
          <v-list-item
            three-line
            v-for="(notification, index) in notifications"
            :key="index">
            <v-list-item-content>
              <v-list-item-title class="font-weight-bold">
                {{ notification.title }}
              </v-list-item-title>
              <v-list-item-subtitle>
                {{ notification.body }}
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
      notifications: [
          { title: 'Sample Notification', body: 'Sample Notification Body', created_at: '2021-07-16 13:30:30'}
      ],
    };
  },
  mounted() {
    this.retrieveNotifications();
  },
  methods: {
    retrieveNotifications() {},
  },
};
</script>
