<template>
  <v-container fluid>
    <v-form ref="form" v-model="valid" lazy-validation>
      <v-row no-gutters>
        <v-col cols="12">
          <div>
            <v-text-field
              :disabled="isNotEditing"
              v-model="email"
              label="Email"
              :rules="emailRules"
            ></v-text-field>
          </div>
        </v-col>
        <v-col cols="12">
          <div>
            <v-text-field
              :disabled="isNotEditing"
              v-model="firstName"
              label="First Name"
              :rules="[(v) => !!v || 'Field is required']"
            ></v-text-field>
          </div>
        </v-col>
        <v-col cols="12">
          <div>
            <v-text-field
              :disabled="isNotEditing"
              v-model="lastName"
              label="Last Name"
              :rules="[(v) => !!v || 'Field is required']"
            ></v-text-field>
          </div>
        </v-col>
        <v-col cols="12">
          <div>
            <v-text-field
              :disabled="isNotEditing"
              v-model="contactNumber"
              label="Contact Number"
              :rules="[(v) => !!v || 'Field is required']"
            ></v-text-field>
          </div>
        </v-col>
        <v-col cols="12">
          <div>
            <v-textarea
              :disabled="isNotEditing"
              v-model="address"
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
  </v-container>
</template>

<script>
export default {
  data() {
    return {
      isNotEditing: true,
      valid: true,

      email: "anthonvillaflor@gmail.com",
      emailRules: [
        (v) => !!v || "E-mail is required",
        (v) => /.+@.+\..+/.test(v) || "E-mail must be valid",
      ],
      firstName: "John",
      lastName: "Doe",
      contactNumber: "09051406999",
      address: "Mapple Drive, Honey Street, Bee Colony",
    };
  },
  methods: {
    validate() {
      if (this.$refs.form.validate()) {
        // Axios
        this.isNotEditing = true;
      }
    },
    updateProfile() {
        this.isNotEditing = false;
    },
    cancelEditing() {
        this.isNotEditing = true;
        // Revert to original information
    }
  },
};
</script>
