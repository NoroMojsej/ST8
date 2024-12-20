<script setup>
import { ref, onMounted } from "vue";
import { useRoute } from "vue-router";
import BaseLayout from "@/layouts/sections/components/BaseLayout.vue";
import MaterialInput from "@/components/MaterialInput.vue";
import setMaterialInput from "@/assets/js/material-input";

const facultyId = ref(null);
const route = useRoute();

onMounted(() => {
  setMaterialInput();
  facultyId.value = route.params.id;
});
</script>

<template>
  <BaseLayout
    title="Vytvoriť Fakultu"
    :breadcrumb="[ 
      { label: 'Správca Univerzít', route: '/pages/landing-pages/admin-control-panel/uni-manager' },
      { label: 'Vytvoriť Fakultu' }
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
                    id="fac-title"
                    class="input-group-static mt-2"
                    label="NÁZOV FAKULTY"
                    type="name"
                    placeholder="Názov Fakulty"
                  />
                </div>

                <div class="mb-3">
                  <MaterialInput
                    id="fac-code"
                    class="input-group-static mt-2"
                    label="SKRÁTENÝ NÁZOV FAKULTY"
                    type="name"
                    placeholder="Skratka Fakulty"
                  />
                </div>

                <div class="d-flex justify-content-center mt-3">
                  <button class="btn btn-success">
                    Vytvoriť Fakultu
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
