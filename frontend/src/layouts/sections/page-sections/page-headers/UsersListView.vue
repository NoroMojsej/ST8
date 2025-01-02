<script setup>
import { ref, computed } from "vue";
import BaseLayout from "../../components/BaseLayout.vue";
import { useRouter } from "vue-router";
import UserCard from "../../components/UserCard.vue";

const router = useRouter();
const input = ref("");
const users = [
  { id: 1, firstName: "Mark Otto", uni: "UKF", role: "Student" },
  { id: 2, firstName: "Jacob Thornton", uni: "UBM", role: "Student" },
  { id: 3, firstName: "Larry Bird", uni: "UKF", role: "Recenzent" },
  { id: 4, firstName: "Larry Bird", uni: "UKF", role: "Student" },
];

const filteredUsers = computed(() => {
  return users.filter(user =>
    user.firstName.toLowerCase().includes(input.value.toLowerCase())
  );
});

function handleEssayManager(id) {
  router.push({ name: "essayassign", params: { id } });
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
              <UserCard
                class="px-lg-1 mt-lg-0 mt-4 p-4"
                height="h-100"
                :color="{ text: 'dark', background: 'primary' }"
                :icon="{ component: 'edit', color: 'success' }"
                :title="user.firstName"
                :description="user.uni"
                :handleEdit="() => handleEssayManager(user.id)"
                :initialRole="user.role"
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
