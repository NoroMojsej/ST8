<script setup>
defineProps({
  opinion: {
    type: String,
    default: "",
  }
});
</script>

<template>
    
<div class="wrapper">

    <div class="container">
    <div class="row">
      <p class="question"> {{ opinion }} </p>
    </div>
    <div class="row answear">
      <div class="form-group">
      <textarea class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
    </div>
    </div>
  </div>
</div>

  </template>

<style setup>

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
  display: flex;
  justify-content: center;
  align-items: center;
  padding-bottom: 35px;
  padding-top: 35px;
}

</style>