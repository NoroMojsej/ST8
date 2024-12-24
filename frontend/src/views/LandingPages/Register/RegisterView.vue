<script lang="ts" setup>
import { onMounted } from "vue";
import '@/assets/css/custom.css'

//example components
import DefaultNavbar from "../../../examples/navbars/NavbarDefault.vue";

//image
import image from "@/assets/img/annie-spratt.jpg";

//material components
import MaterialInput from "@/components/MaterialInput.vue";
import MaterialButton from "@/components/MaterialButton.vue";
import MaterialSelect from "../../../../MaterialSelect.vue";

import { ref } from "vue";
import axiosInstance from '@/axios'; // Import axios instance

// material-input
import setMaterialInput from "@/assets/js/material-input";
import { useRouter } from "vue-router";

onMounted(() => {
  fetchCountries();
  fetchDegrees();
  loadUniversities();
  setMaterialInput();
});

const toggleContentVisibility = () => {
  isContentVisible.value = !isContentVisible.value;
};

const router = useRouter();

const isContentVisible = ref(false); // Obsah je skrytý na začiatku

interface Degree {
  iddegree: string;
  abbreviation: string;
}

const errorMessage = ref('');

const name = ref('');
const surname = ref('');
const email = ref('');
const password = ref('');
const degrees = ref<Degree[]>([]) // Pre uloženie údajov o stupňoch
const selectedDegrees = ref<string[]>([]);
const countries = ref([]);
const isLoadingCountries = ref(true);
const universities = ref([]);
const isLoadingUniversities = ref(false);
const faculties = ref([]);
const isLoadingFaculties = ref(false);
const departments = ref([]);
const isLoadingDepartments = ref(true);
const selectedCountry = ref(null);
const selectedUniversity = ref(null);
const selectedFaculty = ref(null);
const selectedDepartment = ref(null);

const fetchDegrees = async () => {
  try {
    const response = await axiosInstance.get('/degrees');
    if (Array.isArray(response.data)) {
      degrees.value = response.data.map((degree: { iddegree: string; abbreviation: string }) => ({
        iddegree: degree.iddegree,
        abbreviation: degree.abbreviation,
      }));
    } else {
      console.error("Invalid data format:", response.data);
    }
  } catch (error) {
    console.error("Failed to fetch degrees:", error);
    if (error.response.data?.message) {
      errorMessage.value = error.response.data.message;
    }
  }
};


const fetchCountries = async () => {
  try {
    const response = await axiosInstance.get('/countries');
    countries.value = response.data.map((item: { idcountry: string; name: string }) => ({
      value: item.idcountry,
      label: item.name,
    }));
  } catch (error) {
    console.error('Failed to fetch countries:', error);
  } finally {
    isLoadingCountries.value = false;
  }
};



const loadUniversities = async () => {
  try {
    const response = await axiosInstance.get(`/universities`);
    universities.value = response.data.map((item: { iduniversity: string; name: string }) => ({
      value: item.iduniversity,
      label: item.name,
    }));
  } catch (error) {
    console.error('Failed to fetch universities:', error);
  } finally {
    isLoadingUniversities.value = false;
  }
};


const onUniversityChange = () => {
  faculties.value = [];
  departments.value = [];
  selectedFaculty.value = null;
  console.log("University ID " + selectedUniversity.value);
  loadFaculties();
};


const loadFaculties = async () => {
  if (!selectedUniversity.value) return;
  isLoadingFaculties.value = true;
  try {
    const response = await axiosInstance.get(`/faculties/${selectedUniversity.value}`);
    faculties.value = response.data.map((item: { idfaculty: string; name: string }) => ({
      value: item.idfaculty,
      label: item.name,
    }));
  } catch (error) {
    console.error('Failed to fetch faculties:', error);
  } finally {
    isLoadingFaculties.value = false;
  }
};

const onFacultyChange = () => {
  departments.value = [];
  selectedDepartment.value = null;
  console.log("University ID " + selectedDepartment.value);
  loadDepartments();
};

// Načítanie univerzít podľa vybranej krajiny
const loadDepartments = async () => {
  if (!selectedFaculty.value) return; // Ak nie je krajina vybraná, nič neponúkame
  isLoadingDepartments.value = true;
  try {
    const response = await axiosInstance.get(`/departments/${selectedFaculty.value}`);
    departments.value = response.data.map((item: { iddepartment: string; name: string }) => ({
      value: item.iddepartment,
      label: item.name,
    }));
  } catch (error) {
    console.error('Failed to fetch universities:', error);
  } finally {
    isLoadingUniversities.value = false;
  }
};

// Handle login request
const register = async () => {
  errorMessage.value = '';
  console.log("Country ID " + selectedCountry.value);
  console.log("pswd - " + password.value);
  console.log("DEGREES " + selectedDegrees.value)
  try {
    const response = await axiosInstance.post('/register', {
      degrees: selectedDegrees.value,
      name: name.value,
      surname: surname.value,
      country: selectedCountry.value,
      university: selectedUniversity.value,
      faculty: selectedFaculty.value,
      department: selectedDepartment.value,
      email: email.value,
      password: password.value,
    });

    const session = response.data.session;
    const token = response.data.access_token;
    console.log('Session data:', session);
    console.log('Token data:', token);

    //uloženie session ako JSON String
    localStorage.setItem('session', JSON.stringify(session));
    localStorage.setItem('auth_token', JSON.stringify(token));


    router.push({ name: 'student_home' });

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
        <DefaultNavbar :sticky="true" />
      </div>
    </div>
  </div>

  <section>
    <div class="page-header min-vh-100">
      <div class="container">
        <div class="row">
          <div
            class="col-6 d-lg-flex d-none h-100 my-auto pe-0 position-fixed top-0 start-0 text-center justify-content-center flex-column">
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


                    <h6 style="color:#4caf50; font-weight: 350;">
                      TITUL
                    </h6>

                    <div v-for="(degree, index) in degrees.slice(0, 16)" :key="degree.iddegree"
                      class="form-check form-check-inline">
                      <input class="form-check-input" type="checkbox" :id="'degree-' + degree.iddegree"
                        :value="degree.iddegree" v-model="selectedDegrees" />
                      <label class="form-check-label" :for="'degree-' + degree.abbreviation">
                        {{ degree.abbreviation }}
                      </label>
                    </div>


                    <div>

                      <!-- Tlačidlo na toggle obsahu -->
                      <div class="btn-float">
                        <button class="btn btn-success btn-sm text-lg" @click="toggleContentVisibility">
                          {{ isContentVisible ? '-' : '+' }}
                        </button>
                      </div>

                      <!-- Obsah na zobrazenie/skrytie -->
                      <div ref="scrollContent" class="mt-4" v-show="isContentVisible">

                        <div v-for="(degree, index) in degrees.slice(16)" :key="degree.iddegree"
                          class="form-check form-check-inline">
                          <input class="form-check-input" type="checkbox" :id="'degree-' + degree.iddegree"
                            :value="degree.iddegree" v-model="selectedDegrees" />
                          <label class="form-check-label" :for="'degree-' + degree.abbreviation">
                            {{ degree.abbreviation }}
                          </label>
                        </div>


                      </div>
                    </div>

                    <div class="row">
                      <MaterialInput v-model="name" id="name" icon="bi bi-person text-lg"
                        class="input-group-static mt-2 mb-2" label="MENO" type="name" placeholder="Meno" />
                      <MaterialInput v-model="surname" id="surname" icon="bi bi-person text-lg"
                        class="input-group-static mt-2 mb-2" label="PRIEZVISKO" type="surname"
                        placeholder="Priezvisko" />

                      <MaterialSelect label="KRAJINA" placeholder="Zvoľte krajinu" :options="countries"
                        :loading="isLoadingCountries" v-model="selectedCountry"></MaterialSelect>

                      <MaterialSelect label="UNIVERZITA" placeholder="Zvoľte univerzitu" v-model="selectedUniversity"
                        :options="universities" @change="onUniversityChange" />


                      <MaterialSelect label="FAKULTA" placeholder="Zvoľte fakultu" v-model="selectedFaculty"
                        :options="faculties" :disabled="!faculties.length" @change="onFacultyChange" />


                      <MaterialSelect label="KATEDRA" placeholder="Zvoľte katedru" v-model="selectedDepartment"
                        :options="departments" :disabled="!selectedUniversity" />



                      <MaterialInput v-model="email" id="email" icon="bi bi-envelope text-lg"
                        class="input-group-static mt-2 mb-2" label="EMAIL" type="email"
                        placeholder="hello@creative-tim.com" />
                      <MaterialInput v-model="password" id="password" class="input-group-static mt-2 mb-4"
                        icon="bi bi-lock text-lg" label="HESLO" type="password" placeholder="Heslo" />
                    </div>
                    <div class="row">
                      <div class="col-md-12 text-end">
                        <MaterialButton type="submit" variant="outline" color="success" class="w-35 me-2 mt-3 mb-0 btn">
                          VYTVORIŤ ÚČET
                        </MaterialButton>
                        <div v-if="errorMessage" class="text-danger mt-2">{{ errorMessage }}</div>
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

<style>
.form-check:not(.form-switch) .form-check-input[type=checkbox]:checked {
  background-color: #66bb6a !important;
  border-color: #66bb6a !important;
}

.btn-float {
  width: 100%;
  display: flex;
  justify-content: end;
}
</style>