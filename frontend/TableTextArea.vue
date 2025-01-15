<script setup>
defineProps({
  opinion: {
    type: String,
    default: "",
  },
  modelValue: {
    type: String,
    default: "",
  },
});

defineEmits(["update:modelValue"]);
</script>

<template>
    <div class="wrapper">
      <div class="container">
        <div class="row">
          <p class="question"> {{ opinion }} </p>
        </div>
        <div class="row answear">
          <div class="form-group">
            <textarea 
              class="form-control" 
              id="exampleFormControlTextarea1" 
              rows="3" 
              :value="modelValue"
              @input="$emit('update:modelValue', $event.target.value)"
            ></textarea>
          </div>
        </div>
      </div>
    </div>
  </template>

<style setup scoped>

th.question-table {
  align-items: center !important;
  display: flex;
  justify-content: center;
  max-width: 50% !important;
  background-color: green !important;
  ;
}

.question {
    text-align: center !important;
  }

  .wrapper {
  width:100%;
  padding-top: 35px;
}

.form-group {
  display: flex !important;
  justify-content: center !important;
  align-items: center !important;
}

textarea {
  width: 50%;
  border:solid !important;
  border-color:  #66bb6a !important;
  border-width: 0.1cap !important;
  border-top: 0px !important;
  border-left: 0px !important;
  border-right: 0px !important;
  border-radius: 0px !important ;
}

</style>