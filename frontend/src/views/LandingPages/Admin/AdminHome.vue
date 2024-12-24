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
            description="Prehľad konferencií a stiahnutie prác. Vytvorte nové alebo spravujte existujúce konferencie."
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
            description="Prehľad existujúcich sekcií s možnosťou vytvorenia nových alebo upravenia existujúcich."
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
            description="Prehľad existujúcich univerzít s možnosťou vytvorenie nových a úpravy existujúcich."
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
            description="Zmena rolí používateľov a priraďovanie prác recenzentom."
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