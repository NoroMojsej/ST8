<script setup>
import { ref, onMounted } from "vue";

import BaseLayout from "@/layouts/sections/components/BaseLayout.vue";
import MaterialInput from "@/components/MaterialInput.vue";
import setMaterialInput from "@/assets/js/material-input";
import axiosInstance from '@/axios';

const countries = ref([]);
const errorMessage = ref("");
const selectedCountry = ref("");
const universityName = ref("");
const universityCode = ref("");

async function handleSubmit() {
  errorMessage.value = "";

  if (!universityName.value || !universityCode.value || !selectedCountry) {
    errorMessage.value = "Prosím vyplňte všetky povinné polia.";
    console.log("Error: Missing required fields");
    return;
  }

  const data = new FormData();
  data.append("code", universityCode.value);
  data.append("name", universityName.value);
  data.append("country_idcountry", selectedCountry.value);

  try {
    console.log("Sending request to server...");

    const response = await axiosInstance.post(`/universities/create`, data, {
      headers: {
      "Content-Type": "multipart/form-data",
      },      
    });

    console.log("Response:", response.data);
  } catch (error) {
    errorMessage.value = error.response?.data?.message || "Chyba pri odosielaní formuláru.";
    console.error("Error while submitting form:", error);
  }
}

const fetchCountries = async () => {
  try {
    const response = await axiosInstance.get("/countries");
    countries.value = response.data;
    console.log("Fetched countries Data:", countries.value);
  } catch (error) {
    errorMessage.value = "Failed to fetch countries. Please try again.";
    console.error("Error fetching universities:", error);
  }
};

onMounted(() => {
  setMaterialInput();
  fetchCountries();
});
</script>

<template>
  <BaseLayout
    title="Vytvoriť Univerzitu"
    :breadcrumb="[ 
      { label: 'Správca Univerzít', route: '/pages/landing-pages/admin-control-panel/uni-manager' },
      { label: 'Vytvoriť Univerzitu' }
    ]"
  >
    <div class="container">
      <div class="row">
        <div class="col-24 mx-auto">
          <div class="row">
            <div class="col-lg-7 col-md-7 z-index-2 position-relative px-md-2 px-sm-5 mx-auto">
              <div class="row mt-4 mb-5 p-3 rounded shadow-sm bg-container">
                
                <div class="mb-3">
                  <MaterialInput
                    id="uni-title"
                    class="input-group-static mt-2"
                    label="NÁZOV UNIVERZITY"
                    type="text"
                    placeholder="Názov Univerzity"
                    v-model="universityName"
                  />
                </div>

                <div class="mb-3">
                  <MaterialInput
                    id="uni-code"
                    class="input-group-static mt-2"
                    label="SKRÁTENÝ NÁZOV UNIVERZITY"
                    type="text"
                    placeholder="Skratka Univerzity"
                    v-model="universityCode"
                  />
                </div>

                <div class="mb-3">
                  <label for="country" class="form-label" style="color: #4CAF50;">KRAJINA UNIVERZITY</label>
                  <select
                    id="country"
                    class="form-select"
                    style="box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.05);"
                    v-model="selectedCountry"
                  >
                    <option value="" disabled selected>Vyberte krajinu</option>
                    <option v-for="country in countries" :key="country.idcountry" :value="country.idcountry">
                      {{ country.name }}
                    </option>
                  </select>
                </div>

                <div class="d-flex justify-content-center mt-3">
                  <button class="btn btn-success" @click="handleSubmit">
                    Vytvoriť Univerzitu
                  </button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </BaseLayout>
</template>

<style scoped>
.bg-container {
  background-color: rgba(253, 253, 253, 0.89);
  border-radius: 15px;
  padding: 20px;
}

.form-select {
  box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.05);
}

.form-control {
  box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.05);
}

.gap-2 > * {
  margin-right: 8px;
}

.gap-2 > *:last-child {
  margin-right: 0;
}
</style>
