<template>
  <v-footer
    id="core-footer"
    absolute
    height="82"
  >
    <v-spacer/>
    <span class="font-weight-light copyright">
      &copy;
      {{ (new Date()).getFullYear() }}
      <a
        href="https://www.dreamers.ph/"
        target="_blank">Dreamre.rs</a>, made with
      <v-icon
        color="primary"
        size="17">mdi-heart</v-icon>
      for a better web
    </span>
    <v-spacer/>
  </v-footer>
</template>

<style>
#core-footer {
  z-index: 0;
}
</style>
