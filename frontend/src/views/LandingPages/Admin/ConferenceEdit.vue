<script setup>
import { ref, onMounted, computed } from "vue";
import { useRoute } from "vue-router";
import axiosInstance from '@/axios';
import { useRouter } from "vue-router";
// Sections
import BaseLayout from "@/layouts/sections/components/BaseLayout.vue";
import MaterialInput from "@/components/MaterialInput.vue";

// Hooks
import setMaterialInput from "@/assets/js/material-input";

onMounted(() => {
  setMaterialInput();
  fetchConference();
  fetchCountries();
  fetchUniversities();
  fetchSections();
});

const route = useRoute();
const router = useRouter();
const conferenceId = route.params.id;

const countries = ref([]);
const universities = ref([]);
const title = ref('');
const selectedCountry = ref('');
const selectedUniversity = ref('');
const description = ref('');
const submissionFrom = ref('');
const submissionTo = ref('');
const conferenceFrom = ref('');
const conferenceTo = ref('');

const sections = ref([]);
const allSections = ref([]);
const entriesForSections = ref([
]);

const fetchConference = async () => {
  try {
    const response = await axiosInstance.get(`/conferences/${conferenceId}`);
    title.value = response.data.abbreviation;
    selectedCountry.value = response.data.country_idcountry;
    selectedUniversity.value = response.data.university_iduniversity
    description.value = response.data.description;
    submissionFrom.value = response.data.submissions_from.split(" ")[0];
    submissionTo.value = response.data.submissions_to.split(" ")[0];
    conferenceFrom.value = response.data.take_place_from.split(" ")[0];
    conferenceTo.value = response.data.take_place_to.split(" ")[0];
    sections.value = response.data.sections;

    entriesForSections.value = sections.value.map((section) => ({
      idSection: section.idsection,
    }));

  } catch (error) {
    console.error('Error fetching conference data:', error);
  }
};

const fetchCountries = async () => {
  try {
    const response = await axiosInstance.get('/countries');
    countries.value = response.data;

  } catch (error) {
    console.error('Error fetching countries:', error.message);
  }
};

const fetchUniversities = async () => {
  try {
    const response = await axiosInstance.get('/universities');
    universities.value = response.data;

  } catch (error) {
    console.error('Error fetching countries:', error.message);
  }
};

const fetchSections = async () => {
  try {
    const response = await axiosInstance.get('/sections');

    if (Array.isArray(response.data)) {
      allSections.value = response.data;
    } else {
      console.error("No sections found");
    }
  } catch (error) {
    console.error("Error fetching sections:", error);
  }
};


//PRIDÁVANIE SEKCIÍ + SLEDOVANIE ICH DOSTUPNOSTI
const addRow = () => {
  if (availableSectionsCount.value > entriesForSections.value.length) {
    entriesForSections.value.push({ idSection: "" }); // Pridáme riadok, ak sú k dispozícii voľné sekcie
  }
};

// Počet dostupných sekcií
const availableSectionsCount = computed(() => allSections.value.length);

// Kontrola, či je možné pridať ďalšiu sekciu
const canAddSection = computed(() => {
  return entriesForSections.value.length < availableSectionsCount.value;
});

const getAvailableSections = (index) => {
  const selectedSections = entriesForSections.value.map(entry => entry.idSection);
  // Filtrovanie sekcií na základe už vybraných sekcií v entriesForSections
  return allSections.value.filter(section => !selectedSections.includes(section.idsection) || section.idsection === entriesForSections.value[index].idSection);
};


async function Conference() {
  try {
    const formatDate = (dateString) => {
      const date = new Date(dateString);
      date.setHours(0, 0, 0, 0);
      return date.toISOString().slice(0, 19).replace('T', ' ');
    };

    var submissionFrom2 = formatDate(submissionFrom.value);
    var submissionTo2 = formatDate(submissionTo.value);

    const response = await axiosInstance.put(`/conference/${conferenceId}`, {
      title: title.value,
      country: selectedCountry.value,
      university: selectedUniversity.value,
      description: description.value,
      submissionFrom: submissionFrom2,
      submissionTo: submissionTo2,
      conferenceFrom: conferenceFrom.value,
      conferenceTo: conferenceTo.value,
      sections: entriesForSections.value.map(entry => entry.idSection),
    });

    console.log(response.data);
    router.push({ name: "conferenceman" });
  } catch (error) {
    console.error(error.message);
  }
}

</script>

<template>
  <BaseLayout title="Upraviť Konferenciu" :breadcrumb="[
    { label: 'Správa Konferencií', route: '/pages/landing-pages/admin-control-panel/conference-manager' },
    { label: 'Upraviť Konferenciu' },
  ]">
    <div class="container">
      <div class="row">
        <div class="col-24 mx-auto">
          <div class="row">
            <div class="col-lg-7 col-md-7 z-index-2 position-relative px-md-2 px-sm-5 mx-auto">
              <div class="row mt-4 mb-5 p-3 rounded shadow-sm bg-container">
                <div class="mb-3">
                  <MaterialInput id="conference-title" class="input-group-static mt-2" label="NÁZOV KONFERENCIE"
                    type="text" v-model="title" />
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
                    <option value="" disabled selected>Vyberte univerzitu</option>
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
                  <tbody>
                    <div class="d-flex justify-content-center"> </div>
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
              </div>

              <div class="d-flex justify-content-center">
                <button class="btn btn-success" @click="Conference">
                  Upraviť Konferenciu
                </button>
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
