<script setup>
import { onMounted } from "vue";
import BaseLayout from "@/layouts/sections/components/BaseLayout.vue";
import setMaterialInput from "@/assets/js/material-input";

onMounted(() => {
  setMaterialInput();
});
</script>

<template>
  <BaseLayout
    title="Hodnotenie"
    :breadcrumb="[
      { label: 'Moje Práce', route: '/student/home/my-essays' },
      { label: 'Hodnotenie' }
    ]"
  >
    <div class="info-horizontal border-radius-xl d-block d-md-flex justify-content-between align-items-center bg-light p-3">
      <div>
        <h5 class="text-dark mb-3">{{ name }}</h5>

        <div class="mb-3">
          <span v-if="status === 'Schvaľujem'" class="text-success fw-bold">
            {{ status }}
          </span>
          <span v-else class="text-danger fw-bold">
            {{ status }}
          </span>
        </div>

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
            <strong>Prínos (silné stránky) práce:</strong> {{ text1 }}
          </p>
          <p class="text-muted">
            <strong>Nedostatky (slabé stránky) práce:</strong> {{ text2 }}
          </p>
        </details>
      </div>
    </div>
  </BaseLayout>
</template>

<script>
export default {
  computed: {
    grades() {
      return [
        { label: "Aktuálnosť a náročnosť práce", value: this.grade1 },
        { label: "Zorientovanie sa v problematike", value: this.grade2 },
        { label: "Vhodnosť metód", value: this.grade3 },
        { label: "Rozsah výsledkov", value: this.grade4 },
        { label: "Analýza výsledkov", value: this.grade5 },
        { label: "Štruktúra práce", value: this.grade6 },
        { label: "Formálna úroveň", value: this.grade7 },
        { label: "Analýza a interpretácia výsledkov", value: this.grade8 },
        { label: "Prehľadnosť práce", value: this.grade9 },
        { label: "Zorientovanie sa v literatúre", value: this.grade10 }
      ];
    },
    yesnoItems() {
      return [
        { label: "Práca zodpovedá šablóne", value: this.yesno1 },
        { label: "Chýba názov práce", value: this.yesno2 },
        { label: "Chýba meno autora", value: this.yesno3 },
        { label: "Chýba emailová adresa", value: this.yesno4 },
        { label: "Chýba abstrakt", value: this.yesno5 },
        { label: "Abstrakt nespĺňa rozsah", value: this.yesno6 },
        { label: "Chýbajú kľúčové slová", value: this.yesno7 },
        { label: "Chýba 'Úvod', 'Výsledky', 'Záver'", value: this.yesno8 },
        { label: "Chýbajú zdroje", value: this.yesno9 },
        { label: "Chýbajú referencie", value: this.yesno10 },
        { label: "Chýbajú referencie obrázkov", value: this.yesno11 },
        { label: "Obrázkom chýba popis", value: this.yesno12 }
      ];
    }
  }
};
</script>

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
