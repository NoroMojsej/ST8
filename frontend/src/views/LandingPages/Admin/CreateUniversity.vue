<script setup>
import { ref, onMounted } from "vue";

import BaseLayout from "@/layouts/sections/components/BaseLayout.vue";
import MaterialInput from "@/components/MaterialInput.vue";
import setMaterialInput from "@/assets/js/material-input";

onMounted(() => {
  setMaterialInput();
});
</script>

<template>
  <BaseLayout
    title="Vytvoriť Univerzitu"
    :breadcrumb="[ 
      { label: 'Správca Univerzít', route: '/pages/landing-pages/admin-control-panel/uni-manager' },
      { label: 'Vytvoriť Univerzitu' }
    ]"
  >
    <div class="container">
      <div class="row">
        <div class="col-24 mx-auto">
          <div class="row">
            <div class="col-lg-7 col-md-7 z-index-2 position-relative px-md-2 px-sm-5 mx-auto">
              <div class="row mt-4 mb-5 p-3 rounded shadow-sm bg-container">
                
                <div class="mb-3">
                  <MaterialInput
                    id="uni-title"
                    class="input-group-static mt-2"
                    label="NÁZOV UNIVERZITY"
                    type="name"
                    placeholder="Názov Univerzity"
                  />
                </div>

                <div class="mb-3">
                  <MaterialInput
                    id="uni-code"
                    class="input-group-static mt-2"
                    label="SKRÁTENÝ NÁZOV UNIVERZITY"
                    type="name"
                    placeholder="Skratka Univerzity"
                  />
                </div>

                <div class="mb-3">
                  <label for="country" class="form-label" style="color: #4CAF50;">KRAJINA UNIVERZITY</label>
                  <select
                    id="country"
                    class="form-select"
                    style="box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.05);"
                  >
                    <option value="" disabled selected>Vyberte krajinu</option>
                    <option value="university1">Krajina 1</option>
                    <option value="university2">Krajina 2</option>
                    <option value="university3">Krajina 3</option>
                    <option value="university4">Krajina 4</option>
                  </select>
                </div>


                <div class="d-flex justify-content-center mt-3">
                  <button class="btn btn-success">
                    Vytvoriť Univerzitu
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

.gap-2 > * {
  margin-right: 8px;
}

.gap-2 > *:last-child {
  margin-right: 0;
}
</style>
