<template>
  <div class="space-y-6">
    <div class="flex flex-col sm:flex-row justify-between sm:items-center gap-4">
      <div>
        <h1 class="text-2xl font-bold text-slate-800">Manajemen Servis</h1>
        <p class="text-slate-500">Daftar antrean dan riwayat perbaikan kendaraan.</p>
      </div>
      <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-4">
        <!-- Search Bar -->
        <div class="relative">
          <input v-model="searchQuery" type="text" placeholder="Cari nama atau plat..." 
            class="pl-10 pr-4 py-2.5 bg-white border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 outline-none w-full sm:w-64 transition-all text-slate-800 placeholder-slate-400 shadow-sm">
          <svg class="w-5 h-5 text-slate-400 absolute left-3 top-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
        </div>
        <router-link to="/admin/service/create" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2.5 px-5 rounded-xl shadow-md flex items-center justify-center gap-2 transition-all hover:-translate-y-0.5">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"></path></svg>
          Servis Baru
        </router-link>
      </div>
    </div>

    <!-- Table -->
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
      <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-slate-100">
          <thead class="bg-slate-50/80">
            <tr>
              <th class="px-6 py-4 text-left text-[11px] font-extrabold text-slate-500 uppercase tracking-widest">Tgl Masuk</th>
              <th class="px-6 py-4 text-left text-[11px] font-extrabold text-slate-500 uppercase tracking-widest">Pelanggan</th>
              <th class="px-6 py-4 text-left text-[11px] font-extrabold text-slate-500 uppercase tracking-widest">Keluhan</th>
              <th class="px-6 py-4 text-left text-[11px] font-extrabold text-slate-500 uppercase tracking-widest">Status</th>
              <th class="px-6 py-4 text-right text-[11px] font-extrabold text-slate-500 uppercase tracking-widest">Aksi</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-slate-50">
            <tr v-if="isLoading" class="text-center">
              <td colspan="5" class="px-6 py-10 text-slate-500">
                <div class="flex flex-col items-center justify-center">
                  <div class="animate-spin w-8 h-8 border-4 border-indigo-500 border-t-transparent rounded-full mb-3"></div>
                  <span>Memuat data...</span>
                </div>
              </td>
            </tr>
            <tr v-else-if="filteredServices.length === 0">
              <td colspan="5" class="px-6 py-10 text-center text-slate-500 font-medium">Servis tidak ditemukan.</td>
            </tr>
            <tr v-for="item in filteredServices" :key="item.id_service" class="hover:bg-slate-50/80 transition-colors group">
              <td class="px-6 py-5 whitespace-nowrap text-sm text-slate-500 font-medium">{{ new Date(item.created_at).toLocaleDateString('id-ID') }}</td>
              <td class="px-6 py-5 whitespace-nowrap">
                <div class="font-bold text-slate-800 text-base">{{ item.kendaraan?.pelanggan?.nama_pelanggan || 'Tanpa Nama' }}</div>
                <div class="text-[11px] text-indigo-600 font-mono mt-1 font-bold tracking-wider">{{ item.kendaraan?.nomor_polisi }} <span class="text-slate-500 font-sans">({{ item.kendaraan?.merk_mobil }})</span></div>
              </td>
              <td class="px-6 py-5 text-sm text-slate-600 max-w-xs truncate">{{ item.catatan }}</td>
              <td class="px-6 py-5 whitespace-nowrap">
                <span :class="statusClass(item.status)">
                  {{ item.status }}
                </span>
              </td>
              <td class="px-6 py-5 whitespace-nowrap text-right text-sm font-medium">
                <div class="flex items-center justify-end gap-2 opacity-100 md:opacity-0 md:group-hover:opacity-100 transition-opacity">
                  <router-link :to="`/admin/service/${item.id_service}`" class="inline-flex items-center gap-1.5 text-indigo-700 hover:text-white bg-indigo-50 hover:bg-indigo-600 border border-indigo-100 px-3 py-1.5 rounded-lg transition-all text-xs font-bold tracking-wide shadow-sm">
                    Kelola
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"></path></svg>
                  </router-link>
                  <button @click="deleteService(item.id_service)" class="inline-flex items-center gap-1 text-red-600 hover:text-white bg-red-50 hover:bg-red-600 border border-red-100 px-3 py-1.5 rounded-lg transition-all text-xs font-bold tracking-wide shadow-sm">
                    Hapus
                  </button>
                </div>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</template>

<script setup>
import Swal from 'sweetalert2';
import { ref, onMounted, onActivated, computed } from 'vue';
import api from '../../utils/axios';

const services = ref([]);
const searchQuery = ref('');
const isLoading = ref(true);

const filteredServices = computed(() => {
  if (!searchQuery.value) return services.value;
  const lowerCaseQuery = searchQuery.value.toLowerCase();
  return services.value.filter(item => 
    item.kendaraan?.pelanggan?.nama_pelanggan?.toLowerCase().includes(lowerCaseQuery) ||
    item.kendaraan?.nomor_polisi?.toLowerCase().includes(lowerCaseQuery)
  );
});

const fetchServices = async (force = false) => {
  // Cache 30 detik - tidak perlu fetch ulang jika data masih segar
  const lastFetch = services._lastFetch || 0;
  if (!force && services.value.length > 0 && Date.now() - lastFetch < 30000) {
    isLoading.value = false;
    return;
  }
  try {
    const res = await api.get('/service');
    services.value = res.data;
    services._lastFetch = Date.now();
  } catch (err) {
    console.error(err);
  } finally {
    isLoading.value = false;
  }
};

const deleteService = async (id) => {
  if (await Swal.fire({
      title: 'Konfirmasi',
      text: `Yakin ingin menghapus riwayat servis ini secara permanen?`,
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#4f46e5',
      cancelButtonColor: '#ef4444',
      confirmButtonText: 'Ya, Lanjutkan!',
      cancelButtonText: 'Batal'
    }).then(result => result.isConfirmed)) {
    try {
      await api.delete(`/service/${id}`);
      fetchServices();
    } catch (err) {
      alert(err.response?.data?.message || 'Gagal menghapus servis');
    }
  }
};

const statusClass = (status) => {
  switch (status) {
    case 'Menunggu': return 'px-3 py-1.5 bg-yellow-100 text-yellow-800 border border-yellow-200 rounded-full text-[11px] uppercase tracking-wider font-extrabold shadow-sm';
    case 'Diproses': return 'px-3 py-1.5 bg-blue-100 text-blue-800 border border-blue-200 rounded-full text-[11px] uppercase tracking-wider font-extrabold shadow-sm';
    case 'Selesai': return 'px-3 py-1.5 bg-emerald-100 text-emerald-800 border border-emerald-200 rounded-full text-[11px] uppercase tracking-wider font-extrabold shadow-sm';
    default: return 'px-3 py-1.5 bg-slate-100 text-slate-700 border border-slate-200 rounded-full text-[11px] uppercase tracking-wider font-extrabold shadow-sm';
  }
};

onMounted(() => {
  fetchServices();
});

onActivated(() => {
  // Cek apakah data sudah ada; hanya refresh jika cache kedaluwarsa (> 30 detik)
  fetchServices();
});
</script>
