<script setup>
import { ref, onMounted } from "vue";

// Sections
import BaseLayout from "@/layouts/sections/components/BaseLayout.vue";
import setMaterialInput from "@/assets/js/material-input";

const essays = ref([
  { id: '1', value: 'Práca 1' },
  { id: '2', value: 'Práca 2' },
  { id: '3', value: 'Práca 3' },
  { id: '4', value: 'Práca 4' }
]);

const entries = ref([]);

onMounted(() => {
  setMaterialInput();
});

const addRow = () => {
  entries.value.push({
    essay: "",
  });
};

function saveEssays() {
    //uložiť priradené práce do db
}
</script>

<template>
  <BaseLayout title="Priradiť Práce" :breadcrumb="[
    { label: 'Správca Používateľov', route: '/pages/landing-pages/admin-control-panel/users-list' },
    { label: 'Priradiť Práce' }
  ]">
    <div class="container">
      <div class="row">
        <div class="col-24 mx-auto">
          <div class="row">
            <div class="col-lg-7 col-md-7 z-index-2 position-relative px-md-2 px-sm-5 mx-auto">
              <div class="row mt-4 mb-5 p-3 rounded shadow-sm bg-container">

                <table class="table">
                  <thead>
                    <tr class="tr">
                      <th scope="col"></th>
                      <th scope="col">
                        <div class="d-flex justify-content-center font">Práce</div>
                      </th>
                      <th scope="col">
                        <div class="d-flex justify-content-center"></div>
                      </th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="(entry, index) in entries" :key="index">
                      <td></td>
                      <td>
                        <select v-model="entry.essay" class="form-select" style="box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.05);">
                          <option value="" disabled selected>Vyberte Prácu</option>
                          <option v-for="essay in essays" :key="essay.id" :value="essay.value">
                            {{ essay.value }}
                          </option>
                        </select>
                      </td>
                      <td class="d-flex justify-content-end">
                        <button class="btn btn-danger" @click="entries.splice(index, 1)">Odstrániť</button>
                      </td>
                    </tr>
                  </tbody>
                </table>

                <div class="d-flex justify-content-center">
                  <button class="btn btn-success" @click="addRow">
                    Pridať Prácu
                  </button>
                </div>

                <div class="d-flex justify-content-center mt-3">
                  <button @click="saveEssays()" class="btn btn-success">
                    Uložiť
                  </button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </BaseLayout>
</template>

<style scoped>
.bg-container {
  background-color: rgba(253, 253, 253, 0.89);
  border-radius: 15px;
  padding: 20px;
}

.form-select {
  box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.05);
}

.form-control {
  box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.05);
}

.gap-2>* {
  margin-right: 8px;
}

.gap-2>*:last-child {
  margin-right: 0;
}
</style>
