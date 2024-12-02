<script setup>
defineProps({
  question: {
    type: String,
    default: "",
  },
  radioNumber:{
    type: String,
    default: "",
  },
});
</script>

<template>

<tr>
      <td  scope="row" class="question-table text-wrap">
        <p class="question">
       {{question}}
      </p>
    </td>

      <td class="td-wrapper"><div class="form-check">
        <input class="form-check-input" type="radio"  :name="`flexRadioDefault${radioNumber}`"
        :id="`flexRadioDefault${radioNumber}`">
  <label class="form-check-label" for="flexRadioDefault3">
  </label>
</div></td>
      <td class="td-wrapper"><div class="form-check">
  <input class="form-check-input" type="radio" name="flexRadioDefault3" id="flexRadioDefault3">
  <label class="form-check-label" for="flexRadioDefault3">
  </label>
</div></td>
      <td class="td-wrapper"><div class="form-check">
  <input class="form-check-input" type="radio" name="flexRadioDefault3" id="flexRadioDefault3">
  <label class="form-check-label" for="flexRadioDefault3">
  </label>
</div></td>
<td class="td-wrapper"><div class="form-check">
  <input class="form-check-input" type="radio" name="flexRadioDefault3" id="flexRadioDefault3">
  <label class="form-check-label" for="flexRadioDefault3">
  </label>
</div></td>
<td class="td-wrapper"><div class="form-check">
  <input class="form-check-input" type="radio" name="flexRadioDefault3" id="flexRadioDefault3">
  <label class="form-check-label" for="flexRadioDefault3">
  </label>
</div></td>
<td class="td-wrapper"><div class="form-check">
  <input class="form-check-input" type="radio" name="flexRadioDefault3" id="flexRadioDefault3">
  <label class="form-check-label" for="flexRadioDefault3">
  </label>
</div></td>
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