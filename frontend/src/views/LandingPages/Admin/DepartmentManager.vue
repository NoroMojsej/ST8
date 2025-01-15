<script setup>
import { ref, onMounted } from "vue";
import { useRoute } from "vue-router";
import { useRouter } from "vue-router";
import BaseLayout from "@/layouts/sections/components/BaseLayout.vue";
import ListCard from "./components/ListCard.vue";
import axiosInstance from '@/axios';

const route = useRoute();
const router = useRouter();
const facultyId = ref(null);

const departments = ref([]);
const errorMessage = ref("");

const fetchDepartments = async () => {
  try {
    const response = await axiosInstance.get(`/departments/${facultyId.value}`);
    departments.value = response.data;
    console.log("Fetched Faculty Data:", departments.value);
  } catch (error) {
    errorMessage.value = "Failed to fetch Faculties. Please try again.";
    console.error("Error fetching Faculties:", error);
  }
};

onMounted(() => {
  facultyId.value = route.params.id;
  fetchDepartments();
});

function handleEdit(id) {
  router.push({ name: "departmentedit", params: { id } });
}

function handleCreate(id) {
  router.push({ name: "departmentadd", params: { id } });
}
</script>

<template>
  <BaseLayout
    title="Správca Katedier"
    :breadcrumb="[
      { label: 'Správca Univerzít', route: '/pages/landing-pages/admin-control-panel/uni-manager' },
      { label: 'Správca Katedier' },
    ]"
  >
    <div class="container mb-4">
      <div
        class="row mb-3"
        v-for="dep in departments"
        :key="dep.iddepartment"
      >
        <div class="col-12">
          <div class="d-flex align-items-center">
            <div class="flex-grow-1">
              <ListCard
                class="px-lg-1 mt-lg-0 mt-4 p-4"
                height="h-100"
                :icon="{ component: 'school', color: 'success' }"
                :title="dep.code"
                :description="dep.name"
                :handleEdit="() => handleEdit(dep.iddepartment)"
              />
        </div>
      </div>
    </div>
    </div>
    <div class="d-flex justify-content-center">
      <button class="btn btn-success" @click="handleCreate(facultyId)">
        Pridať Katedru
      </button>
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
