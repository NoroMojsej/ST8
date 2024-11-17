<script setup>
import { onMounted, onUnmounted } from "vue";

// Sections
import BaseLayout from "@/layouts/sections/components/BaseLayout.vue";
import ConferenceCard from "./components/ConferenceCard.vue";

// Hooks
const body = document.getElementsByTagName("body")[0];
onMounted(() => {
  body.classList.add("presentation-page");
  body.classList.add("bg-gray-200");
});
onUnmounted(() => {
  body.classList.remove("presentation-page");
  body.classList.remove("bg-gray-200");
});
</script>

<template>
  <BaseLayout
    title="Správca Konferencii"
    :breadcrumb="[
      { label: 'Admin Rozhranie', route: '/pages/landing-pages/admin-control-panel' },
      { label: 'Správca Konferencii' },
    ]"
  >
    <div class="container mb-4">
      <div
        class="row mb-3"
        v-for="(card, index) in cards"
        :key="index"
      >
        <div class="col-12">
          <div class="d-flex align-items-center">
            <div class="flex-grow-1">
              <ConferenceCard
                class="px-lg-1 mt-lg-0 mt-4 p-4"
                height="h-100"
                :icon="{ component: 'flag', color: 'success' }"
                :title="card.title"
                :description="card.description"
                :handleDelete="() => confirmDelete(index)"
              />
            </div>
          </div>
        </div>
      </div>
    </div>
    <button class="btn btn-success">
      Vytvoriť Konferenciu
    </button>
  </BaseLayout>
</template>

<script>
export default {
  data() {
    return {
      cards: [
        {
          title: "Správca Konferencii",
          description:
            "Check the possible ways of working with our product and the necessary files for building your own project.",
          icon: "precision_manufacturing",
        },
        {
          title: "Správca Sekcií",
          description:
            "Check the possible ways of working with our product and the necessary files for building your own project.",
          icon: "precision_manufacturing",
        },
        {
          title: "Správca Recenzentov",
          description:
            "Check the possible ways of working with our product and the necessary files for building your own project.",
          icon: "precision_manufacturing",
        },
        {
          title: "Správca Používateľov",
          description:
            "Check the possible ways of working with our product and the necessary files for building your own project.",
          icon: "precision_manufacturing",
        },
      ],
    };
  },

  methods: {
    confirmDelete(index) {
      const confirmed = window.confirm(
        "Naozaj chcete odstrániť túto konferenciu? Táto akcia sa nedá vrátiť späť."
      );

      if (confirmed) {
        this.cards.splice(index, 1);
      }
    },
  },
};
</script>
