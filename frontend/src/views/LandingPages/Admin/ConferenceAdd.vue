<script setup>
import { ref, watch, onMounted, computed } from "vue";
import { useRouter } from "vue-router";

// Sections
import BaseLayout from "@/layouts/sections/components/BaseLayout.vue";
import MaterialInput from "@/components/MaterialInput.vue";
import axiosInstance from '@/axios';

// Hooks
import setMaterialInput from "@/assets/js/material-input";

const router = useRouter();

const countries = ref([]);
const selectedCountry = ref("");
const universities = ref([]);
const selectedUniversity = ref("");
const description = ref("");
const submissionFrom = ref("");
const submissionTo = ref("");
const conferenceFrom = ref("");
const conferenceTo = ref("");
const sections = ref([]);
const entriesForSections = ref([
  { idSection: "" }
]);

const conferenceTitle = ref("");

onMounted(() => {
  setMaterialInput();
  fetchCountries();
  fetchSections();
});



//PRIDÁVANIE SEKCIÍ + SLEDOVANIE ICH DOSTUPNOSTI
const addRow = () => {
  if (availableSectionsCount.value > entriesForSections.value.length) {
    entriesForSections.value.push({ idSection: "" }); // Pridáme riadok, ak sú k dispozícii voľné sekcie
  }
};

// Počet dostupných sekcií
const availableSectionsCount = computed(() => sections.value.length);

// Kontrola, či je možné pridať ďalšiu sekciu
const canAddSection = computed(() => {
  return entriesForSections.value.length < availableSectionsCount.value;
});

const getAvailableSections = (index) => {
  const selectedSections = entriesForSections.value.map(entry => entry.idSection);
  // Filtrovanie sekcií na základe už vybraných sekcií v entriesForSections
  return sections.value.filter(section => !selectedSections.includes(section.idsection) || section.idsection === entriesForSections.value[index].idSection);
};


//WATCHERY
watch(selectedUniversity, async (newUniversity) => {
  if (newUniversity) {
    console.log("UNIVERZITA " + newUniversity);
  }
});

watch(selectedCountry, async (newCountry) => {
  if (newCountry) {
    console.log("KRAJINA " + newCountry);
    universities.value = [];
    selectedUniversity.value = "";
    await fetchUniversities();
  }
});

watch([submissionFrom, submissionTo], ([newFrom, newTo]) => {
  const submissionFromDate = newFrom ? new Date(newFrom) : null;
  const submissionToDate = newTo ? new Date(newTo) : null;
  const conferenceFromDate = conferenceFrom.value ? new Date(conferenceFrom.value) : null;
  const conferenceToDate = conferenceTo.value ? new Date(conferenceTo.value) : null;


  if (submissionFromDate && submissionToDate && submissionFromDate > submissionToDate) {
    console.error("Submission 'from' date cannot be after submission 'to' date.");
  }


  if (conferenceFromDate && conferenceToDate) {
    if (submissionFromDate && submissionFromDate < conferenceFromDate) {
      console.error("Submission 'from' date must be on or after the conference 'from' date.");
    }
    if (submissionToDate && submissionToDate > conferenceToDate) {
      console.error("Submission 'to' date must be on or before the conference 'to' date.");
    }
  } else {
    console.error("Conference dates are not set correctly.");
  }
});

watch([conferenceFrom, conferenceTo], ([newFrom, newTo]) => {
  const conferenceFromDate = newFrom ? new Date(newFrom) : null;
  const conferenceToDate = newTo ? new Date(newTo) : null;
  const submissionFromDate = submissionFrom.value ? new Date(submissionFrom.value) : null;
  const submissionToDate = submissionTo.value ? new Date(submissionTo.value) : null;


  if (conferenceFromDate && conferenceToDate && conferenceFromDate > conferenceToDate) {
    console.error("Conference 'from' date cannot be after conference 'to' date.");
  }


  if (submissionFromDate && conferenceFromDate && submissionFromDate < conferenceFromDate) {
    console.error("Submission 'from' date must be on or after the conference 'from' date.");
  }
  if (submissionToDate && conferenceToDate && submissionToDate > conferenceToDate) {
    console.error("Submission 'to' date must be on or before the conference 'to' date.");
  }
});


const fetchCountries = async () => {
  try {
    const response = await axiosInstance.get('/countries');
    countries.value = response.data;

  } catch (error) {
    console.error('Error fetching countries:', error.message);
  }
};


const fetchUniversities = async () => {
  if (!selectedCountry.value) return;

  try {
    const response = await axiosInstance.get(`/universities/${selectedCountry.value}`);
    universities.value = response.data;
  } catch (error) {
    console.error("Failed to fetch universities:", error);
  }
};

const fetchSections = async () => {
  try {
    const response = await axiosInstance.get('/sections');
    sections.value = response.data;
    console.log("SEKCIE " + response)
  } catch (error) {
    console.error("Error fetching sections:", error);
  }
};

async function createConference() {
  try {
    console.log(entriesForSections.value.map(entry => entry.idSection));
    console.log("sub " + submissionFrom.value)
    const response = await axiosInstance.post('/createConf', {
      title: conferenceTitle.value,
      country: selectedCountry.value,
      university: selectedUniversity.value,
      description: description.value,
      submissionFrom: submissionFrom.value,
      submissionTo: submissionTo.value,
      conferenceFrom: conferenceFrom.value,
      conferenceTo: conferenceTo.value,
      sections: entriesForSections.value.map(entry => entry.idSection),
    });

    router.push({ name: 'conferenceman' });

  } catch (error) {
    console.error(error.message);
  }
}

</script>

<template>
  <BaseLayout title="Vytvoriť Konferenciu" :breadcrumb="[
    { label: 'Správa Konferencií', route: '/pages/landing-pages/admin-control-panel/conference-manager' },
    { label: 'Vytvoriť Konferenciu' }
  ]">
    <div class="container">
      <div class="row">
        <div class="col-24 mx-auto">
          <div class="row">
            <div class="col-lg-7 col-md-7 z-index-2 position-relative px-md-2 px-sm-5 mx-auto">
              <div class="row mt-4 mb-5 p-3 rounded shadow-sm bg-container">

                <div class="mb-3">
                  <MaterialInput id="conference-title" class="input-group-static mt-2" label="NÁZOV KONFERENCIE"
                    type="name" placeholder="Názov Konferencie" v-model="conferenceTitle" />
                </div>

                <div class="mb-3">
                  <label for="country" class="form-label" style="color: #4CAF50;">Krajina Konferencie</label>
                  <select id="country" class="form-select" style="box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.05);"
                    v-model="selectedCountry">
                    <option value="" disabled selected>Vyberte krajinu</option>
                    <option v-for="country in countries" :key="country.idcountry" :value="country.idcountry">
                      {{ country.name }}
                    </option>
                  </select>
                </div>

                <div class="mb-3">
                  <label for="university" class="form-label" style="color: #4CAF50;">Organizuje Univerzita</label>
                  <select id="university" class="form-select" style="box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.05);"
                    v-model="selectedUniversity">
                    <option v-for="university in universities" :key="university.iduniversity"
                      :value="university.iduniversity">
                      {{ university.name }}
                    </option>
                  </select>
                </div>

                <div class="mb-3">
                  <label for="description" class="form-label" style="color: #4CAF50;">POPIS</label>
                  <textarea id="description" class="form-control" style="box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.05);"
                    rows="4" placeholder="Popis konferencie..." v-model="description"></textarea>
                </div>

                <div class="mb-3">
                  <label for="submission-dates" class="form-label" style="color: #4CAF50;">TERMÍNY NAHRANIA PRÁC</label>
                  <div class="d-flex gap-2">
                    <input id="submission-from" type="date" class="form-control" placeholder="Od"
                      v-model="submissionFrom" />
                    <input id="submission-to" type="date" class="form-control" placeholder="Do"
                      v-model="submissionTo" />
                  </div>
                </div>

                <div class="mb-3">
                  <label for="conference-dates" class="form-label" style="color: #4CAF50;">DÁTUM KONANIA
                    KONFERENCIE</label>
                  <div class="d-flex gap-2">
                    <input id="take-place-from" type="date" class="form-control" placeholder="Od"
                      v-model="conferenceFrom" />
                    <input id="take-place-to" type="date" class="form-control" placeholder="Do"
                      v-model="conferenceTo" />
                  </div>
                </div>

                <table class="table">
                  <thead>
                    <tr class="tr">
                      <th scope="col"></th>
                      <th scope="col">
                        <div class="d-flex justify-content-center font">Sekcie Konferencie</div>
                      </th>
                      <th scope="col">
                        <div class="d-flex justify-content-center"></div>
                      </th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="(entry, index) in entriesForSections" :key="index">
                      <td></td>
                      <td>
                        <select v-model="entry.idSection" class="form-select"
                          style="box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.05);">
                          <option value="" disabled selected>Vyberte sekciu</option>
                          <option v-for="section in getAvailableSections(index)" :key="section.idsection"
                            :value="section.idsection">
                            {{ section.text }}
                          </option>
                        </select>
                      </td>
                      <td class="d-flex justify-content-end">
                        <button class="btn btn-danger" @click="entriesForSections.splice(index, 1)">Odstrániť</button>
                      </td>
                    </tr>
                  </tbody>
                </table>

                <div class="d-flex justify-content-center">
                  <button class="btn btn-success" @click="addRow" :disabled="!canAddSection">
                    Pridať sekciu
                  </button>
                </div>

                <div class="d-flex justify-content-center mt-3">
                  <button @click="createConference" class="btn btn-success">
                    Vytvoriť Konferenciu
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

.gap-2>* {
  margin-right: 8px;
}

.gap-2>*:last-child {
  margin-right: 0;
}
</style>
