<script setup>
import { onMounted } from "vue";
import MaterialButton from "@/components/MaterialButton.vue";
import HeaderLine from "/HeaderLine.vue";
import TableRow from "/TableRow.vue";
import TableSelect from "/TableSelect.vue";
import TableTextArea from "/TableTextArea.vue";
import { reactive } from "vue";
import axiosInstance from '@/axios'; // Import axios instance

// Sections components
import BaseLayout from "@/layouts/sections/components/BaseLayout.vue";

// nav-pills
import setNavPills from "@/assets/js/nav-pills.js";

// hook
onMounted(() => {
  setNavPills();
});
</script>

<style setup scoped>
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

<script>


    const approveWork = () => {
      review.status = 'YY';
      review.status_desc = 'Work has been approved.';
    };

    const disapproveWork = () => {
      review.status = 'NN';
      review.status_desc = 'Work has not been approved.';
    };


    const today = () => {
      const newDate = new Date();
      const day = String(newDate.getDate()).padStart(2, '0');
      const month = String(newDate.getMonth() + 1).padStart(2, '0');
      const year = newDate.getFullYear();

      return `${year}-${month}-${day}`;
    };

    const twoYearsFromNow = () => {
      const newDate = new Date();
      newDate.setFullYear(newDate.getFullYear() + 2);

      const day = String(newDate.getDate()).padStart(2, '0');
      const month = String(newDate.getMonth() + 1).padStart(2, '0');
      const year = newDate.getFullYear();

      return `${year}-${month}-${day}`;
    };

    const review = reactive({
      grade1: null,
      grade2: null,
      grade3: null,
      grade4: null,
      grade5: null,
      grade6: null,
      grade7: null,
      grade8: null,
      grade9: null,
      grade10: null,

      user_iduser: 2,     //TODO: lokalny user v db, bude treba aktualizovat na pouzivatela ktoreho praca je hodnotena

      yesno1: "",
      yesno2: "",
      yesno3: "",
      yesno4: "",
      yesno5: "",
      yesno6: "",
      yesno7: "",
      yesno8: "",
      yesno9: "",
      yesno10: "",
      yesno11: "",
      yesno12: "",
      yesno13: "",
      yesno14: "",

      txt_plus: "",
      txt_minus: "",
      txt_general: "",

      status: "",
      status_desc: "",


      valid_from: today(),
      valid_to: twoYearsFromNow(),
      
    });

    const submitReview = async () => {
        try {
          console.log(review);
          const response = await axiosInstance.post('/submit-review', review, {
            headers: {
              'Content-Type': 'application/json',
            },
          });

          console.log('Review submitted successfully:', response.data);
        } catch (error) {
          console.error('Error submitting review:', error.response?.data || error.message);
        }
      };

</script>

<template>
  <BaseLayout
 title="Hodnotenie Práce"
    :breadcrumb="[
      { label: 'Práce na Hodnotenie', route: '/reviewer/home' },
      { label: 'Hodnotenie Práce' },
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

<table class="table caption-top">
  <!--<caption>List of users</caption>-->
  <thead>
    <tr>
      <th scope="col" class=""></th>
      <th scope="col" class="th-header">A</th>
      <th scope="col" class="th-header">B</th>
      <th scope="col" class="th-header">C</th>
      <th scope="col" class="th-header">D</th>
      <th scope="col" class="th-header">E</th>
      <th scope="col" class="th-header FX">FX</th>
    </tr>
  </thead>
  <tbody>

    <TableRow
      id="grade1" 
      question="Aktuálnosť a náročnosť práce"
      radio-number="1"
      @update="review.grade1 = $event"
      >
    </TableRow>

    <TableRow
      id="grade2" 
      question="Zorientovanie sa študenta v danej problematike, predovšetkým analýzou domácej a zahraničnej literatúry"
      radio-number="2"
      @update="review.grade2 = $event"
      >
    </TableRow>

    <TableRow
      id="grade3" 
      question="Vhodnosť zvolených metód spracovania riešenej problematiky"
      radio-number="3"
      @update="review.grade3 = $event"
      >
    </TableRow>

    <TableRow
      id="grade4" 
      question="Rozsah a úroveň dosiahnutých výsledkov"
      radio-number="4"
      @update="review.grade4 = $event"
      >
    </TableRow>

    <TableRow
      id="grade5" 
      question="Analýza a interpretácia výsledkov a formulácia záverov práce"
      radio-number="5"
      @update="review.grade5 = $event"
      >
    </TableRow>

    <TableRow
      id="grade6" 
      question="Prehľadnosť a logická štruktúra práce"
      radio-number="6"
      @update="review.grade6 = $event"
      >
    </TableRow>

    <TableRow
      id="grade7" 
      question="Formálna, jazyková a štylistická úroveň práce"
      radio-number="7"
      @update="review.grade7 = $event"
      >
    </TableRow>

    <TableRow
      id="grade8" 
      question="Analýza a interpretácia výsledkov a formulácia záverov práce"
      radio-number="8"
      @update="review.grade8 = $event"
      >
    </TableRow>

    <TableRow
      id="grade9" 
      question="Prehľadnosť a logická štruktúra práce"
      radio-number="9"
      @update="review.grade9 = $event"
      >
    </TableRow>

    <TableRow
      id="grade10" 
      question="Prehľadnosť a logická štruktúra práce"
      radio-number="10"
      @update="review.grade10 = $event"
      >
    </TableRow>
    
  </tbody>
</table>
</div>

<!--TABULKA2-->

<HeaderLine
  label="VYBERTE ÁNO/NIE"
  ></HeaderLine>

  <TableSelect
     id="yesno1" 
      opinion="Zorientovanie sa študenta v danej problematike, predovšetkým analýzou domácej a zahraničnej literatúry"
      v-model="review.yesno1"
      >
  </TableSelect>
                                                              
                                                            <!-- pre Git ovanim vymeniť : -->

  
 <TableSelect
    id="yesno2" 
    opinion="Práca zodpovedá šablóne určenej pre ŠVK"
    v-model="review.yesno2"
    >
  </TableSelect>

  <TableSelect
    id="yesno3" 
    opinion="Chýba názov práce v slovenskom alebo anglickom jazyku" 
    v-model="review.yesno3"
    >
  </TableSelect>

  <TableSelect
    id="yesno4" 
    opinion="Chýba meno autora alebo školiteľa" 
    v-model="review.yesno4"
    >
  </TableSelect>

  <TableSelect
    id="yesno5" 
    opinion="Chýba pracovná emailová adresa autora alebo školiteľa" 
    v-model="review.yesno5"
    >
  </TableSelect>

  <TableSelect
    id="yesno6" 
    opinion="Chýba abstrakt v slovenskom alebo anglickom jazyku" 
    v-model="review.yesno6"
    >
  </TableSelect>

  <TableSelect
    id="yesno7" 
    opinion="Abstrakt nespĺňa rozsah 100 - 150 slov" 
    v-model="review.yesno7"
    >
  </TableSelect>

  <TableSelect
    id="yesno8" 
    opinion="Chýbajú kľúčové slová v slovenskom alebo v anglickom jazyku" 
    v-model="review.yesno8"
    >
  </TableSelect>

  <TableSelect
    id="yesno9" 
    opinion="Chýba 'Úvod', 'Výsledky a diskusia' alebo 'Záver'" 
    v-model="review.yesno9"
    >
  </TableSelect>

  <TableSelect
    id="yesno10" 
    opinion="Nie sú uvedené zdroje a použitá literatúra" 
    v-model="review.yesno10"
    >
  </TableSelect>

  <TableSelect
    id="yesno11" 
    opinion="V texte chýbajú referencie na zoznam bibliografie" 
    v-model="review.yesno11"
    >
  </TableSelect>

  <TableSelect
    id="yesno12" 
    opinion="V texte chýbajú referencie na použité obrázky alebo tabuľky" 
    v-model="review.yesno12"
    >
  </TableSelect>
  
  <TableSelect
    id="yesno13" 
    opinion="Obrázkom alebo tabuľkám chýba popis" 
    v-model="review.yesno13"
    >
  </TableSelect>

  <TableSelect
    id="yesno14" 
    opinion="Chýba meno autora alebo školiteľa" 
    v-model="review.yesno14"
    >
  </TableSelect>
<!--TABULKA 3-->

<HeaderLine
  label="VPÍŠTE STANOVISKO"
  ></HeaderLine>

  <TableTextArea
    opinion="Prínos (silné stránky) práce"
    v-model="review.txt_plus" >
  </TableTextArea>

  <TableTextArea
    opinion="Nedostatky (slabé stránky) práce"
    v-model="review.txt_minus">
  </TableTextArea>


  <HeaderLine
  label="CELKOVÉ STANOVISKO"
  ></HeaderLine>

  <section class="py-7 m-3 bg-gray-100">
    <div class="container">
      <div class="row justify-space-between text-center py-2">
        <div class="col-6 mx-auto">
          <div class="btn-group" role="group" aria-label="Basic example">
            <MaterialButton size="lg" variant="outline" color="success" @click="approveWork">
              SCHVAĽUJEM PRÁCU
            </MaterialButton>
            <MaterialButton size="lg" variant="outline" color="success" @click="disapproveWork">
              NESCHVAĽUJEM PRÁCU
            </MaterialButton>
          </div>
        </div>
      </div>
    </div>
  </section>



<div class="button-holder">
          <MaterialButton
            variant="contained"
            color="success"
            class="w-auto me-2"
            size="lg"
            @click="submitReview"
            style="font-family: 'Open Sans' !important">
            ODOSLAŤ
          </MaterialButton>
</div>


  </BaseLayout>
</template>
