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
      <v-col cols="12" sm="10" md="8" lg="6" xl="4">
        <v-form ref="form" v-model="valid" lazy-validation>
          <v-row no-gutters>
            <v-col cols="12">
              <div>
                <v-text-field
                  :disabled="isNotEditing"
                  v-model="customerInformation.email"
                  label="Email"
                  :rules="emailRules"
                ></v-text-field>
              </div>
            </v-col>
            <v-col cols="12">
              <div>
                <v-text-field
                  :disabled="isNotEditing"
                  v-model="customerInformation.firstName"
                  label="First Name"
                  :rules="[(v) => !!v || 'Field is required']"
                ></v-text-field>
              </div>
            </v-col>
            <v-col cols="12">
              <div>
                <v-text-field
                  :disabled="isNotEditing"
                  v-model="customerInformation.lastName"
                  label="Last Name"
                  :rules="[(v) => !!v || 'Field is required']"
                ></v-text-field>
              </div>
            </v-col>
            <v-col cols="12">
              <div>
                <v-text-field
                  :disabled="isNotEditing"
                  v-model="customerInformation.contactNumber"
                  label="Contact Number"
                  :rules="[(v) => !!v || 'Field is required']"
                ></v-text-field>
              </div>
            </v-col>
            <v-col cols="12">
              <div>
                <v-textarea
                  :disabled="isNotEditing"
                  v-model="customerInformation.address"
                  label="Address"
                  rows="1"
                  auto-grow
                  :rules="[(v) => !!v || 'Field is required']"
                ></v-textarea>
              </div>
            </v-col>
            <v-col cols="12">
              <v-btn
                block
                color="primary"
                @click="updateProfile"
                v-if="isNotEditing == true"
                class="mt-2"
                :disabled="isRetrievingProfile"
              >
                Update Information
              </v-btn>
              <v-btn
                block
                color="primary"
                @click="validate"
                v-if="isNotEditing == false"
                class="mt-2"
              >
                Save
              </v-btn>
              <v-btn
                block
                depressed
                color="default"
                @click="cancelEditing"
                v-if="isNotEditing == false"
                class="mt-2"
              >
                Cancel
              </v-btn>
            </v-col>
          </v-row>
        </v-form>
      </v-col>
    </v-row>
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
        firstName: null,
        lastName: null,
        contactNumber: null,
        address: null,
        latitude: null,
        longitude: null,
        email: null,
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
        this.isNotEditing = true;
        this.update();
      }
    },

    // Update
    update() {
      let profileId = sessionStorage.getItem("profileId");

      axios
        .put("/api/v1/customers/" + profileId, {
          ...this.customerInformation,
          first_name: this.customerInformation.firstName,
          last_name: this.customerInformation.lastName,
          contact_number: this.customerInformation.contactNumber,
        })
        .then((response) => {
          let data = response.data;

          this.customerInformation = {
            email: data.user.email,
            firstName: data.first_name,
            lastName: data.last_name,
            contactNumber: data.contact_number,
            address: data.address,
            latitude: data.latitude,
            longitude: data.longitude,
          };
        })
        .catch((error) => {
          console.log(error);
        })
        .catch((fin) => {
          console.log(fin);
        });
    },

    // Edit
    updateProfile() {
      this.isNotEditing = false;
    },

    // Cancel
    cancelEditing() {
      this.isNotEditing = true;
      this.retrieveProfile();
    },

    // Show
    retrieveProfile() {
      this.isRetrievingProfile = true;
      let profileId = sessionStorage.getItem("profileId");
      axios
        .get("/api/v1/customers/" + profileId)
        .then((response) => {
          let data = response.data;

          this.customerInformation = {
            email: data.user.email,
            firstName: data.first_name,
            lastName: data.last_name,
            contactNumber: data.contact_number,
            address: data.address,
            latitude: data.latitude,
            longitude: data.longitude,
          };
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
