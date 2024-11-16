<script setup>
import { onMounted, onUnmounted } from "vue";

//example components
import NavbarDefault from "@/examples/navbars/NavbarDefault.vue";
import DefaultFooter from "@/examples/footers/FooterDefault.vue";
import Header from "@/examples/Header.vue";
import FilledInfoCard from "@/examples/cards/infoCards/FilledInfoCard.vue";

//Vue Material Kit 2 components
import MaterialSocialButton from "@/components/MaterialSocialButton.vue";

// sections
import BaseLayout from "@/layouts/sections/components/BaseLayout.vue";
import PresentationCounter from "@/views/Presentation/Sections/PresentationCounter.vue";
import PresentationPages from "@/views/Presentation/Sections/PresentationPages.vue";
import PresentationExample from "@/views/Presentation/Sections/PresentationExample.vue";
import data from "@/views/Presentation/Sections/Data/designBlocksData";
import BuiltByDevelopers from "@/views/Presentation/Components/BuiltByDevelopers.vue";

//images
import vueMkHeader from "@/assets/img/annie-spratt.jpg";
import wavesWhite from "@/assets/img/waves-white.svg";
import logoBootstrap from "@/assets/img/logos/bootstrap5.jpg";
import logoTailwind from "@/assets/img/logos/icon-tailwind.jpg";
import logoVue from "@/assets/img/logos/vue.jpg";
import logoAngular from "@/assets/img/logos/angular.jpg";
import logoReact from "@/assets/img/logos/react.jpg";
import logoSketch from "@/assets/img/logos/sketch.jpg";

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
              route:
                'https://www.creative-tim.com/learning-lab/vue/overview/material-kit/',
              label: { text: 'Let\'s start', color: 'white' }
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
            title="Správca Recenzentov"
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