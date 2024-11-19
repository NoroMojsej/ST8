<script setup>
import { onMounted, onUnmounted } from "vue";

//example components
import FilledInfoCard from "@/examples/cards/infoCards/FilledInfoCard.vue";

// sections
import BaseLayout from "@/layouts/sections/components/BaseLayout.vue";

//hooks
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
        title="Admin Rozhranie"
        :breadcrumb="[
            { label: 'Domov', route: '/' },
            { label: 'Admin Rozhranie' },]"
        >

    <div class="container mb-4">
      <div class="row">
        <div class="col-lg-4">
          <FilledInfoCard
            class="p-4"
            :color="{ text: 'white', background: 'bg-gradient-success' }"
            :icon="{ component: 'precision_manufacturing', color: 'white' }"
            title="Správca Konferencii"
            description="Check the possible ways of working with our product and the necessary files for building your own project."
            :action="{
                to: { name: 'conferenceman' },
                label: { text: 'Prejsť na', color: 'white' }
            }"
          />
        </div>
        <div class="col-lg-4">
          <FilledInfoCard
            class="p-4"
            :color="{ text: 'white', background: 'bg-gradient-success' }"
            :icon="{ component: 'precision_manufacturing', color: 'white' }"
            title="Správca Sekcií"
            description="Check the possible ways of working with our product and the necessary files for building your own project."
            :action="{
              route:
                'https://www.creative-tim.com/learning-lab/vue/overview/material-kit/',
              label: { text: 'Prejsť na', color: 'white' }
            }"
          />
        </div>
        <div class="col-lg-4">
          <FilledInfoCard
            class="p-4"
            :color="{ text: 'white', background: 'bg-gradient-success' }"
            :icon="{ component: 'precision_manufacturing', color: 'white' }"
            title="Správca Vysokých Škôl"
            description="Check the possible ways of working with our product and the necessary files for building your own project."
            :action="{
              route:
                'https://www.creative-tim.com/learning-lab/vue/overview/material-kit/',
              label: { text: 'Prejsť na', color: 'white' }
            }"
          />
        </div>
      </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-lg-4">
          <FilledInfoCard
            class="p-4"
            :color="{ text: 'white', background: 'bg-gradient-success' }"
            :icon="{ component: 'precision_manufacturing', color: 'white' }"
            title="Správca Používateľov"
            description="Check the possible ways of working with our product and the necessary files for building your own project."
            :action="{
              route:
                'https://www.creative-tim.com/learning-lab/vue/overview/material-kit/',
              label: { text: 'Prejsť na', color: 'white' }
            }"
          />
        </div>
        </div>
    </div>
</BaseLayout>
</template>