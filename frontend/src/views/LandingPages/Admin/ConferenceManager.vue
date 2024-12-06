<script setup>
// Sections
import BaseLayout from "@/layouts/sections/components/BaseLayout.vue";
import ConferenceCard from "./components/ConferenceCard.vue";

</script>

<template>
  <BaseLayout
    title="Správca Konferencií"
    :breadcrumb="[
      { label: 'Admin Rozhranie', route: '/pages/landing-pages/admin-control-panel' },
      { label: 'Správca Konferencií' },
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
                :handleEdit="() => editCard(index)"
              />
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="d-flex justify-content-center">
    <Router-Link :to="{ name: 'conferenceadd' }" class="btn btn-success">
      Vytvoriť Konferenciu
    </Router-Link>
    </div>
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
    editCard(index) {
      this.$router.push({ name: "conferenceedit", params: { id: index } });
    },
  },
};
</script>
