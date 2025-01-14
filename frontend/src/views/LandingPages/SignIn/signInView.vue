<script setup>
import { ref } from "vue";
import { useRouter } from "vue-router";
import { onMounted } from "vue";
import "@/assets/css/custom.css";
import axiosInstance from '@/axios';

import NavbarDefault from "../../../examples/navbars/NavbarDefault.vue";
import image from "@/assets/img/illustrations/laptop.jpg";

// Import Material Input and Material Button components
import MaterialInput from "@/components/MaterialInput.vue";
import MaterialButton from "@/components/MaterialButton.vue";

import setMaterialInput from "@/assets/js/material-input";

const router = useRouter();

const email = ref('');
const password = ref('');
const errorMessage = ref('');

onMounted(() => {
  setMaterialInput();
});

// Handle login request
const login = async () => {
  errorMessage.value = '';

  try {
    const response = await axiosInstance.post('/login', {
      email: email.value,
      password: password.value,
    });

    const token = response.data.access_token;
    const session = response.data.session;
    localStorage.setItem('auth_token', JSON.stringify(token));
    localStorage.setItem('session', JSON.stringify(session));
    console.log("ROLA " + JSON.stringify(session));
    if (session.user_role === "ADMIN") {
      router.push({ name: 'adminhome' });
    } else if (session.user_role === "REVIW") {
      router.push({ name: 'reviewer_home' });
    } else {
      router.push({ name: 'student_home' });
    }
  } catch (error) {
    if (error.response) {
      console.error("Error response:", error.response);

      if (error.response.data?.message) {
        errorMessage.value = error.response.data.message;
      } else {
        errorMessage.value = 'An unexpected error occurred (response).';
      }
    } else {

      console.error("Error:", error);
      errorMessage.value = 'An unexpected error occurred (no response).';
    }
  }
};
</script>

<template>

  <NavbarDefault :sticky="true" />
  <section>
    <div class="page-header min-vh-100">
      <div class="container">
        <div class="row">
          <div
            class="col-6 d-lg-flex d-none h-100 my-auto pe-0 position-absolute top-0 start-0 text-center justify-content-center flex-column">
            <div class="position-relative h-100 m-3 px-7 border-radius-lg d-flex flex-column justify-content-center"
              :style="{ backgroundImage: `url(${image})`, backgroundSize: 'cover' }"></div>
          </div>
          <div class="col-xl-5 col-lg-6 col-md-7 d-flex flex-column ms-auto me-auto ms-lg-auto me-lg-5">
            <div class="card d-flex blur justify-content-center shadow-lg my-sm-0 my-sm-6 mt-8 mb-5">
              <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2 bg-transparent"></div>
              <div class="card-body">
                <div class="p-4 bg-white border-highlighted">
                  <h3 class="text-black text-success mb-0 heading-highlighted">PRIHLÁSIŤ SA</h3>
                  <p class="text-ordinary">
                    Nový používateľ?
                    <router-link :to="{ name: 'register-basic' }" class="text-highlighted">
                      Registrujte sa tu.
                    </router-link>
                  </p>
                  <p class="text-ordinary">
                    Pre prístup k bližším informáciám a svojim údajom súvisiacich
                    so školskou vedeckou konferenciou sa môžete prihlásiť nižšie.
                  </p>
                </div>
                <form id="signin-form" method="post" autocomplete="off" @submit.prevent="login">
                  <div class="card-body p-0 my-3">
                    <div class="row">
                      <MaterialInput v-model="email" id="email" icon="bi bi-person text-lg"
                        class="input-group-static mt-2 mb-2" label="EMAIL" type="email"
                        placeholder="hello@creative-tim.com" />
                      <MaterialInput v-model="password" id="password" class="input-group-static mt-2 mb-4"
                        icon="bi bi-lock text-lg" label="HESLO" type="password" placeholder="Heslo" />
                    </div>
                    <div v-if="errorMessage" class="text-danger mt-2">{{ errorMessage }}</div>
                    <div class="row">
                      <div class="col-md-12 text-end">
                        <MaterialButton type="submit" variant="outline" color="success" class="w-35 me-2 mt-3 mb-0 btn">
                          PRIHLÁSIŤ SA
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
</template>
