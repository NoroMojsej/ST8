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
  handleEdit: {
    type: Function,
    required: true,
  },
  buttonText: {
    type: String,
    default: "Upraviť", // Default button text
  },
  optionalButton: {
    type: Object,
    default: null, // Default to null if no optional button is provided
    validator(value) {
      if (!value) return true;
      return (
        typeof value.text === "string" &&
        typeof value.onClick === "function" &&
        (!value.color || typeof value.color === "string")
      );
    },
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
    <div class="d-flex gap-2 mt-3 mt-md-0">
      <button class="btn btn-success" @click="handleEdit">{{ buttonText }}</button>
      <button
        v-if="optionalButton"
        class="btn"
        :class="optionalButton.color ? `btn-${optionalButton.color}` : 'btn-primary'"
        @click="optionalButton.onClick"
      >
        {{ optionalButton.text }}
      </button>
    </div>
  </div>
</template>
