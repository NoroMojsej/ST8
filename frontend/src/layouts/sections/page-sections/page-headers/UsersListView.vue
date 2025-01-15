<script setup>
import { ref, computed, onMounted } from "vue";
import setMaterialInput from "@/assets/js/material-input";
import BaseLayout from "../../components/BaseLayout.vue";
import { useRouter } from "vue-router";
import UserCard from "../../components/UserCard.vue";
import axiosInstance from '@/axios';

onMounted(() => {
  setMaterialInput();
  fetchUsers();
});

const router = useRouter();
const searchInput = ref("");
const users = ref([]);

const filteredUsers = computed(() => {
  if (!Array.isArray(users.value)) return [];

  return users.value.filter(user => {
    const fullName = `${user.name} ${user.surname}`.toLowerCase();
    return fullName.startsWith(searchInput.value.toLowerCase());
  });
});

function handleEssayManager(id) {
  console.log("ID je "+id);
  router.push({ name: "essayassign", params: { id } });
}

async function fetchUsers() {
  try {
    const response = await axiosInstance.get(`/user/list`);
    users.value = response.data;
    console.log(JSON.stringify(users.value));
  } catch (err) {
    console.error('Chyba pri načítaní údajov:', err);
  }
}

const handleRoleChanged = async ({ id, newRole }) => {
  console.log('ID používateľa:', id);
  console.log('Nová rola:', newRole);

  try {
    const response = await axiosInstance.put(`/user/changeRole/${id}`, {
      role_code: newRole,
    });
    console.log('Úspešná zmena roly:', response.data);
  } catch (error) {
    console.error('Chyba pri zmene roly:', error);
  }
};

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
              v-model="searchInput"
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
    v-for="user in filteredUsers" :key="user.iduser"
  >
    <div class="col-12">
      <div class="d-flex align-items-center">
        <div class="flex-grow-1">
          <UserCard
            class="px-lg-1 mt-lg-0 mt-4 p-4"
            height="h-100"
            :id="user.iduser"
            :color="{ text: 'dark', background: 'primary' }"
            :icon="{ component: 'edit', color: 'success' }"
            :title="user.name + ' ' + user.surname"
            :description="user.department_code + ', ' + user.university_code"
            :handleEdit="() => handleEssayManager(user.iduser)"
            :initialRole="user.role_code" 
            @role-changed="handleRoleChanged"
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
