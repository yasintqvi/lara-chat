import { createApp } from 'vue'
import App from './App.vue'
import axios from 'axios'
import router from './router'
import store from './store'
import Toast from 'vue-toastification';
import "vue-toastification/dist/index.css";
import './assets/main.css';


const app = createApp(App)

const options = {
    position: 'top-right',
    timeout: 3000,
    closeOnClick: true,
    pauseOnFocusLoss: true,
    pauseOnHover: true,
    draggable: true,
    draggablePercent: 0.6,
    showCloseButtonOnHover: false,
    hideProgressBar: false,
    closeButton: 'button',
    icon: true,
    rtl: false
};

app.use(store)
app.use(router)
app.use(Toast, options)

axios.defaults.baseURL = import.meta.env.VITE_API_BASE_URL

axios.defaults.withCredentials = true

axios.defaults.headers.common['Content-Type'] = 'application/json'

app.config.globalProperties.$axios = axios

app.mount('#app')