<script setup>
import { ref, onMounted } from 'vue';
import BaseLayout from "@/layouts/sections/components/BaseLayout.vue";
import ListCard from "@/views/LandingPages/Admin/components/ListCard.vue";
import axiosInstance from '@/axios';
import { useRouter } from 'vue-router';

const conferences = ref([]);
const router = useRouter(); 

onMounted(() => {
  fetchConferences();
});

async function fetchConferences() {
  try {
    const response = await axiosInstance.get('/conferences/active');
    conferences.value = response.data;
  } catch (error) {
    console.error('Chyba pri načítaní konferencií:', error);
  }
}

function essayUpload(id) {
  console.log("KONF"+id);
    router.push({ name: "essay", params: { id } });
}

</script>

<template>
  <BaseLayout
    title="Výber Konferencie"
    :breadcrumb="[
      { label: 'Študent Rozhranie', route: '/student/home' },
      { label: 'Výber Konferencie' },
    ]"
  >
    <div class="container mb-4">
      <div
        class="row mb-3"
        v-for="conference in conferences"
        :key="conference.idconference"
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
              :handleEdit="() => essayUpload(conference.idconference)"
              :buttonText="'Nahrať Prácu'"
            />
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="d-flex justify-content-center">
    </div>
  </BaseLayout>
</template>
