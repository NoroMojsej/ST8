<script setup>
import { ref, computed } from "vue";
import BaseLayout from "../../components/BaseLayout.vue";
import ListCard from "../../../../views/LandingPages/Admin/components/ListCard.vue";
import { useRouter } from "vue-router";

const router = useRouter();
const input = ref("");
const users = [
  { id: 1, firstName: "Mark Otto", uni: "UKF" },
  { id: 2, firstName: "Jacob Thornton", uni: "UBM" },
  { id: 3, firstName: "Larry Bird", uni: "UKF" },
  { id: 4, firstName: "Larry Bird", uni: "UKF" },
];

const filteredUsers = computed(() => {
  return users.filter(user =>
    user.firstName.toLowerCase().includes(input.value.toLowerCase())
  );
});

function handleEdit(id) {
  router.push({ name: "user_management", params: { id } });
}
</script>

<template>
  <BaseLayout
    title="Správca Používateľov"
    :breadcrumb="[
      { label: 'Admin Rozhranie', route: '/pages/landing-pages/admin-control-panel' },
      { label: 'Správca Používateľov' },
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
              placeholder="Hľadať používateľa"
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
        v-for="user in filteredUsers" :key="user.id"
      >
        <div class="col-12">
          <div class="d-flex align-items-center">
            <div class="flex-grow-1">
              <ListCard
                class="px-lg-1 mt-lg-0 mt-4 p-4"
                height="h-100"
                :icon="{ component: 'school', color: 'success' }"
                :title="user.firstName"
                :description="user.uni"
                :handleEdit="() => handleEdit(user.id)"
                :buttonText="'Spravovať'"
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
