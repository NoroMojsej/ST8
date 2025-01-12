<script setup>
import { ref, onMounted } from "vue";
import BaseLayout from "@/layouts/sections/components/BaseLayout.vue";
import setMaterialInput from "@/assets/js/material-input";
import { useRoute } from "vue-router";
import axiosInstance from '@/axios';

const route = useRoute();
const essayID = ref(null);
const reviewData = ref({});
const reviewStatus = ref("");

const grades = ref([]);
const labelsGradesItems = [
  "Aktuálnosť a náročnosť práce",
  "Zorientovanie sa v problematike",
  "Vhodnosť metód",
  "Rozsah výsledkov",
  "Analýza výsledkov",
  "Štruktúra práce",
  "Formálna úroveň",
  "Analýza a interpretácia výsledkov",
  "Prehľadnosť práce",
  "Zorientovanie sa v literatúre"
];


const yesnoItems = ref([]);
const labelsYesNoItems = [
  "Zorientovanie sa študenta v danej problematike, predovšetkým analýzou domácej a zahraničnej literatúry",
  "Práca zodpovedá šablóne určenej pre ŠVK",
  "Chýba názov práce v slovenskom alebo anglickom jazyku",
  "Chýba meno autora alebo školiteľa",
  "Chýba pracovná emailová adresa autora alebo školiteľa",
  "Chýba abstrakt v slovenskom alebo anglickom jazyku",
  "Abstrakt nespĺňa rozsah 100 - 150 slov",
  "Chýbajú kľúčové slová v slovenskom alebo v anglickom jazyku",
  "Chýba 'Úvod', 'Výsledky a diskusia' alebo 'Záver'",
  "Nie sú uvedené zdroje a použitá literatúra",
  "V texte chýbajú referencie na zoznam bibliografie",
  "V texte chýbajú referencie na použité obrázky alebo tabuľky",
  "Obrázkom alebo tabuľkám chýba popis",
  "Chýba meno autora alebo školiteľa",
];

const descriptions = ref({
  textPos: '',
  textNeg: ''
});


onMounted(() => {
  setMaterialInput();
  if (route.params) {
    essayID.value = route.params.idEssay;
    fetchEssayReview(essayID.value);
  }
});

async function fetchEssayReview(essayID) {
  try {
    const response = await axiosInstance.get(`/papers/${essayID}/review`);
    reviewData.value = response.data.review;
    grades.value = labelsGradesItems.map((label, index) => ({
      label,
      value: reviewData.value[`grade${index + 1}`], // Z databázy získa hodnotu pre daný index
    }));

    yesnoItems.value = labelsYesNoItems.map((label, index) => ({
      label,
      value: reviewData.value[`yesno${index + 1}`] == 1 ? "ÁNO" : "NIE",
    }));

    descriptions.value = {
      textPos: reviewData.value.txt_plus,
      textNeg: reviewData.value.txt_minus,
    };

    reviewStatus.value = response.data.status;
  } catch (err) {
    console.error('Chyba pri načítaní údajov:', err);
  }
}

</script>

<template>
  <BaseLayout title="Hodnotenie" :breadcrumb="[
    { label: 'Moje Práce', route: '/student/home/my-essays' },
    { label: 'Hodnotenie' }
  ]">
    <div
      class="info-horizontal border-radius-xl d-block d-md-flex justify-content-between align-items-center bg-light p-3">
      <div>

        <details class="mb-4">
          <summary class="text-dark fw-bold">HODNOTENIE</summary>
          <ul class="list-unstyled mt-2">
            <li v-for="(grade, index) in grades" :key="index" class="mb-2">
              <p class="text-muted">
                <strong>{{ grade.label }}:</strong> {{ grade.value }}
              </p>
            </li>
          </ul>
        </details>

        <details class="mb-4">
          <summary class="text-dark fw-bold">KONTROLA ŠABLÓNY</summary>
          <ul class="list-unstyled mt-2">
            <li v-for="(yesno, index) in yesnoItems" :key="index" class="mb-2">
              <p class="text-muted">
                <strong>{{ yesno.label }}:</strong> {{ yesno.value }}
              </p>
            </li>
          </ul>
        </details>

        <details class="mb-4">
          <summary class="text-dark fw-bold">DOPLŇUJÚCE INFORMÁCIE</summary>
          <p class="text-muted mt-2">
            <strong>Prínos (silné stránky) práce:</strong> {{ descriptions.textPos }}
          </p>
          <p class="text-muted">
            <strong>Nedostatky (slabé stránky) práce:</strong> {{ descriptions.textNeg }}
          </p>
        </details>

        <details class="mb-4">
          <summary class="text-dark fw-bold">STATUS</summary>
          <p class="text-muted mt-2">
            <strong> {{ reviewStatus.status_desc }} </strong>
          </p>
        </details>



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

summary {
  cursor: pointer;
  font-size: 1.1rem;
  margin-bottom: 0.5rem;
}

summary::marker {
  content: '\25BA';
  color: darkgray;
  margin-right: 0.5rem;
}

details[open] summary::marker {
  content: '\25BC';
}

.list-unstyled {
  padding-left: 1rem;
  list-style: none;
}

.text-success {
  color: limegreen !important;
}

.text-danger {
  color: darkred !important;
}
</style>
