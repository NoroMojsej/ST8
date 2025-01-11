<script setup>
import { ref, onMounted, computed } from "vue";
import { useRoute } from 'vue-router';
import BaseLayout from "@/layouts/sections/components/BaseLayout.vue";
import MaterialInput from "@/components/MaterialInput.vue";
import MaterialButton from "@/components/MaterialButton.vue";
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
  if (route.params.idEssay) {
    essayID.value = route.params.idEssay;
    selectedConference.value = route.params.idConference;
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
    console.log(essayData.value);
    name.value = essayData.value.paper.name;
    abstract_lang1.value = essayData.value.paper.abstract_lang1;
    abstract_lang2.value = essayData.value.paper.abstract_lang2;
    keywords_lang1.value = essayData.value.paper.keywords_lang1;
    keywords_lang2.value = essayData.value.paper.keywords_lang2;
    selectedSection.value = essayData.value.paper.section_idsection;
    const response_conference = await axiosInstance.get(`/conferences/${essayData.value.paper.conference_idconference}`);
    console.log(response_conference.data);
    closeDate.value = new Date(response_conference.data.submissions_to);
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

const isAfterCloseDate = computed(() => new Date() > closeDate.value);
const isUploadAllowed = computed(() => !isAfterCloseDate.value);

const formattedCloseDate = computed(() => {
  const options = {
    weekday: "long",
    year: "numeric",
    month: "long",
    day: "numeric",
    hour: "2-digit",
    minute: "2-digit",
    hour12: false,
  };
  return closeDate.value
    ? closeDate.value.toLocaleString("sk-SK", options)
    : new Date("2024-12-20T23:59:00").toLocaleString("sk-SK", options);
});

function handleFileChange(event) {
  const files = Array.from(event.target.files);

  if (files.length !== 2) {
    errorMessage.value = "Prosím nahrajte presne 2 súbory.";
    uploadedFiles.value = [];
    return;
  }

  const validExtensions = ["application/pdf", "application/vnd.openxmlformats-officedocument.wordprocessingml.document"];
  const isValid = files.every((file) => validExtensions.includes(file.type));

  if (!isValid) {
    errorMessage.value = "Iba súbory PDF a DOCX sú povolené.";
    uploadedFiles.value = [];
    return;
  }

  uploadedFiles.value = files;
  errorMessage.value = "";
}

async function handleSubmit() {
  errorMessage.value = "";
  successMessage.value = "";

  if (!isUploadAllowed.value) {
    errorMessage.value = "Nahrávanie nie je povolené. Skontrolujte čas uzávierky.";
    return;
  }

  if (!name.value || !selectedSection.value) {
    errorMessage.value = "Prosím vyplňte všetky povinné polia.";
    console.log("Error: Missing required fields");
    return;
  }

  const data = new FormData();
  data.append("name", name.value);
  data.append("abstract_lang1", abstract_lang1.value);
  data.append("abstract_lang2", abstract_lang2.value);
  data.append("keywords_lang1", keywords_lang1.value);
  data.append("keywords_lang2", keywords_lang2.value);
  data.append("section_id", selectedSection.value);
  data.append("conference_id", selectedConference.value);

  const fileInput = document.querySelector("#file-upload");
  const files = fileInput?.files;

  console.log("Files selected:", files); // Debugging

  for (const [key, value] of data.entries()) {
    console.log(`${key}:`, value);
  }

  if (files && files.length === 2) {
    console.log("Files to upload:", files);

    Array.from(files).forEach((file) => {
      console.log("Appending file:", file.name); // Debugging
      data.append("files[]", file);
    });
  } else {
    errorMessage.value = "Prosím nahrajte presne 2 súbory.";
    console.log("Error: Uploaded files are not exactly 2. Files found:", files ? files.length : 0);
    return;
  }

  try {
    console.log("Sending request to server...");
    const token = JSON.parse(localStorage.getItem('auth_token'));
    const session = JSON.parse(localStorage.getItem('session'));
    if(!token)
      console.error("No token found.");

    const response = await axiosInstance.post(`/update-paper/${essayID.value}/${session?.user_id}`, data, {
      headers: {
      "Content-Type": "multipart/form-data",
      },      
    });

    successMessage.value = response.data.message;
    console.log("Response:", response.data);
  } catch (error) {
    errorMessage.value = error.response?.data?.message || "Chyba pri odosielaní formuláru.";
    console.error("Error while submitting form:", error);
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

              <div class="file-upload-section mt-4 p-4 rounded shadow-sm bg-white text-center">
                <label for="file-upload" class="form-label d-block mb-3">Nahrajte 2 súbory (PDF a DOCX)</label>
                <p class="text-danger">
                  Termín odovzdania: {{ formattedCloseDate }}
                </p>

                <input
                  type="file"
                  id="file-upload"
                  class="form-control-file"
                  multiple
                  accept=".pdf,.docx"
                  @change="handleFileChange"
                />

                <div v-if="uploadedFiles.length" class="uploaded-files mt-3">
                  <ul class="list-unstyled">
                    <li v-for="file in uploadedFiles" :key="file.name" class="d-flex align-items-center mb-2">
                      <i class="bi bi-file-earmark me-2 text-primary"></i>
                      <span>{{ file.name }}</span>
                    </li>
                  </ul>
                </div>
              </div>

              <div class="col-md-12 text-center">
                <MaterialButton
                  id="save-essay"
                  variant="outline"
                  color="success"
                  class="w-35 me-2 mt-3 mb-0 btn"
                  @click="handleSubmit"
                >
                  UPRAVIŤ PRÁCU
                </MaterialButton>
              <p class="text-danger mt-3" v-if="errorMessage">{{ errorMessage }}</p>
              <p class="text-success mt-3" v-if="successMessage">{{ successMessage }}</p>
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