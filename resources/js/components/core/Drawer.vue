<template>
    <v-navigation-drawer
        id="app-drawer"
        v-model="inputValue"
        app
        dark
        floating
        persistent
        mobile-breakpoint="991"
        width="260"
    >
        <v-list dense>
            <v-list-item
                v-for="(link, i) in links"
                :key="i"
                :to="link.to"
                :active-class="color"
                v-if="userPermission(link.module)"
                class="v-list-item"
            >
                <v-list-item-action>
                    <v-icon>{{ link.icon }}</v-icon>
                </v-list-item-action>
                <v-list-item-title v-text="link.text" />
            </v-list-item>
        </v-list>
        <template v-slot:append>
            <v-list dense>
                <v-list-item @click.stop="logout">
                    <v-list-item-action>
                        <v-icon>mdi-exit-to-app</v-icon>
                    </v-list-item-action>
                    <v-list-item-content>
                        <v-list-item-title class="subtitle-2 font-weight-bold"
                            >Logout</v-list-item-title
                        >
                    </v-list-item-content>
                </v-list-item>
            </v-list>
        </template>
    </v-navigation-drawer>
</template>

<script>
// Utilities
import { mapMutations, mapState } from "vuex";

export default {
    props: {
        opened: {
            type: Boolean,
            default: false
        }
    },
    data: () => ({
        logo: "favicon.ico",
        links: [
            {
                to: `/${
                    "Administrator" == "Administrator"
                        ? "admin"
                        : "establishment"
                }/user-profile`,
                icon: "mdi-account",
                text: "User Profile",
                module: "profile"
            },
            {
                to: `/${
                    "Administrator" == "Administrator"
                        ? "admin"
                        : "establishment"
                }/dashboard`,
                icon: "mdi-view-dashboard",
                text: "Dashboard",
                module: "dashboard"
            },
            {
                to: `/${
                    "Administrator" == "Administrator"
                        ? "admin"
                        : "establishment"
                }/table-list`,
                icon: "mdi-clipboard-outline",
                text: "Table List",
                module: "orders"
            },
            {
                to: `/${
                    "Administrator" == "Administrator"
                        ? "admin"
                        : "establishment"
                }/typography`,
                icon: "mdi-format-font",
                text: "Typography",
                module: "typo"
            },
            {
                to: `/${
                    "Administrator" == "Administrator"
                        ? "admin"
                        : "establishment"
                }/icons`,
                icon: "mdi-chart-bubble",
                text: "Icons",
                module: "icons"
            },
            {
                to: `/${
                    "Administrator" == "Administrator"
                        ? "admin"
                        : "establishment"
                }/maps`,
                icon: "mdi-map-marker",
                text: "Maps",
                module: "map"
            },
            {
                to: `/${
                    "Administrator" == "Administrator"
                        ? "admin"
                        : "establishment"
                }/notifications`,
                icon: "mdi-bell",
                text: "Notifications",
                module: "notif"
            }
        ],
        userRole: "Administrator"
    }),
    computed: {
        ...mapState("app", ["color"]),
        inputValue: {
            get() {
                return this.$store.state.app.drawer;
            },
            set(val) {
                this.setDrawer(val);
            }
        },
        items() {
            return this.$t("Layout.View.items");
        }
    },

    methods: {
        ...mapMutations("app", ["setDrawer", "toggleDrawer"]),
        userPermission(module) {
            var modules = {
                dashboard: true,
                profile: true,
                orders: true,
                typo: true,
                icon: true,
                map: true,
                notif: true
            };
            var permissions = {
                Administrator: {
                    ...modules
                },
                Establishment: {
                    ...modules,
                    typo: false,
                    profile: false,
                    map: false
                }
            };
            return permissions[this.userRole][module];
        },

        logout() {
            axios
                .get("/api/v1/logout")
                .then(response => {
                    if (response.data.errors) {
                        this.error = response.data.errors;
                        return;
                    }
                    sessionStorage.clear();
                    this.$router.push("/signin");
                })
                .catch(error => {
                    if (error.response.data.message == "Unauthenticated.") {
                        sessionStorage.clear();
                        this.$router.push("/signin");
                    }
                });
        }
    }
};
</script>

<style lang="scss">
#app-drawer {
    .v-list__tile {
        border-radius: 4px;

        &--buy {
            margin-top: auto;
            margin-bottom: 17px;
        }
    }
}
</style>
