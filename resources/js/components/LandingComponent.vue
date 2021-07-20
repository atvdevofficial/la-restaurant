<template>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="card-body">
          <example-component></example-component>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import ExampleComponent from "./subs/ExampleComponent.vue";

export default {
  components: {
    ExampleComponent,
  },
  mounted() {
    Echo.channel("sample-events").listen("SampleEvent", (e) => {
      console.log(e);
    });
  },
};
</script>
