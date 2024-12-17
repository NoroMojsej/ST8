<script setup>
defineProps({
  color: {
    type: Object,
    default: () => ({
      text: "",
      background: "bg-gray-100",
    }),
    validator(value) {
      return (
        typeof value === "object" &&
        [
          "primary",
          "secondary",
          "info",
          "success",
          "warning",
          "error",
          "light",
          "dark",
          "white",
        ].includes(value.background)
      );
    },
  },
  customClass: {
    type: String,
    required: true,
  },
  title: {
    type: String,
    required: true,
  },
  description: {
    type: String,
    required: true,
  },
  action: {
    type: Object,
    required: true,
    default: () => ({
      label: {
        text: "",
        color: "",
      },
      route: "",
      to: "",
    }),
  },
});
</script>


<template>
  <div
    class="info-horizontal border-radius-xl d-block d-md-flex"
    :class="`${color.background ?? ''}`"
  >
    <i :class="customClass"></i>
    <div class="ps-0 ps-md-3 mt-3 mt-md-0">
      <h5 :class="`text-${color.text ?? ''}`">{{ title }}</h5>
      <p :class="`text-${color.text ?? ''} description`">
        {{ description }}
      </p>
      <!-- Conditional rendering for routing or external links -->
      <router-link
        v-if="action.to"
        :to="action.to"
        class="icon-move-right"
        :class="`text-${action.label.color ?? 'success'}`"
      >
      <div class="d-flex justify-content-start">
      <i class="bi bi-arrow-right-circle-fill fs-2"></i>
    </div>
      </router-link>
      <a
        v-else-if="action.route"
        :href="action.route"
        class="icon-move-right"
        :class="`text-${action.label.color ?? 'success'}`"
      >
        {{ action.label.text }}
        <i class="fas fa-arrow-right text-sm ms-1"></i>
      </a>
    </div>
  </div>
</template>

<style scoped>

* {
  font-family: 'Montserrat', sans-serif !important;
}

.description {
  font-weight: 400 !important
}

.white {
  color: white !important
}

</style>