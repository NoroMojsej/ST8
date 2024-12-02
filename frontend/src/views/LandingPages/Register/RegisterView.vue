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

import { ref } from "vue";
import axiosInstance from '@/axios'; // Import axios instance

// material-input
import setMaterialInput from "@/assets/js/material-input";
import { useRouter } from "vue-router";

const router = useRouter();


// Reactive state for email, password, and error message
const degree = ref('');
const name = ref('');
const surname = ref('');
const university = ref('');
const faculcy = ref('');
const email = ref('');
const password1 = ref('');
const password2 = ref('');
const errorMessage = ref('');

// On component mount, initialize Material Input
onMounted(() => {
  setMaterialInput();
});

// Handle login request
const register = async () => {
  errorMessage.value = ''; // Reset any previous error messages
  
  console.log("pswd - "+password1.value);
  try {
    const response = await axiosInstance.post('/register', {
      degree: degree.value,
      name: name.value,
      surname: surname.value,
      university: university.value,
      faculcy: faculcy.value,
      email: email.value,
      password1: password1.value,
      password2: password2.value
    });

    const token = response.data.access_token;
    localStorage.setItem('auth_token', token); // Store the token in localStorage

    alert('Register successful!');
    router.push({ name: 'edit_account' }); // Redirect to dashboard or another page
  } catch (error) {
    if (error.response?.data?.message) {
      errorMessage.value = error.response.data.message;
    } else {
      errorMessage.value = 'An unexpected error occurred.';
    }
  }
};


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
                <form id="register-form" method="post" autocomplete="off" @submit.prevent="register">
                  <div class="card-body p-0 my-3">
                    <div class="row">
                    <!--  <input v-model="name">-->
                      <MaterialInput  v-model="degree" id="degree" icon="bi bi-person text-lg" class="input-group-static mt-2 mb-2" label="TITUL"
                        type="name" placeholder="Titul" />
                      <MaterialInput  v-model="name" id="name" icon="bi bi-person text-lg" class="input-group-static mt-2 mb-2" label="MENO"
                        type="name" placeholder="Meno" />
                      <MaterialInput  v-model="surname" id="surname" icon="bi bi-person text-lg" class="input-group-static mt-2 mb-2" label="PRIEZVISKO"
                        type="surname" placeholder="Priezvisko" />
                      <label for="univerzita" class="form-label" style="color: #4CAF50;">UNIVERZITA</label>
                      <select v-model="university" id="univerzita" class="form-select" aria-label="Category">
                        <option selected disabled>Vyberte Univerzitu</option>
                        <!--Tieto údaje sa budú vkladať z databázy-->
                        <option value="essay">Kat1</option>
                        <option value="report">Kat2</option>
                        <option value="thesis">Kat3</option>
                        <option value="other">Kat4</option>
                      </select>
                      <label for="fakulta" class="form-label" style="color: #4CAF50;">FAKULTA</label>
                      <select v-model="faculcy" id="fakulta" class="form-select" aria-label="Category">
                        <option selected disabled>Vyberte Fakultu</option>
                        <!--Tieto údaje sa budú vkladať z databázy-->
                        <option value="essay">Kat1</option>
                        <option value="report">Kat2</option>
                        <option value="thesis">Kat3</option>
                        <option value="other">Kat4</option>
                      </select>
                      <MaterialInput  v-model="email" id="email" icon="bi bi-person text-lg" class="input-group-static mt-2 mb-2" label="EMAIL"
                        type="email" placeholder="hello@creative-tim.com" />
                      <MaterialInput  v-model="password1" id="password" class="input-group-static mt-2 mb-4" icon="bi bi-lock text-lg" label="HESLO"
                        type="password" placeholder="Heslo" />
                      <MaterialInput  v-model="password2" class="input-group-static mt-2 mb-4" icon="bi bi-lock text-lg" label="ZOPAKOVAŤ HESLO"
                        type="password" placeholder="Zopakovať Heslo" />
                    </div>
                    <div class="row">
                      <div class="col-md-12 text-end">
                        <MaterialButton type="submit" variant="outline" color="success" class="w-35 me-2 mt-3 mb-0 btn">VYTVORIŤ ÚČET
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
