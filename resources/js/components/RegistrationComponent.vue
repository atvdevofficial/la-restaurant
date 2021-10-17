<template>
  <v-container fluid fill-height>
    <v-row justify="center" align="center" class="100vh" no-gutters>
      <v-col cols="10" sm="8" md="6" lg="4" xl="2">
        <v-form ref="form" v-model="valid">
          <v-card>
            <v-card-title class="justify-center">
              La Restaurant Account Creation</v-card-title
            >

            <v-card-text>
              <v-row justify="center" v-if="accountCreationStatus == false">
                <v-col cols="12">
                  <v-form ref="form" v-model="valid" lazy-validation>
                    <v-row no-gutters>
                      <v-col cols="12">
                        <div>
                          <v-text-field
                            dense
                            outlined
                            v-model="customerInformation.email"
                            placeholder="Email"
                            :rules="[
                              (v) => !!v || 'E-mail is required',
                              (v) =>
                                /.+@.+\..+/.test(v) || 'E-mail must be valid',
                            ]"
                            :error-messages="serverValidationErrors.email"
                          ></v-text-field>
                        </div>
                      </v-col>
                      <v-col cols="12">
                        <div>
                          <v-text-field
                            dense
                            outlined
                            v-model="customerInformation.password"
                            :rules="[(v) => !!v || 'Password is required']"
                            :error-messages="serverValidationErrors.password"
                            placeholder="Password"
                            type="password"
                          ></v-text-field>
                        </div>
                      </v-col>
                      <v-col cols="12 mb-6">
                        <v-divider></v-divider>
                      </v-col>
                      <v-col cols="12">
                        <div>
                          <v-text-field
                            dense
                            outlined
                            v-model="customerInformation.firstName"
                            placeholder="First Name"
                            :rules="[(v) => !!v || 'First Name is required']"
                            :error-messages="serverValidationErrors.first_name"
                          ></v-text-field>
                        </div>
                      </v-col>
                      <v-col cols="12">
                        <div>
                          <v-text-field
                            dense
                            outlined
                            v-model="customerInformation.lastName"
                            placeholder="Last Name"
                            :rules="[(v) => !!v || 'Last Name is required']"
                            :error-messages="serverValidationErrors.last_name"
                          ></v-text-field>
                        </div>
                      </v-col>
                      <v-col cols="12">
                        <div>
                          <v-text-field
                            dense
                            outlined
                            v-model="customerInformation.contactNumber"
                            placeholder="Contact Number"
                            :rules="[
                              (v) => !!v || 'Contact Number is required',
                            ]"
                            :error-messages="
                              serverValidationErrors.contact_number
                            "
                          ></v-text-field>
                        </div>
                      </v-col>
                      <v-col cols="12">
                        <div>
                          <v-textarea
                            dense
                            outlined
                            v-model="customerInformation.address"
                            placeholder="Address"
                            rows="1"
                            auto-grow
                            :rules="[(v) => !!v || 'Address is required']"
                            :error-messages="serverValidationErrors.address"
                          >
                            <template v-slot:append-outer>
                              <v-dialog v-model="dialogMap" width="500">
                                <template v-slot:activator="{ on, attrs }">
                                  <v-icon v-bind="attrs" v-on="on"
                                    >mdi-earth</v-icon
                                  >
                                </template>

                                <v-card>
                                  <v-card-title></v-card-title>

                                  <v-card-text>
                                    <GmapMap
                                      style="width: 100%; height: 400px"
                                      :zoom="15"
                                      :center="centerCoordinates"
                                    >
                                      <GmapMarker
                                        @dragend="mapMarkerDragEnd"
                                        :draggable="true"
                                        :position="positionCoordinates"
                                      />
                                    </GmapMap>
                                  </v-card-text>

                                  <v-divider></v-divider>

                                  <v-card-actions>
                                    <v-btn
                                      color="primary"
                                      text
                                      @click="getUserGeolocation"
                                    >
                                      Use Current Location
                                    </v-btn>
                                    <v-spacer></v-spacer>
                                    <v-btn
                                      color="default"
                                      text
                                      @click="dialogMap = false"
                                    >
                                      Close
                                    </v-btn>
                                  </v-card-actions>
                                </v-card>
                              </v-dialog>
                            </template>
                          </v-textarea>
                        </div>
                      </v-col>
                      <v-col cols="12">
                        <v-btn
                          block
                          color="primary"
                          @click="register"
                          class="mt-2"
                          :loading="isRegisteringAccount"
                        >
                          Create Account
                        </v-btn>
                        <v-btn
                          small
                          block
                          depressed
                          color="default"
                          @click="goToSignInPage"
                          class="mt-2"
                        >
                          Back To Sign In Page
                        </v-btn>
                      </v-col>
                    </v-row>
                  </v-form>
                </v-col>
              </v-row>
              <v-row justify="center" v-if="accountCreationStatus == true">
                <v-col cols="12" class="text-center">
                  Account Created Successfuly.
                </v-col>
                <v-col cols="12">
                  <v-btn
                    block
                    color="primary"
                    @click="goToSignInPage"
                    class="mt-2"
                  >
                    Go to Sign In Page
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
      isRegisteringAccount: false,
      accountCreationStatus: false,
      valid: true,

      customerInformation: {
        email: null,
        password: null,
        firstName: null,
        lastName: null,
        contactNumber: null,
        address: null,
      },

      serverValidationErrors: {
        email: null,
        password: null,
        first_name: null,
        last_name: null,
        contact_number: null,
        address: null,
      },

      dialogMap: false,
      centerCoordinates: { lat: 6.9214, lng: 122.079 },
      positionCoordinates: { lat: 6.9214, lng: 122.079 },
    };
  },
  mounted() {
    this.getUserGeolocation();
  },
  methods: {
    goToSignInPage() {
      this.$router.push("signin");
    },

    // Validate
    validate() {
      if (this.$refs.form.validate()) {
        this.register();
      }
    },

    // Update
    register() {
      this.isRegisteringAccount = true;
      axios
        .post("/api/v1/registration", {
          ...this.customerInformation,
          password_confirmation: this.customerInformation.password,

          first_name: this.customerInformation.firstName,
          last_name: this.customerInformation.lastName,
          contact_number: this.customerInformation.contactNumber,

          latitude: this.positionCoordinates.lat,
          longitude: this.positionCoordinates.lng,
        })
        .then((response) => {
          this.resetTextFields();
          this.accountCreationStatus = true;
        })
        .catch((error) => {
          if (error.response.status == 422) {
            this.serverValidationErrors = error.response.data.errors;
          }
        })
        .finally((_) => {
          this.isRegisteringAccount = false;
        });
    },

    // Cancel
    resetTextFields() {
      this.serverValidationErrors = {
        email: null,
        password: null,
        first_name: null,
        last_name: null,
        contact_number: null,
        address: null,
      };

      this.customerInformation = {
        email: null,
        password: null,
        firstName: null,
        lastName: null,
        contactNumber: null,
        address: null,
      };

      this.centerCoordinates = { lat: 6.9214, lng: 122.079 };
      this.positionCoordinates = { lat: 6.9214, lng: 122.079 };
    },

    mapMarkerDragEnd(event) {
      var userGeolocationLatitude = event.latLng.lat();
      var userGeolocationLongitude = event.latLng.lng();
      this.positionCoordinates = {
        lat: userGeolocationLatitude,
        lng: userGeolocationLongitude,
      };

      this.reverseGeocode();
      this.calculateDeliveryFee();
    },

    // Get User Geolocation
    getUserGeolocation() {
      if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(this.setUserGeolocation);
      } else {
        window.clearInterval(window.locationInterval);
        alert("Geolocation is not supported by this browser.");
      }
    },

    // Set User Geolocation
    setUserGeolocation(position) {
      var userGeolocationLatitude = position.coords.latitude;
      var userGeolocationLongitude = position.coords.longitude;
      this.centerCoordinates = {
        lat: userGeolocationLatitude,
        lng: userGeolocationLongitude,
      };
      this.positionCoordinates = this.centerCoordinates;

      this.reverseGeocode();
    },

    reverseGeocode() {
      axios
        .get("/api/v1/reverse-geocode", {
          params: {
            latitude: this.positionCoordinates.lat,
            longitude: this.positionCoordinates.lng,
          },
        })
        .then((response) => {
          var data = response.data;
          this.customerInformation.address = data;
        })
        .catch((error) => {
          this.snackbar = {
            visible: true,
            color: "error",
            message:
              "Something went wrong while trying to determine address. Please try again.",
          };
        })
        .finally(() => (this.loading = false));
    },
  },
};
</script>
