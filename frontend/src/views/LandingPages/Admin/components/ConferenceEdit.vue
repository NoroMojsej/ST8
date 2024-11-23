<script setup>
import { onMounted } from "vue";

// Sections
import BaseLayout from "@/layouts/sections/components/BaseLayout.vue";
import MaterialInput from "@/components/MaterialInput.vue";

// Hooks
import setMaterialInput from "@/assets/js/material-input";

onMounted(() => {
  setMaterialInput();
});
</script>

<template>
  <BaseLayout
    title="Vytvoriť Konferenciu"
    :breadcrumb="[
      { label: 'Správa Konferencií', route: '/pages/landing-pages/admin-control-panel/conference-manager' },
      { label: 'Vytvoriť Konferenciu' },
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
                    id="conference-title"
                    class="input-group-static mt-2"
                    label="NÁZOV KONFERENCIE"
                    type="name"
                    placeholder="Názov Konferencie"
                  />
                </div>

                <div class="mb-3">
                  <label for="country" class="form-label" style="color: #4CAF50;">Krajina Konferencie</label>
                  <select
                    id="country"
                    class="form-select"
                    style="box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.05);"
                  >
                    <option value="" disabled selected>Vyberte krajinu</option>
                    <option value="university1">Krajina 1</option>
                    <option value="university2">Krajina 2</option>
                    <option value="university3">Krajina 3</option>
                    <option value="university4">krajina 4</option>
                  </select>
                </div>

                <div class="mb-3">
                  <label for="description" class="form-label" style="color: #4CAF50;">POPIS</label>
                  <textarea
                    id="description"
                    class="form-control"
                    style="box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.05);"
                    rows="4"
                    placeholder="Popis konferencie..."
                  ></textarea>
                </div>

                <div class="mb-3">
                  <label for="submission-dates" class="form-label" style="color: #4CAF50;">TERMÍNY NAHRANIA PRÁC</label>
                  <div class="d-flex gap-2">
                    <input id="submission-from" type="date" class="form-control" placeholder="Od" />
                    <input id="submission-to" type="date" class="form-control" placeholder="Do" />
                  </div>
                </div>

                <div class="mb-3">
                  <label for="conference-dates" class="form-label" style="color: #4CAF50;">DÁTUM KONANIA KONFERENCIE</label>
                  <div class="d-flex gap-2">
                    <input id="take-place-from" type="date" class="form-control" placeholder="Od" />
                    <input id="take-place-to" type="date" class="form-control" placeholder="Do" />
                  </div>
                </div>

                <div class="mb-3">
                  <label for="university" class="form-label" style="color: #4CAF50;">ORGANIZÁTOR</label>
                  <select
                    id="university"
                    class="form-select"
                    style="box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.05);"
                  >
                    <option value="" disabled selected>Vyberte univerzitu</option>
                    <option value="university1">Univerzita 1</option>
                    <option value="university2">Univerzita 2</option>
                    <option value="university3">Univerzita 3</option>
                    <option value="university4">Univerzita 4</option>
                  </select>
                </div>

                <div class="d-flex justify-content-center">
                  <button class="btn btn-success">
                    Vytvoriť
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
