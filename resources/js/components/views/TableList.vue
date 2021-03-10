<template>
    <v-container fill-height fluid grid-list-xl>
        <v-row justify-center wrap>
            <v-col md12>
                <material-card color="green">
                    <v-row slot="header">
                        <v-col style="align-self: center">
                            <span class="title font-weight-light mr-3">
                                Simple Table
                            </span>
                        </v-col>
                        <v-spacer></v-spacer>
                        <v-col class="text-right">
                            <v-btn small color="primary" class="mr-5">
                                <v-icon small left>mdi-printer</v-icon> Print
                                Codes
                            </v-btn>
                        </v-col>
                    </v-row>
                    <v-data-table
                        :headers="tableEstablishmentHeaders"
                        :items="establishments"
                    >
                        <template
                            v-for="h in tableEstablishmentHeaders"
                            v-slot:[`header.${h.value}`]
                        >
                            <span
                                class="font-weight-light text-success text--darken-3"
                                v-text="h.text"
                            />
                        </template>
                        <template slot="items" slot-scope="{ item }">
                            <td>{{ item.name }}</td>
                            <td>{{ item.country }}</td>
                            <td>{{ item.city }}</td>
                            <td class="text-xs-right">{{ item.salary }}</td>
                        </template>
                    </v-data-table>
                </material-card>
            </v-col>
        </v-row>
    </v-container>
</template>

<script>
export default {
    data() {
        return {
            //Table Variables
            tableEstablishmentHeaders: [
                { sortable: false, text: "Name", value: "name" },
                { sortable: false, text: "Country", value: "country" },
                { sortable: false, text: "City", value: "city" },
                {
                    sortable: false,
                    text: "Salary",
                    value: "salary",
                    align: "right"
                }
            ],
            tableLoading: false,
            tableSearch: null,
            establishments: [
                {
                    name: "Dakota Rice",
                    country: "Niger",
                    city: "Oud-Tunrhout",
                    salary: "$35,738"
                },
                {
                    name: "Minerva Hooper",
                    country: "Curaçao",
                    city: "Sinaai-Waas",
                    salary: "$23,738"
                },
                {
                    name: "Sage Rodriguez",
                    country: "Netherlands",
                    city: "Overland Park",
                    salary: "$56,142"
                },
                {
                    name: "Philip Chanley",
                    country: "Korea, South",
                    city: "Gloucester",
                    salary: "$38,735"
                },
                {
                    name: "Doris Greene",
                    country: "Malawi",
                    city: "Feldkirchen in Kārnten",
                    salary: "$63,542"
                },
                {
                    name: "Mason Porter",
                    country: "Chile",
                    city: "Gloucester",
                    salary: "$78,615"
                }
            ],
            //Forms Varialbes
            defaultEstablishmentInformation: {},
            editedEstablishmentInformation: {},
            formErrors: {},
            editedIndex: -1,
            rules: {
                //Form Field Rules
                required: [v => !!v || "Field is required"],
                usernameRules: [
                    v => !!v || "Username is required",
                    v =>
                        (!!v && v.length >= 8) ||
                        "Username must be atleast 8 characters",
                    v =>
                        (!!v && v.length <= 255) ||
                        "Username must be more than 255 characters"
                ],
                passwordRules: [
                    v => !!v || "Password is required",
                    v =>
                        (!!v && v.length >= 6) ||
                        "Password must be atleast 6 characters",
                    v =>
                        (!!v && v.length <= 255) ||
                        "Password must be more than 255 characters"
                ],
                locationRules: [
                    v => !!v || "Address is required",
                    v =>
                        (!!v && v.length <= 500) ||
                        "Location must be more than 500 characters"
                ],
                emailRules: [
                    v => !!v || "E-mail is required",
                    v =>
                        /^\w+([.-]?\w+)*@\w+([.-]?\w+)*(\.\w{2,3})+$/.test(v) ||
                        "E-mail must be valid",
                    v =>
                        (!!v && v.length <= 255) ||
                        "E-mail must be more than 255 characters"
                ],
                contactRules: [
                    v => !!v || "Contact Number is required",
                    v =>
                        (!!v && v.length <= 255) ||
                        "Contact Number must be more than 255 characters"
                ]
            },
            //Overlays Variables
            formDialog: false
        };
    },

    computed: {
        formTitle() {
            return this.editedIndex === -1
                ? "New Establishment"
                : "Edit Establishment";
        }
    },

    mounted() {
        this.fetchEstablishments();
    },

    methods: {
        fetchEstablishments() {
            this.tableLoading = true;
            axios
                .get("/api/provider/boxes")
                .then(response => {
                    this.establishments = response.data.data;
                })
                .catch(error => {
                    console.log(error);
                })
                .finally(() => (this.tableLoading = false));
        },

        saveEstablishment() {
            this.formOverlay = true;
            if (this.editedIndex > -1) {
                this.updateEstablishment();
            } else {
                this.createEstablishment();
            }
        },

        createEstablishment() {
            this.boxStatuses.forEach(status => {
                if (status.name.includes("Created")) {
                    this.editedEstablishmentInformation.box_status_id =
                        status.id;
                }
            });
            this.editedEstablishmentInformation.box_status_id = axios
                .post("/api/provider/boxes", {
                    ...this.editedEstablishmentInformation
                })
                .then(response => {
                    this.fetchEstablishmentes();
                    this.closeForm();
                })
                .catch(error => {
                    this.formOverlay = false;

                    if (error.response.status == 422) {
                        this.formErrors = error.response.data.errors;
                    } else {
                        console.log(error);
                    }
                })
                .finally(() => {});
        },

        editEstablishment(box) {
            this.editedIndex = this.tableEstablishmentes.indexOf(box);
            this.editedEstablishmentInformation = Object.assign(
                {},
                {
                    id: box.id,
                    provider_id: box.provider.id,
                    box_size_id: box.box_size.id,
                    box_status_id: box.box_status.id
                }
            );
            this.formDialog = true;
        },

        infoEstablishment(box) {
            if (box.recipient == null) box.recipient = "";
            if (box.sender == null) box.sender = "";
            this.EstablishmentInformation = box;
            this.qrCodeUrl =
                "https://api.qrserver.com/v1/create-qr-code/?size=500x500&data=" +
                this.EstablishmentInformation.qr_code;
            console.log(this.EstablishmentInformation.qr_code);
            this.formDialog2 = true;
        },

        updateEstablishment() {
            axios
                .put(
                    "/api/provider/boxes/" +
                        this.editedEstablishmentInformation.id,
                    {
                        ...this.editedEstablishmentInformation
                    }
                )
                .then(response => {
                    this.fetchEstablishmentes();
                    this.closeForm();
                })
                .catch(error => {
                    this.formOverlay = false;

                    if (error.response.status == 422) {
                        this.formErrors = error.response.data.errors;
                    } else {
                        console.log(error);
                    }
                })
                .finally(() => {});
        },

        deleteEstablishment(box) {
            swal.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, delete it!"
            })
                .then(result => {
                    if (result.value) {
                        // console.log(box);
                        axios
                            .delete("/api/provider/boxes/" + box.id)
                            .then(() => {
                                // console.log('wew');
                                this.fetchEstablishmentes();
                                this.closeForm();
                                swal.fire(
                                    "Deleted!",
                                    "Establishment has been deleted.",
                                    "success"
                                );
                            })
                            .catch(error => {
                                // console.log('waw');
                                swal.fire(
                                    "Failed!",
                                    "There was something wrong.",
                                    "warning"
                                );
                                this.error = response.data.errors;
                                if (
                                    error.response.data.message ==
                                    "Unauthenticated."
                                ) {
                                    sessionStorage.clear();
                                    this.$router.push("/signin");
                                }
                                return;
                            });
                    }
                })
                .catch(() => {
                    swal("Failed!", "There was something wrong.", "warning");
                });
        },

        closeForm() {
            this.formDialog = false;
            this.formOverlay = false;
            setTimeout(() => {
                this.formErrors = {
                    name: null,
                    contact_number: null,
                    email: null,
                    password: null
                };
                this.editedEstablishmentInformation = Object.assign(
                    {},
                    this.defaultEstablishmentInformation
                );
                this.editedIndex = -1;
            }, 500);
        }
    }
};
</script>
