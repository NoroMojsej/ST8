<script setup>
defineProps({
  color: {
    type: String,
    required: true,
  },
  label: {
    type: String,
    default: "",
  },
});
</script>


<template>

<h5 class="style">{{ label }}</h5>

</template>


<style>

.style {
color: #66bb6a !important;
margin: 0px !important;
font-family: 'Montserrat', sans-serif !important;
font-weight: 400 !important;
border-bottom: solid;
border-color: #66bb6a;
}

</style>