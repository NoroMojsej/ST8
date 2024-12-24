<script setup>
import InfoCardCustom from "../../examples/cards/infoCards/InfoCardCustom.vue";

// sections
import BaseLayout from "@/layouts/sections/components/BaseLayout.vue";
import { useRouter } from 'vue-router';
import { onMounted } from "vue";

onMounted(() => {
  const router = useRouter(); 
  const authorizedToken = localStorage.getItem('auth_token');

  console.log("Checking session...");

  if (!authorizedToken) {
    console.log("No session found. Redirecting to homepage.");
    router.push('/');
  } else {
    try {
      const session = JSON.parse(authorizedToken);
      console.log("Session found:", session); 

      console.log("StudentHomeView", session);
    } catch (error) {
      console.error("Error parsing session data:", error);
      router.push('/');
    }
  }
});

</script>

<template>  
   <BaseLayout
    title="Študentské Rozhranie"
    :breadcrumb="[
      { label: 'Domov', route: '/' },
      { label: 'Študentské Rozhranie' }
    ]"
  >

    <div class="container mb-4">
      <div class="row">
        <div class="col-lg-4">
          <InfoCardCustom
            class="p-4"
            :color="{ text: 'white', background: 'bg-gradient-success' }"
            :icon="{ component: 'precision_manufacturing', color: 'white' }"
            :customClass="'bi bi-cloud-upload fs-3 white'"
            title="Nahrať článok"
            description="Zvoľte konferenciu a nahrajte vytvorenú prácu."
            :action="{
                to: { name: 'studentconference' },
                label: {color: 'white' }
            }"
          />
        </div>
        <div class="col-lg-4">
          <InfoCardCustom
            class="p-4"
            :color="{ text: 'white', background: 'bg-gradient-success' }"
            :icon="{ component: 'precision_manufacturing', color: 'white' }"
            :customClass="'bi bi-pass fs-3 white'"
            title="Moje články"
            description="Pozrite si prehľad svojich prác a hodnotení."
            :action="{
                to: { name: 'myessays' },
                label: {color: 'white' }
            }"
          />
        </div>
       
        </div>
    </div>
</BaseLayout>
</template>