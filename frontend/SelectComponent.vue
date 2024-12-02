<script setup>

import { ref, onMounted } from "vue";

defineProps({
  label: {
    type: String,
    default: "",
  },
  alignLabel: { // center, start
    type: [String, Array],
    default: "" // Môžeš nastaviť aj predvolenú hodnotu
  }
});

// Reaktivní proměnná pro možnosti
const options = ref([]);

// Simulovaná funkce pro načítání dat z databáze
const fetchOptions = async () => {
  // Nahraďte tímto voláním API, pokud používáte backend
  return new Promise((resolve) => {
    setTimeout(() => {
      resolve([
        { value: 1, text: "UKF" },
        { value: 2, text: "UCM" },
        { value: 3, text: "UMB" },
      ]);
    }, 1000); // Simulace zpoždění
  });
};

// Načítání dat při prvním vykreslení
onMounted(async () => {
  options.value = await fetchOptions();
});
</script>

<template>
<div class="wrapper">
    <div class="container">
    <div class="row">
      <p :class="alignLabel"> {{ label }} </p>
    </div>
    <div class="row pad-fsel">
      <select class="form-select mb-3">
        <option disabled selected>Otvoriť možnosti</option>
          <option
            v-for="option in options"
            :key="option.value"
            :value="option.value"
          >
          {{ option.text }}
        </option>
  </select>
    </div>
  </div>
  </div>
</template>

<style setup scoped>

.center {
    text-align: center !important;
  }

  .start {
    text-align: start !important;
  }

  .color-font-green {
    color: green !important;
  }

  .color-font-black {
    color: black !important;
  }

  .wrapper {
  width:100%;
  display: flex;
  justify-content: center;
  align-items: center;
  padding: 0px !important;
}

select .form-select {
    width:100% !important
}

.row {
    width:100% !important
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

.pad-fsel {
  padding: 0px 12px !important;
}

.container {
  padding: 0px !important;
}
</style>