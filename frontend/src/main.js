import { createApp } from 'vue';
import App from './App.vue';
import { createPinia } from 'pinia';
import axios from './axios'; // Import the Axios instance
import './assets/tailwind.css'; // Import Tailwind CSS

const app = createApp(App);
app.use(createPinia());
app.config.globalProperties.$axios = axios; // Add Axios to global properties
app.mount('#app');
