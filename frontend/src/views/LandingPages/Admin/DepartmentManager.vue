<script setup>
import { ref, onMounted } from "vue";
import { useRoute } from "vue-router";
import { useRouter } from "vue-router";
import BaseLayout from "@/layouts/sections/components/BaseLayout.vue";
import ListCard from "./components/ListCard.vue";

const route = useRoute();
const router = useRouter();
const facultyId = ref(null);

const department = ref([
  { id: 1, dep: "Katedra 1", desc: "Popis" },
  { id: 2, dep: "Katedra 2", desc: "Popis" },
  { id: 3, dep: "Katedra 3", desc: "Popis" },
  { id: 4, dep: "Katedra 4", desc: "Popis" },
]);

onMounted(() => {
  facultyId.value = route.params.id;
});

function handleEdit(id) {
  router.push({ name: "departmentedit", params: { id } });
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
        v-for="dep in department"
        :key="dep.id"
      >
        <div class="col-12">
          <div class="d-flex align-items-center">
            <div class="flex-grow-1">
              <ListCard
                class="px-lg-1 mt-lg-0 mt-4 p-4"
                height="h-100"
                :icon="{ component: 'school', color: 'success' }"
                :title="dep.dep"
                :description="dep.desc"
                :handleEdit="() => handleEdit(dep.id)"
              />
        </div>
      </div>
    </div>
    </div>
    <div class="d-flex justify-content-center">
    <Router-Link :to="{ name: 'departmentadd' }" class="btn btn-success">
      Pridať Katedru
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
