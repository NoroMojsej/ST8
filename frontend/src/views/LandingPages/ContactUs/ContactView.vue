<script setup>
import { onMounted } from "vue";
import '@/assets/css/custom.css'

//example components
import DefaultNavbar from "@/examples/navbars/NavbarDefault.vue";
import DefaultFooter from "@/examples/footers/FooterDefault.vue";

//image
import image from "@/assets/img/illustrations/laptop.jpg";

//material components
import MaterialInput from "@/components/MaterialInput.vue";
import MaterialTextArea from "@/components/MaterialTextArea.vue";
import MaterialButton from "@/components/MaterialButton.vue";

// material-input
import setMaterialInput from "@/assets/js/material-input";
onMounted(() => {
  setMaterialInput();
});
</script>
<template>
  <div class="container position-sticky z-index-sticky top-0">
    <div class="row">
      <div class="col-12">
        <DefaultNavbar :sticky="true" :action="{
          route: 'https://www.creative-tim.com/product/vue-material-kit-pro',
          color: 'bg-gradient-success',
          label: 'PRIHLÁSIŤ SA',
          label2: 'REGISTROVAŤ SA',
        }" />
      </div>
    </div>
  </div>
  <section>
    <div class="page-header min-vh-100">
      <div class="container">
        <div class="row">
          <div
            class="col-6 d-lg-flex d-none h-100 my-auto pe-0 position-absolute top-0 start-0 text-center justify-content-center flex-column">
            <div class="position-relative h-100 m-3 px-7 border-radius-lg d-flex flex-column justify-content-center"
              :style="{
                backgroundImage: `url(${image})`,
                backgroundSize: 'cover',
              }" loading="lazy"></div>
          </div>
          <div class="mt-8 col-xl-5 col-lg-6 col-md-7 d-flex flex-column ms-auto me-auto ms-lg-auto me-lg-5">
            <div class="card d-flex blur justify-content-center shadow-lg my-sm-0 my-sm-6 mt-8 mb-5">
              <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2 bg-transparent">
              </div>
              <div class="card-body">
                <div class="p-4 bg-white border-highlighted">
                  <h3 class="text-black text-success mb-0 heading-highlighted">PRIHLÁSIŤ SA</h3>
                  <p class="text-ordinary">
                    Nový použávateľ? <span class="text-highlighted"> Registrujte sa tu. </span>
                  </p>
                  <p class="text-ordinary">
                    Pre prístup k bližším informáciám a svojim údajom súvisiacich
                    so školskou vedeckou konferenciou sa môžete prihlásiť nižšie.
                  </p>
                </div>
                <form id="contact-form" method="post" autocomplete="off">
                  <div class="card-body p-0 my-3">
                    <div class="row">
                      <MaterialInput icon="bi bi-person text-lg" class="input-group-static mt-2 mb-2" label="EMAIL"
                        type="email" placeholder="hello@creative-tim.com" />
                      <MaterialInput class="input-group-static mt-2 mb-4" icon="bi bi-lock text-lg" label="HESLO"
                        type="password" placeholder="password" />
                    </div>
                    <p class="text-highlighted-lighter">
                      Zabudli ste heslo?
                    </p>
                    <div class="row">
                      <div class="col-md-12 text-end">
                        <MaterialButton variant="outline" color="success" class="w-25 me-2 mt-3 mb-0 btn">POTVRDIŤ
                        </MaterialButton>
                      </div>
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <DefaultFooter />
</template>
