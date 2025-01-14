<script setup>
import { ref, onMounted } from "vue";
import { useRouter } from "vue-router";
import BaseLayout from "@/layouts/sections/components/BaseLayout.vue";
import ListCard from "./components/ListCard.vue";
import axiosInstance from '@/axios';

const schools = ref([]);
const errorMessage = ref("");

const router = useRouter();

function handleEdit(id) {
  router.push({ name: "universityedit", params: { id } });
}
function facultyView(id) {
  router.push({ name: "facultyman", params: { id } });
}

const fetchUniversities = async () => {
  try {
    const response = await axiosInstance.get("/universities");
    schools.value = response.data;
    console.log("Fetched Uni Data:", schools.value);
  } catch (error) {
    errorMessage.value = "Failed to fetch universities. Please try again.";
    console.error("Error fetching universities:", error);
  }
};

onMounted(() => {
  fetchUniversities();
});
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
        v-for="school in schools" :key="school.iduniversity" 
      >
        <div class="col-12">
          <div class="d-flex align-items-center">
            <div class="flex-grow-1">
              <ListCard
                class="px-lg-1 mt-lg-0 mt-4 p-4"
                height="h-100"
                :icon="{ component: 'school', color: 'success' }"
                :title="school.code"
                :description="school.name"
                :handleEdit="() => handleEdit(school.iduniversity)"
                :buttonText="'Upraviť'"
                :optionalButton="{
                  text: 'Fakulty',
                  onClick: () => facultyView(school.iduniversity),
                  color: 'info'
                }"
              />
          </div>
        </div>
      </div>
    </div>
    <div class="d-flex justify-content-center">
      <div v-if="errorMessage" class="alert alert-danger">
        {{ errorMessage }}
      </div>
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
