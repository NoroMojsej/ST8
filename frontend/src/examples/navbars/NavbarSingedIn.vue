 <script setup>

import { RouterLink } from "vue-router";
import { ref, watch, computed } from "vue";
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

const session = JSON.parse(localStorage.getItem('session'));
console.log("Session data:", session);

const getLink = computed(() => {
  if (session.user_role === "ADMIN") {
    return { name: 'adminhome' };
  } else if (session.user_role === "REVIW") {
    return { name: 'reviewer_home' };
  } else {
    return { name: 'student_home' };
  }
});

function logout() {
  localStorage.removeItem('session');
  if (location.pathname === '/') {
    console.log('You are at the root path');
    location.reload();
  } else {
    console.log('You are not at the root path');
  }
  console.log("User logged out");
}

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


  <nav class="navbar navbar-expand-lg bg-white" v-if="session">

    <div class="home">
      <RouterLink :to="{ name: 'home' }">
        <i class="bi bi-house-fill"></i>
      </RouterLink>
    </div>

    <button class="navbar-toggler d-block d-lg-none" type="button" data-toggle="collapse" data-target="#navbarNav"
      aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <i class="bi bi-person-circle display-6"></i> 
      <div class="name1">
      <span class="name2"> {{ session.user_first_name + " " +
        session.user_last_name }}<i class="bi bi-chevron-down"></i>  </span> 
      </div>

    </button>
    
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav d-block d-lg-none">
       
  <li class="nav-item ">
          <a class="nav-link" href="#">
            <RouterLink
    :to="getLink"
    class="dropdown-item border-radius-md"
  >
    <span><i class="bi bi-display"></i> Tvoja dashboard</span>
  </RouterLink>
          </a>
        </li>

        <li class="nav-item ">
          <a class="nav-link" href="#">
            <RouterLink :to="{ name: 'edit_account' }" class="dropdown-item border-radius-md">
              <span><i class="bi bi-pencil-square"></i> Editovať profil</span>
            </RouterLink>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">
            <RouterLink :to="{ name: 'home' }" class="dropdown-item border-radius-md" @click="logout">
              <span> <i class="bi bi-arrow-bar-right"></i> Odhlásiť sa </span>
            </RouterLink>
          </a>
        </li>
      </ul>
    
      <div id="longScreen">
        <ul>
        <li class="nav-item dropdown d-none d-lg-block">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink"
            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="bi bi-person-circle display-6"></i> <span class="name2"> {{ session.user_first_name + " " +
              session.user_last_name }} </span>
          </a>
          <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">

            <a class="dropdown-item" href="#">
            <RouterLink
    :to="getLink"
    class="dropdown-item border-radius-md"
  >
    <span><i class="bi bi-display"></i> Dashboard</span>
  </RouterLink>
          </a>

            <a class="dropdown-item" href="#">
              <RouterLink :to="{ name: 'edit_account' }" class="dropdown-item border-radius-md">
                <span><i class="bi bi-pencil-square"></i> Editovať profil</span>
              </RouterLink>
            </a>
            <a class="dropdown-item" href="#">
              <RouterLink :to="{ name: 'home' }" class="dropdown-item border-radius-md" @click="logout">
                <span> <i class="bi bi-arrow-bar-right"></i> Odhlásiť sa</span>
              </RouterLink>
            </a>
          </div>
        </li>
      
      </ul>
    </div>

    </div>
  </nav>
</template>

<style scoped>

.home {
  padding-left: 10%;
}

.bi.bi-house-fill {
  color: #344767 !important;
  font-size: 1.5rem !important;
}

#navbarDropdownMenuLink::after {
  display: inline-block;
  margin-left: 0.5em;
  vertical-align: 0.255em;
  content: "";
  border-top: 0.3em solid;
  border-right: 0.3em solid transparent;
  border-left: 0.3em solid transparent;
}

.nav-link.dropdown-toggle {
  padding-bottom: 0px;
  display: flex;
  align-items: center;
}

.dropdown:not(.dropdown-hover) .dropdown-menu.show{
  margin-top: 10px !important;
  top: 100% !important;
  margin-top: 15px !important;
}

span.name1 {
    display: flex !important; 
    align-items: center !important;
}

span.name2 {
  font-weight: bold !important;
  font-size: large !important;
  font-family: 'Montserrat', sans-serif !important;
  padding-left: 5px !important
}

.navbar-collapse.collapse.show {
  justify-content: right;
  padding-right: 10%;
}

#longScreen {
  width: 100% !important;
  padding-right: 10% !important;
  display: flex !important;
  justify-content: right !important;
}

.navbar {
  box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1) !important;
  z-index: 1;
}
</style>