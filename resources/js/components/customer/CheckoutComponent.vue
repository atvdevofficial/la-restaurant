<template>
  <v-container>
    <v-row>
      <v-col cols="12" md="6">
        <v-card
          v-for="(product, index) in products"
          :key="index"
          class="mb-2"
          @click="editProduct(product)"
        >
          <v-list-item two-line>
            <v-list-item-content>
              <v-list-item-title>{{ product.name }}</v-list-item-title>
              <v-list-item-subtitle>
                Php {{ product.price }} x {{ product.quantity }}
              </v-list-item-subtitle>
            </v-list-item-content>
            <v-list-item-action class="font-weight-bold">
              Php {{ product.price * product.quantity }}
            </v-list-item-action>
          </v-list-item>
        </v-card>
      </v-col>
      <v-col cols="12" md="6">
        <v-card>
          <v-card-title class="justify-center"> Checkout </v-card-title>

          <v-card-text>
            <v-row>
              <v-col cols="12">
                <div class="caption">Address</div>
                <div class="font-weight-bold">
                  <v-icon small>mdi-earth</v-icon>
                  Mapple Driver, Honey Street, Bee Colony
                </div>
              </v-col>

              <v-col cols="12"
                ><div class="caption">Notes / Instructions</div>
                <div>
                  <v-textarea
                    placeholder="No Notes / Instructions"
                    auto-grow
                    rows="1"
                  ></v-textarea></div
              ></v-col>

              <v-col cols="6">
                <div class="caption">Sub Total</div>
                <div>Php 3,750.00</div></v-col
              >

              <v-col cols="6"
                ><div class="caption">Delivery Fee</div>
                <div>Php 100.00</div></v-col
              >

              <v-col cols="6"
                ><div class="caption">Grand Total</div>
                <div class="font-weight-bold">Php 3,850.00</div></v-col
              >
            </v-row>
          </v-card-text>
        </v-card>

        <v-dialog v-model="dialogCheckoutConfirmation" max-width="320">
          <template v-slot:activator="{ on, attrs }">
            <v-btn block color="primary" v-bind="attrs" v-on="on" class="my-2">
              Checkout
            </v-btn>
          </template>
          <v-card>
            <v-card-text class="pa-4 text-center">
              Please confirm checkout action.
            </v-card-text>
            <v-card-actions>
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
  </v-container>
</template>

<script>
export default {
  data() {
    return {
      editedIndex: -1,
      dialogInformation: false,
      dialogCheckoutConfirmation: false,
      editedProduct: {
        id: null,
        image: null,
        name: null,
        description: null,
        price: null,
        quantity: null,
      },
      products: [
        {
          id: 1,
          image:
            "https://www.tasteofhome.com/wp-content/uploads/2020/03/Smash-Burgers_EXPS_TOHcom20_246232_B10_06_10b.jpg",
          name: "Burger",
          description: "The Delicious Burger",
          price: 100,
          quantity: 1,
        },
        {
          id: 2,
          image:
            "https://www.sprinklesandsprouts.com/wp-content/uploads/2021/05/Peri-Peri-Fries-SQ.jpg",
          name: "Fries",
          description: "The Delicious Fries",
          price: 100,
          quantity: 2,
        },
        {
          id: 3,
          image:
            "https://www.lanascooking.com/wp-content/uploads/2012/06/coke-floats-feature.jpg",
          name: "Coke Float",
          description: "The Delicious Coke Float",
          price: 100,
          quantity: 3,
        },
        {
          id: 4,
          image:
            "https://a7m3f5i5.rocketcdn.me/wp-content/uploads/2015/09/moms-spaghetti-sauce-recipe-a-healthy-slice-of-life-6-of-6-800x600.jpg",
          name: "Spaghetti",
          description: "The Delicious Spaghetti",
          price: 100,
          quantity: 4,
        },
      ],
    };
  },
  methods: {
    checkout() {
      this.dialogCheckoutConfirmation = false;
      console.log("Checkout!");
    },

    editProduct(product) {
      this.editedIndex = this.products.indexOf(product);
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
      Object.assign(this.products[this.editedIndex], this.editedProduct);
      this.editedIndex = -1;
      this.dialogInformation = false;
    },

    deleteProduct() {
        this.products.splice(this.editedIndex, 1);
        this.dialogInformation = false;
    }
  },
};
</script>
