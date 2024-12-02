<script setup>

import BaseLayout from "../../components/BaseLayout.vue";
import HeaderLine from "../../../../../HeaderLine.vue";
import DescriptionComponent from "../../../../../DescriptionComponent.vue";

import { ref } from "vue";
let input = ref("");
const fruits = ["apple", "banana", "orange"];
function filteredList() {
  return fruits.filter((fruit) =>
    fruit.toLowerCase().includes(input.value.toLowerCase())
  );
}

let input2 = ref("");
const users = ["Marek", "Adam", "David"];
function usersList() {
  return users.filter((user) =>
    user.toLowerCase().includes(input2.value.toLowerCase())
  );
}


</script>

<template scoped>
    <BaseLayout
   title="Správa rolí, článkov"
      :breadcrumb="[
        { label: 'Sekcie', route: '/sections/page-sections/page-headers' },
        { label: 'Správa rolí, článkov' },
      ]"
    >

    <HeaderLine
  label="PRIRADIŤ ROLU"
  ></HeaderLine>


  <DescriptionComponent
    description="V nasledujúcej sekcii je možno zaregistrovanému užívateľovi (na ľavej strane) priradiť rolu (na pravej strane). Vybraním užívateľa
    je na pravom paneli zelenou farbou vyznačená jeho aktuálne priradená rola. Zakliknutím inej role - ktorá sa týmto podfarbí tmavosivou farbou - a potvrdením tlačidla 'PRIRADIŤ' bude rola následne pozmenená.">
  </DescriptionComponent>


  <div class="row pt-4">
    <div class="col-6">

              <div class="row">
                <div class="col fst">
                <input class="searchbox" type="text" v-model="input2" placeholder="Search fruits..."/>
              </div>

              <div class="col scnd">
                <div class="lupa">
              <i class="bi bi-search icon-color"></i>
            </div>
            </div>
            </div>
          </div>
        </div>

            <div class="row pt-4 pb-6">
    <div class="col">
              <div class="row"></div>
              <select class="form-select" size="10" aria-label="size 3 select example" >
                <option v-for="user in usersList()" :key="user" :value="user">
                  {{ user }}
                </option>
              </select>
          </div>   

     <div class="col no-search">
              <select class="form-select no-search" size="10" aria-label="size 3 select example" >
                <option v-for="fruit in filteredList()" :key="fruit" :value="fruit">
                  {{ fruit }}
                </option>
              </select>
</div>

<div class="pt-4">
    <input class="btn btn-success btn-md" type="submit" value="PRIRADiŤ ČLÁNOK">
</div>

        </div>

  <HeaderLine
  label="PRIRADIŤ ČLÁNOK"
  ></HeaderLine>

  <div class="row pt-4">
    <div class="col-6">
              <div class="row">
                <div class="col fst">
                <input class="searchbox" type="text" v-model="input" placeholder="Search fruits..."/>
              </div>
              <div class="col-6 scnd">
                <div class="lupa">
              <i class="bi bi-search icon-color"></i>
            </div>
            </div>
            </div>
          </div>
        </div>

            <div class="row pt-4 pb-6">
    <div class="col">
              <div class="row"></div>
              <select class="form-select" size="10" aria-label="size 3 select example" >
                <option v-for="fruit in filteredList()" :key="fruit" :value="fruit">
                  {{ fruit }}
                </option>
              </select>
          </div>   

     <div class="col no-search">
              <select class="form-select no-search" size="10" aria-label="size 3 select example" >
                <option v-for="fruit in filteredList()" :key="fruit" :value="fruit">
                  {{ fruit }}
                </option>
              </select>
</div>

<div class="pt-4">
    <input class="btn btn-success btn-md" type="submit" value="PRIRADiŤ ČLÁNOK">
</div>

        </div>


        <HeaderLine
  label="ODOBRAŤ ČLÁNOK"
  ></HeaderLine>

  <div class="row pt-4">
    <div class="col-6">
              <div class="row">
                <div class="col fst">
                <input class="searchbox" type="text" v-model="input" placeholder="Search fruits..."/>
              </div>
              <div class="col-6 scnd">
                <div class="lupa">
              <i class="bi bi-search icon-color"></i>
            </div>
            </div>
            </div>
          </div>
        </div>

            <div class="row pt-4 pb-6">
    <div class="col">
              <div class="row"></div>
              <select class="form-select" size="10" aria-label="size 3 select example" >
                <option v-for="fruit in filteredList()" :key="fruit" :value="fruit">
                  {{ fruit }}
                </option>
              </select>
          </div>   

     <div class="col no-search">
              <select class="form-select no-search" size="10" aria-label="size 3 select example" >
                <option v-for="fruit in filteredList()" :key="fruit" :value="fruit">
                  {{ fruit }}
                </option>
              </select>
</div>

<div class="pt-4">
    <input class="btn btn-success btn-md" type="submit" value="PRIRADiŤ ČLÁNOK">
</div>

        </div>


        
    </BaseLayout>
   </template>

   <style scoped>

  .searchbox {
    border-top: none;
    border-left: none;
    border-right: none;
    border-bottom: solid;
    border-color: #66bb6a;
    width: 100% !important
  }

  .fst {
    padding-right: 0% !important;
  }

  .scnd {
    padding-left: 0% !important;
    align-items: flex-end !important;
  }

  .searchbox {
    width:100% !important;
    vertical-align: bottom !important;
  }

  
  .lupa {
  display: inline-block; /* Nastaví šírku podľa obsahu */
  text-align: center;    /* Zarovná obsah horizontálne (ak treba) */
  height: 100%;
  padding-right: 3%;
  border: solid;
  border-color: #66bb6a;
  border-left: none;
  border-right: none;
  border-top: none;
}

.no-search {
  vertical-align: bottom;
}

.icon-color {
  font-weight: bold;
}

  </style>