<script setup>
import { onMounted } from "vue";
import MaterialButton from "@/components/MaterialButton.vue";
import HeaderLine from "../../../../../HeaderLine.vue";
import TableRow from "../../../../../TableRow.vue";
import TableSelect from "../../../../../TableSelect.vue";
import TableTextArea from "../../../../../TableTextArea.vue";


// Sections components
import BaseLayout from "../../components/BaseLayout.vue";
import View from "../../components/View.vue";

// Headers page components
import HeaderOne from "./components/HeaderOne.vue";

// Headers page components codes
import { header1Code } from "./components/codes";

// nav-pills
import setNavPills from "@/assets/js/nav-pills.js";

// hook
onMounted(() => {
  setNavPills();
});
</script>

<style setup>
* {
  color: black;
  font-weight: 400;
}

.table-striped {
  /*background-color: #f9fdf4;*/
  background-color: white;
}

.form-check:not(.form-switch) .form-check-input[type=radio]:after  {
  background-image: linear-gradient(195deg, #66bb6a 0%, #66bb6a 100%), var(--bs-gradient) !important;
}

.form-check:not(.form-switch) .form-check-input[type=checkbox]:checked, .form-check:not(.form-switch) .form-check-input[type=radio]:checked {
  border-color: #66bb6a !important;
}

.form-check:not(.form-switch) .form-check-input[type=radio] {
  border-color: #66bb6a !important
}


.btn-group .btn:not(:last-child):not(.dropdown-toggle) {
border-color: #66bb6a ;
}

td {
  text-align: center;
  align-items: center !important;
  max-width: 30% !important;
  word-wrap: break-word !important;
}

.table thead th {
  text-align: center;
  font-size: 15px;
}

.table tbody th {
  font-size: 20px;
  text-align: center;
  padding-top: 2.5% !important;
  padding-bottom: 2.5% !important;
}


.th-header {
  font-size: 20px;
  text-align: center;
  padding-top: 1.5% !important;
  padding-bottom: 1.5% !important;
  color: black;
  font-family: "Open Sans";
  font-size: medium !important;
  font-weight: 300 !important;
}

.form-check  {
  padding-left: 0px !important;
}

.table {
  width: 80% !important;
  --bs-table-striped-bg: white !important;
  --bs-table-border-color: white !important

}

.wrapper {
  width:100%;
  display: flex;
  justify-content: center;
  align-items: center;
  padding-bottom: 35px;
  padding-top: 35px;
}

p {
  margin: 0% !important;
}

th.question-table {
  align-items: center !important;
  display: flex;
  justify-content: center;
  max-width: 50% !important;
  background-color: green !important;
  ;
}

tr {
  align-items: center !important;
}

h5 {
  color: #66bb6a !important;
  margin: 0px !important;
  font-family: 'Montserrat', sans-serif !important;
    font-weight: 400 !important;
    border-bottom: solid;
    border-color: #66bb6a;
}

textarea {
  border:solid !important;
  border-color:  #66bb6a !important;
  border-width: 0.1cap !important;
  border-radius: 0px !important;
}

.form-select {
  border:solid !important;
  border-color:  #66bb6a !important;
  border-width: 0.1cap !important;
  border-top: 0px !important;
  border-left: 0px !important;
  border-right: 0px !important;
  border-radius: 0px !important ;
}

input {
  cursor: pointer;
}

.descriptive-div1 {
  width: 100%;
  display: flex;
  justify-content: center;
  padding-top: 2.5%;
  padding-bottom: 2.5%;
  font-size: large
}

.descriptive-div2 {
  width: 100%;
  text-align: center;
  background-color: #66bb6a;
  color: white;
  padding: 2%;
  font-weight: 450;
  font-family: Montserrat;
}


  .question {
    text-align: center !important;
  }

.form-select {
  max-width: 50% !important;
}

textarea {
  max-width: 50%;
  border-top: white !important;
  border-left: white !important;
  border-right: white !important;
}

.row.answear {
  display: flex;
  justify-content: center;
}

.form-group {
  display: flex;
  justify-content: center;
}

.p {
  background-color: white;
  color: #66bb6a;
  font-weight: 700 !important;
  font-family: Montserrat;
}

.table > :not(:last-child) > :last-child > * {
  border-bottom-color: #66bb6a;
}

.button-holder {
  width: 100%;
  padding-top: 5%;
  display: flex;
  justify-content: end;
}
</style>

<template>
  <BaseLayout
 title="Hodnotenie článku"
    :breadcrumb="[
      { label: 'Sekcie', route: '/sections/page-sections/page-headers' },
      { label: 'Celkové hodnotenia' },
    ]"
  >

  <div class="descriptive-div1">
<div class="descriptive-div2">
  V tejto sekcii je možné ohodnotiť Vám pridelený článok. 
  Hodnotíte odpoveďami na otázky - známkou v prvej sekcii,
  výberom odpove áno/nie v druhej sekcii, vyjadrením sa v
  textovom okne v tretej sekcii.
  Odpovede odošlete zakliknutím tlačidla Potvrdiť dole vpravo.
  V prípade, že si odpovede po potvrdení formulára premyslíte,
  je možné ich potvrdiť do stanovených termínov.
  <br><br> <p class="p">PRAJEME PRÍJEMNÉ HODNOTENIE!</p>
</div>
</div>

  <HeaderLine
  label="ZVOLTE ZNÁMKU"
  ></HeaderLine>
  <div class="wrapper">
   
<table class="table table-striped caption-top">
  <!--<caption>List of users</caption>-->
  <thead>
    <tr>
      <th scope="col" class=""></th>
      <th scope="col" class="th-header A"> A</th>
      <th scope="col" class="th-header">B</th>
      <th scope="col" class="th-header">C</th>
      <th scope="col" class="th-header">D</th>
      <th scope="col" class="th-header">E</th>
      <th scope="col" class="th-header FX">FX</th>
    </tr>
  </thead>
  <tbody>

    <TableRow
      question="Zorientovanie sa študenta v danej problematike, 
        predovšetkým analýzou domácej a zahraničnej literatúry"
        radio-number="3">
    </TableRow>

    <TableRow
      question="Zorientovanie sa študenta v danej problematike, 
        predovšetkým analýzou domácej a zahraničnej literatúry">
    </TableRow>

    <TableRow
      question="Zorientovanie sa študenta v danej problematike, 
        predovšetkým analýzou domácej a zahraničnej literatúry">
    </TableRow>

    <TableRow
      question="Zorientovanie sa študenta v danej problematike, 
        predovšetkým analýzou domácej a zahraničnej literatúry">
    </TableRow>


    <TableRow
      question="Zorientovanie sa študenta v danej problematike, 
        predovšetkým analýzou domácej a zahraničnej literatúry">
    </TableRow>
    
    
  </tbody>
</table>
</div>

<!--TABULKA2-->

<HeaderLine
  label="VYBERTE ÁNO/NIE"
  ></HeaderLine>

  <TableSelect
  opinion="Zorientovanie sa študenta v danej problematike, 
      predovšetkým analýzou domácej a zahraničnej literatúry">
  </TableSelect>

  <TableSelect
  opinion="Zorientovanie sa študenta v danej problematike, 
      predovšetkým analýzou domácej a zahraničnej literatúry">
  </TableSelect>


<!--TABULKA 3-->

<HeaderLine
  label="VPÍŠTE STANOVISKO"
  ></HeaderLine>

  <TableTextArea
  opinion="Zorientovanie sa študenta v danej problematike, 
      predovšetkým analýzou domácej a zahraničnej literatúry">
  </TableTextArea>

<div class="button-holder">
          <MaterialButton
            variant="contained"
            color="success"
            class="w-auto me-2"
            size="md"
            style="font-family: 'Open Sans' !important">
            ODOSLAŤ
          </MaterialButton>
</div>


  </BaseLayout>
</template>
