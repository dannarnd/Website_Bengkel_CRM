<template>
  <div class="space-y-6">
    <h1 class="text-2xl font-bold text-slate-800">Dashboard</h1>
    
    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
      <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 flex items-center gap-4 hover:shadow-md transition-shadow group">
        <div class="w-14 h-14 bg-indigo-50 text-indigo-600 rounded-2xl flex items-center justify-center font-bold text-xl group-hover:scale-110 transition-transform">
          <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
        </div>
        <div>
          <p class="text-xs text-slate-500 font-extrabold uppercase tracking-widest">Total Servis</p>
          <p class="text-3xl font-extrabold text-slate-800 mt-1">{{ stats.total_servis }}</p>
        </div>
      </div>
      <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 flex items-center gap-4 hover:shadow-md transition-shadow group">
        <div class="w-14 h-14 bg-teal-50 text-teal-600 rounded-2xl flex items-center justify-center font-bold text-xl group-hover:scale-110 transition-transform">
          <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
        </div>
        <div>
          <p class="text-xs text-slate-500 font-extrabold uppercase tracking-widest">Total Pelanggan</p>
          <p class="text-3xl font-extrabold text-slate-800 mt-1">{{ stats.total_pelanggan }}</p>
        </div>
      </div>
      <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 flex items-center gap-4 hover:shadow-md transition-shadow group">
        <div class="w-14 h-14 bg-fuchsia-50 text-fuchsia-600 rounded-2xl flex items-center justify-center font-bold text-xl group-hover:scale-110 transition-transform">
          <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
        </div>
        <div>
          <p class="text-xs text-slate-500 font-extrabold uppercase tracking-widest">Total Suku Cadang</p>
          <p class="text-3xl font-extrabold text-slate-800 mt-1">{{ stats.total_sparepart }}</p>
        </div>
      </div>
    </div>

    <!-- Alert Threshold Widget -->
    <div class="bg-white rounded-2xl shadow-sm border border-red-200 overflow-hidden mt-8 relative">
      <div class="absolute top-0 right-0 w-32 h-32 bg-red-50 rounded-full blur-3xl opacity-50 -mr-10 -mt-10 pointer-events-none"></div>
      
      <div class="bg-red-50/80 px-6 py-5 border-b border-red-100 flex items-center gap-4 relative z-10">
        <div class="p-3 bg-red-100 rounded-xl">
          <svg class="w-6 h-6 text-red-600 animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
        </div>
        <div>
          <h2 class="text-lg font-bold text-red-700">Peringatan Stok Kritis (Alert Threshold)</h2>
          <p class="text-sm text-red-500 font-medium">Sistem otomatis mendeteksi barang yang akan habis.</p>
        </div>
      </div>
      
      <div class="overflow-x-auto relative z-10">
        <table class="min-w-full divide-y divide-slate-100">
          <thead class="bg-slate-50/50">
            <tr>
              <th class="px-6 py-4 text-left text-xs font-extrabold text-slate-500 uppercase tracking-wider">Nama Barang</th>
              <th class="px-6 py-4 text-left text-xs font-extrabold text-slate-500 uppercase tracking-wider">Sisa Stok</th>
              <th class="px-6 py-4 text-left text-xs font-extrabold text-slate-500 uppercase tracking-wider">Batas Minimum</th>
              <th class="px-6 py-4 text-left text-xs font-extrabold text-slate-500 uppercase tracking-wider">Status</th>
            </tr>
          </thead>
          <tbody class="bg-white divide-y divide-slate-50">
            <tr v-if="isLoading" class="text-center">
              <td colspan="4" class="px-6 py-10 text-slate-500">
                <div class="flex flex-col items-center justify-center">
                  <div class="animate-spin w-8 h-8 border-4 border-indigo-500 border-t-transparent rounded-full mb-3"></div>
                  <span>Memuat data...</span>
                </div>
              </td>
            </tr>
            <tr v-else-if="stats.critical_stok.length === 0">
              <td colspan="4" class="px-6 py-12 text-center text-slate-500">
                <div class="flex flex-col items-center justify-center">
                  <div class="w-14 h-14 bg-emerald-100 text-emerald-600 rounded-full flex items-center justify-center mb-4">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                  </div>
                  <p class="font-bold text-lg text-slate-700">Semua stok barang aman terkendali.</p>
                </div>
              </td>
            </tr>
            <tr v-for="item in stats.critical_stok" :key="item.kode_barang" class="hover:bg-slate-50 transition-colors">
              <td class="px-6 py-5 whitespace-nowrap text-sm font-bold text-slate-800">{{ item.nama_barang }}</td>
              <td class="px-6 py-5 whitespace-nowrap text-sm text-red-600 font-bold">
                <span class="flex items-center gap-1.5">
                  {{ item.stok_sekarang }}
                  <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 17h8m0 0V9m0 8l-8-8-4 4-6-6"></path></svg>
                </span>
              </td>
              <td class="px-6 py-5 whitespace-nowrap text-sm text-slate-500 font-medium">{{ item.batas_minimum }}</td>
              <td class="px-6 py-5 whitespace-nowrap text-sm">
                <span class="px-3 py-1 bg-red-100 text-red-700 rounded-full text-[11px] font-extrabold uppercase tracking-widest shadow-sm">Segera Restock</span>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted, onActivated } from 'vue';
import api from '../../utils/axios';

const stats = ref({
  total_servis: 0,
  total_pelanggan: 0,
  total_sparepart: 0,
  critical_stok: []
});
const isLoading = ref(true);

const fetchStats = async () => {
  try {
    const response = await api.get('/dashboard');
    stats.value = response.data.data;
  } catch (error) {
    console.error("Gagal mengambil data dashboard:", error);
  } finally {
    isLoading.value = false;
  }
};

onMounted(() => {
  fetchStats();
});

onActivated(() => {
  fetchStats();
});
</script>
