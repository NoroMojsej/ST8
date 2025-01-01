<script setup>

import { RouterLink } from "vue-router";
import { ref, watch, onMounted } from "vue";
import { useWindowsWidth } from "../../assets/js/useWindowsWidth";

import ArrDark from "@/assets/img/down-arrow-dark.svg";
import downArrow from "@/assets/img/down-arrow.svg";
import DownArrWhite from "@/assets/img/down-arrow-white.svg";

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

// Reaktívna hodnota pre session
const sessionData = ref(null);

// Funkcia na získanie session z localStorage
function getSessionFromLocalStorage() {
  const storedSession = localStorage.getItem("session"); // Nahraď "sessionKey" kľúčom, ktorý používa tvoj backend
  if (storedSession) {
    try {
      sessionData.value = JSON.parse(storedSession);
      console.log("HOME "+sessionData.value);
    } catch (error) {
      console.error("Error parsing session data from localStorage", error);
    }
  }
}

// Získanie session pri načítaní komponenty
onMounted(() => {
  getSessionFromLocalStorage();
});

// Funkcia na nastavenie farby šípky
function getArrowColor() {
  if (props.transparent && textDark.value) {
    return ArrDark;
  } else if (props.transparent) {
    return DownArrWhite;
  } else {
    return ArrDark;
  }
}

// Funkcia na nastavenie farby textu
const getTextColor = () => {
  let color;
  if (props.transparent && textDark.value) {
    color = "#02925f";
  } else if (props.transparent) {
    color = "text-white";
  } else {
    color = "#02925f";
  }

  return color;
};

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

// Debug: Sledujeme session dáta
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
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
    <i class="bi bi-arrow-down-short fs-1"></i>
  </button>
  <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
    <div class="navbar-nav">
      <a class="nav-item nav-link active" href="#"> <router-link
              :to="action.route"
              class="btn btn-md mb-0"
              :class="action.color"
              style="font-family: 'Montserrat', sans-serif; font-size: 12px;"
              @click.native="smoothToPricing('pricing-soft-ui')"
            >
              {{ action.label }}
            </router-link></a>
      <a class="nav-item nav-link" href="#">
        <router-link
              :to="action.route2"
              class="btn btn-md mb-0"
              :class="action.color"
              style="font-family: 'Montserrat', sans-serif; font-size: 12px;"
              @click.native="smoothToPricing('pricing-soft-ui')"
            >
              {{ action.label2 }}
            </router-link>
      </a>
    </div>
  </div>
</nav>


  <!--<nav
    class="navbar navbar-expand-lg top-0 blur border-radius-lg z-index-3 py-2 shadow py-2 start-0 end-0 position-absolute"
  >
    <div
      :class="
        props.transparent || props.light || props.dark
          ? 'container'
          : 'container-fluid px-0'
      "
     
    >

    <RouterLink
        class="navbar-brand d-block d-md-none"
        :class="
          props.transparent || props.dark
            ? 'text-white'
            : 'font-weight-bolder ms-sm-3'
        "
        to="/"
        rel="tooltip"
        title="Designed and Coded by Creative Tim"
        data-placement="bottom"
      >
        Material Design
      </RouterLink>
      <a
        href="https://www.creative-tim.com/product/vue-material-kit-pro"
        class="btn btn-sm bg-gradient-success mb-0 ms-auto d-lg-none d-block"
        >Buy Now</a
      >
      <button
        class="navbar-toggler shadow-none ms-2"
        type="button"
        data-bs-toggle="collapse"
        data-bs-target="#navigation"
        aria-controls="navigation"
        aria-expanded="false"
        aria-label="Toggle navigation"
      >
        <span class="navbar-toggler-icon mt-2">
          <span class="navbar-toggler-bar bar1"></span>
          <span class="navbar-toggler-bar bar2"></span>
          <span class="navbar-toggler-bar bar3"></span>
        </span>
      </button>

     

      <div
        class="collapse navbar-collapse w-100 pt-3 pb-2 py-lg-0"
        id="navigation"
      >
      <div class="home">
      <RouterLink
              class="navbar-brand d-block ms-0"
              :class="
                props.transparent || props.dark
                  ? 'text-white'
                  : 'font-weight-bolder ms-sm-3'
              "
              to="/"
              rel="tooltip"
              title=""
              data-placement="bottom"
            >
           
            <i class="bi bi-house-fill"></i>
          
            </RouterLink>
          </div>

      <div class="log d-lg-flex d-none p-2 ms-auto">
        <ul class="navbar-nav">
          <li class="nav-item">
            <router-link
              :to="action.route"
              class="btn btn-md mb-0"
              :class="action.color"
              style="font-family: 'Montserrat', sans-serif; font-size: 12px;"
              @click.native="smoothToPricing('pricing-soft-ui')"
            >
              {{ action.label }}
            </router-link>
          </li>
        </ul>
        <ul class="navbar-nav ms-2">
          <li class="nav-item">
            <router-link
              :to="action.route2"
              class="btn btn-md mb-0"
              :class="action.color"
              style="font-family: 'Montserrat', sans-serif; font-size: 12px;"
              @click.native="smoothToPricing('pricing-soft-ui')"
            >
              {{ action.label2 }}
            </router-link>
          </li>
        </ul>
      </div>


      </div>
    </div>
  </nav> -->
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