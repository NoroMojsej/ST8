<script setup>
import { onMounted } from "vue";


// Sections components
import BaseLayout from "../../components/BaseLayout.vue";
import View from "../../components/View.vue";

// Headers page components
import HeaderOne from "./components/HeaderOne.vue";

// Headers page components codes
import { header1Code } from "./components/codes";

// nav-pills
import setNavPills from "@/assets/js/nav-pills.js";

import MaterialInput from "@/components/MaterialInput.vue";
import MaterialButton from "@/components/MaterialButton.vue";
import SelectComponent from "../../../../../SelectComponent.vue";

// hook
onMounted(() => {
  setNavPills();
});
</script>

<template scoped>
  <BaseLayout
 title="Editácia profilu"
    :breadcrumb="[
      { label: 'Sekcie', route: '/sections/page-sections/page-headers' },
      { label: 'Editácia profilu' },
    ]"
  >

  <div class="container">
  
    <div class="row">
    <div class="col-sm">
      <MaterialInput id="name"  class="input-group-static mt-2 mb-2" label="Meno"
      type="email" placeholder="{ z databázy }" />
    </div>
    <div class="col-sm">
      <MaterialInput id="surname" class="input-group-static mt-2 mb-2" label="Priezvisko"
      type="email" placeholder="{ z databázy }" />
    </div>
  </div>

  <div class="row">
    <div class="col-sm">
      <MaterialInput id="email"  class="input-group-static mt-2 mb-2" label="Email"
      type="email" placeholder="{ z databázy }" />
    </div>
    <div class="col-sm">
      <MaterialInput id="pswd" class="input-group-static mt-2 mb-2" label="Heslo"
      type="email" placeholder="{ z databázy }" />
    </div>
  </div>

  <div class="row">
    <div class="col-sm mt-2">  <!--mt-2 treba lebo predtým margin vďaka inputu-->

      <SelectComponent
      label="Univerzita"
      :alignLabel="['start', 'color-font-green']">
      </SelectComponent>
    </div>

    <div class="col-sm mt-2"> <!--mt-2 treba lebo predtým margin vďaka inputu-->
      <SelectComponent
      label="Katedra"
      :alignLabel="['start', 'color-font-green']">
      </SelectComponent>
    </div>
    </div>

</div>

<div class="button-holder">
        <MaterialButton
                    variant="contained"
                    color="success"
                    class="w-auto me-2"
                    size="md"
                    style="font-family: 'Open Sans' !important">
                    EDITOVAŤ
        </MaterialButton>
</div>

  </BaseLayout>

  <div class="input-group">
  <div class="form-outline" data-mdb-input-init>
    <input id="search-focus" type="search" class="form-control" />
    <label class="form-label" for="form1">Search</label>
  </div>
  <button type="button" class="btn btn-primary" data-mdb-ripple-init>
    <i class="fas fa-search"></i>
  </button>
</div>

</template>

<style setup scoped>

.button-holder {
  width: 100%;
  padding-top: 5%;
  display: flex;
  justify-content: end;
}

</style>