<template>
  <div class="min-h-screen bg-slate-50 flex font-sans text-slate-800 relative">

    <!-- Overlay for Mobile -->
    <div v-if="isSidebarOpen" @click="isSidebarOpen = false"
      class="fixed inset-0 bg-slate-900/40 z-40 md:hidden backdrop-blur-sm transition-opacity"></div>

    <!-- Sidebar (Premium Light) -->
    <aside
      :class="[isSidebarOpen ? 'translate-x-0' : '-translate-x-full', 'md:translate-x-0 w-[280px] bg-white text-slate-600 flex flex-col fixed h-full z-50 transition-transform duration-400 ease-out border-r border-slate-100 shadow-[4px_0_24px_rgba(0,0,0,0.02)]']">

      <!-- Logo Section -->
      <div class="h-24 flex items-center px-8 border-b border-slate-100 relative overflow-hidden bg-white">
        <div class="absolute -top-10 -left-10 w-32 h-32 bg-indigo-50 blur-3xl rounded-full"></div>
        <div class="flex items-center gap-3 relative z-10">
          <div class="w-10 h-10 bg-gradient-to-tr from-indigo-500 to-fuchsia-500 rounded-xl p-[2px] shadow-sm">
            <div class="w-full h-full bg-white rounded-[10px] flex items-center justify-center overflow-hidden">
              <img src="/logo.png" alt="Logo" class="w-full h-full object-contain p-1" onerror="this.src='https://ui-avatars.com/api/?name=DR&background=fff&color=6366f1'">
            </div>
          </div>
          <span class="font-extrabold text-[17px] tracking-wider text-slate-800">DOLES <span class="text-transparent bg-clip-text bg-gradient-to-r from-indigo-600 to-fuchsia-600">RADIATOR</span></span>
        </div>
        <button @click="isSidebarOpen = false"
          class="md:hidden ml-auto text-slate-400 hover:text-indigo-600 transition-colors relative z-10">
          <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
        </button>
      </div>

      <!-- Navigation Links -->
      <nav class="flex-1 px-4 py-6 space-y-1.5 overflow-y-auto custom-scrollbar bg-white">
        <p class="px-4 text-[10px] font-extrabold text-slate-400 uppercase tracking-widest mb-4 mt-2">Menu Utama</p>

        <router-link @click="isSidebarOpen = false" to="/admin/dashboard"
          class="flex items-center gap-3 px-4 py-3.5 rounded-2xl font-semibold transition-all duration-300 border border-transparent"
          active-class="bg-indigo-50 text-indigo-700 border-indigo-100/50 shadow-sm"
          :class="[$route.path === '/admin/dashboard' ? '' : 'hover:bg-slate-50 hover:text-slate-900']">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
          <span class="text-sm tracking-wide">Dashboard</span>
        </router-link>

        <router-link @click="isSidebarOpen = false" to="/admin/service"
          class="flex items-center gap-3 px-4 py-3.5 rounded-2xl font-semibold transition-all duration-300 border border-transparent"
          active-class="bg-indigo-50 text-indigo-700 border-indigo-100/50 shadow-sm"
          :class="[$route.path.startsWith('/admin/service') ? 'bg-indigo-50 text-indigo-700 border-indigo-100/50 shadow-sm' : 'hover:bg-slate-50 hover:text-slate-900']">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
          </svg>
          <span class="text-sm tracking-wide">Manajemen Servis</span>
        </router-link>

        <p class="px-4 text-[10px] font-extrabold text-slate-400 uppercase tracking-widest mb-4 mt-8">Database</p>

        <router-link @click="isSidebarOpen = false" to="/admin/pelanggan"
          class="flex items-center gap-3 px-4 py-3.5 rounded-2xl font-semibold transition-all duration-300 border border-transparent"
          active-class="bg-indigo-50 text-indigo-700 border-indigo-100/50 shadow-sm"
          :class="[$route.path === '/admin/pelanggan' ? '' : 'hover:bg-slate-50 hover:text-slate-900']">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
          <span class="text-sm tracking-wide">Data Pelanggan</span>
        </router-link>

        <router-link @click="isSidebarOpen = false" to="/admin/kendaraan"
          class="flex items-center gap-3 px-4 py-3.5 rounded-2xl font-semibold transition-all duration-300 border border-transparent"
          active-class="bg-indigo-50 text-indigo-700 border-indigo-100/50 shadow-sm"
          :class="[$route.path === '/admin/kendaraan' ? '' : 'hover:bg-slate-50 hover:text-slate-900']">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path></svg>
          <span class="text-sm tracking-wide">Data Kendaraan</span>
        </router-link>

        <router-link @click="isSidebarOpen = false" to="/admin/sparepart"
          class="flex items-center gap-3 px-4 py-3.5 rounded-2xl font-semibold transition-all duration-300 border border-transparent"
          active-class="bg-indigo-50 text-indigo-700 border-indigo-100/50 shadow-sm"
          :class="[$route.path === '/admin/sparepart' ? '' : 'hover:bg-slate-50 hover:text-slate-900']">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
          <span class="text-sm tracking-wide">Manajemen Sparepart</span>
        </router-link>

        <router-link @click="isSidebarOpen = false" to="/admin/stock-adjustment"
          class="flex items-center gap-3 px-4 py-3.5 rounded-2xl font-semibold transition-all duration-300 border border-transparent"
          active-class="bg-indigo-50 text-indigo-700 border-indigo-100/50 shadow-sm"
          :class="[$route.path === '/admin/stock-adjustment' ? '' : 'hover:bg-slate-50 hover:text-slate-900']">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
          <span class="text-sm tracking-wide">Mutasi Stok</span>
        </router-link>

        <template v-if="authStore.user?.jabatan === 'admin'">
          <p class="px-4 text-[10px] font-extrabold text-slate-400 uppercase tracking-widest mb-4 mt-8">Sistem</p>

          <router-link @click="isSidebarOpen = false" to="/admin/chatbot-rule"
            class="flex items-center gap-3 px-4 py-3.5 rounded-2xl font-semibold transition-all duration-300 border border-transparent"
            active-class="bg-indigo-50 text-indigo-700 border-indigo-100/50 shadow-sm"
            :class="[$route.path === '/admin/chatbot-rule' ? '' : 'hover:bg-slate-50 hover:text-slate-900']">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path></svg>
            <span class="text-sm tracking-wide">Aturan Chatbot</span>
          </router-link>

          <router-link @click="isSidebarOpen = false" to="/admin/users"
            class="flex items-center gap-3 px-4 py-3.5 rounded-2xl font-semibold transition-all duration-300 border border-transparent"
            active-class="bg-indigo-50 text-indigo-700 border-indigo-100/50 shadow-sm"
            :class="[$route.path === '/admin/users' ? '' : 'hover:bg-slate-50 hover:text-slate-900']">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
            <span class="text-sm tracking-wide">Daftar Akun Pegawai</span>
          </router-link>
        </template>
      </nav>

      <!-- User Profile Card -->
      <div class="p-4 bg-white border-t border-slate-100">
        <div class="bg-slate-50 rounded-2xl p-4 flex items-center justify-between border border-slate-100 group hover:bg-slate-100 transition-colors">
          <div class="flex items-center gap-3 overflow-hidden">
            <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-indigo-500 to-fuchsia-500 flex items-center justify-center text-white font-extrabold text-lg shrink-0 shadow-sm">
              {{ authStore.user?.name?.charAt(0).toUpperCase() || 'U' }}
            </div>
            <div class="overflow-hidden">
              <p class="text-sm font-bold text-slate-800 truncate tracking-wide" :title="authStore.user?.name">{{ authStore.user?.name || 'Loading...' }}</p>
              <p class="text-[10px] text-indigo-600 uppercase tracking-widest font-bold truncate mt-0.5">{{ authStore.user?.jabatan || 'user' }}</p>
            </div>
          </div>
          <button @click="handleLogout" class="text-slate-400 hover:text-red-500 p-2 rounded-xl transition-all hover:bg-red-50 shrink-0" title="Logout">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
          </button>
        </div>
      </div>
    </aside>

    <!-- Main Content Wrapper -->
    <div class="flex-1 flex flex-col md:ml-[280px] min-w-0 transition-all duration-300">
      
      <!-- Topbar (Glassmorphism Light) -->
      <header class="h-[88px] bg-white/70 backdrop-blur-2xl shadow-[0_4px_30px_rgba(0,0,0,0.02)] border-b border-slate-200/50 flex items-center justify-between px-6 md:px-10 sticky top-0 z-30">
        <div class="flex items-center gap-4">
          <button @click="isSidebarOpen = true" class="md:hidden text-slate-500 hover:text-indigo-600 bg-white shadow-sm border border-slate-200 p-2.5 rounded-xl transition-all active:scale-95">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"></path></svg>
          </button>
          
          <!-- Back button with premium styling -->
          <button @click="$router.back()" class="group flex items-center gap-2 text-sm font-bold text-slate-600 hover:text-indigo-600 bg-white px-5 py-2.5 rounded-xl transition-all shadow-sm border border-slate-200 hover:border-indigo-200 hover:shadow-md hover:-translate-y-0.5">
            <svg class="w-4 h-4 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            <span class="hidden sm:inline tracking-wide">Kembali</span>
          </button>
        </div>
        
        <div class="flex items-center gap-6">
          <div class="hidden sm:flex flex-col text-right">
            <span class="text-[13px] font-bold text-slate-800 tracking-wide">{{ new Date().toLocaleDateString('id-ID', { weekday: 'long', day: 'numeric', month: 'long', year: 'numeric' }) }}</span>
            <span class="text-[11px] text-indigo-500 font-extrabold tracking-widest uppercase mt-0.5">Admin Workspace</span>
          </div>
        </div>
      </header>

      <!-- Main Content Area -->
      <main class="flex-1 p-6 md:p-10 overflow-auto bg-slate-50 relative">
        <div class="relative z-10 h-full">
          <router-view v-slot="{ Component }">
            <transition name="page-fade" mode="out-in">
              <keep-alive>
                <component :is="Component" />
              </keep-alive>
            </transition>
          </router-view>
        </div>
      </main>
    </div>
  </div>
</template>

<script setup>
import { useAuthStore } from '../stores/auth';
import { useRouter } from 'vue-router';
import { onMounted, ref } from 'vue';

const authStore = useAuthStore();
const router = useRouter();
const isSidebarOpen = ref(false);

onMounted(() => {
  if (!authStore.user) {
    authStore.fetchUser();
  }
});

const handleLogout = async () => {
  await authStore.logout();
  router.push('/login');
};
</script>

<style>
/* Custom Scrollbar for Sidebar */
.custom-scrollbar::-webkit-scrollbar {
  width: 4px;
}
.custom-scrollbar::-webkit-scrollbar-track {
  background: transparent;
}
.custom-scrollbar::-webkit-scrollbar-thumb {
  background-color: rgba(148, 163, 184, 0.2);
  border-radius: 10px;
}
.custom-scrollbar::-webkit-scrollbar-thumb:hover {
  background-color: rgba(148, 163, 184, 0.4);
}

/* Page Transition */
.page-fade-enter-active,
.page-fade-leave-active {
  transition: opacity 0.3s ease, transform 0.3s ease;
}
.page-fade-enter-from,
.page-fade-leave-to {
  opacity: 0;
  transform: translateY(10px);
}
</style>
