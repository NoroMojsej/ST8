<script setup>
import NavbarStnd from "../../../examples/navbars/NavbarStnd.vue";
import CenteredFooter from "@/examples/footers/FooterCentered.vue";
import Breadcrumbs from "@/examples/Breadcrumbs.vue";

defineProps({
  breadcrumb: {
    type: Array,
    required: true,
  },
  title: {
    type: String,
    required: true,
  }
});


</script>


<template>

<NavbarStnd></NavbarStnd>

  <div class="text-sans-serif container mt-5">
    <div class="row">
      <div class="col-lg-12 mx-auto">
        <div class="mb-4 w-100 w-md-50 w-lg-25">
          <Breadcrumbs :routes="breadcrumb" />
          <h3>{{ title }}</h3>
        </div>

        <slot />
      </div>
    </div>
  </div>
  <CenteredFooter />
</template>

<style>
h3 {
  font-family: 'Montserrat' !important;
}
</style>