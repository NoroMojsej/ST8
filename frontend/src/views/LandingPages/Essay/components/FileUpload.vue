<script setup>
  import { ref, computed } from "vue";
  import MaterialButton from "@/components/MaterialButton.vue";

  const uploadedFiles = ref([]);
  const errorMessage = ref("");
  const fileInputRef = ref(null);

  // premenná s dátumom odovzdania. Bude sa vkladať z databázy
  const closeDate = new Date("2024-12-20T23:59:00");

  // Kontrola či je možné odovzdať prácu
  const isAfterCloseDate = computed(() => new Date() > closeDate);
  const isUploadAllowed = computed(() => !isAfterCloseDate.value);

  const formattedCloseDate = computed(() => {
    const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric', hour: '2-digit', minute: '2-digit', hour12: false };
    return closeDate.toLocaleString('sk-SK', options);
  });

  function handleFileUpload(event) {
    const files = Array.from(event.target.files);

    if (!isUploadAllowed.value) {
      errorMessage.value = "Nahrávanie nie je povolené. Skontrolujte čas uzávierky.";
      return;
    }

    if (files.length !== 2) {
      errorMessage.value = "Prosím nahrajte 2 súbory.";
      uploadedFiles.value = [];
      return;
    }

    const isValid = files.every(file =>
      ["application/pdf", "application/vnd.openxmlformats-officedocument.wordprocessingml.document"].includes(file.type)
    );

    if (!isValid) {
      errorMessage.value = "Len PDF a DOCX súbory sú povolené.";
      uploadedFiles.value = [];
      return;
    }

    errorMessage.value = "";
    uploadedFiles.value = files;
  }

  function triggerFileInput() {
    if (isUploadAllowed.value && fileInputRef.value) {
      fileInputRef.value.click();
    }
  }
</script>

<template>
  <div class="file-upload-section mt-4 p-4 rounded shadow-sm bg-white text-center">
    <label class="form-label d-block mb-3">Nahrajte súbory práce (PDF a DOCX)</label>
    
    <p class="text-danger">
      Termín odovzdania: {{ formattedCloseDate }}
    </p>

    <input 
      type="file" 
      class="d-none" 
      ref="fileInputRef"   
      multiple 
      accept=".pdf,.docx" 
      @change="handleFileUpload"
    />
    
    <MaterialButton 
      @click="triggerFileInput" 
      :disabled="!isUploadAllowed" 
      variant="outline" 
      color="success" 
      class="w-35 me-2 mt-3 mb-0 btn"
    >
      Vybrať Súbory
    </MaterialButton>
    
    <p class="text-danger mt-2" v-if="errorMessage">{{ errorMessage }}</p>
    
    <div class="uploaded-files mt-3" v-if="uploadedFiles.length">
      <ul class="list-unstyled">
        <li v-for="file in uploadedFiles" :key="file.name" class="d-flex align-items-center mb-2">
          <i class="bi bi-file-earmark me-2 text-primary"></i>
          <span>{{ file.name }}</span>
        </li>
      </ul>
    </div>
  </div>
</template>

<style scoped>
.file-upload-section {
  border: 2px dashed #a9afb4;
}

.uploaded-files i {
  font-size: 1.2rem;
}
</style>
