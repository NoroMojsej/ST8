<script setup>
//example components
import InfoCardCustom from "../../examples/cards/infoCards/InfoCardCustom.vue";

// sections
import BaseLayout from "@/layouts/sections/components/BaseLayout.vue";
import { useRouter } from 'vue-router';
import { onMounted } from "vue";

    
// On mounted, check session
onMounted(() => {
  const router = useRouter(); // Get the router instance
  const authorizedToken = localStorage.getItem('auth_token'); // Get the session string from localStorage

  console.log("Checking session...");

  // Check if session exists and is valid
  if (!authorizedToken) {
    console.log("No session found. Redirecting to homepage.");
    router.push('/'); // Redirect to homepage if no session
  } else {
    try {
      // Parse the session data if exists
      const session = JSON.parse(authorizedToken);
      console.log("Session found:", session); // Log session data if it exists

      // You can use session data here if needed
      console.log("StudentHomeView", session);
    } catch (error) {
      console.error("Error parsing session data:", error);
      router.push('/'); // Redirect in case of invalid session data
    }
  }
});

</script>

<template>  
   <BaseLayout
    title="Konferencia X"
    :breadcrumb="[
      { label: 'Domov', route: '/' },
      { label: 'Študentské Rozhranie' }
    ]"
  > <!--tu sa odovzdá session-->

    <div class="container mb-4">
      <div class="row">
        <div class="col-lg-4">
          <InfoCardCustom
            class="p-4"
            :color="{ text: 'white', background: 'bg-gradient-success' }"
            :icon="{ component: 'precision_manufacturing', color: 'white' }"
            :customClass="'bi bi-cloud-upload fs-3 white'"
            title="Nahrať článok"
            description="Check the possible ways of working with our product and the necessary files for building your own project."
            :action="{
                to: { name: 'essay' },
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
            description="Check the possible ways of working with our product and the necessary files for building your own project."
            :action="{
                to: { name: '' },
                label: {color: 'white' }
            }"
          />
        </div>
       
        </div>
    </div>
</BaseLayout>
</template>