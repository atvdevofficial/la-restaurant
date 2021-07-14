<template>
    <v-container fluid fill-height>
    <v-row justify="center" align="center" class="100vh" no-gutters>
      <v-col cols="10" sm="8" md="6" lg="4" xl="2">
          <h1>Oops! You are unauthenticated. (401)</h1>
          <p>Please login by clicking the button below.</p>
          <v-btn color="primary" to="/signin">Sign in</v-btn>
      </v-col>
    </v-row>
  </v-container>
</template>

<script>
export default {
    data() {
        return {

        }
    }
}
</script>
