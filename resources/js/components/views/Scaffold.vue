<template>
    <v-app>
        <v-overlay :value="overlay" @overlay="overlay == !overlay">
            <v-progress-circular
                :size="100"
                :width="5"
                indeterminate
            ></v-progress-circular>
        </v-overlay>
        <core-filter />

        <core-toolbar />

        <core-drawer />

        <core-view />
    </v-app>
</template>

<script>
export default {
    data: () => ({
        overlay: false
    })
};
</script>

<style lang="scss">
/* Remove in 1.2 */
.v-datatable thead th.column.sortable i {
    vertical-align: unset;
}
</style>
