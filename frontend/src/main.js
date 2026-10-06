import { createApp } from 'vue';
import { createPinia } from 'pinia';
import App from './App.vue';
import router from './router';
import './style.css';

import Vue3Toastify, { toast } from 'vue3-toastify';
import 'vue3-toastify/dist/index.css';

const app = createApp(App);
const pinia = createPinia();

app.use(pinia);
app.use(router);
app.use(Vue3Toastify, {
  autoClose: 3000,
  position: 'top-right',
  theme: 'colored',
  clearOnUrlChange: false
});

// Override window.alert agar seluruh aplikasi menggunakan toast yang estetik
window.alert = (message) => {
    if (!message) return;
    const msgStr = String(message).toLowerCase();
    // Deteksi apakah pesan ini adalah error atau success
    if (msgStr.includes('gagal') || msgStr.includes('error') || msgStr.includes('salah')) {
        toast.error(message);
    } else if (msgStr.includes('berhasil') || msgStr.includes('sukses') || msgStr.includes('diperbarui')) {
        toast.success(message);
    } else {
        toast.info(message);
    }
};

app.mount('#app');
