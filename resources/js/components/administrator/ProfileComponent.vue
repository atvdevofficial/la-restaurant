<template>
  <v-container>
    <v-row justify="center">
      <v-col
        cols="12"
        sm="10"
        md="8"
        lg="6"
        xl="4"
        class="my-4"
        v-if="isRetrievingProfile == true"
      >
        <div class="caption mb-2">Retrieving profile, please wait ...</div>
        <v-progress-linear height="5" indeterminate></v-progress-linear>
      </v-col>
    </v-row>
    <v-row justify="center">
      <v-col cols="12" sm="10" md="8" lg="6" xl="4">
        <v-form ref="form" v-model="valid" lazy-validation>
          <v-row no-gutters>
            <v-col cols="12">
              <div>
                <v-text-field
                  disabled
                  v-model="customerInformation.email"
                  label="Email"
                  :rules="emailRules"
                  :error-messages="serverValidationErrors.email"
                ></v-text-field>
              </div>
            </v-col>
            <v-col cols="12">
              <div>
                <v-text-field
                  v-model="customerInformation.password"
                  label="Password"
                  type="password"
                  :error-messages="serverValidationErrors.first_name"
                  :rules="[(v) => !!v || 'Password is required']"
                ></v-text-field>
              </div>
            </v-col>
            <v-col cols="12">
              <v-btn
                block
                color="primary"
                @click="updatePassword"
                class="mt-2"
                :disabled="isRetrievingProfile"
                :loading="!isNotEditing"
              >
                Update Password
              </v-btn>
            </v-col>
          </v-row>
        </v-form>
      </v-col>
    </v-row>

    <v-snackbar color="primary" v-model="snackbar.visible" timeout="2000">
      {{ snackbar.message }}
    </v-snackbar>
  </v-container>
</template>

<script>
export default {
  data() {
    return {
      isRetrievingProfile: false,
      isNotEditing: true,
      valid: true,

      emailRules: [
        (v) => !!v || "E-mail is required",
        (v) => /.+@.+\..+/.test(v) || "E-mail must be valid",
      ],

      customerInformation: {
        email: null,
        password: null,
      },

      serverValidationErrors: {
        email: null,
        password: null,
      },

      snackbar: {
        visible: false,
        message: "",
      },
    };
  },
  mounted() {
    this.retrieveProfile();
  },
  methods: {
    // Validate
    validate() {
      if (this.$refs.form.validate()) {
        this.update();
      }
    },

    // Edit
    updatePassword() {
      this.isNotEditing = false;

      axios
        .put("/api/v1/user/change/password", {
          password: this.customerInformation.password,
        })
        .then((response) => {
          this.snackbar = {
              visible: true, message: 'Password Updated'
          }
        })
        .catch((error) => {
          console.log(error.response.data);
        })
        .finally((_) => {
          this.isNotEditing = true;
        });
    },

    // Show
    retrieveProfile() {
      this.isRetrievingProfile = true;
      axios
        .get("/api/v1/user")
        .then((response) => {
          var data = response.data;
          this.customerInformation = data;
        })
        .catch((error) => {
          console.log(error.response.data);
        })
        .finally((_) => {
          this.isRetrievingProfile = false;
        });
    },
  },
};
</script>
