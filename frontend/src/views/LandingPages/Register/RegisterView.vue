<script setup>
import { onMounted } from "vue";
import '@/assets/css/custom.css'

//example components
import DefaultNavbar from "@/examples/navbars/NavbarDefault.vue";
import DefaultFooter from "@/examples/footers/FooterDefault.vue";

//image
import image from "@/assets/img/annie-spratt.jpg";

//material components
import MaterialInput from "@/components/MaterialInput.vue";
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
        <DefaultNavbar :sticky="true"/>
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
                  <h3 class="text-black text-success mb-0 heading-highlighted">REGISTRÁCIA</h3>
                  <p class="text-ordinary">
                    Už máte u nás konto?
                    <router-link :to="{ name: 'signin-basic' }" class="text-highlighted">
                      Prihláste sa.
                    </router-link>
                  </p>
                </div>
                
                <!-- Registračný formulár. Každý atribút obsahuje "id" pre identifikáciu vložených údajov -->
                <form id="register-form" method="post" autocomplete="off">
                  <div class="card-body p-0 my-3">
                    <div class="row">
                      <MaterialInput id="name" icon="bi bi-person text-lg" class="input-group-static mt-2 mb-2" label="MENO"
                        type="name" placeholder="Meno" />
                      <MaterialInput id="surname" icon="bi bi-person text-lg" class="input-group-static mt-2 mb-2" label="PRIEZVISKO"
                        type="surname" placeholder="Priezvisko" />
                      <label for="univerzita" class="form-label" style="color: #4CAF50;">UNIVERZITA</label>
                      <select id="univerzita" class="form-select" aria-label="Category">
                        <option selected disabled>Vyberte Univerzitu</option>
                        <!--Tieto údaje sa budú vkladať z databázy-->
                        <option value="essay">Kat1</option>
                        <option value="report">Kat2</option>
                        <option value="thesis">Kat3</option>
                        <option value="other">Kat4</option>
                      </select>
                      <label for="fakulta" class="form-label" style="color: #4CAF50;">FAKULTA</label>
                      <select id="fakulta" class="form-select" aria-label="Category">
                        <option selected disabled>Vyberte Fakultu</option>
                        <!--Tieto údaje sa budú vkladať z databázy-->
                        <option value="essay">Kat1</option>
                        <option value="report">Kat2</option>
                        <option value="thesis">Kat3</option>
                        <option value="other">Kat4</option>
                      </select>
                      <label for="katedra" class="form-label" style="color: #4CAF50;">KATEDRA</label>
                      <select id="katedra" class="form-select" aria-label="Category">
                        <option selected disabled>Vyberte Katedru</option>
                        <!--Tieto údaje sa budú vkladať z databázy-->
                        <option value="essay">Kat1</option>
                        <option value="report">Kat2</option>
                        <option value="thesis">Kat3</option>
                        <option value="other">Kat4</option>
                      </select>
                      <MaterialInput id="email" icon="bi bi-person text-lg" class="input-group-static mt-2 mb-2" label="EMAIL"
                        type="email" placeholder="hello@creative-tim.com" />
                      <MaterialInput id="password" class="input-group-static mt-2 mb-4" icon="bi bi-lock text-lg" label="HESLO"
                        type="password" placeholder="Heslo" />
                      <MaterialInput class="input-group-static mt-2 mb-4" icon="bi bi-lock text-lg" label="ZOPAKOVAŤ HESLO"
                        type="password" placeholder="Zopakovať Heslo" />
                    </div>
                    <div class="row">
                      <div class="col-md-12 text-end">
                        <MaterialButton variant="outline" color="success" class="w-35 me-2 mt-3 mb-0 btn">VYTVORIŤ ÚČET
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
