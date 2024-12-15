<script setup>

import BaseLayout from "../../components/BaseLayout.vue";
import { RouterLink } from "vue-router";

const users = [
  { id: 1, firstName: "Mark Otto", uni: "UKF" },
  { id: 2, firstName: "Jacob Thornton",  uni: "UBM" },
  { id: 3, firstName: "Larry Bird",  uni: "UKF" },
  { id: 4, firstName: "Larry Bird",  uni: "UKF" },
];

</script>

<template scoped>
     <BaseLayout
   title="Správca užívateľov, rolí, článkov"
      :breadcrumb="[
        { label: 'Admin Rozhranie', route: '/pages/landing-pages/admin-control-panel' },
        { label: 'Správca užívateľov' },
      ]"
    >

    <div class="row pt-4 pb-4">
    <div class="col-6">
              <div class="row">
                <div class="col fst">
                <input class="searchbox" type="text" v-model="input" placeholder="Hľadať užívateľa"/>
              </div>
              <div class="col-6 scnd">
                <div class="lupa">
              <i class="bi bi-search icon-color"></i>
            </div>
            </div>
            </div>
          </div>
        </div>


    <table class="table">
  <thead>
    <tr class="tr">
      <th scope="col"></th>
      <th scope="col"><div class="d-flex justify-content-center font">MENO</div></th>
      <th scope="col"><div class="d-flex justify-content-center font">UNIVERZITA</div></th>
      <th scope="col"><div class="d-flex justify-content-center"></div></th>
    </tr>
  </thead>
  <tbody>
     <!-- Dynamický cyklus -->
     <tr v-for="user in users" :key="user.id">
          <th scope="row"><div class="d-flex justify-content-center">{{ user.id }}</div></th>
          <td><div class="d-flex justify-content-center">{{ user.firstName }}</div></td>
          <td><div class="d-flex justify-content-center">{{ user.uni }}</div></td>
          <td class="td-btn"> 
            <div class="d-flex justify-content-center">
                <router-link
              :to="{ name: 'user_management' }"
              class="btn btn-md mb-0 bg-gradient-success"
              style="font-family: 'Montserrat', sans-serif; font-size: 12px;"
              @click.native="smoothToPricing('pricing-soft-ui')"
            >
            SPRAVOVAŤ
            </router-link>
            </div></td>
        </tr>
  </tbody>
</table>

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
    border:solid;
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
    width: 100% !important
  }

</style>

