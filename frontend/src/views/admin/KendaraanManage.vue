<template>
  <div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
      <h1 class="text-2xl font-bold text-slate-800">Data Kendaraan</h1>
      <button @click="openForm()" class="bg-teal-600 hover:bg-teal-700 text-white font-medium py-2 px-6 rounded-xl shadow-lg shadow-teal-500/30 transition-all flex items-center gap-2">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
        Tambah Kendaraan
      </button>
    </div>

    <!-- Tabel Kendaraan -->
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
      <div class="p-4 border-b border-slate-100 bg-slate-50 flex items-center gap-3">
        <svg class="w-5 h-5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path></svg>
        <h2 class="font-bold text-slate-800">Daftar Kendaraan & Pemilik</h2>
      </div>

      <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-slate-100">
          <thead class="bg-slate-50/50">
            <tr>
              <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase">Plat Nomor</th>
              <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase">Model Mobil</th>
              <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase">Pemilik</th>
              <th class="px-6 py-4 text-right text-xs font-bold text-slate-500 uppercase">Aksi</th>
            </tr>
          </thead>
          <tbody class="bg-white divide-y divide-slate-50">
            <tr v-if="isLoading">
              <td colspan="4" class="px-6 py-8 text-center text-slate-500">Memuat data...</td>
            </tr>
            <tr v-else-if="kendaraans.length === 0">
              <td colspan="4" class="px-6 py-8 text-center text-slate-500">Belum ada data kendaraan.</td>
            </tr>
            <tr v-for="k in kendaraans" :key="k.nomor_polisi" class="hover:bg-slate-50 transition-colors">
              <td class="px-6 py-4 font-bold text-slate-800">{{ k.nomor_polisi }}</td>
              <td class="px-6 py-4 text-slate-600">{{ k.model }}</td>
              <td class="px-6 py-4 text-slate-600">{{ k.pelanggan?.nama }}</td>
              <td class="px-6 py-4 text-right space-x-2">
                <button @click="openForm(k)" class="text-teal-500 hover:text-teal-700 bg-teal-50 hover:bg-teal-100 p-2 rounded-lg transition-colors">
                  <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                </button>
                <button @click="deleteData(k.nomor_polisi)" class="text-red-500 hover:text-red-700 bg-red-50 hover:bg-red-100 p-2 rounded-lg transition-colors">
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
      <div class="bg-white rounded-2xl shadow-xl w-full max-w-md animate-fade-in-up">
        <div class="p-4 border-b border-slate-100 bg-slate-50 flex justify-between items-center rounded-t-2xl">
          <h2 class="font-bold text-slate-800">{{ isEdit ? 'Edit Kendaraan' : 'Tambah Kendaraan' }}</h2>
          <button @click="closeForm" class="text-slate-400 hover:text-slate-600 transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
          </button>
        </div>
        <form @submit.prevent="submitForm" class="p-6 space-y-4">
          <div class="space-y-1">
            <label class="text-sm font-semibold text-slate-700">Plat Nomor (Nomor Polisi)</label>
            <input v-model="form.nomor_polisi" type="text" :disabled="isEdit" required class="w-full px-4 py-2 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-teal-500 outline-none" placeholder="B 1234 ABC">
          </div>
          <div class="space-y-1">
            <label class="text-sm font-semibold text-slate-700">Model Mobil</label>
            <input v-model="form.model" type="text" required class="w-full px-4 py-2 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-teal-500 outline-none" placeholder="Toyota Avanza">
          </div>
          <div class="space-y-1">
            <label class="text-sm font-semibold text-slate-700">Pemilik (Pelanggan)</label>
            <SearchableSelect 
              v-model="form.id_pelanggan" 
              :options="pelangganOptions" 
              placeholder="Ketik Nama atau No HP..." 
            />
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
import { ref, reactive, onMounted, onActivated, computed } from 'vue';
import api from '../../utils/axios';
import SearchableSelect from '../../components/SearchableSelect.vue';

const kendaraans = ref([]);
const pelanggans = ref([]);
const isLoading = ref(true);
const isFormOpen = ref(false);
const isSubmitting = ref(false);
const isEdit = ref(false);

const form = reactive({
  nomor_polisi: '',
  model: '',
  id_pelanggan: ''
});

const pelangganOptions = computed(() => {
  return pelanggans.value.map(p => ({
    label: `${p.nama} (${p.nomor_hp})`,
    value: p.id
  }));
});

const fetchData = async () => {
  isLoading.value = true;
  try {
    const res = await api.get('/kendaraan');
    kendaraans.value = res.data;
    const resPelanggan = await api.get('/pelanggan');
    pelanggans.value = resPelanggan.data;
  } catch (err) {
    console.error(err);
  } finally {
    isLoading.value = false;
  }
};

const openForm = (data = null) => {
  if (data) {
    isEdit.value = true;
    form.nomor_polisi = data.nomor_polisi;
    form.model = data.model;
    form.id_pelanggan = data.id_pelanggan;
  } else {
    isEdit.value = false;
    form.nomor_polisi = '';
    form.model = '';
    form.id_pelanggan = '';
  }
  isFormOpen.value = true;
};

const closeForm = () => isFormOpen.value = false;

const submitForm = async () => {
  isSubmitting.value = true;
  try {
    if (isEdit.value) {
      await api.put(`/kendaraan/${form.nomor_polisi}`, form);
    } else {
      await api.post('/kendaraan', form);
    }
    closeForm();
    await fetchData();
  } catch (err) {
    alert(err.response?.data?.message || 'Gagal menyimpan data kendaraan');
  } finally {
    isSubmitting.value = false;
  }
};

const deleteData = async (id) => {
  if (await Swal.fire({
      title: 'Konfirmasi',
      text: `Yakin ingin menghapus kendaraan ini?`,
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#0d9488',
      cancelButtonColor: '#ef4444',
      confirmButtonText: 'Ya, Lanjutkan!',
      cancelButtonText: 'Batal'
    }).then(result => result.isConfirmed)) {
    try {
      await api.delete(`/kendaraan/${id}`);
      await fetchData();
    } catch (err) {
      alert('Gagal menghapus kendaraan');
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
