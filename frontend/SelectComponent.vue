<script setup>
defineProps({
  label: {
    type: String,
    default: "",
  },
  placeholder: {
    type: String,
    default: "",
  },
  options: {
    type: Array,
    default: () => [],
  },
  modelValue: {  // Pre v-model viazanie
    type: [String, Number, null],
    default: null,
  },
});

const emit = defineEmits(['update:modelValue']);  // Emit pre v-model
</script>

<template>
  <div class="mt-2 mb-2">
    <h6>{{ label }}</h6>
    <select 
      id="univerzita" 
      class="form-select" 
      aria-label="Category"
      :value="modelValue"  
      @change="event => emit('update:modelValue', event.target.value)"
    >
      <option selected disabled>{{ placeholder }}</option>
      <option 
        v-for="(option, index) in options" 
        :key="index"
        :value="option.name"
      >
        {{ option.name }}
      </option>
    </select>
  </div>
</template>

<style scoped>

h6 {
  color: #4caf50; 
  font-weight: 350;
}

select{
    border: solid;
    border-width: thin !important;
    border-top: 0px;
    border-right: 0px;
    border-left: 0px;
    border-radius: 0px;
    border-color: #4caf50;
}

</style>
