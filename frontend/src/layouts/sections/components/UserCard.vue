<script setup>
import { ref, watch } from "vue";

const props = defineProps({
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
    default: "Priradiť Práce",
  },
  initialRole: {
    type: String,
    default: "Student",
  },
});

const selectedRole = ref(props.initialRole);

watch(
  () => props.initialRole,
  (newRole) => {
    selectedRole.value = newRole;
  }
);
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
    <div class="d-flex flex-column align-items-start mt-3 mt-md-0">
      <select v-model="selectedRole" class="form-select mb-2">
        <option value="Student">Študent</option>
        <option value="Recenzent">Recenzent</option>
      </select>
      <button
        v-if="selectedRole === 'Recenzent'"
        class="btn btn-success"
        @click="handleEdit"
      >
        {{ buttonText }}
      </button>
    </div>
  </div>
</template>
