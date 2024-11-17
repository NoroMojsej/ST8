<script setup>
defineProps({
  color: {
    text: String,
    background: {
      validator(value) {
        return [
          "primary",
          "secondary",
          "info",
          "success",
          "warning",
          "error",
          "light",
          "dark",
          "white",
        ].includes(value);
      },
    },
    default() {
      return {
        text: "",
        background: "bg-gray-100",
      };
    },
  },
  icon: {
    type: Object,
    required: true,
    component: String,
    color: String,
  },
  title: {
    type: String,
    required: true,
  },
  description: {
    type: String,
    required: true,
  },
  handleDelete: {
    type: Function,
    required: true,
  },
});
</script>

<template>
  <div
    class="info-horizontal border-radius-xl d-block d-md-flex justify-content-between align-items-center"
    :class="`${color.background ?? ''}`"
  >
    <div class="d-flex">
      <i class="material-icons text-3xl" :class="`text-${icon.color}`">{{ icon.component }}</i>
      <div class="ps-0 ps-md-3 mt-3 mt-md-0">
        <h5 :class="`text-${color.text ?? ''}`">{{ title }}</h5>
        <p :class="`text-${color.text ?? ''}`">{{ description }}</p>
      </div>
    </div>
    <button class="btn btn-danger ms-3" @click="handleDelete">Odstrániť konferenciu</button>
  </div>
</template>
