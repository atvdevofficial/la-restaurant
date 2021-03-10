<template>
    <v-app>
        <div class="signin">
            <v-container class="signin-container" fluid fill-height>
                <v-row justify="center">
                    <v-col cols="12" md="8">
                        <v-container
                            width="80vw"
                            max-width="100vw"
                            min-width="400"
                            fluid
                        >
                            <v-row justify="center">
                                <v-col id="column-1" cols="12" lg="8" class="">
                                    <v-row justify="center">
                                        <h1
                                            class="pa-5 font-weight-black primary--text"
                                        >
                                            Business Sign-in
                                        </h1>
                                    </v-row>
                                    <v-row justify="center">
                                        <v-col cols="12" md="7">
                                            <v-card
                                                class="transparent elevation-0"
                                            >
                                                <v-form
                                                    ref="login"
                                                    lazy-validation
                                                >
                                                    <v-card-text>
                                                        <v-alert
                                                            small
                                                            type="error"
                                                            v-if="error"
                                                        >
                                                            <span>{{
                                                                error
                                                            }}</span>
                                                        </v-alert>
                                                        <v-text-field
                                                            v-model="username"
                                                            label="Username"
                                                            name="username"
                                                            id="username"
                                                            prepend-icon="fa-user"
                                                            :rules="
                                                                rules.usernameRules
                                                            "
                                                            type="text"
                                                            @keydown.enter="
                                                                login()
                                                            "
                                                        ></v-text-field>
                                                        <v-text-field
                                                            v-model="password"
                                                            label="Password"
                                                            id="password"
                                                            name="password"
                                                            prepend-icon="fa-lock"
                                                            append-icon="fa-eye"
                                                            @click:append="
                                                                visible = !visible
                                                            "
                                                            :rules="
                                                                rules.passwordRules
                                                            "
                                                            :type="
                                                                visible
                                                                    ? 'text'
                                                                    : 'password'
                                                            "
                                                            @keydown.enter="
                                                                login()
                                                            "
                                                        ></v-text-field>
                                                    </v-card-text>
                                                </v-form>
                                                <v-card-actions>
                                                    <v-btn
                                                        color="primary"
                                                        block
                                                        shaped
                                                        large
                                                        :loading="loading"
                                                        @click="login"
                                                        >Signin</v-btn
                                                    >
                                                </v-card-actions>
                                            </v-card>
                                        </v-col>
                                    </v-row>
                                </v-col>
                            </v-row>
                        </v-container>
                    </v-col>
                </v-row>
            </v-container>
        </div>
    </v-app>
</template>

<script>
export default {
    name: "app",
    data() {
        return {
            loading: false,
            username: null,
            password: null,
            visible: false,
            error: null,
            rules: {
                usernameRules: [
                    v => !!v || "Username is required",
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
                ]
            }
        };
    },
    methods: {
        login() {
            if (this.$refs.login.validate()) {
                this.loading = true;
                axios
                    .post("/api/v1/login", {
                        username: this.username,
                        password: this.password
                    })
                    .then(response => {
                        if (response.data.errors) {
                            this.error = response.data.errors;
                            return;
                        }
                        var token = response.data.token;
                        var user_id = response.data.user.id;
                        var user_type = response.data.user.role;
                        // Create a local storage item
                        sessionStorage.setItem("user-token", token);
                        sessionStorage.setItem("user-type", user_type);
                        sessionStorage.setItem("user-id", user_id);

                        Echo.connector.pusher.config.auth.headers[
                            "Authorization"
                        ] = "Bearer " + token;

                        console.log(
                            Echo.connector.pusher.config.auth.headers[
                                "Authorization"
                            ]
                        );

                        // Redirect user
                        if (user_type == "ADMINISTRATOR")
                            this.$router.push("admin/dashboard");
                        else if (user_type == "ESTABLISHMENT") {
                            // var user_linkable_id = response.data.data.linkable.id
                            // sessionStorage.setItem('user-linkable-id', user_linkable_id)
                            this.$router.push("establishment/dashboard");
                        }
                        swal.fire({
                            position: "top-end",
                            toast: true,
                            type: "success",
                            icon: "success",
                            text: "Successfully Logined",
                            showConfirmButton: false,
                            timer: 1500
                        });
                    })
                    .catch(error => {
                        if (error.response.data.message == "Unauthenticated.") {
                            sessionStorage.clear();
                            this.$router.push("/signin");
                            swal.fire(
                                "Error!",
                                error.response.data.message,
                                "error"
                            );
                        } else {
                            swal.fire("Invalid Credentials!", error, "error");
                        }
                    })
                    .finally(x => {
                        this.loading = false;
                    });
            }
        }
    },
    beforeRouteEnter(to, from, next) {
        if (sessionStorage.getItem("user-type")) {
            if (sessionStorage.getItem("user-type") == "ADMINISTRATOR") {
                return next("admin/dashboard");
            } else if (sessionStorage.getItem("user-type") == "ESTABLISHMENT") {
                return next("establishment/dashboard");
            }
        }
        next();
    }
};
</script>
