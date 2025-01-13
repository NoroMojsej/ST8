<script setup>
import BaseLayout from "@/layouts/sections/components/BaseLayout.vue";
import axiosInstance from '@/axios';
import EssaySummary from "./components/EssaySummary.vue";
import { useRouter } from "vue-router";
import { ref, onMounted } from "vue";

onMounted(() => {
  const selectedStudentId = ref(null);
  const session = JSON.parse(localStorage.getItem('session'));
  selectedStudentId.value = session?.user_id || null;

  if (selectedStudentId.value) {
    fetchEssays(selectedStudentId.value);
  }
});

const router = useRouter();
const essays = ref([]);

const fetchEssays = async (studentId) => {
  try {
    console.log("studentID:", studentId);
    const response = await axiosInstance.get(`/papers/student/${studentId}`);
    essays.value = response.data;
    console.log("Fetched Essays Data:", JSON.stringify(essays.value));
  } catch (error) {
    console.error("Chyba pri načítaní prác:", error);
  }
};

function handleEdit(idEssay, idConference) {
  router.push({ name: "essayUpdate", params: { idEssay, idConference } });
}

function handleEval(idEssay) {
  router.push({ name: "gradesummary", params: { idEssay } });
}

// Funkcia na získanie statusu hodnotenia
const getReviewStatus = (essay) => {
  // Ak review je null, vrátime správu o nepridelení na hodnotenie
  if (!essay.paper.review) {
    return "Práca nebola ešte pridelená na hodnotenie";
  }

  // Ak review existuje, ale status_desc je null, vrátime správu o neohodnotení
  if (!essay.paper.review.status || !essay.paper.review.status.status_desc) {
    return "Práca nebola ešte ohodnotená";
  }

  // Inak vrátime skutočný status
  return essay.paper.review.status.status_desc;
};


</script>

<template>
  <BaseLayout title="Moje Práce" :breadcrumb="[
    { label: 'Študentské Rozhranie', route: '/student/home' },
    { label: 'Moje Práce' },
  ]">

      <div class="container mb-4">
        <div v-if="essays.length > 0">
          <div class="row mb-3" v-for="essay in essays" :key="essay.idpaper">
            <div class="col-12">
              <div class="d-flex align-items-center">
                <div class="flex-grow-1">
                  <EssaySummary 
                  :name="essay.paper.name"
                  :keywords="[essay.paper.keywords_lang1, essay.paper.keywords_lang2]"
                  :conferenceName="essay.paper.conference.abbreviation"
                  :section="essay.paper.section.text"
                  :status="getReviewStatus(essay)"
                  :showEditButton="true"
                  :showEvaluationButton="true"
                  :handleEdit="() => handleEdit(essay.paper.idpaper, essay.paper.conference.idconference)"
                  :handleEvaluation="() => handleEval(essay.paper.idpaper)"
                />
                </div>
              </div>
            </div>
          </div>
        </div>
      <div v-else>
        <p>Žiadne práce na zobrazenie.</p>
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
