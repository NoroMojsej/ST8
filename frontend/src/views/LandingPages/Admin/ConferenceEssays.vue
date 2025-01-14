<script setup>
import { onMounted, ref, computed } from "vue";
import BaseLayout from "@/layouts/sections/components/BaseLayout.vue";
import ListCard from "./components/ListCard.vue";
import axiosInstance from '@/axios';
import { useRoute } from "vue-router";

const route = useRoute();
const input = ref("");
const essays = ref([]);

const fetchEssaysByConference = async (conferenceId) => {
  try {
    const response = await axiosInstance.get(`/papers/conference/${conferenceId}`);
    essays.value = response.data;
    console.log(essays.value);
  } catch (error) {
    console.error('Error fetching essays:', error);
  }
};

const filteredEssays = computed(() => {
  if(input.value){
  return essays.filter(essay =>
    essay.essay.toLowerCase().includes(input.value.toLowerCase())
  );
  }
  return essays;
});

async function handleDownload(confid, id) {
  try {
    const response = await axiosInstance.get(`/conferences/${confid}/papers/${id}/download`, {
      responseType: 'blob',
    });
    const blob = response.data;
    const url = window.URL.createObjectURL(blob);
    const a = document.createElement('a');
    a.href = url;
    a.download = `conference_${confid}_paper_${id}_files.zip`;
    document.body.appendChild(a);
    a.click();
    document.body.removeChild(a);    
  } catch (error) {
    console.error("Error downloading files:", error);
  }
}

async function allDownload(id) {
  try {
    console.log("Requesting bulk download...");

    const response = await axiosInstance.get(`/conferences/download-all/${id}`, {
      responseType: 'blob',
    });

    const blob = response.data;
    const url = window.URL.createObjectURL(blob);
    const a = document.createElement('a');
    a.href = url;
    a.download = `conference_${id}_papers.zip`;
    document.body.appendChild(a);
    a.click();
    document.body.removeChild(a);

    console.log("Download started.");
  } catch (error) {
    console.error("Error during bulk download:", error);
  }
}
async function acceptedDownload(id) {
  try {
    console.log("Requesting bulk download of approved papers...");

    const response = await axiosInstance.get(`/conferences/download-approved/${id}`, {
      responseType: 'blob',
    });

    const blob = response.data;
    const url = window.URL.createObjectURL(blob);
    const a = document.createElement('a');
    a.href = url;
    a.download = `conference_${id}_approved_papers.zip`;
    document.body.appendChild(a);
    a.click();
    document.body.removeChild(a);

    console.log("Download started.");
  } catch (error) {
    console.error("Error during bulk download:", error);
  }
}
async function rejectedDownload(id) {
  try {
    console.log("Requesting bulk download of refused papers...");

    const response = await axiosInstance.get(`/conferences/download-refused/${id}`, {
      responseType: 'blob',
    });

    const blob = response.data;
    const url = window.URL.createObjectURL(blob);
    const a = document.createElement('a');
    a.href = url;
    a.download = `conference_${id}_refused_papers.zip`;
    document.body.appendChild(a);
    a.click();
    document.body.removeChild(a);

    console.log("Download started.");
  } catch (error) {
    console.error("Error during bulk download:", error);
  }
}

onMounted(() => {
  const conferenceId = route.params.id;
  console.log("Conference ID:", conferenceId);
  fetchEssaysByConference(conferenceId);
});
</script>

<template>
  <BaseLayout
    title="Odovzdané Práce"
    :breadcrumb="[
      { label: 'Správa Konferencií', route: '/pages/landing-pages/admin-control-panel/conference-manager' },
      { label: 'Odovzdané Práce' },
    ]"
  >
  <div class="row pt-4 pb-4">
  <div class="col-6">
    <div class="row">
      <div class="col fst">
        <input
          class="searchbox"
          type="text"
          v-model="input"
          placeholder="Hľadať prácu"
        />
      </div>
      <div class="col-6 scnd">
        <div class="lupa">
          <i class="bi bi-search icon-color"></i>
        </div>
      </div>
    </div>
  </div>
  <div class="col-6 d-flex justify-content-end align-items-center">
    <button 
      @click="allDownload(route.params.id)" 
      class="btn btn-info ms-2"
    >
      Stiahnuť Všetky
    </button>
    <button 
      @click="acceptedDownload(route.params.id)" 
      class="btn btn-success ms-2"
    >
      Stiahnuť Schválené
    </button>
    <button 
      @click="rejectedDownload(route.params.id)" 
      class="btn btn-danger ms-2"
    >
      Stiahnuť Neschválené
    </button>
  </div>
</div>


    <div class="container mb-4">
      <!--<div
        v-for="(essay, idessay) in essays"
        :key="idessay"
      >
      <div class="col-12">-->
    <div v-for="essay in essays" :key="essay.idpaper" class="d-flex align-items-center">
      <div class="flex-grow-1">
        <ListCard
          class="px-lg-1 mt-lg-0 mt-4 p-4"
          height="h-100"
          :icon="{ component: 'receipt_long', color: 'success' }"
          :title="essay.name"
          :description="essay.keywords_lang2"
          :handleEdit="() => handleDownload(route.params.id, essay.idpaper)"
          :buttonText="'Stiahnuť'"
        />
      </div>
    </div>
  </div>
     <!-- </div>
    </div>-->
  </BaseLayout>
</template>

<style scoped>
.btn {
  margin-bottom: 0px !important;
}

td {
  align-content: center !important;
}

.font {
  font-weight: 500;
  color: white;
}

table {
  border: solid;
  border-width: 0.1cap;
  border-color: #66bb6a;
}

.table thead th {
  border-bottom: #66bb6a !important;
}

.tr {
  background-color: #66bb6a;
}

.searchbox {
  border-top: none;
  border-left: none;
  border-right: none;
  border-bottom: solid;
  border-color: #66bb6a;
  width: 100% !important;
}
</style>
