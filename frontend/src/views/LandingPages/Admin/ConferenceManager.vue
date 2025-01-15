<script setup>
import { ref, onMounted } from 'vue';
import { useRouter } from 'vue-router';
import BaseLayout from "@/layouts/sections/components/BaseLayout.vue";
import ListCard from "./components/ListCard.vue";
import axiosInstance from '@/axios';

const router = useRouter();
const conferences = ref([]);

onMounted(() => {
  fetchConferences();
});

async function fetchConferences() {
  try {
    const response = await axiosInstance.get('/conferences');
    conferences.value = response.data;
  } catch (error) {
    console.error('Chyba pri načítaní konferencií:', error);
  }
}

const navigateToEdit = (idconference) => {
  router.push({
    name: 'conferenceedit', // Používame názov routy definovaný v index.js
    params: { id: idconference }, // Posielame ID konferencie ako parameter
  });
};

const viewEssays = (idconference) => {
  console.log("ID "+idconference)
  router.push({ name: 'conferenceessays', params: { id: idconference } });
};

</script>

<template>
  <BaseLayout
    title="Správca Konferencií"
    :breadcrumb="[
      { label: 'Admin Rozhranie', route: '/pages/landing-pages/admin-control-panel' },
      { label: 'Správca Konferencií' },
    ]"
  >
    <div class="container mb-4">
      <div
        class="row mb-3"
        v-for="(conference, idconference) in conferences"
        :key="idconference"
      >
        <div class="col-12">
          <div class="d-flex align-items-center">
            <div class="flex-grow-1">
              <ListCard
              class="px-lg-1 mt-lg-0 mt-4 p-4"
              height="h-100"
              :icon="{ component: 'flag', color: 'success' }"
              :title="conference.abbreviation"
              :description="conference.description"
              :handleEdit="() => navigateToEdit(conference.idconference)"
              :buttonText="'Upraviť'"
              :optionalButton="{
                text: 'Práce',
                onClick: () => viewEssays(conference.idconference),
                color: 'info'
              }"
            />
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="d-flex justify-content-center">
    <Router-Link :to="{ name: 'conferenceadd' }" class="btn btn-success">
      Vytvoriť Konferenciu
    </Router-Link>
    </div>
  </BaseLayout>
</template>
