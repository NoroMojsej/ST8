<script setup>
import { defineProps, defineEmits } from "vue";

// Define emits to handle the value update
const emit = defineEmits();

// Define props
defineProps({
  id: {
    type: String,
    default: "",
  },
  type: {
    type: String,
    default: "text",
  },
  label: {
    type: [String, Object],
    default: () => ({
      text: "",
      class: "",
    }),
  },
  modelValue: {
    type: String,
    default: "",
  },
  placeholder: {
    type: String,
    default: "",
  },
  size: {
    type: String,
    default: "md",
  },
  error: {
    type: Boolean,
    default: false,
  },
  success: {
    type: Boolean,
    default: false,
  },
  isRequired: {
    type: Boolean,
    default: false,
  },
  isDisabled: {
    type: Boolean,
    default: false,
  },
  inputClass: {
    type: String,
    default: "",
  },
  icon: {
    type: String,
    default: "",
  },
});

// Emit the updated value when the input changes
const updateValue = (event) => {
  emit("update:modelValue", event.target.value);
};

function getClasses(size, success, error) {
  let sizeValue, isValidValue;

  sizeValue = size && `form-control-${size}`;

  if (error) {
    isValidValue = "is-invalid";
  } else if (success) {
    isValidValue = "is-valid";
  } else {
    isValidValue = "";
  }

  return `${sizeValue} ${isValidValue}`;
}
</script>

<template>
  <div class="input-group">
    <h6 v-if="label" :class="label.class" style="color:#4caf50; font-weight: 350;">
      {{ typeof label === 'string' ? label : label.text }}
    </h6>
    <div class="input-group-prepend">
      <span v-if="icon" class="input-group-text p-2">
        <i :class="icon" aria-hidden="true" style="color:#4caf50"></i>
      </span>
    </div>
    <input
      :id="id"
      :type="type"
      class="form-control"
      :class="[getClasses(size, success, error), inputClass]"
      :value="modelValue" 
      :placeholder="placeholder"
      :required="isRequired"
      :disabled="isDisabled"
      @input="updateValue"
    />
  </div>
</template>
