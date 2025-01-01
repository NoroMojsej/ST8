<script setup>

import { RouterLink } from "vue-router";
import { ref, watch, onMounted } from "vue";
import { useWindowsWidth } from "../../assets/js/useWindowsWidth";

const props = defineProps({
  action: {
    type: Object,
    route: String,
    color: String,
    label: String,
    default: () => ({
      route: { name: "signin-basic" },
      route2: { name: "register-basic" },
      color: "bg-gradient-success",
      label: "PRIHLÁSIŤ SA",
      label2: "REGISTRÁCIA"
    })
  },
  transparent: {
    type: Boolean,
    default: false
  },
  light: {
    type: Boolean,
    default: false
  },
  dark: {
    type: Boolean,
    default: false
  },
  sticky: {
    type: Boolean,
    default: false
  },
  darkText: {
    type: Boolean,
    default: false
  }
});

const sessionData = ref(null);

function getSessionFromLocalStorage() {
  const storedSession = localStorage.getItem("session");
  if (storedSession) {
    try {
      sessionData.value = JSON.parse(storedSession);
      console.log("HOME " + sessionData.value);
    } catch (error) {
      console.error("Error parsing session data from localStorage", error);
    }
  }
}

onMounted(() => {
  getSessionFromLocalStorage();
});


// Nastavenie farby navigácie na mobile a desktop
let textDark = ref(props.darkText);
const { type } = useWindowsWidth();

if (type.value === "mobile") {
  textDark.value = true;
} else if (type.value === "desktop" && textDark.value == false) {
  textDark.value = false;
}

watch(
  () => type.value,
  (newValue) => {
    if (newValue === "mobile") {
      textDark.value = true;
    } else {
      textDark.value = false;
    }
  }
);

watch(sessionData, (newData) => {
  console.log("Session data updated:", newData);
});

</script>


<template>

  <nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="home">
      <RouterLink :to="{ name: 'home' }">
        <i class="bi bi-house-fill"></i>
      </RouterLink>
    </div>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup"
      aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
      <i class="bi bi-arrow-down-short fs-1"></i>
    </button>
    <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
      <div class="navbar-nav">
        <a class="nav-item nav-link active" href="#"> <router-link :to="action.route" class="btn btn-md mb-0"
            :class="action.color" style="font-family: 'Montserrat', sans-serif; font-size: 12px;"
            @click.native="smoothToPricing('pricing-soft-ui')">
            {{ action.label }}
          </router-link></a>
        <a class="nav-item nav-link" href="#">
          <router-link :to="action.route2" class="btn btn-md mb-0" :class="action.color"
            style="font-family: 'Montserrat', sans-serif; font-size: 12px;"
            @click.native="smoothToPricing('pricing-soft-ui')">
            {{ action.label2 }}
          </router-link>
        </a>
      </div>
    </div>
  </nav>

</template>

<style scoped>
.home {
  padding-left: 10% !important;
}

.bi.bi-house-fill {
  color: #344767 !important;
  font-size: 1.7rem !important;
}

.log {
  padding-right: 10% !important;
}

.navbar {
  padding-top: 1%;
  padding-bottom: 1%;
  box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1) !important;
  z-index: 1;
}

.bi.bi-arrow-down-short {
  color: #344767 !important;
}

.navbar-nav {
  width: 100% !important;
  display: flex !important;
  justify-content: end !important;
}
</style>