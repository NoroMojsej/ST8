<script setup>
import { ref } from "vue";
import { useRouter } from "vue-router";
import BaseLayout from "@/layouts/sections/components/BaseLayout.vue";
import ListCard from "./components/ListCard.vue";

const schools = ref([
  { id: 1, uni: "Uni 1", desc: "Popis" },
  { id: 2, uni: "Uni 2", desc: "Popis" },
  { id: 3, uni: "Uni 3", desc: "Popis" },
  { id: 4, uni: "Uni 4", desc: "Popis" },
]);

const router = useRouter();

function handleEdit(id) {
  router.push({ name: "universityedit", params: { id } });
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
                :buttonText="'Upraviť'"
              />
                <router-link
                  :to="{ name: 'facultyman', params: { id: school.id } }"
                  class="btn btn-success ms-3 mt-n3"
                >
                  Fakulty
                </router-link>
          </div>
        </div>
      </div>
    </div>
    <div class="d-flex justify-content-center">
      <Router-Link :to="{ name: 'universityadd' }" class="btn btn-success">
        Pridať Univerzitu
      </Router-Link>
    </div>
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
