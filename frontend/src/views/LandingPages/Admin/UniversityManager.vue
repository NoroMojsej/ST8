<script setup>
import { ref } from "vue";
import { useRouter } from "vue-router";
import BaseLayout from "@/layouts/sections/components/BaseLayout.vue";
import ListCard from "./components/ListCard.vue";

const schools = ref([
  { id: 1, uni: "UKF", desc: "Adresa napr." },
  { id: 2, uni: "SPU", desc: "Adresa napr." },
  { id: 3, uni: "MUNI", desc: "Adresa napr." },
  { id: 4, uni: "UK", desc: "Adresa napr." },
]);

const router = useRouter();

function handleEdit(id) {
  router.push({ name: "facultyman", params: { id } });
}
</script>

<template>
  <BaseLayout
    title="Správca Univerzít"
    :breadcrumb="[
      { label: 'Admin Rozhranie', route: '/pages/landing-pages/admin-control-panel' },
      { label: 'Správca Univerzít' },
    ]"
  >
  <div class="container mb-4">
      <div
        class="row mb-3"
        v-for="school in schools" :key="school.id" 
      >
        <div class="col-12">
          <div class="d-flex align-items-center">
            <div class="flex-grow-1">
              <ListCard
                class="px-lg-1 mt-lg-0 mt-4 p-4"
                height="h-100"
                :icon="{ component: 'school', color: 'success' }"
                :title="school.uni"
                :description="school.desc"
                :handleEdit="() => handleEdit(school.id)"
                :buttonText="'Fakulty'"
              />
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="d-flex justify-content-center">
    <Router-Link :to="{ name: '' }" class="btn btn-success">
      Pridať Univerzitu
    </Router-Link>
    </div>
  </BaseLayout>
</template>

<style scoped>
.btn {
  margin-bottom: 0 !important;
}

.font {
  font-weight: 500;
  color: white;
}
</style>
