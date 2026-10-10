<template>
  <div class="flex items-center justify-center min-h-[100vh] bg-slate-50 relative overflow-hidden font-sans">

    <!-- Background Effects (Soft Orbs) -->
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
      <div class="absolute -top-[10%] -left-[10%] w-[60%] h-[60%] rounded-full bg-indigo-100 blur-[120px]"></div>
      <div class="absolute -bottom-[10%] -right-[10%] w-[60%] h-[60%] rounded-full bg-fuchsia-100 blur-[120px]"></div>
      <div
        class="absolute inset-0 bg-[url('data:image/svg+xml;base64,PHN2ZyB2aWV3Qm94PSIwIDAgMjAwIDIwMCIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48ZmlsdGVyIGlkPSJub2lzZUZpbHRlciI+PGZlVHVyYnVsZW5jZSB0eXBlPSJmcmFjdGFsTm9pc2UiIGJhc2VGcmVxdWVuY3k9IjAuNjUiIG51bU9jdGF2ZXM9IjMiIHN0aXRjaFRpbGVzPSJzdGl0Y2giLz48L2ZpbHRlcj48cmVjdCB3aWR0aD0iMTAwJSIgaGVpZ2h0PSIxMDAlIiBmaWx0ZXI9InVybCgibm9pc2VGaWx0ZXIpIiBvcGFjaXR5PSIwLjAzIi8+PC9zdmc+')] opacity-50">
      </div>
    </div>

    <!-- Login Card -->
    <div
      class="w-full max-w-[420px] bg-white/90 backdrop-blur-3xl rounded-[2.5rem] shadow-[0_20px_60px_-15px_rgba(0,0,0,0.05)] border border-slate-200 overflow-hidden relative z-10 m-6">

      <!-- Back Button -->
      <router-link to="/"
        class="absolute top-6 left-6 text-slate-500 hover:text-indigo-600 flex items-center gap-1.5 text-xs font-bold uppercase tracking-wider transition-all hover:-translate-x-1">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
        </svg>
        Kembali
      </router-link>

      <!-- Header Section -->
      <div class="pt-20 pb-8 px-8 text-center flex flex-col items-center">
        <div
          class="w-20 h-20 bg-gradient-to-tr from-indigo-500 to-fuchsia-500 rounded-[1.5rem] p-[2px] shadow-lg shadow-indigo-200 mb-6 rotate-3 hover:rotate-0 transition-transform duration-500">
          <div class="w-full h-full bg-white rounded-[1.4rem] flex items-center justify-center overflow-hidden">
            <img src="/logo.png" alt="Logo" class="w-14 h-14 object-contain"
              onerror="this.src='https://ui-avatars.com/api/?name=DR&background=fff&color=6366f1'">
          </div>
        </div>
        <h2 class="text-3xl font-extrabold text-slate-900 mb-2 tracking-tight">Admin Portal</h2>
        <p class="text-slate-500 font-light text-sm">Masuk untuk mengelola sistem Doles Radiator.</p>
      </div>

      <!-- Form Section -->
      <form @submit.prevent="handleLogin" class="px-8 pb-10 space-y-6">

        <!-- Error Alert -->
        <div v-if="errorMessage"
          class="bg-red-50 text-red-600 p-4 rounded-2xl text-sm font-bold border border-red-200 flex items-center gap-3 animate-fade-in-up shadow-sm">
          <div class="bg-red-100 p-1.5 rounded-full"><svg class="w-4 h-4" fill="none" stroke="currentColor"
              stroke-width="3" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"></path>
            </svg></div>
          {{ errorMessage }}
        </div>

        <!-- Username Input -->
        <div class="space-y-2">
          <label class="text-[10px] font-bold text-slate-500 uppercase tracking-widest ml-2">Username</label>
          <div class="relative group">
            <span
              class="absolute inset-y-0 left-4 flex items-center text-slate-400 group-focus-within:text-indigo-600 transition-colors">
              <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round"
                  d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
              </svg>
            </span>
            <input v-model="form.username" type="text" required autocomplete="username"
              class="w-full pl-12 pr-4 py-4 bg-slate-50 border border-slate-200 text-slate-900 rounded-2xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent outline-none transition-all placeholder-slate-400"
              placeholder="Masukkan username">
          </div>
        </div>

        <!-- Password Input -->
        <div class="space-y-2">
          <label class="text-[10px] font-bold text-slate-500 uppercase tracking-widest ml-2">Password</label>
          <div class="relative group">
            <span
              class="absolute inset-y-0 left-4 flex items-center text-slate-400 group-focus-within:text-indigo-600 transition-colors">
              <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round"
                  d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z">
                </path>
              </svg>
            </span>
            <input v-model="form.password" :type="showPassword ? 'text' : 'password'" required
              autocomplete="current-password"
              class="w-full pl-12 pr-12 py-4 bg-slate-50 border border-slate-200 text-slate-900 rounded-2xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent outline-none transition-all placeholder-slate-400 tracking-widest"
              placeholder="••••••••">
            <button type="button" @click="showPassword = !showPassword"
              class="absolute inset-y-0 right-4 flex items-center text-slate-400 hover:text-indigo-600 transition-colors focus:outline-none">
              <svg v-if="!showPassword" class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2"
                viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                <path stroke-linecap="round" stroke-linejoin="round"
                  d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                </path>
              </svg>
              <svg v-else class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round"
                  d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21">
                </path>
              </svg>
            </button>
          </div>
        </div>

        <button type="submit" :disabled="isLoading"
          class="w-full mt-2 bg-gradient-to-r from-indigo-600 to-fuchsia-600 hover:from-indigo-500 hover:to-fuchsia-500 text-white font-bold py-4 px-4 rounded-2xl transition-all shadow-md hover:shadow-lg flex justify-center items-center disabled:opacity-70 disabled:hover:scale-100 hover:-translate-y-1">
          <span v-if="!isLoading" class="tracking-wide">Masuk</span>
          <span v-else class="animate-spin w-6 h-6 border-2 border-white border-t-transparent rounded-full"></span>
        </button>
      </form>
    </div>
  </div>
</template>

<script setup>
import { reactive, ref } from 'vue';
import { useRouter } from 'vue-router';
import { useAuthStore } from '../stores/auth';

const router = useRouter();
const authStore = useAuthStore();

const form = reactive({
  username: '',
  password: ''
});

const isLoading = ref(false);
const errorMessage = ref('');
const showPassword = ref(false);

const handleLogin = async () => {
  isLoading.value = true;
  errorMessage.value = '';

  const result = await authStore.login(form);

  if (result.success) {
    router.push('/admin');
  } else {
    errorMessage.value = result.message;
  }

  isLoading.value = false;
};
</script>

<style scoped>
@keyframes fadeInUp {
  from {
    opacity: 0;
    transform: translateY(10px);
  }

  to {
    opacity: 1;
    transform: translateY(0);
  }
}

.animate-fade-in-up {
  animation: fadeInUp 0.4s ease-out forwards;
}
</style>
