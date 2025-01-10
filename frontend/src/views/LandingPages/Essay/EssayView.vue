<script setup>
import { ref, onMounted } from "vue";
import BaseLayout from "@/layouts/sections/components/BaseLayout.vue";
import MaterialInput from "@/components/MaterialInput.vue";
import MaterialButton from "@/components/MaterialButton.vue";
import { useRoute } from "vue-router";
import axiosInstance from '@/axios'; 

const formData = ref({
  name: "",
  abstract_lang1: "",
  abstract_lang2: "",
  keywords_lang1: "",
  keywords_lang2: "",
  section_id: "",
});

const route = useRoute();
const uploadedFiles = ref([]);
const errorMessage = ref("");
const successMessage = ref("");
const conferenceId = ref(null);
const sections = ref([]);

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

  if (!formData.value.name || !formData.value.section_id) {
    errorMessage.value = "Prosím vyplňte všetky povinné polia.";
    console.log("Error: Missing required fields");
    return;
  }

  const data = new FormData();
  data.append("name", formData.value.name);
  data.append("abstract_lang1", formData.value.abstract_lang1);
  data.append("abstract_lang2", formData.value.abstract_lang2);
  data.append("keywords_lang1", formData.value.keywords_lang1);
  data.append("keywords_lang2", formData.value.keywords_lang2);
  data.append("section_id", formData.value.section_id);
  data.append("conference_id", conferenceId.value);

  const fileInput = document.querySelector("#file-upload");
  const files = fileInput?.files;

  console.log("Files selected:", files); // Debugging

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
    const token = JSON.parse(localStorage.getItem('auth_token')); // Get the token from localStorage
    const session = JSON.parse(localStorage.getItem('session'));
    if(!token)
      console.error("No token found.");

    const response = await axiosInstance.post(`/upload-paper/${session?.user_id}`, data, {
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

import setMaterialInput from "@/assets/js/material-input";

async function fetchSections() {
  try {
    console.log("ConfId: ", conferenceId.value);
    const response = await axiosInstance.get(`/sections/${conferenceId.value}`);
    sections.value = response.data;
    console.log("Found sections: ", sections.value);    
  } catch (error) {
    console.error('Chyba pri načítaní sekcií:', error);
  }
}

onMounted(() => {
  setMaterialInput();
  conferenceId.value = route.params.id;
  fetchSections();
});
</script>

<template>
  <BaseLayout
    title="Nahranie Práce"
    :breadcrumb="[ { label: 'Domov', route: '/' }, { label: 'Nahranie Práce' } ]"
  >
    <div class="descriptive-div1">
      <div class="descriptive-div2">
        V tomto formulári môžete nahrať svoju vytvorenú prácu.
        Po vyplnení formuláru nahrajte 2 súbory - PDF a dokument Word.
        <br /><br />
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
                  <MaterialInput
                    id="essay-title"
                    class="input-group-static mt-2"
                    label="NÁZOV PRÁCE"
                    type="text"
                    placeholder="Názov Práce"
                    v-model="formData.name"
                  />
                </div>
                <div class="mb-3">
                  <label for="textarea2" class="form-label" style="color: #4caf50;">ABSTRAKT ENG</label>
                  <textarea
                    id="textarea2"
                    class="form-control"
                    style="box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.05);"
                    rows="4"
                    placeholder="Abstract..."
                    v-model="formData.abstract_lang1"
                  ></textarea>
                  <br />
                  <label for="textarea3" class="form-label" style="color: #4caf50;">ABSTRAKT SVK</label>
                  <textarea
                    id="textarea3"
                    class="form-control"
                    style="box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.05);"
                    rows="4"
                    placeholder="Abstrakt..."
                    v-model="formData.abstract_lang2"
                  ></textarea>
                </div>
                <div class="mb-3">
                  <MaterialInput
                    id="keywords-eng"
                    class="input-group-static mt-2"
                    label="KEYWORDS"
                    type="text"
                    placeholder="Keywords"
                    v-model="formData.keywords_lang1"
                  />
                  <MaterialInput
                    id="keywords-svk"
                    class="input-group-static mt-2"
                    label="KĽÚČOVÉ SLOVÁ"
                    type="text"
                    placeholder="Kľúčové Slová"
                    v-model="formData.keywords_lang2"
                  />
                </div>
                <div class="mb-3">
                  <br />
                  <label for="category" class="form-label" style="color: #4caf50;">SEKCIA PRÁCE</label>
                  <select
                    id="category"
                    class="form-select"
                    aria-label="Category"
                    v-model="formData.section_id"
                  >
                    <option selected disabled>Vyberte sekciu</option>
                    <option v-for="section in sections" :key="section.idsection" :value="section.idsection">
                      {{ section.text }}
                    </option>
                  </select>
                </div>
              </div>

              <div class="file-upload-section mt-4 p-4 rounded shadow-sm bg-white text-center">
                <label for="file-upload" class="form-label d-block mb-3">Nahrajte 2 súbory (PDF a DOCX)</label>

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
                  PRIDAŤ PRÁCU
                </MaterialButton>
              </div>
              <p class="text-danger mt-3" v-if="errorMessage">{{ errorMessage }}</p>
              <p class="text-success mt-3" v-if="successMessage">{{ successMessage }}</p>
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

  .file-upload-section {
    border: 2px dashed #a9afb4;
  }

  .uploaded-files i {
    font-size: 1.2rem;
  }
</style>
