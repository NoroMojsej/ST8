<script setup>
defineProps({
  opinion: {
    type: String,
    default: "",
  }
});
</script>

<template setup scoped>
<div class="wrapper">
    <div class="container">
    <div class="row">
      <p class="question"> {{ opinion }} </p>
    </div>
    <div class="row answear">
      <select class="form-select form-select-lg mb-3" aria-label="Large select example">
    <option selected>Otvoriť možnosti</option>
    <option value="1">Áno</option>
    <option value="2">Nie</option>
  </select>
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

  .wrapper {
  width:100%;
  display: flex;
  justify-content: center;
  align-items: center;
  padding-top: 35px;
}

.container {
    padding-top: 30px
}

.form-select {
  border:solid !important;
  border-color:  #66bb6a !important;
  border-width: 0.1cap !important;
  border-top: 0px !important;
  border-left: 0px !important;
  border-right: 0px !important;
  border-radius: 0px !important ;
  max-width: 50% !important;
}

  .row.answear {
  display: flex;
  justify-content: center;
}

.question {
  display: flex;
  justify-content: center;
}

</style>