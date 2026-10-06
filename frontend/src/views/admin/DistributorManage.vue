<template>
  <div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
      <h1 class="text-2xl font-bold text-slate-800">Data Distributor</h1>
      <button @click="openForm()" class="bg-teal-600 hover:bg-teal-700 text-white font-medium py-2 px-6 rounded-xl shadow-lg shadow-teal-500/30 transition-all flex items-center gap-2">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
        Tambah Distributor
      </button>
    </div>

    <!-- Tabel Pelanggan -->
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
      <div class="p-4 border-b border-slate-100 bg-slate-50 flex items-center gap-3">
        <svg class="w-5 h-5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
        <h2 class="font-bold text-slate-800">Daftar Distributor</h2>
      </div>

      <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-slate-100">
          <thead class="bg-slate-50/50">
            <tr>
              <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase">ID</th>
              <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase">Nama Distributor</th>
              <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase">Nomor HP</th>
              <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase">Alamat</th>
              <th class="px-6 py-4 text-right text-xs font-bold text-slate-500 uppercase">Aksi</th>
            </tr>
          </thead>
          <tbody class="bg-white divide-y divide-slate-50">
            <tr v-if="isLoading">
              <td colspan="5" class="px-6 py-8 text-center text-slate-500">Memuat data...</td>
            </tr>
            <tr v-else-if="distributors.length === 0">
              <td colspan="5" class="px-6 py-8 text-center text-slate-500">Belum ada data distributor.</td>
            </tr>
            <tr v-for="p in distributors" :key="p.id_distributor" class="hover:bg-slate-50 transition-colors">
              <td class="px-6 py-4 font-mono font-medium text-teal-600">{{ p.id_distributor }}</td>
              <td class="px-6 py-4 font-medium text-slate-800">{{ p.nama_distributor }}</td>
              <td class="px-6 py-4 text-slate-600">{{ p.no_hp }}</td>
              <td class="px-6 py-4 text-slate-600 truncate max-w-[200px]">{{ p.alamat }}</td>
              <td class="px-6 py-4 text-right space-x-2">
                <button @click="openForm(p)" class="text-teal-500 hover:text-teal-700 bg-teal-50 hover:bg-teal-100 p-2 rounded-lg transition-colors">
                  <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                </button>
                <button @click="deleteData(p.id_distributor)" class="text-red-500 hover:text-red-700 bg-red-50 hover:bg-red-100 p-2 rounded-lg transition-colors">
                  <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                </button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>

    <!-- Modal Form -->
    <div v-if="isFormOpen" class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/50 backdrop-blur-sm p-4">
      <div class="bg-white rounded-2xl shadow-xl w-full max-w-md overflow-hidden animate-fade-in-up">
        <div class="p-4 border-b border-slate-100 bg-slate-50 flex justify-between items-center">
          <h2 class="font-bold text-slate-800">{{ editId ? 'Edit Distributor' : 'Tambah Distributor' }}</h2>
          <button @click="closeForm" class="text-slate-400 hover:text-slate-600 transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
          </button>
        </div>
        <form @submit.prevent="submitForm" class="p-6 space-y-4">
          <div class="space-y-1">
            <label class="text-sm font-semibold text-slate-700">Nama Distributor</label>
            <input v-model="form.nama_distributor" type="text" required class="w-full px-4 py-2 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-teal-500 outline-none">
          </div>
          <div class="space-y-1">
            <label class="text-sm font-semibold text-slate-700">Nomor HP (Opsional)</label>
            <input v-model="form.no_hp" type="text" class="w-full px-4 py-2 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-teal-500 outline-none">
          </div>
          <div class="space-y-1">
            <label class="text-sm font-semibold text-slate-700">Alamat (Opsional)</label>
            <textarea v-model="form.alamat" rows="3" class="w-full px-4 py-2 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-teal-500 outline-none"></textarea>
          </div>
          <div class="pt-4 flex gap-3">
            <button type="button" @click="closeForm" class="flex-1 py-2 border rounded-xl hover:bg-slate-50 font-medium">Batal</button>
            <button type="submit" :disabled="isSubmitting" class="flex-1 py-2 bg-teal-600 hover:bg-teal-700 text-white rounded-xl font-medium disabled:opacity-70">
              {{ isSubmitting ? 'Menyimpan...' : 'Simpan' }}
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>

<script setup>
import Swal from 'sweetalert2';
import { ref, reactive, onMounted, onActivated } from 'vue';
import api from '../../utils/axios';

const distributors = ref([]);
const isLoading = ref(true);
const isFormOpen = ref(false);
const isSubmitting = ref(false);
const editId = ref(null);

const form = reactive({
  nama_distributor: '',
  no_hp: '',
  alamat: ''
});

const fetchData = async () => {
  isLoading.value = true;
  try {
    const res = await api.get('/distributor');
    distributors.value = res.data;
  } catch (err) {
    console.error(err);
  } finally {
    isLoading.value = false;
  }
};

const openForm = (data = null) => {
  if (data) {
    editId.value = data.id_distributor;
    form.nama_distributor = data.nama_distributor;
    form.no_hp = data.no_hp;
    form.alamat = data.alamat;
  } else {
    editId.value = null;
    form.nama_distributor = '';
    form.no_hp = '';
    form.alamat = '';
  }
  isFormOpen.value = true;
};

const closeForm = () => isFormOpen.value = false;

const submitForm = async () => {
  isSubmitting.value = true;
  try {
    if (editId.value) {
      await api.put(`/distributor/${editId.value}`, form);
    } else {
      await api.post('/distributor', form);
    }
    closeForm();
    await fetchData();
  } catch (err) {
    alert('Gagal menyimpan data');
  } finally {
    isSubmitting.value = false;
  }
};

const deleteData = async (id) => {
  if (await Swal.fire({
      title: 'Konfirmasi',
      text: `Yakin ingin menghapus distributor ini?`,
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#0d9488',
      cancelButtonColor: '#ef4444',
      confirmButtonText: 'Ya, Lanjutkan!',
      cancelButtonText: 'Batal'
    }).then(result => result.isConfirmed)) {
    try {
      await api.delete(`/distributor/${id}`);
      await fetchData();
    } catch (err) {
      alert('Gagal menghapus distributor');
    }
  }
};

onMounted(fetchData);
onActivated(fetchData);
</script>

<style scoped>
.animate-fade-in-up { animation: fadeInUp 0.3s ease-out forwards; }
@keyframes fadeInUp { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
</style>
