<script setup>
import { onMounted, onUnmounted } from "vue";
import Typed from "typed.js";


const body = document.getElementsByTagName("body")[0];
let typedInstance;

//hooks
onMounted(() => {
  body.classList.add("about-us");
  body.classList.add("bg-gray-200");

  if (document.getElementById("typed")) {
    typedInstance = new Typed("#typed", {
      stringsElement: "#typed-strings",
      typeSpeed: 90,
      backSpeed: 90,
      backDelay: 200,
      startDelay: 500,
      loop: true,
    });
  }
});

onUnmounted(() => {
      
      if (typedInstance) {
        typedInstance.destroy();
        typedInstance = null; 
      }
    });

</script>
<template>
  <div class="container mt-6">
    <div
      class="page-header py-6 py-md-5 my-sm-3 mb-3 border-radius-xl"
      :style="{
        backgroundImage:
          'url(https://raw.githubusercontent.com/creativetimofficial/public-assets/master/soft-ui-design-system/assets/img/desktop.jpg)'
      }"
      loading="lazy"
    >
      <span class="mask bg-gradient-dark"></span>
      <div class="container">
        <div class="row">
          <div class="col-lg-8 ms-lg-5">
            <h4 class="text-white">2 0 2 4</h4>


            <h1 class="text-white">
              Študentská vedecká <span class="text-white" id="typed"></span>
            </h1>
            <div id="typed-strings">
              <h1>konferencia</h1>
              <h1>UKF</h1>
              <h1>FMB</h1>
              <h1>UCM</h1>
            </div>

            <p class="lead text-white opacity-8">
              Študentská vedecká konferencia (ŠVK) je spoločné vedecké podujatie Fakulty prírodných vied a informatiky UKF v Nitre a Fakulty prírodných vied UMB v Banskej Bystrici a po prvýkrát aj Fakulty prírodných vied UCM v Trnave. Konferencia je určená pre študentov 1., 2. a 3. stupňa vysokoškolského štúdia.
            </p>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
