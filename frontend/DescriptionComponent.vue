<script setup>

defineProps({
  description: {
    type: String,
    default: "",
  },
});

</script>

<template>

<div class="container pt-4">
   
    <p class="font-weight-normal"> {{ description }} </p>

</div>

</template>