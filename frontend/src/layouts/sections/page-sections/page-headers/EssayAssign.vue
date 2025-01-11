<script setup>
import { ref, onMounted, computed } from "vue";
import axiosInstance from '@/axios';
import { useRoute } from "vue-router";

import BaseLayout from "@/layouts/sections/components/BaseLayout.vue";
import setMaterialInput from "@/assets/js/material-input";

const route = useRoute();
const entries = ref([{ essay: null }]);
const conferences = ref([]);
const sections = ref([]);
const essays = ref([]);
const userId = ref(null);
const selectedConference = ref(null);
const selectedSection = ref(null);

const successMessage = ref('');
const errorMessage = ref('');

onMounted(() => {
  console.log(route.params);
  userId.value = route.params.id;
  console.log('User ID:', userId);
  setMaterialInput();
  fetchConference();
});

async function fetchConference() {
  try {
    const response = await axiosInstance.get(`/conferences/active`);
    conferences.value = response.data.map(conference => ({
      idconference: conference.idconference,
      abbreviation: conference.abbreviation
    }));
  } catch (err) {
    console.error('Chyba pri načítaní údajov:', err);
  }
}

async function fetchEssays() {
  try {
    const response = await axiosInstance.get(`/papers/available/${selectedSection.value.idsection}`);
    essays.value = response.data;
    entries.value = [{ essay: null }];
  } catch (err) {
    console.error('Chyba pri načítaní údajov:', err);
  }
}

const addRow = () => {
  entries.value.push({ essay: null });
};

function filteredEssays(entry) {
  return essays.value.filter(essay => {
    return !entries.value.some(e => e.essay && e.essay.idpaper === essay.idpaper) || entry.essay?.idpaper === essay.idpaper;
  });
}

const canAddRow = computed(() => {
  const remainingEssays = essays.value.filter(essay => !entries.value.some(e => e.essay && e.essay.idpaper === essay.idpaper));
  const allSelected = entries.value.every(entry => entry.essay && entry.essay.idpaper !== null);
  return remainingEssays.length > 0 && allSelected;
});

const removeRow = (index) => {
  entries.value.splice(index, 1);
};

async function saveEssaysForReviewer() {
  const essayIds = entries.value.map(entry => entry.essay.idpaper);

  try {
    const response = await axiosInstance.post(`/papers/assign/${userId.value}`, {
      essayIds: essayIds,
    });

    successMessage.value = 'Eseje boli úspešne uložené!';

    setTimeout(() => {
      successMessage.value = '';
    }, 3000);

    entries.value = [{ essay: null }];
    conferences.value = [];
    sections.value = [];
    essays.value = [];
    selectedConference.value = null;
    selectedSection.value = null;

    fetchConference();

  } catch (error) {
    errorMessage.value = 'Pri ukladaní došlo k chybe.';
    setTimeout(() => {
      errorMessage.value = '';
    }, 3000);
    console.error('Chyba pri odosielaní:', error);
  }
}

const fetchSections = async (event) => {
  if (selectedConference.value) {
    try {
      const response = await axiosInstance.get(`/sections/${selectedConference.value}`);
      sections.value = response.data;
      selectedSection.value = null;
      entries.value = [{ essay: null }];
    } catch (err) {
      console.error('Chyba pri načítaní údajov:', err);
    }

  } else {
    console.log("No conference selected");
  }
};

</script>

<template>
  <BaseLayout title="Priradiť Práce" :breadcrumb="[
    { label: 'Správca Používateľov', route: '/pages/landing-pages/admin-control-panel/users-list' },
    { label: 'Priradiť Práce' }
  ]">
    <div class="container">
      <div class="row">
        <div class="col-24 mx-auto">
          <div class="row">
            <div class="col-lg-7 col-md-7 z-index-2 position-relative px-md-2 px-sm-5 mx-auto">
              <div class="row mt-4 mb-5 p-3 rounded shadow-sm bg-container">

                <table class="table">
                  <thead>
                    <tr class="tr">
                      <th scope="col"></th>
                      <th scope="col">
                        <div class="d-flex justify-content-center font">Práce</div>
                      </th>
                      <th scope="col">
                        <div class="d-flex justify-content-center"></div>
                      </th>
                    </tr>
                  </thead>
                  <tbody>

                    <!--KONFERENCIA ZAC-->

                    <tr>
                      <td></td>
                      <td>
                        <select class="form-select" style="box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.05);"
                          @change="fetchSections" v-model="selectedConference">
                          <option value=null disabled selected>Vyberte Konferenciu</option>
                          <option v-for="conference in conferences" :key="conference.idconference"
                            :value="conference.idconference">
                            {{ conference.abbreviation }}
                          </option>
                        </select>
                      </td>
                    </tr>

                    <!--KONFERENCIA KON-->

                    <!--SEKCIA ZAC-->

                    <tr>
                      <td></td>
                      <td>
                        <select class="form-select" style="box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.05);"
                          v-model="selectedSection" @change="fetchEssays">
                          <option value=null disabled selected>Vyberte Sekciu</option>
                          <option v-for="section in sections" :key="section.idsection" :value="section">
                            {{ section.text }}
                          </option>
                        </select>
                      </td>
                    </tr>

                    <!--SEKCIA KON-->

                    <!--ESEJ ZAC-->

                    <tr v-for="(entry, index) in entries" :key="index">
                      <td></td>
                      <td>
                        <select v-model="entry.essay" class="form-select"
                          style="box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.05);">
                          <option value=null disabled selected>Vyberte Prácu</option>
                          <option v-for="essay in filteredEssays(entry)" :key="essay.idpaper" :value="essay">
                            {{ essay.name }}
                          </option>
                        </select>
                      </td>
                      <td class="d-flex justify-content-end">
                        <button class="btn btn-danger" @click="removeRow(index)">Odstrániť</button>
                      </td>
                    </tr>

                    <!--ESEJ KON-->

                  </tbody>
                </table>

                <div class="d-flex justify-content-center">
                  <button class="btn btn-success" @click="addRow" :disabled="!canAddRow">
                    Pridať Prácu
                  </button>
                </div>
                <div class="d-flex justify-content-center mt-3">
                  <button @click="saveEssaysForReviewer()" class="btn btn-success"
                    :disabled="!selectedConference || !selectedSection || entries.length === 0 || entries[0].essay === null">
                    Uložiť
                  </button>
                  <p v-if="successMessage" class="text-success mt-2">{{ successMessage }}</p>
                  <p v-if="errorMessage" class="text-danger mt-2">{{ errorMessage }}</p>
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

.gap-2>* {
  margin-right: 8px;
}

.gap-2>*:last-child {
  margin-right: 0;
}
</style>
