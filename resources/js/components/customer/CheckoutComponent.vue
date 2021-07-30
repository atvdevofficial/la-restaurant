<template>
  <v-container>
    <v-row>
      <v-col cols="12" v-if="cartItemsCount == 0">
        <p>
          No products inside your cart. Add products now to satisfy your
          cravings.
        </p>
      </v-col>

      <v-col cols="12" md="6" v-if="cartItemsCount > 0">
        <v-card
          v-for="(product, index) in cart"
          :key="index"
          class="mb-2"
          @click="editProduct(product)"
        >
          <v-list-item two-line>
            <v-list-item-content>
              <v-list-item-title>{{ product.name }}</v-list-item-title>
              <v-list-item-subtitle>
                Php {{ parseFloat(product.price).toFixed(2) }} x
                {{ product.quantity }}
              </v-list-item-subtitle>
            </v-list-item-content>
            <v-list-item-action class="font-weight-bold">
              Php {{ parseFloat(product.price * product.quantity).toFixed(2) }}
            </v-list-item-action>
          </v-list-item>
        </v-card>
        <v-dialog
          v-model="dialogClearCartConfirmation"
          max-width="320"
          v-if="cart.length > 0"
        >
          <template v-slot:activator="{ on, attrs }">
            <v-btn
              text
              small
              block
              color="error"
              v-bind="attrs"
              v-on="on"
              class="mt-2"
              >Clear Cart Items
            </v-btn>
          </template>
          <v-card>
            <v-card-text class="pa-4 text-center">
              Please confirm action.
            </v-card-text>
            <v-card-actions>
              <v-spacer></v-spacer>
              <v-btn
                color="default"
                text
                @click="dialogClearCartConfirmation = false"
              >
                Cancel
              </v-btn>
              <v-btn color="primary darken-1" @click="clearCart">
                Confirm
              </v-btn>
              <v-spacer></v-spacer>
            </v-card-actions>
          </v-card>
        </v-dialog>
      </v-col>

      <v-col cols="12" md="6" v-if="cartItemsCount > 0">
        <v-card>
          <v-card-title class="justify-center"> Checkout </v-card-title>

          <v-card-text>
            <v-row>
              <v-col cols="12">
                <div class="font-weight-bold">
                  <v-text-field
                    label="Address"
                    v-model="customerInformation.address"
                  >
                    <template v-slot:append-outer>
                      <v-dialog v-model="dialogMap" width="500">
                        <template v-slot:activator="{ on, attrs }">
                          <v-icon v-bind="attrs" v-on="on">mdi-earth</v-icon>
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
                  </v-text-field>
                </div>
              </v-col>

              <v-col cols="12">
                <div>
                  <v-textarea
                    label="Notes / Instructions"
                    placeholder="No Notes / Instructions"
                    auto-grow
                    rows="1"
                  >
                  </v-textarea>
                </div>
              </v-col>

              <v-col cols="6">
                <div class="caption">Sub Total</div>
                <div>Php {{ parseFloat(cartSubTotal).toFixed(2) }}</div></v-col
              >

              <v-col cols="6"
                ><div class="caption">Delivery Fee</div>
                <div>
                  <span v-if="!isCalculating && deliveryFee != null">
                    Php {{ parseFloat(deliveryFee).toFixed(2) }} (
                    {{ parseFloat(deliveryDistance / 1000).toFixed(3) }} KM )
                  </span>
                  <span
                    v-if="isCalculating && deliveryFee != null"
                    class="font-italic"
                  >
                    Calculating Delivery Fee. Please Wait...
                  </span>
                  <span
                    v-if="!isCalculating && deliveryFee == null"
                    class="font-italic"
                  >
                    Location Out Of Reach.
                  </span>
                </div>
              </v-col>

              <v-col cols="6"
                ><div class="caption">Grand Total</div>
                <div class="font-weight-bold title">
                  Php {{ parseFloat(cartSubTotal + 100).toFixed(2) }}
                </div>
              </v-col>
            </v-row>
          </v-card-text>
        </v-card>

        <v-dialog
          v-model="dialogCheckoutConfirmation"
          max-width="320"
          persistent
        >
          <template v-slot:activator="{ on, attrs }">
            <v-btn
              block
              color="primary"
              v-bind="attrs"
              v-on="on"
              class="my-2"
              :disabled="deliveryFee == null"
            >
              Checkout
            </v-btn>
          </template>
          <v-card>
            <v-card-text class="pa-4 text-center">
              <div v-if="isProcessing == false">
                Please confirm checkout action.
              </div>

              <div v-if="isProcessing == true">
                <div class="caption mb-2">Processing order, please wait...</div>
                <v-progress-linear height="5" indeterminate></v-progress-linear>
              </div>
            </v-card-text>
            <v-card-actions v-if="isProcessing == false">
              <v-spacer></v-spacer>
              <v-btn
                color="default"
                text
                @click="dialogCheckoutConfirmation = false"
              >
                Cancel
              </v-btn>
              <v-btn color="primary darken-1" @click="checkout">
                Confirm
              </v-btn>
              <v-spacer></v-spacer>
            </v-card-actions>
          </v-card>
        </v-dialog>

        <v-dialog v-model="dialogInformation" width="500" :retain-focus="false">
          <v-card class="flex-grow-1" height="100%">
            <template slot="progress">
              <v-progress-linear
                color="deep-purple"
                height="10"
                indeterminate
              ></v-progress-linear>
            </template>
            <v-img height="200" :src="editedProduct.image"
              ><template v-slot:placeholder>
                <v-row class="fill-height ma-0" align="center" justify="center">
                  <v-progress-circular
                    indeterminate
                    color="primary"
                  ></v-progress-circular>
                </v-row> </template
            ></v-img>
            <v-card-title class="ma-0 pb-0 font-weight-bold"
              >{{ editedProduct.name }}
            </v-card-title>
            <v-card-text class="">
              <div class="">Php {{ editedProduct.price }} / Order</div>
              <div class="mt-2">{{ editedProduct.description }}</div>
              <div class="mt-4">
                <v-chip small color="primary"> Beef </v-chip>
                <v-chip small color="primary"> Juicy </v-chip>
                <v-chip small color="primary"> Grilled </v-chip>
              </div>
              <v-divider class="my-2"></v-divider>
              <v-row no-gutters>
                <v-col cols="6" class="text-center">Quantity</v-col>
                <v-col cols="6" class="text-center">Total</v-col>
                <v-col cols="6" class="mt-1 px-2 text-center font-weight-bold">
                  <v-row no-gutters justify="center" align="center">
                    <v-col>
                      <v-btn icon color="primary" @click="decreaseQuantity">
                        <v-icon>mdi-minus</v-icon>
                      </v-btn>
                    </v-col>
                    <v-col>
                      <div>{{ editedProduct.quantity }}</div>
                    </v-col>
                    <v-col>
                      <v-btn icon color="primary" @click="increaseQuantity">
                        <v-icon>mdi-plus</v-icon>
                      </v-btn>
                    </v-col>
                  </v-row>
                </v-col>
                <v-col
                  cols="6"
                  class="mt-1 px-2 title text-center font-weight-bold"
                >
                  Php {{ editedProduct.price * editedProduct.quantity }}
                </v-col>
              </v-row>
            </v-card-text>

            <v-card-actions>
              <v-btn icon color="error" @click.stop="deleteProduct">
                <v-icon>mdi-delete</v-icon>
              </v-btn>
              <v-spacer></v-spacer>
              <v-btn
                depressed
                color="default"
                @click.stop="dialogInformation = false"
              >
                Close
              </v-btn>
              <v-btn color="primary" @click.stop="updateProduct">
                Update
              </v-btn>
            </v-card-actions>
          </v-card>
        </v-dialog>

        <v-btn block depressed color="default" class="my-2" to="/c/menu"
          >Back to Menu</v-btn
        >
      </v-col>
    </v-row>

    <v-snackbar color="primary" v-model="snackbar.visible" timeout="2000">
      {{ snackbar.message }}
    </v-snackbar>
  </v-container>
</template>

<script>
import { mapGetters, mapActions } from "vuex";

export default {
  data() {
    return {
      isCalculating: false,
      isProcessing: false,

      editedIndex: -1,
      dialogMap: false,
      dialogInformation: false,
      dialogCheckoutConfirmation: false,
      dialogClearCartConfirmation: false,
      editedProduct: {
        id: null,
        image: null,
        name: null,
        description: null,
        price: null,
        quantity: null,
      },

      customerInformation: {
        firstName: null,
        lastName: null,
        contactNumber: null,
        address: null,
        latitude: null,
        longitude: null,
        email: null,
      },

      deliveryFee: null,
      deliveryDistance: 0,

      snackbar: {
        visible: false,
        message: "",
      },

      // Google Maps Variables
      centerCoordinates: { lat: 6.9214, lng: 122.079 },
      positionCoordinates: { lat: 6.9214, lng: 122.079 },
    };
  },
  computed: {
    ...mapGetters(["cart", "cartSubTotal", "cartItemsCount"]),
  },
  mounted() {
    this.getUserGeolocation();
    this.retrieveCustomerProfile();
    // this.calculateDeliveryFee();
  },
  methods: {
    ...mapActions(["updateCartProduct", "removeCartProduct", "clearCartItems"]),

    // Retrieve customer profile
    retrieveCustomerProfile() {
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
        .finally((_) => {});
    },

    clearCart() {
      this.clearCartItems();
      this.dialogClearCartConfirmation = false;
    },

    checkout() {
      this.isProcessing = true;

      axios
        .post("/api/v1/orders", {
          address: this.customerInformation.address,
          latitude: this.customerInformation.latitude,
          longitude: this.customerInformation.longitude,
          distance: 100,
          products: this.cart,
        })
        .then((response) => {
          this.clearCart();
          this.snackbar = {
            visible: true,
            message: "Order successfuly submitted.",
          };
        })
        .catch((error) => {
          if (error.response.status == 422) {
            this.snackbar = {
              visible: true,
              message: "Please check all neccessary data and try again.",
            };
          } else {
            this.snackbar = {
              visible: true,
              message: "Something went wrong. Please try again.",
            };
          }
        })
        .finally(_ => {
          this.isProcessing = false;
          this.dialogCheckoutConfirmation = false;
        });
    },

    editProduct(product) {
      this.editedIndex = this.cart.indexOf(product);
      this.editedProduct = Object.assign({}, product);
      this.dialogInformation = true;
    },

    increaseQuantity() {
      this.editedProduct.quantity += 1;
    },

    decreaseQuantity() {
      this.editedProduct.quantity -= 1;
    },

    updateProduct() {
      this.updateCartProduct({
        original: this.cart[this.editedIndex],
        updated: this.editedProduct,
      });
      this.editedIndex = -1;
      this.dialogInformation = false;
    },

    deleteProduct() {
      this.removeCartProduct(this.cart[this.editedIndex]);
      this.dialogInformation = false;
    },

    mapMarkerDragEnd(event) {
      var userGeolocationLatitude = event.latLng.lat();
      var userGeolocationLongitude = event.latLng.lng();
      this.positionCoordinates = {
        lat: userGeolocationLatitude,
        lng: userGeolocationLongitude,
      };

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

      this.calculateDeliveryFee();
    },

    calculateDeliveryFee() {
      console.log('Calculate Delivery Fee: ' + Date.now());
      this.isCalculating = true;
      axios
        .get("/api/v1/delivery-fees/calculate", {
          params: {
            latitude: this.positionCoordinates.lat,
            longitude: this.positionCoordinates.lng,
          },
        })
        .then((response) => {
          var data = response.data;

          this.deliveryFee = data.fee;
          this.deliveryDistance = data.distance;
        })
        .catch((error) => {
          console.log(error);
        })
        .finally((_) => {
          this.isCalculating = false;
        });
    },
  },
};
</script>
