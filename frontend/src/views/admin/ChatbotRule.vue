<template>
  <div class="space-y-6">
    <div class="flex flex-col sm:flex-row justify-between sm:items-center gap-4">
      <h1 class="text-2xl font-bold text-slate-800">Manajemen Aturan Chatbot</h1>
      <button @click="openAddModal" class="bg-teal-600 hover:bg-teal-700 text-white font-medium py-2 px-4 rounded-lg shadow-sm flex items-center gap-2 transition-colors">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
        Tambah Keyword Baru
      </button>
    </div>

    <!-- Table -->
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
      <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-slate-100">
          <thead class="bg-slate-50">
            <tr>
              <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase">Keyword</th>
              <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase">Action Type</th>
              <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase">Response Text</th>
              <th class="px-6 py-4 text-right text-xs font-bold text-slate-500 uppercase">Aksi</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-slate-50">
            <tr v-if="isLoading" class="text-center">
              <td colspan="4" class="px-6 py-8 text-slate-400">Loading data...</td>
            </tr>
            <tr v-else-if="items.length === 0">
              <td colspan="4" class="px-6 py-8 text-center text-slate-500">Belum ada aturan chatbot.</td>
            </tr>
            <tr v-for="item in items" :key="item.id" class="hover:bg-slate-50">
              <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-teal-700 bg-teal-50/50">"{{ item.keyword }}"</td>
              <td class="px-6 py-4 whitespace-nowrap text-sm">
                <span class="px-2 py-1 bg-slate-100 text-slate-700 rounded font-mono text-xs">{{ item.action_type }}</span>
              </td>
              <td class="px-6 py-4 text-sm text-slate-600 max-w-md truncate">{{ item.response_text || '-' }}</td>
              <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                <button @click="openEditModal(item)" class="text-teal-600 hover:text-teal-900 mr-3">Edit</button>
                <button @click="deleteItem(item.id)" class="text-red-600 hover:text-red-900">Hapus</button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>

    <!-- Modal Form -->
    <div v-if="isModalOpen" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/50 backdrop-blur-sm">
      <div class="bg-white rounded-2xl shadow-xl w-full max-w-lg overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-100 flex justify-between items-center bg-slate-50">
          <h3 class="text-lg font-bold text-slate-800">{{ isEdit ? 'Edit Aturan' : 'Tambah Aturan' }}</h3>
          <button @click="closeModal" class="text-slate-400 hover:text-slate-600">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
          </button>
        </div>
        <form @submit.prevent="saveItem" class="p-6 space-y-4">
          <div>
            <label class="block text-sm font-semibold text-slate-700 mb-1">Keyword (Kata Kunci)</label>
            <input v-model="form.keyword" type="text" placeholder="contoh: harga oli" required class="w-full px-4 py-2 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-teal-500 outline-none">
          </div>
          <div>
            <label class="block text-sm font-semibold text-slate-700 mb-1">Action Type</label>
            <select v-model="form.action_type" required class="w-full px-4 py-2 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-teal-500 outline-none">
              <option value="text_only">Hanya Balasan Teks (text_only)</option>
              <option value="check_stock">Otomatis Cek Stok (check_stock)</option>
              <option value="check_price">Otomatis Cek Harga (check_price)</option>
            </select>
            <p class="text-xs text-slate-500 mt-1">Gunakan check_stock / check_price jika keyword memuat nama barang persis.</p>
          </div>
          <div v-if="form.action_type === 'text_only'">
            <label class="block text-sm font-semibold text-slate-700 mb-1">Response Text (Balasan Chatbot)</label>
            <textarea v-model="form.response_text" rows="3" class="w-full px-4 py-2 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-teal-500 outline-none" required></textarea>
          </div>
          
          <div class="pt-4 flex justify-end gap-3">
            <button type="button" @click="closeModal" class="px-4 py-2 text-slate-600 hover:bg-slate-100 rounded-xl font-medium transition-colors">Batal</button>
            <button type="submit" :disabled="isSaving" class="px-4 py-2 bg-teal-600 text-white rounded-xl font-bold shadow-sm hover:bg-teal-700 transition-colors disabled:opacity-50">
              {{ isSaving ? 'Menyimpan...' : 'Simpan Aturan' }}
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

const items = ref([]);
const isLoading = ref(true);
const isSaving = ref(false);
const isModalOpen = ref(false);
const isEdit = ref(false);
const editId = ref(null);

const form = reactive({
  keyword: '',
  action_type: 'text_only',
  response_text: ''
});

const fetchItems = async () => {
  try {
    const res = await api.get('/chatbot-rule');
    items.value = res.data;
  } catch (err) {
    console.error(err);
  } finally {
    isLoading.value = false;
  }
};

onMounted(() => {
  fetchItems();
});

onActivated(() => {
  fetchItems();
});

const openAddModal = () => {
  isEdit.value = false;
  editId.value = null;
  form.keyword = '';
  form.action_type = 'text_only';
  form.response_text = '';
  isModalOpen.value = true;
};

const openEditModal = (item) => {
  isEdit.value = true;
  editId.value = item.id;
  form.keyword = item.keyword;
  form.action_type = item.action_type;
  form.response_text = item.response_text || '';
  isModalOpen.value = true;
};

const closeModal = () => {
  isModalOpen.value = false;
};

const saveItem = async () => {
  isSaving.value = true;
  try {
    if (isEdit.value) {
      await api.put(`/chatbot-rule/${editId.value}`, form);
    } else {
      await api.post('/chatbot-rule', form);
    }
    closeModal();
    fetchItems();
  } catch (err) {
    alert("Gagal menyimpan aturan. Pastikan keyword unik.");
  } finally {
    isSaving.value = false;
  }
};

const deleteItem = async (id) => {
  if (await Swal.fire({
      title: 'Konfirmasi',
      text: `Yakin ingin menghapus aturan chatbot ini?`,
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#0d9488',
      cancelButtonColor: '#ef4444',
      confirmButtonText: 'Ya, Lanjutkan!',
      cancelButtonText: 'Batal'
    }).then(result => result.isConfirmed)) {
    try {
      await api.delete(`/chatbot-rule/${id}`);
      fetchItems();
    } catch (err) {
      alert("Gagal menghapus data.");
    }
  }
};
</script>
