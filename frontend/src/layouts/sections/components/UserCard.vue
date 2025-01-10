<script setup>
import { ref, watch } from "vue";

const props = defineProps({
  color: {
    type: Object,
    default: () => ({
      text: "", 
      background: "bg-gray-100",
    }),
    validator(value) {
      const validBackgroundColors = [
        "primary",
        "secondary",
        "info",
        "success",
        "warning",
        "error",
        "light",
        "dark",
        "white",
      ];
      return validBackgroundColors.includes(value.background);
    },
  },
  
  icon: {
    type: Object,
    required: true,
    default: () => ({
      component: "",
      color: "gray",
    }),
  },
  
  id: {
    type: Number,
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
    default: "STDNT",
  },
});

const selectedRole = ref(props.initialRole);
const emit = defineEmits();

const handleRoleChange = () => {
  emit('role-changed', { id: props.id, newRole: selectedRole.value });
};

watch(
  () => selectedRole.value,
  (newRole) => {
    console.log("Rola sa zmenila na: ", newRole);
  }
);
</script>

<template>
  <div
    class="info-horizontal border-radius-xl d-block d-md-flex justify-content-between align-items-center"
    :class="color.background"
  >
    <div class="d-flex">
      <i class="material-icons text-3xl" :class="`text-${icon.color}`">{{ icon.component }}</i>
      <div class="ps-0 ps-md-3 mt-3 mt-md-0">
        <h5 :class="`text-${color.text}`">{{ title }}</h5>
        <p :class="`text-${color.text}`">{{ description }}</p>
      </div>
    </div>
    <div class="d-flex flex-column align-items-start mt-3 mt-md-0">
      <select v-model="selectedRole" class="form-select mb-2" @change="handleRoleChange">
        <option value="STDNT">Študent</option>
        <option value="REVIW">Recenzent</option>
      </select>
      <button
        v-if="selectedRole === 'REVIW'"
        class="btn btn-success"
        @click="handleEdit"
      >
        {{ buttonText }}
      </button>
    </div>
  </div>
</template>
