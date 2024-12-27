<script setup>
defineProps({
  name: {
    type: String,
    required: true,
  },
  keywords: {
    type: Array,
    required: true,
    validator(value) {
      return value.every(keyword => typeof keyword === 'string');
    },
  },
  conferenceName: {
    type: String,
    required: true,
  },
  section: {
    type: String,
    required: true,
  },
  status: {
    type: String,
    required: true,
  },
  showEditButton: {
    type: Boolean,
    default: true,
  },
  showEvaluationButton: {
    type: Boolean,
    default: false,
  },
  handleEdit: {
    type: Function,
    required: true,
  },
  handleEvaluation: {
    type: Function,
    default: null,
  },
});
</script>

<template>
  <div class="info-horizontal border-radius-xl d-block d-md-flex justify-content-between align-items-center bg-light p-3">
    <div>
      <h5 class="text-dark">{{ name }}</h5>
      <p class="text-muted">
        <strong>Kľúčové Slová:</strong> {{ keywords.join(", ") }}
      </p>
      <p class="text-muted">
        <strong>Konferencia:</strong> {{ conferenceName }}
      </p>
      <p class="text-muted">
        <strong>Sekcia:</strong> {{ section }}
      </p>
      <p class="text-muted">
        <strong>Status:</strong> {{ status }}
      </p>
    </div>
    <div class="d-flex gap-2 mt-3 mt-md-0">
      <button
        v-if="showEditButton"
        class="btn btn-success"
        @click="handleEdit"
      >
        Upraviť
      </button>
      <button
        v-if="showEvaluationButton"
        class="btn btn-success"
        @click="handleEvaluation"
      >
        Hodnotenie
      </button>
    </div>
  </div>
</template>
