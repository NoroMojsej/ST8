<script setup>
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
</script>

<template>
<div class="wrapper">
    <div class="container">
    <div class="row">
      <p :class="alignLabel"> {{ label }} </p>
    </div>
    <div class="row">
      <select class="form-select mb-3" aria-label="Large select example">
    <option selected>Otvoriť možnosti</option>
    <option value="1">Áno</option>
    <option value="2">Nie</option>
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
</style>