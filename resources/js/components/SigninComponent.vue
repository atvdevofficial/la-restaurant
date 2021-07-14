<template>
  <v-container fluid fill-height>
    <v-row justify="center" align="center" class="100vh" no-gutters>
      <v-col cols="10" sm="8" md="6" lg="4" xl="2">
        <v-form ref="form" v-model="valid">
          <v-card>
            <v-card-title class="justify-center">
              MyRestaurant.com
            </v-card-title>

            <v-card-text>
              <v-row no-gutters>
                <v-col cols="12">
                  <div>Email</div>
                  <div>
                    <v-text-field
                      v-model="email"
                      dense
                      outlined
                      type="email"
                      :rules="emailRules"
                    ></v-text-field>
                  </div>
                </v-col>

                <v-col cols="12">
                  <div>Password</div>
                  <div>
                    <v-text-field
                      v-model="password"
                      dense
                      outlined
                      type="password"
                      :rules="[(v) => !!v || 'Password is required']"
                    ></v-text-field></div
                ></v-col>

                <v-col
                  cols="12"
                  v-if="errorMessage != ''"
                  class="text-center red--text"
                >
                  {{ errorMessage }} !
                </v-col>

                <v-col cols="12">
                  <v-btn
                    block
                    color="primary"
                    @click="validate"
                    :loading="isSigningIn"
                  >
                    Sign in
                  </v-btn>
                </v-col>
              </v-row>
            </v-card-text>
          </v-card>
        </v-form>
      </v-col>
    </v-row>
  </v-container>
</template>

<script>
export default {
  data() {
    return {
      isSigningIn: false,
      valid: false,
      errorMessage: "",
      email: "customer@mr.com",
      emailRules: [
        (v) => !!v || "E-mail is required",
        (v) => /.+@.+\..+/.test(v) || "E-mail must be valid",
      ],
      password: "password",
    };
  },
  methods: {
    validate() {
      if (this.$refs.form.validate()) this.signin();
    },

    signin() {
      this.isSigningIn = true;

      axios
        .post("/api/v1/login", { email: this.email, password: this.password })
        .then((response) => {
          let authToken = response.data.authToken;
          let userRole = response.data.userRole;

          // Set session storage items
          sessionStorage.setItem("authToken", authToken);
          sessionStorage.setItem("userRole", userRole);

          // Pusher authToken
          // Echo.connector.pusher.config.auth.headers["Authorization"] = "Bearer " + authToken;

          // Push to dashboard
          this.$router.push("dashboard");
        })
        .catch((error) => {
            this.errorMessage = error.response.data;
        })
        .finally((fin) => {
          this.isSigningIn = false;
        });
    },
  },
};
</script>
