<script setup>
defineProps({
  question: {
    type: String,
    default: "",
  },
  radioNumber: {
    type: Number,
    default: "",
  },
  value: {
    type: String,
    default: "",
  },
});

const emit = defineEmits(["update"]);
</script>

<template>

<tr>
  <td scope="row" class="question-table text-wrap">
    <p class="question">{{ question }}</p>
  </td>

  <!-- A -->
  <td class="td-wrapper">
    <div class="form-check">
      <input
        class="form-check-input"
        type="radio"
        :name="`flexRadioDefault${radioNumber}`"
        :id="`flexRadioDefault${radioNumber}A`"
        value="A"
        v-model="value"
        @change="$emit('update', value)"
      />
      <label class="form-check-label" :for="`flexRadioDefault${radioNumber}A`"></label>
    </div>
  </td>

  <!-- B -->
  <td class="td-wrapper">
    <div class="form-check">
      <input
        class="form-check-input"
        type="radio"
        :name="`flexRadioDefault${radioNumber}`"
        :id="`flexRadioDefault${radioNumber}B`"
        value="B"
        v-model="value"
        @change="$emit('update', value)"
      />
      <label class="form-check-label" :for="`flexRadioDefault${radioNumber}B`"></label>
    </div>
  </td>

  <!-- C -->
  <td class="td-wrapper">
    <div class="form-check">
      <input
        class="form-check-input"
        type="radio"
        :name="`flexRadioDefault${radioNumber}`"
        :id="`flexRadioDefault${radioNumber}C`"
        value="C"
        v-model="value"
        @change="$emit('update', value)"
      />
      <label class="form-check-label" :for="`flexRadioDefault${radioNumber}C`"></label>
    </div>
  </td>

  <!-- D -->
  <td class="td-wrapper">
    <div class="form-check">
      <input
        class="form-check-input"
        type="radio"
        :name="`flexRadioDefault${radioNumber}`"
        :id="`flexRadioDefault${radioNumber}D`"
        value="D"
        v-model="value"
        @change="$emit('update', value)"
      />
      <label class="form-check-label" :for="`flexRadioDefault${radioNumber}D`"></label>
    </div>
  </td>

  <!-- E -->
  <td class="td-wrapper">
    <div class="form-check">
      <input
        class="form-check-input"
        type="radio"
        :name="`flexRadioDefault${radioNumber}`"
        :id="`flexRadioDefault${radioNumber}E`"
        value="E"
        v-model="value"
        @change="$emit('update', value)"
      />
      <label class="form-check-label" :for="`flexRadioDefault${radioNumber}E`"></label>
    </div>
  </td>

  <!-- FX-->
  <td class="td-wrapper">
    <div class="form-check">
      <input
        class="form-check-input"
        type="radio"
        :name="`flexRadioDefault${radioNumber}`"
        :id="`flexRadioDefault${radioNumber}FX`"
        value="FX"
        v-model="value"
        @change="$emit('update', value)"
      />
      <label class="form-check-label" :for="`flexRadioDefault${radioNumber}FX`"></label>
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
  padding: 0px !important;
  text-align: center !important; 
}

.question {
  text-align: center !important;
}
</style>