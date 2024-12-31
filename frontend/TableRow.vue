<script setup>
defineProps({
  question: {
    type: String,
    default: "",
  },
  radioNumber: {
    type: String,
    default: "",
  },
});
</script>


<template>
  <tr>
    <!-- Question Column -->
    <td scope="row" class="question-table text-wrap">
      <p class="question">{{ question }}</p>
    </td>

    <!-- Radio Button Columns -->
    <td class="td-wrapper">
      <div class="form-check">
        <input
          class="form-check-input"
          type="radio"
          :name="`radioGroup${radioNumber}`"
          :id="`optionA${radioNumber}`"
        />
        <label class="form-check-label" :for="`optionA${radioNumber}`"></label>
      </div>
    </td>
    <td class="td-wrapper">
      <div class="form-check">
        <input
          class="form-check-input"
          type="radio"
          :name="`radioGroup${radioNumber}`"
          :id="`optionB${radioNumber}`"
        />
        <label class="form-check-label" :for="`optionB${radioNumber}`"></label>
      </div>
    </td>
    <td class="td-wrapper">
      <div class="form-check">
        <input
          class="form-check-input"
          type="radio"
          :name="`radioGroup${radioNumber}`"
          :id="`optionC${radioNumber}`"
        />
        <label class="form-check-label" :for="`optionC${radioNumber}`"></label>
      </div>
    </td>
    <td class="td-wrapper">
      <div class="form-check">
        <input
          class="form-check-input"
          type="radio"
          :name="`radioGroup${radioNumber}`"
          :id="`optionD${radioNumber}`"
        />
        <label class="form-check-label" :for="`optionD${radioNumber}`"></label>
      </div>
    </td>
    <td class="td-wrapper">
      <div class="form-check">
        <input
          class="form-check-input"
          type="radio"
          :name="`radioGroup${radioNumber}`"
          :id="`optionE${radioNumber}`"
        />
        <label class="form-check-label" :for="`optionE${radioNumber}`"></label>
      </div>
    </td>
    <td class="td-wrapper">
      <div class="form-check">
        <input
          class="form-check-input"
          type="radio"
          :name="`radioGroup${radioNumber}`"
          :id="`optionFX${radioNumber}`"
        />
        <label class="form-check-label" :for="`optionFX${radioNumber}`"></label>
      </div>
    </td>
  </tr>
</template>


<style scoped>

th.question-table {
  align-items: center !important;
  display: flex;
  justify-content: center;
  max-width: 50% !important;
  background-color: green !important;
  max-width: 300px !important;
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

.form-check {
  display: flex !important;
  justify-content: center !important;
}

.question {
  align-items: center !important;
  align-content: center !important;
  display: flex !important;
  justify-content: center !important;
}
</style>