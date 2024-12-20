<script setup>
import { ref, onMounted } from "vue";
import { useRoute } from "vue-router";
import { useRouter } from "vue-router";
import BaseLayout from "@/layouts/sections/components/BaseLayout.vue";
import ListCard from "./components/ListCard.vue";

const route = useRoute();
const router = useRouter();
const schoolId = ref(null);

const faculty = ref([
  { id: 1, fac: "Fakulta 1", desc: "Popis" },
  { id: 2, fac: "Fakulta 2", desc: "Popis" },
  { id: 3, fac: "Fakulta 3", desc: "Popis" },
  { id: 4, fac: "Fakulta 4", desc: "Popis" },
]);

function handleEdit(id) {
  router.push({ name: "facultyedit", params: { id } });
}

onMounted(() => {
  schoolId.value = route.params.id;
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
        v-for="fac in faculty"
        :key="fac.id"
      >
        <div class="col-12">
          <div class="d-flex align-items-center">
            <div class="flex-grow-1">
              <ListCard
                class="px-lg-1 mt-lg-0 mt-4 p-4"
                height="h-100"
                :icon="{ component: 'school', color: 'success' }"
                :title="fac.fac"
                :description="fac.desc"
                :handleEdit="() => handleEdit(fac.id)"
                :buttonText="'Upraviť'"
              />
              <router-link
                  :to="{ name: 'departmentman', params: { id: fac.id } }"
                  class="btn btn-success ms-3 mt-n3"
                >
                  Katedry
              </router-link>
        </div>
      </div>
    </div>
  </div>
    <div class="d-flex justify-content-center">
    <Router-Link :to="{ name: 'facultyadd' }" class="btn btn-success">
      Pridať Fakultu
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
