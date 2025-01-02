<script setup>
import { ref, onMounted, onUnmounted } from "vue";

import NavbarDefault from "../..//examples/navbars/NavbarDefault.vue";
import NavbarSignedIn from "../../examples/navbars/NavbarSingedIn.vue";
import CenteredFooter from "../../examples/footers/FooterCentered.vue";
import InfoCardCustom from "../../examples/cards/infoCards/InfoCardCustom.vue";
import MaterialSocialButton from "@/components/MaterialSocialButton.vue";
import Carousel from "./Components/Carousel.vue";

onMounted(() => {
  getSessionFromLocalStorage();
});

const sessionData = ref(null);

function getSessionFromLocalStorage() {
  const storedSession = localStorage.getItem("session");

  if (storedSession) {
    try {
      sessionData.value = JSON.parse(storedSession);
      console.log("Parsed session data:", sessionData.value);
    } catch (error) {
      console.error("Error parsing session data:", error);
    }
  } else {
    console.warn("No session data found in localStorage.");
  }
}

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

  <NavbarDefault v-if="!sessionData || Object.keys(sessionData).length === 0" :sticky="true" />
  <NavbarSignedIn v-else :sticky="true" />

  <div class="card">
    <Carousel />

    <div class="container">
      <div class="row">
        <div class="col-lg-4 mb-3">
          <InfoCardCustom class="p-4" :color="{ text: 'white', background: 'bg-gradient-success' }"
            :icon="{ color: 'white' }" title="Registrácia"
            description="Nemáte u nás účet? Zaregistrujte sa a zúčastnite sa ŠVD!" :action="{
              to: { name: 'register-basic' },
              label: { color: 'white' }
            }" />
        </div>
        <div class="col-lg-4 mb-3">
          <InfoCardCustom class="p-4" :color="{ text: 'white', background: 'bg-gradient-success' }"
            :icon="{ color: 'white' }" title="Prihlásiť sa"
            description="Už máte u nás účet? Prihláste sa a prezrite si aktuálne prebiehajúce konferencie!" :action="{
              to: { name: 'signin-basic' },
              label: { color: 'white' }
            }" />
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
            <MaterialSocialButton route="https://twitter.com/" component="twitter" color="twitter" label="X" />
            <MaterialSocialButton route="https://www.facebook.com/" component="facebook-square" color="facebook"
              label="Facebook" />
          </div>
        </div>
      </div>
    </div>
  </div>
  <CenteredFooter />
</template>