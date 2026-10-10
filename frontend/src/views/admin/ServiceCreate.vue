<template>
  <div class="space-y-6">
    <div class="flex items-center gap-4">
      <router-link to="/admin/service"
        class="p-2 bg-white border border-slate-200 rounded-lg hover:bg-slate-50 transition-colors">
        <svg class="w-5 h-5 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
        </svg>
      </router-link>
      <h1 class="text-2xl font-bold text-slate-800">Pendaftaran Servis Baru</h1>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden max-w-3xl">
      <form @submit.prevent="submitForm" class="p-6 md:p-8 space-y-6">

        <!-- Section: Data Kendaraan -->
        <div>
          <h2 class="text-lg font-bold text-slate-800 border-b border-slate-100 pb-2 mb-4">Informasi Kendaraan & Pelanggan</h2>
          <div class="grid grid-cols-1 gap-6">
            <div class="space-y-2">
              <label class="text-sm font-semibold text-slate-700">Pilih Kendaraan (Plat Nomor)</label>
              <SearchableSelect 
                v-model="form.id_kendaraan" 
                :options="kendaraanOptions" 
                placeholder="Ketik Plat Nomor Kendaraan..." 
              />
              <p class="text-xs text-slate-500">Jika kendaraan tidak ada, tambahkan dulu di menu <router-link to="/admin/kendaraan" class="text-teal-600 hover:underline">Data Kendaraan</router-link>.</p>
            </div>
          </div>
        </div>

        <!-- Section: Kendaraan -->
        <div class="pt-4">
          <h2 class="text-lg font-bold text-slate-800 border-b border-slate-100 pb-2 mb-4">Detail Servis</h2>
          <div class="space-y-2">
            <label class="text-sm font-semibold text-slate-700">Keluhan Kendaraan</label>
            <textarea v-model="form.catatan" rows="4"
              placeholder="Mesin cepat panas saat macet, air radiator sering berkurang..." required
              class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-teal-500 outline-none transition-all"></textarea>
          </div>
        </div>
        <!--
        <div>
          <label class="block text-sm font-medium text-slate-700">Catatan Mekanik</label>
          <textarea v-model="form.catatan" class="w-full rounded-lg border-slate-200" rows="2" placeholder="Catatan opsional untuk mekanik..."></textarea>
        </div>
-->
        <!-- Submit Button -->
        <div class="pt-4 border-t border-slate-100 flex justify-end gap-4">
          <router-link to="/admin/service"
            class="px-6 py-3 text-slate-600 hover:bg-slate-100 rounded-xl font-medium transition-colors">Batal</router-link>
          <button type="submit" :disabled="isSubmitting"
            class="bg-teal-600 hover:bg-teal-700 text-white font-bold py-3 px-8 rounded-xl shadow-lg shadow-teal-500/30 transition-all flex items-center justify-center disabled:opacity-70">
            <span v-if="!isSubmitting">Daftarkan Servis</span>
            <span v-else class="animate-spin w-5 h-5 border-2 border-white border-t-transparent rounded-full"></span>
          </button>
        </div>
      </form>
    </div>
  </div>
</template>

<script setup>
import { reactive, ref, onMounted, onActivated, computed } from 'vue';
import { useRouter } from 'vue-router';
import api from '../../utils/axios';
import SearchableSelect from '../../components/SearchableSelect.vue';

const router = useRouter();
const isSubmitting = ref(false);
const kendaraans = ref([]);

const form = reactive({
  id_kendaraan: '',
  catatan: '',
});

const kendaraanOptions = computed(() => {
  return kendaraans.value.map(k => ({
    label: `${k.nomor_polisi} - ${k.merk_mobil} (Milik: ${k.pelanggan?.nama_pelanggan})`,
    value: k.id_kendaraan
  }));
});

const fetchKendaraan = async () => {
  try {
    const res = await api.get('/kendaraan');
    kendaraans.value = res.data;
  } catch (err) {
    console.error(err);
  }
};

onMounted(() => {
  fetchKendaraan();
});

onActivated(() => {
  fetchKendaraan();
  // Reset form ketika komponen diaktifkan (agar tidak menempel data servis sebelumnya akibat keep-alive)
  form.id_kendaraan = '';
  form.catatan = '';
  isSubmitting.value = false;
});

const submitForm = async () => {
  isSubmitting.value = true;
  try {
    const res = await api.post('/service', form);
    const newServiceId = res.data.id_service;
    // Redirect langsung ke ruang kerja mekanik
    router.push(`/admin/service/${newServiceId}`);
  } catch (err) {
    alert(err.response?.data?.message || 'Gagal mendaftarkan servis.');
    isSubmitting.value = false;
  }
};
</script>
