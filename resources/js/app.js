import { createApp } from 'vue';
import App from './App.vue';
import router from './router';
import axios from 'axios';
import { createVuetify } from 'vuetify';
import 'vuetify/styles';
import '@mdi/font/css/materialdesignicons.css';

axios.defaults.baseURL = 'http://127.0.0.1:8000';


const vuetify = createVuetify({
  icons: {
    defaultSet: 'mdi',
  },
});

createApp(App).use(router).use(vuetify).mount('#app');
