<script setup>
import { onMounted, ref, computed } from "vue";
import BaseLayout from "@/layouts/sections/components/BaseLayout.vue";
import ListCard from "./components/ListCard.vue";
import axiosInstance from '@/axios';
import { useRoute } from "vue-router";



onMounted(() => {
  fetchEssaysByConference();
});

const route = useRoute();
const conferenceId = route.params.id;
console.log("Conference ID:", conferenceId);
const input = ref("");
const essays = ref([]);


const fetchEssaysByConference = async (conferenceId) => {
  try {
    const response = await axiosInstance.get(`/conferences/${conferenceId}/essays`);
    essays.value = response.data;
  } catch (error) {
    console.error('Error fetching essays:', error);
  }
};

const filteredEssays = computed(() => {
  return essays.filter(essay =>
    essay.essay.toLowerCase().includes(input.value.toLowerCase())
  );
});

function handleDownload(id) {
  //tu bude logika pre stiahnutie konrétnej práce
}

function allDownload() {
  //tu bude logika pre stiahnutie všetkých prác
}
function acceptedDownload() {
  //tu bude logika pre stiahnutie schválených prác
}
function rejectedDownload() {
  //tu bude logika pre stiahnutie neschválených prác
}
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
      @click="allDownload" 
      class="btn btn-info ms-2"
    >
      Stiahnuť Všetky
    </button>
    <button 
      @click="acceptedDownload" 
      class="btn btn-success ms-2"
    >
      Stiahnuť Schválené
    </button>
    <button 
      @click="rejectedDownload" 
      class="btn btn-danger ms-2"
    >
      Stiahnuť Neschválené
    </button>
  </div>
</div>


    <div class="container mb-4">
      <div
        v-for="(essay, idessay) in essays"
        :key="idessay"
      >
      <div class="col-12">
    <div v-for="essay in essays" :key="essay.idessay" class="d-flex align-items-center">
      <div class="flex-grow-1">
        <ListCard
          class="px-lg-1 mt-lg-0 mt-4 p-4"
          height="h-100"
          :icon="{ component: 'receipt_long', color: 'success' }"
          :title="essay.essay"
          :description="essay.info"
          :handleEdit="() => handleDownload(essay.idessay)"
          :buttonText="'Stiahnuť'"
        />
      </div>
    </div>
  </div>
      </div>
    </div>
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
