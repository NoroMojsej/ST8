<script setup>
// Sections
import BaseLayout from "@/layouts/sections/components/BaseLayout.vue";
import ListCard from "./components/ListCard.vue";

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
              <ListCard
                class="px-lg-1 mt-lg-0 mt-4 p-4"
                height="h-100"
                :icon="{ component: 'flag', color: 'success' }"
                :title="card.title"
                :description="card.description"
                :handleEdit="() => editCard(index)"
                :buttonText="'Upraviť'"
                :optionalButton="{
                  text: 'Práce',
                  onClick: () => viewEssays(index),
                  color: 'info'
                }"
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
          title: "Konferencia 1",
          description:
            "Popis",
          icon: "precision_manufacturing",
        },
        {
          title: "Konferencia 2",
          description:
            "Popis",
          icon: "precision_manufacturing",
        },
        {
          title: "Konferencia 3",
          description:
            "Popis",
          icon: "precision_manufacturing",
        },
        {
          title: "Konferencia 4",
          description:
            "Popis",
          icon: "precision_manufacturing",
        },
      ],
    };
  },

  methods: {
    editCard(index) {
      this.$router.push({ name: "conferenceedit", params: { id: index } });
    },
    viewEssays(index) {
      this.$router.push({ name: "conferenceessays", params: { id: index } });
    },
  },
};
</script>
