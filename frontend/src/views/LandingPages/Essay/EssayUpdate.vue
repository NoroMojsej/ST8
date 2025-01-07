<script setup>
import { ref, onMounted } from "vue";
import { useRoute } from 'vue-router';
import BaseLayout from "@/layouts/sections/components/BaseLayout.vue";
import MaterialInput from "@/components/MaterialInput.vue";
import MaterialButton from "@/components/MaterialButton.vue";
import FileUpload from "@/views/LandingPages/Essay/components/FileUpload.vue";
import axiosInstance from '@/axios';

const route = useRoute();
const essayID = ref(null);
const essayData = ref({});
const errorMessage = ref(null);
const successMessage = ref(null);
const selectedConference = ref("");
const sections = ref("");
const closeDate = ref(new Date("2035-12-20T23:59:00"));

const name = ref("");
const abstract_lang1 = ref("");
const abstract_lang2 = ref("");
const keywords_lang1 = ref("");
const keywords_lang2 = ref("");
const selectedSection = ref("");

const uploadedFiles = ref([]);

onMounted(() => {
  if (route.params.id) {
    essayID.value = route.params.id;
    selectedConference.value = 12;
    fetchEssayData(essayID.value);
    fetchSections(selectedConference.value);
  } else {
    console.error('No ID found in route parameters.');
  }
});

async function fetchEssayData(idEssay) {
  errorMessage.value = null;

  try {
    console.log("idsay" + idEssay);
    const response = await axiosInstance.get(`/papers/${idEssay}`);
    essayData.value = response.data;
    name.value = essayData.value.name;
    abstract_lang1.value = essayData.value.abstract_lang1;
    abstract_lang2.value = essayData.value.abstract_lang2;
    keywords_lang1.value = essayData.value.keywords_lang1;
    keywords_lang2.value = essayData.value.keywords_lang2;
    selectedSection.value = essayData.value.section.idsection;
    closeDate.value = essayData.value.conference.submissions_to;
    console.log("CLOSE DATA:", closeDate.value);
  } catch (err) {
    console.error('Chyba pri načítaní údajov:', err);
    errorMessage.value = 'Nepodarilo sa načítať údaje eseje.';
  }
}

async function fetchSections(idConference) {
  errorMessage.value = null;

  try {
    const response = await axiosInstance.get(`/sections/${idConference}`);
    sections.value = response.data;
  } catch (err) {
    console.error('Chyba pri načítaní údajov:', err);
    errorMessage.value = 'Nepodarilo sa načítať údaje eseje.';
  }
}


async function updateEssay() {
  if (uploadedFiles.value.length !== 2) {
    errorMessage.value = "Prosím nahrajte 2 súbory.";
    successMessage.value = '';
    return;
  }

  try {
    const essayData = {
      name: name.value,
      abstract_lang1: abstract_lang1.value,
      abstract_lang2: abstract_lang2.value,
      keywords_lang1: keywords_lang1.value,
      keywords_lang2: keywords_lang2.value,
      selectedSection: selectedSection.value,
    };

    const fileData = new FormData();
    uploadedFiles.value.forEach((file, index) => {
      if (file.type === 'application/pdf' || file.type === 'application/vnd.openxmlformats-officedocument.wordprocessingml.document') {
        fileData.append(`file${index + 1}`, file);
      } else {
        errorMessage.value = "Iba súbory PDF a DOCX sú povolené.";
        successMessage.value = '';
        return;
      }
    });

    await axiosInstance.put(`/papers/update/${essayID.value}`, essayData);

    await axiosInstance.post(`/papers/update/${essayID.value}/upload-files`, fileData, {
      headers: {
        'Content-Type': 'multipart/form-data',
      },
    });

    successMessage.value = 'Úspešne zmenené';
    errorMessage.value = '';

  } catch (error) {
    console.error('Error during form submission:', error);
    successMessage.value = '';
    errorMessage.value = error.message;
  }
}

</script>

<template>
  <BaseLayout title="Upraviť Prácu" :breadcrumb="[
    { label: 'Moje Práce', route: '/student/home/my-essays' },
    { label: 'Upraviť Prácu' },]">

    <div class="descriptive-div1">
      <div class="descriptive-div2">
        V tomto formulári môžete upraviť svoju vytvorenú prácu.
        Po vyplnení formuláru nahrajte 2 súbory - PDF a dokument Word.
        <br><br>
        <p class="p">DRŽÍME PALCE!</p>
      </div>
    </div>

    <div class="container">
      <div class="row">
        <div class="col-24 mx-auto">

          <div class="row">
            <div class="col-lg-7 col-md-7 z-index-2 position-relative px-md-2 px-sm-5 mx-auto">
              <div class="row mt-4 mb-5 p-3 rounded shadow-sm bg-container">
                <div class="mb-3">
                  <MaterialInput id="essay-title" class="input-group-static mt-2" label="NÁZOV PRÁCE" type="name"
                    placeholder="Názov Práce" v-model="name" />
                </div>
                <div class="mb-3">
                  <label for="textarea2" class="form-label" style="color: #4CAF50;">ABSTRAKT ENG</label>
                  <textarea id="textarea2" class="form-control" style="box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.05);"
                    rows="4" placeholder="Abstract..." v-model="abstract_lang1"></textarea>
                  <br />
                  <label for="textarea3" class="form-label" style="color: #4CAF50;">ABSTRAKT SVK</label>
                  <textarea id="textarea3" class="form-control" style="box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.05);"
                    rows="4" placeholder="Abstrakt..." v-model="abstract_lang2"></textarea>
                </div>
                <div class="mb-3">
                  <MaterialInput id="keywords-eng" class="input-group-static mt-2" label="KEYWORDS" type="name"
                    placeholder="Keywords" v-model="keywords_lang1" />
                  <MaterialInput id="keywords-svk" class="input-group-static mt-2" label="KĽÚČOVÉ SLOVÁ" type="name"
                    placeholder="Kľúčové Slová" v-model="keywords_lang2" />
                </div>
                <div class="mb-3">
                  <br />
                  <label for="category" class="form-label" style="color: #4CAF50;">SEKCIA PRÁCE</label>
                  <select id="category" class="form-select" aria-label="Category" v-model="selectedSection">
                    <option selected disabled>Vyberte sekciu</option>
                    <option v-for="section in sections" :value="section.idsection">
                      {{ section.text }}
                    </option>
                  </select>
                </div>
              </div>

              <FileUpload v-model:uploadedFiles="uploadedFiles" :close-date="closeDate" />
              <!-- nefuknčné, použite štandartný komponent ktorý bol použitý v upravenom essayview -->

              <div class="col-md-12 text-center">
                <MaterialButton id=save-essay variant="outline" color="success" class="w-35 me-2 mt-3 mb-0 btn"
                  @click="updateEssay">UPRAVIŤ PRÁCU
                </MaterialButton>
                <div v-if="errorMessage" class="text-danger mt-2">{{ errorMessage }}</div>
                <div v-if="successMessage" class="text-success mt-2">{{ successMessage }}</div>
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
</style>