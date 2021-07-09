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

                <v-col cols="12">
                  <v-btn block color="primary" @click="validate">
                    Sign in</v-btn
                  >
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
      valid: false,
      email: "",
      emailRules: [
        (v) => !!v || "E-mail is required",
        (v) => /.+@.+\..+/.test(v) || "E-mail must be valid",
      ],
      password: "",
    };
  },
  methods: {
    validate() {
      this.$refs.form.validate();
    },
  },
};
</script>
