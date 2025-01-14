<script setup>
import { ref, onMounted } from "vue";
import { useRouter } from "vue-router";
import { useRoute } from "vue-router";
import BaseLayout from "@/layouts/sections/components/BaseLayout.vue";
import ListCard from "./components/ListCard.vue";
import axiosInstance from '@/axios';

const schoolId = ref(null);

const facluties = ref([]);
const errorMessage = ref("");
const route = useRoute();
const router = useRouter();

function handleCreate(id) {
  router.push({ name: "facultyadd", params: { id } });
}

const fetchFaculties = async () => {
  try {
    const response = await axiosInstance.get(`/faculties/${schoolId.value}`);
    facluties.value = response.data;
    console.log("Fetched Faculty Data:", facluties.value);
  } catch (error) {
    errorMessage.value = "Failed to fetch Faculties. Please try again.";
    console.error("Error fetching Faculties:", error);
  }
};

function handleEdit(id) {
  router.push({ name: "facultyedit", params: { id } });
}
function departmentView(id) {
  router.push({ name: "departmentman", params: { id } });
}

onMounted(() => {
  schoolId.value = route.params.id;
  fetchFaculties();
});
</script>

<template>
  <BaseLayout
    title="Správca Fakúlt"
    :breadcrumb="[
      { label: 'Správca Univerzít', route: '/pages/landing-pages/admin-control-panel/uni-manager' },
      { label: 'Správca Fakúlt' },
    ]"
  >
    <div class="container mb-4">
      <div
        class="row mb-3"
        v-for="fac in facluties"
        :key="fac.idfaculty"
      >
        <div class="col-12">
          <div class="d-flex align-items-center">
            <div class="flex-grow-1">
              <ListCard
                class="px-lg-1 mt-lg-0 mt-4 p-4"
                height="h-100"
                :icon="{ component: 'school', color: 'success' }"
                :title="fac.code"
                :description="fac.name"
                :handleEdit="() => handleEdit(fac.idfaculty)"
                :buttonText="'Upraviť'"
                :optionalButton="{
                  text: 'Katedry',
                  onClick: () => departmentView(fac.idfaculty),
                  color: 'info'
                }"
              />
        </div>
      </div>
    </div>
  </div>
      <div class="d-flex justify-content-center">
      <button class="btn btn-success" @click="handleCreate(schoolId)">
        Pridať Fakultu
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
