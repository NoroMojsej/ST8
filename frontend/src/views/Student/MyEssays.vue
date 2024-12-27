<script setup>
import BaseLayout from "@/layouts/sections/components/BaseLayout.vue";
import ListCard from "@/views/LandingPages/Admin/components/ListCard.vue";
import EssaySummary from "./components/EssaySummary.vue";
import { useRouter } from "vue-router";

const router = useRouter();
const essays = [
  { id: 1, name: "Práca 1", key: ["k1", "k2", "k3" ], conf: "Konferencia", sec: "sekcia", status: "status" },
  { id: 2, name: "Práca 2", key: ["k1", "k2", "k3" ], conf: "Konferencia", sec: "sekcia", status: "status" },
  { id: 3, name: "Práca 3", key: ["k1", "k2", "k3" ], conf: "Konferencia", sec: "sekcia", status: "status" },
  { id: 4, name: "Práca 4", key: ["k1", "k2", "k3" ], conf: "Konferencia", sec: "sekcia", status: "status" },
];

function handleEdit(id) {
  router.push({ name: "essayUpdate", params: { id } });
}

function handleEval(id) {
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
              <EssaySummary
                  :name="essay.name"
                  :keywords="essay.key"
                  :conferenceName="essay.conf"
                  :section="essay.sec"
                  :status="essay.status"
                  :showEditButton="true" 
                  :showEvaluationButton="true"
                  :handleEdit="() => handleEdit(essay.id)"
                  :handleEvaluation="() => handleEval(essay.id)"
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
