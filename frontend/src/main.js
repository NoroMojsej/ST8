import { createApp } from "vue";
import { createPinia } from "pinia";
import App from "./App.vue";
import router from "./router";

// Nucleo Icons
import "./assets/css/nucleo-icons.css";
import "./assets/css/nucleo-svg.css";

// Material Kit
import materialKit from "./material-kit";

// Axios setup
import axios from "./axios"; // Import axios from your axios.js file

const app = createApp(App);

// Mount axios to the app instance, so it is accessible globally
app.config.globalProperties.$axios = axios; // This allows you to access axios as this.$axios in your components

app.use(createPinia());
app.use(router);
app.use(materialKit);
app.mount("#app");
