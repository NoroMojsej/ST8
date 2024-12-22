<script setup>
import { ref, computed } from "vue";
import BaseLayout from "@/layouts/sections/components/BaseLayout.vue";
import ListCard from "../Admin/components/ListCard.vue";
import { useRouter } from "vue-router";

const router = useRouter();
const input = ref("");
const essays = [
  { id: 1, essay: "Práca 1", info: "desc" },
  { id: 2, essay: "Práca 2", info: "desc" },
  { id: 3, essay: "Práca 3", info: "desc" },
  { id: 4, essay: "Práca 4", info: "desc" },
];

const filteredEssays = computed(() => {
  return essays.filter(essay =>
    essay.essay.toLowerCase().includes(input.value.toLowerCase())
  );
});

function handleGrade(id) {
    router.push({ name: "evaluation", params: { id } });
}
function handleDownload(id) {
 //logika pre stiahnutie práce
}
</script>

<template>
  <BaseLayout
    title="Práce na Hodnotenie"
    :breadcrumb="[
      { label: 'Domov', route: '/' },
      { label: 'Práce na Hodnotenie' },
    ]"
  >
    <div class="row pt-4 pb-4">
      <div class="col-6">
        <div class="row">
          <div class="col fst">
            <input
              class="searchbox"
              type="text"
              v-model="input"
              placeholder="Hľadať prácu"
            />
          </div>
          <div class="col-6 scnd">
            <div class="lupa">
              <i class="bi bi-search icon-color"></i>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="container mb-4">
      <div
        class="row mb-3"
        v-for="essay in filteredEssays" :key="essay.id"
      >
        <div class="col-12">
          <div class="d-flex align-items-center">
            <div class="flex-grow-1">
              <ListCard
                class="px-lg-1 mt-lg-0 mt-4 p-4"
                height="h-100"
                :icon="{ component: 'receipt_long', color: 'success' }"
                :title="essay.essay"
                :description="essay.info"
                :handleEdit="() => handleGrade(essay.id)"
                :buttonText="'Hodnotiť'"
                :optionalButton="{
                  text: 'Stiahnuť',
                  onClick: () => handleDownload(essay.id),
                  color: 'info'
                }"
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
