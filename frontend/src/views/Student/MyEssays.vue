<script setup>
import BaseLayout from "@/layouts/sections/components/BaseLayout.vue";
import ListCard from "@/views/LandingPages/Admin/components/ListCard.vue";
import { useRouter } from "vue-router";

const router = useRouter();
const essays = [
  { id: 1, name: "Práca 1", desc: "názov konferencie" },
  { id: 2, name: "Práca 2", desc: "názov konferencie" },
  { id: 3, name: "Práca 3", desc: "názov konferencie" },
  { id: 4, name: "Práca 4", desc: "názov konferencie" },
];

function handleEdit(id) {
  router.push({ name: "", params: { id } });
}
</script>

<template>
  <BaseLayout
    title="Moje Práce"
    :breadcrumb="[
      { label: 'Študentské Rozhranie', route: '/student/home' },
      { label: 'Moje Práce' },
    ]"
  >

    <div class="container mb-4">
      <div
        class="row mb-3"
        v-for="essay in essays" :key="essay.id"
      >
        <div class="col-12">
          <div class="d-flex align-items-center">
            <div class="flex-grow-1">
              <ListCard
                class="px-lg-1 mt-lg-0 mt-4 p-4"
                height="h-100"
                :icon="{ component: 'school', color: 'success' }"
                :title="essay.name"
                :description="essay.desc"
                :handleEdit="() => handleEdit(essay.id)"
                :buttonText="'Detail práce'"
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
