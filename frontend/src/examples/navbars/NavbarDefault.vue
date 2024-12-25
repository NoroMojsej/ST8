<script setup>

import { RouterLink } from "vue-router";
import { ref, watch } from "vue";
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

// set arrow  color
function getArrowColor() {
  if (props.transparent && textDark.value) {
    return ArrDark;
  } else if (props.transparent) {
    return DownArrWhite;
  } else {
    return ArrDark;
  }
}

// set text color
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

// set nav color on mobile && desktop

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
</script>


<template>
  <nav
    class="navbar navbar-expand-lg top-0"
    :class="{
      'z-index-3 w-100 shadow-none navbar-transparent position-absolute my-3':
        props.transparent,
      'my-3 blur border-radius-lg z-index-3 py-2 shadow py-2 start-0 end-0 mx-4 position-absolute mt-4':
        props.sticky,
      'navbar-light bg-white py-3': props.light,
      ' navbar-dark bg-gradient-dark z-index-3 py-3': props.dark
    }"
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
        title=""
        data-placement="bottom"
      >
      ŠTUDENTSKÁ VEDECKÁ KONFERENCIA
      </RouterLink>

      <div
        class="collapse navbar-collapse w-100 pt-3 pb-2 py-lg-0"
        id="navigation"
      >

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
              ŠTUDENTSKÁ VEDECKÁ KONFERENCIA
            </RouterLink>
      <div class="d-lg-flex d-none p-2 ms-auto">
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
  </nav>
</template>
