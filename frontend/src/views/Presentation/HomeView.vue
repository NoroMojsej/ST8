<script setup>
import { onMounted, onUnmounted } from "vue";

//example components
import NavbarDefault from "../..//examples/navbars/NavbarDefault.vue";
import CenteredFooter from "../../examples/footers/FooterCentered.vue";
import InfoCardCustom from "../../examples/cards/infoCards/InfoCardCustom.vue";

//Vue Material Kit 2 components
import MaterialSocialButton from "@/components/MaterialSocialButton.vue";

// sections
import Carousel from "./Components/Carousel.vue";


//hooks
const body = document.getElementsByTagName("body")[0];
onMounted(() => {
  body.classList.add("presentation-page");
  body.classList.add("bg-gray-200");
});
onUnmounted(() => {
  body.classList.remove("presentation-page");
  body.classList.remove("bg-gray-200");
});
</script>

<template>
  <div class="container position-sticky z-index-sticky top-0">
    <div class="row">
      <div class="col-12">
        <NavbarDefault :sticky="true" />
      </div>
    </div>
  </div>

  <div class="card card-body blur shadow-blur mx-3 mx-md-4 mt-n6">
    <Carousel />

    <div class="container">
      <div class="row">
        <div class="col-lg-4 mb-3">
          <InfoCardCustom
            class="p-4"
            :color="{ text: 'white', background: 'bg-gradient-success' }"
            :icon="{ color: 'white' }"
            title="Registrácia"
            description="Nemáte u nás účet? Zaregistrujte sa a zúčastnite sa ŠVD!"
            :action="{
                to: { name: 'register-basic' },
                label: {color: 'white' }
            }"
          />
        </div>
        <div class="col-lg-4 mb-3">
          <InfoCardCustom
            class="p-4"
            :color="{ text: 'white', background: 'bg-gradient-success' }"
            :icon="{ color: 'white' }"
            title="Prihlásiť sa"
            description="Už máte u nás účet? Prihláste sa a prezrite si aktuálne prebiehajúce konferencie!"
            :action="{
                to: { name: 'signin-basic' },
                label: {color: 'white' }
            }"
          />
        </div>
      </div>
    </div>
    <div class="py-5">
      <div class="container">
        <div class="row">
          <div class="col-lg-5 ms-auto">
            <h4 class="mb-1">Ďakujeme za účasť na ŠVD!</h4>
          </div>
          <div class="col-lg-5 me-lg-auto my-lg-auto text-lg-end mt-5">
            <MaterialSocialButton
              route="https://twitter.com/"
              component="twitter"
              color="twitter"
              label="X"
            />
            <MaterialSocialButton
              route="https://www.facebook.com/"
              component="facebook-square"
              color="facebook"
              label="Facebook"
            />
          </div>
        </div>
      </div>
    </div>
  </div>
  <CenteredFooter />
</template>