<script setup>
import { onMounted } from "vue";
import MaterialButton from "@/components/MaterialButton.vue";
import HeaderLine from "/HeaderLine.vue";
import TableRow from "/TableRow.vue";
import TableSelect from "/TableSelect.vue";
import TableTextArea from "/TableTextArea.vue";
import { reactive } from "vue";
import axiosInstance from '@/axios';
import { ref } from 'vue';
import { useRouter } from "vue-router";

// Sections components
import BaseLayout from "@/layouts/sections/components/BaseLayout.vue";

// nav-pills
import setNavPills from "@/assets/js/nav-pills.js";

const router = useRouter();

defineExpose({
  router,
});

// hook
onMounted(() => {
  setNavPills();
  getReviewById();
  const session = JSON.parse(localStorage.getItem('session'));
        console.log("Logged in user:", session.user_id);
  

});

    const approveWork = () => {
      review.review_status_idreview_status = 1;

    };

    const disapproveWork = () => {
      review.review_status_idreview_status = 2;
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

    const getReviewIdFromURL = () => {
    const reviewId = router.currentRoute.value.params.id;

        if (reviewId) {
          console.log("ID extracted from URL:", reviewId);
          return reviewId;
        } else {
          console.log("No ID found in URL. Creating new review.");

        }

        
    };



    const review = reactive({
      id: null,
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

      user_iduser: null,      //logged in reviewer

      yesno1: null,
      yesno2: null,
      yesno3: null,
      yesno4: null,
      yesno5: null,
      yesno6: null,
      yesno7: null,
      yesno8: null,
      yesno9: null,
      yesno10: null,
      yesno11: null,
      yesno12: null,
      yesno13: null,
      yesno14: null,

      txt_plus: null,
      txt_minus: null,
      txt_general: null,

      review_status_idreview_status: null,

      valid_from: null,
      valid_to: null,

      created_on: null,
      updated_on: null,

      validationErrorsPresent: false, 
      
    });

    const openSavedReview = (newReviewId) => {
          console.log(newReviewId);
          router.push({ name: "evaluation", params: { id: newReviewId } });
    };
    
    const gradeQuestions = ref([
      { question: "Aktuálnosť a náročnosť práce", number: 1, key: "grade1", error: "Prosím doplňte hodnotenie."},
      { question: "Zorientovanie sa študenta v danej problematike, predovšetkým analýzou domácej a zahraničnej literatúry", number: 2, key: "grade2", error: "Prosím doplňte hodnotenie." },
      { question: "Vhodnosť zvolených metód spracovania riešenej problematiky", number: 3, key: "grade3", error: "Prosím doplňte hodnotenie." },
      { question: "Rozsah a úroveň dosiahnutých výsledkov", number: 4, key: "grade4", error: "Prosím doplňte hodnotenie." },
      { question: "Analýza a interpretácia výsledkov a formulácia záverov práce", number: 5, key: "grade5", error: "Prosím doplňte hodnotenie." },
      { question: "Prehľadnosť a logická štruktúra práce", number: 6, key: "grade6", error: "Prosím doplňte hodnotenie." },
      { question: "Formálna, jazyková a štylistická úroveň práce", number: 7, key: "grade7", error: "Prosím doplňte hodnotenie." },
      { question: "Analýza a interpretácia výsledkov a formulácia záverov práce", number: 8, key: "grade8", error: "Prosím doplňte hodnotenie." },
      { question: "Prehľadnosť a logická štruktúra práce", number: 9, key: "grade9", error: "Prosím doplňte hodnotenie." },
      { question: "Prehľadnosť a logická štruktúra práce", number: 10, key: "grade10", error: "Prosím doplňte hodnotenie." },
      

    ]);

    const yesNoQuestions = ref ([
      { question: "Zorientovanie sa študenta v danej problematike, predovšetkým analýzou domácej a zahraničnej literatúry", key: "yesno1", error: "Proím odpovedzte na túto otázku." },
      { question: "Práca zodpovedá šablóne určenej pre ŠVK", key: "yesno2", error: "Proím odpovedzte na túto otázku." },
      { question: "Chýba názov práce v slovenskom alebo anglickom jazyku", key: "yesno3", error: "Proím odpovedzte na túto otázku." },
      { question: "Chýba meno autora alebo školiteľa", key: "yesno4", error: "Proím odpovedzte na túto otázku." },
      { question: "Chýba pracovná emailová adresa autora alebo školiteľa", key: "yesno5", error: "Proím odpovedzte na túto otázku." },
      { question: "Chýba abstrakt v slovenskom alebo anglickom jazyku", key: "yesno6", error: "Proím odpovedzte na túto otázku." },
      { question: "Abstrakt nespĺňa rozsah 100 - 150 slov", key: "yesno7", error: "Proím odpovedzte na túto otázku." },
      { question: "Chýbajú kľúčové slová v slovenskom alebo v anglickom jazyku", key: "yesno8", error: "Proím odpovedzte na túto otázku." },
      { question: "Chýba 'Úvod', 'Výsledky a diskusia' alebo 'Záver'", key: "yesno9", error: "Proím odpovedzte na túto otázku." },
      { question: "Nie sú uvedené zdroje a použitá literatúra", key: "yesno2", error: "Proím odpovedzte na túto otázku." },
      { question: "V texte chýbajú referencie na zoznam bibliografie", key: "yesno11", error: "Proím odpovedzte na túto otázku." },
      { question: "V texte chýbajú referencie na použité obrázky alebo tabuľky", key: "yesno12", error: "Proím odpovedzte na túto otázku." },
      { question: "Obrázkom alebo tabuľkám chýba popis", key: "yesno13", error: "Proím odpovedzte na túto otázku." }, 
      { question: "Chýba meno autora alebo školiteľa", key: "yesno14", error: "Proím odpovedzte na túto otázku." },
    ]);

    const updateReview = (key, value) => {      
      review[key] = value;
      // console.log(review);
    };

    const getReviewById = async () => {
      const reviewId = getReviewIdFromURL();
      if (!reviewId) return;  


      try {
        const response = await axiosInstance.get('/reviews/get-review/' + reviewId, {
          headers: {
            'Content-Type': 'application/json',
          },
        });

        console.log('Review retrieved successfully:', response.data);

        

        review.id = response.data.idreview;
        review.grade1 = response.data.grade1;
        review.grade2 = response.data.grade2;
        review.grade3 = response.data.grade3;
        review.grade4 = response.data.grade4;
        review.grade5 = response.data.grade5;
        review.grade6 = response.data.grade6;
        review.grade7 = response.data.grade7;
        review.grade8 = response.data.grade8;
        review.grade9 = response.data.grade9;
        review.grade10 = response.data.grade10;

        review.yesno1 = response.data.yesno1;
        review.yesno2 = response.data.yesno2;
        review.yesno3 = response.data.yesno3;
        review.yesno4 = response.data.yesno4;
        review.yesno5 = response.data.yesno5;
        review.yesno6 = response.data.yesno6;
        review.yesno7 = response.data.yesno7;
        review.yesno8 = response.data.yesno8;
        review.yesno9 = response.data.yesno9;
        review.yesno10 = response.data.yesno10;
        review.yesno11 = response.data.yesno11;
        review.yesno12 = response.data.yesno12;
        review.yesno13 = response.data.yesno13;
        review.yesno14 = response.data.yesno14;

        review.txt_plus = response.data.txt_plus;
        review.txt_minus = response.data.txt_minus;
        review.txt_general = response.data.txt_general;

        review.review_status_idreview_status = response.data.review_status_idreview_status;

        review.user_iduser = response.data.user_iduser;

        review.valid_from = response.data.valid_from;
        review.valid_to = response.data.valid_to;

        review.created_on = response.data.created_on;
        review.updated_on = response.data.updated_on;

        
      } catch (error) {
        console.log('review.id: ', review.id);
        console.error('Review retrieving failed:', error.response?.data || error.message);
      }
    };

    const submitReview = async () => {
        try {
          review.valid_from = today();
          review.valid_to = twoYearsFromNow();
          review.validationErrorsPresent = false;

          
          console.log(review);

          const response = await axiosInstance.post('/reviews/save-review', review, {
            headers: {
              'Content-Type': 'application/json',
            },
          });
          
          
          console.log('Review submitted successfully:', response.data);
          // openSavedReview(response.data.review_id);
         


        } catch (error) {
          if (error.response && error.response.status === 422) {
            const validationErrors = error.response.data.errors;

            review.validationErrorsPresent = true;

            console.error('Validation Errors:', validationErrors);
          } else {
            console.error('Error submitting review:', error.response?.data || error.message);
            alert('An unexpected error occurred. Please try again later.');
          }
        }
      };
      

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
  color=""
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
      <th scope="col" class="th-header">FX</th>
    </tr>
  </thead>
  <tbody>
    
    <TableRow 
      v-for="(question) in gradeQuestions" 
          :key="question.key"
          :question="question.question"
          :radio-number="question.number"
          :value="review[question.key]"
          @update="updateReview(question.key, $event)" 
    ></TableRow> 

  </tbody>
</table>
</div>

<!--TABULKA2-->

<HeaderLine
  label="VYBERTE ÁNO/NIE"
  color=""
  ></HeaderLine>

  <TableSelect
    v-for="(question) in yesNoQuestions"
    :id="question.key"
    :opinion="question.question"
    :value="review[question.key]" 
    @update="updateReview(question.key, $event)"
  ></TableSelect>

  

<!--TABULKA 3-->

  <HeaderLine
    label="VPÍŠTE STANOVISKO"
    color=""
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
    color=""
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
            @click="submitReview()"
            style="font-family: 'Open Sans' !important">
            ODOSLAŤ
          </MaterialButton>
</div>

<div style="text-align: center;">
  <p style="color: red;" v-if="review.validationErrorsPresent">Prosím vyplňte všetky údaje</p>
</div>

  </BaseLayout>
</template>
