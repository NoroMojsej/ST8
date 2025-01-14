<script setup>
import { ref, computed } from "vue";
import BaseLayout from "@/layouts/sections/components/BaseLayout.vue";
import ListCard from "../Admin/components/ListCard.vue";
import { useRouter } from "vue-router";
import { useRoute } from "vue-router";
import axiosInstance from '@/axios';

const papers = ref([]);
const route = useRoute();



const getAllPapersAndTheirReview = async () => {
  try {
    const session = JSON.parse(localStorage.getItem('session'));
    console.log("Logged in user:", session.user_id);

    let apiRouteBasedOnLoggedUserRole = null;
    if(session.user_role == 'REVIW'){
      //reviewer logged in
      console.log('Getting papers for reviewer with user id: '+ session.user_id);
      apiRouteBasedOnLoggedUserRole = '/papers/get-all-papers-and-their-review-by-assigned-userid-to-review/' + session.user_id;
    }else {
      //default: do nothing
      console.log('Doing Nothing');
      return null;
    }
    
    
    
    

    
    const response = await axiosInstance.get(apiRouteBasedOnLoggedUserRole, {
      headers: {
        'Content-Type': 'application/json',
      },
    });

    

    console.log('Papers retrieved successfully:', response.data);


    papers.value = response.data.map(paper => ({
      id: paper.idpaper,
      paper: paper.name,
      conference_id: paper.conference_idconference,
      review_id: paper.review.idreview,
      info: paper.status_desc ? paper.status_desc : 'No status available',
      isEditing: false,
    }));
    // console.log(response.data[index].review.idreview);
  } catch (error) {
    console.error('Papers retrieving failed:', error.response?.data || error.message);
  }
};

getAllPapersAndTheirReview();

const router = useRouter();
const input = ref("");

const filteredPapers = computed(() => {
  return papers.value.filter(paper =>
    paper.paper.toLowerCase().includes(input.value.toLowerCase())
  );
});

function handleGrade(id) {
    router.push({ name: "evaluation", params: { id } });
}

async function handleDownload(confid, id) {
  try {
    const response = await axiosInstance.get(`/papers/download-paper/${id}`, {
      responseType: 'blob',
    });
    const blob = response.data;
    const url = window.URL.createObjectURL(blob);
    const a = document.createElement('a');
    a.href = url;
    a.download = `conference_${confid}_paper_${id}_files.zip`;
    document.body.appendChild(a);
    a.click();
    document.body.removeChild(a);    
  } catch (error) {
    console.error("Error downloading files:", error);
  }
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
        v-for="paper in filteredPapers" :key="paper.id"
      >
        <div class="col-12">
          <div class="d-flex align-items-center">
            <div class="flex-grow-1">
              <ListCard
                class="px-lg-1 mt-lg-0 mt-4 p-4"
                height="h-100"
                :icon="{ component: 'receipt_long', color: 'success' }"
                :title="paper.paper"
                :description="paper.info"
                :handleEdit="() => handleGrade(paper.review_id)"
                :buttonText="'Hodnotiť'"
                :optionalButton="{
                  text: 'Stiahnuť',
                  onClick: () => handleDownload(paper.conference_id, paper.id),
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
