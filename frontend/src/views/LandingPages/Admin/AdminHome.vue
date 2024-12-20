<script setup>

import BaseLayout from "@/layouts/sections/components/BaseLayout.vue";
import InfoCardCustom from "../../../examples/cards/infoCards/InfoCardCustom.vue";

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
          <InfoCardCustom
            class="p-4"
            :color="{ text: 'white', background: 'bg-gradient-success' }"
            title="Správca Konferencii"
            description="Check the possible ways of working with our product and the necessary files for building your own project."
            :action="{
                to: { name: 'conferenceman' },
                label: { color: 'white' }
            }"
          />
        </div>
        <div class="col-lg-4">
          <InfoCardCustom
            class="p-4"
            :color="{ text: 'white', background: 'bg-gradient-success' }"
            title="Správca Sekcií"
            description="Check the possible ways of working with our product and the necessary files for building your own project."
            :action="{
                to: { name: 'sectionman' },
                label: { color: 'white' }
            }"
          />
        </div>
        <div class="col-lg-4">
          <InfoCardCustom
            class="p-4"
            :color="{ text: 'white', background: 'bg-gradient-success' }"
            title="Správca Univerzít"
            description="Check the possible ways of working with our product and the necessary files for building your own project."
            :action="{
              to: { name: 'universityman'},
              label: { color: 'white' }
            }"
          />
        </div>
      </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-lg-4">
          <InfoCardCustom
            class="p-4"
            :color="{ text: 'white', background: 'bg-gradient-success' }"
            title="Správca Používateľov"
            description="Check the possible ways of working with our product and the necessary files for building your own project."
            :action="{
              to: { name: 'users_list'},
              label: { color: 'white' }
            }"
          />
        </div>
        </div>
    </div>
</BaseLayout>
</template>