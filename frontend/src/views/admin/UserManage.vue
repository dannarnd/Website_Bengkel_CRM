<template>
  <div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
      <h1 class="text-2xl font-bold text-slate-800">Manajemen Pegawai</h1>
      <button @click="openForm" class="bg-teal-600 hover:bg-teal-700 text-white font-medium py-2 px-6 rounded-xl shadow-lg shadow-teal-500/30 transition-all flex items-center gap-2">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
        Tambah Pegawai
      </button>
    </div>

    <!-- Halaman Utama: Tabel Pegawai -->
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
      <div class="p-4 border-b border-slate-100 bg-slate-50 flex items-center gap-3">
        <svg class="w-5 h-5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
        <h2 class="font-bold text-slate-800">Daftar Akun Sistem</h2>
      </div>

      <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-slate-100">
          <thead class="bg-slate-50/50">
            <tr>
              <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Nama Pegawai</th>
              <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Username</th>
              <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Jabatan</th>
              <th class="px-6 py-4 text-right text-xs font-bold text-slate-500 uppercase tracking-wider">Aksi</th>
            </tr>
          </thead>
          <tbody class="bg-white divide-y divide-slate-50">
            <tr v-if="isLoading">
              <td colspan="4" class="px-6 py-8 text-center text-slate-500">Memuat data pegawai...</td>
            </tr>
            <tr v-else-if="users.length === 0">
              <td colspan="4" class="px-6 py-8 text-center text-slate-500">Belum ada data pegawai.</td>
            </tr>
            <tr v-for="user in users" :key="user.id" class="hover:bg-slate-50 transition-colors">
              <td class="px-6 py-4 whitespace-nowrap">
                <div class="flex items-center gap-3">
                  <div class="w-8 h-8 rounded-full bg-teal-100 text-teal-600 flex items-center justify-center font-bold text-sm">
                    {{ user.name.charAt(0).toUpperCase() }}
                  </div>
                  <span class="font-medium text-slate-800">{{ user.name }}</span>
                </div>
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600 font-mono">{{ user.username || user.email }}</td>
              <td class="px-6 py-4 whitespace-nowrap">
                <span v-if="user.role === 'admin'" class="px-3 py-1 bg-purple-100 text-purple-700 rounded-full text-xs font-bold">Admin</span>
                <span v-else class="px-3 py-1 bg-blue-100 text-blue-700 rounded-full text-xs font-bold">Mekanik</span>
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-right text-sm">
                <button @click="openForm(user)" class="text-teal-500 hover:text-teal-700 transition-colors bg-teal-50 hover:bg-teal-100 p-2 rounded-lg mr-2">
                  <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                </button>
                <button v-if="authStore.user?.id !== user.id" @click="confirmDelete(user)" class="text-red-500 hover:text-red-700 transition-colors bg-red-50 hover:bg-red-100 p-2 rounded-lg">
                  <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                </button>
                <span v-else class="text-xs text-slate-400 italic ml-2">Akun Anda</span>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>

    <!-- Modal Form Pegawai Baru -->
    <div v-if="isFormOpen" class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/50 backdrop-blur-sm p-4">
      <div class="bg-white rounded-2xl shadow-xl w-full max-w-md overflow-hidden animate-fade-in-up">
        <div class="p-4 border-b border-slate-100 bg-slate-50 flex justify-between items-center">
          <h2 class="font-bold text-slate-800">{{ editId ? 'Edit Pegawai' : 'Tambah Pegawai Baru' }}</h2>
          <button @click="closeForm" class="text-slate-400 hover:text-slate-600 transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
          </button>
        </div>
        <form @submit.prevent="submitForm" class="p-6 space-y-4">
          
          <div v-if="errorMessage" class="p-3 bg-red-50 text-red-600 text-sm rounded-xl border border-red-100">
            {{ errorMessage }}
          </div>

          <div class="space-y-1">
            <label class="text-sm font-semibold text-slate-700">Nama Lengkap</label>
            <input v-model="form.name" type="text" required placeholder="Budi Santoso" class="w-full px-4 py-2 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-teal-500 outline-none transition-all text-sm">
          </div>
          
          <div class="space-y-1">
            <label class="text-sm font-semibold text-slate-700">Username (Untuk Login)</label>
            <input v-model="form.username" type="text" required placeholder="contoh: budisantoso" pattern="[a-zA-Z0-9_.]+" title="Hanya huruf, angka, titik, dan underscore" class="w-full px-4 py-2 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-teal-500 outline-none transition-all text-sm font-mono">
            <p class="text-xs text-slate-500">Hanya huruf, angka, titik (.), dan underscore (_). Tanpa spasi.</p>
          </div>

          <div class="space-y-1">
            <label class="text-sm font-semibold text-slate-700">Password</label>
            <div class="relative">
              <input v-model="form.password" :type="showFormPassword ? 'text' : 'password'" :required="!editId" placeholder="Minimal 6 karakter" minlength="6" class="w-full px-4 py-2 pr-10 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-teal-500 outline-none transition-all text-sm">
              <button type="button" @click="showFormPassword = !showFormPassword" class="absolute inset-y-0 right-2 flex items-center text-slate-400 hover:text-teal-600 transition-colors px-1">
                <svg v-if="!showFormPassword" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                <svg v-else class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"></path></svg>
              </button>
            </div>
            <p v-if="editId" class="text-xs text-slate-500 mt-1">Kosongkan jika tidak ingin mengubah password.</p>
          </div>

          <div class="space-y-1">
            <label class="text-sm font-semibold text-slate-700">Jabatan</label>
            <div class="flex gap-4">
              <label class="flex items-center gap-2 cursor-pointer">
                <input type="radio" v-model="form.role" value="mekanik" class="w-4 h-4 text-teal-600 focus:ring-teal-500 border-slate-300">
                <span class="text-sm font-medium text-slate-700">Mekanik</span>
              </label>
              <label class="flex items-center gap-2 cursor-pointer">
                <input type="radio" v-model="form.role" value="admin" class="w-4 h-4 text-purple-600 focus:ring-purple-500 border-slate-300">
                <span class="text-sm font-medium text-slate-700">Admin</span>
              </label>
            </div>
          </div>

          <div class="pt-4 flex gap-3">
            <button type="button" @click="closeForm" class="flex-1 py-2 px-4 border border-slate-200 text-slate-600 rounded-xl hover:bg-slate-50 transition-colors font-medium">Batal</button>
            <button type="submit" :disabled="isSubmitting" class="flex-1 py-2 px-4 bg-teal-600 hover:bg-teal-700 text-white rounded-xl transition-colors font-medium disabled:opacity-70 flex justify-center items-center">
              <span v-if="!isSubmitting">Simpan</span>
              <span v-else class="animate-spin w-5 h-5 border-2 border-white border-t-transparent rounded-full"></span>
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
import { useAuthStore } from '../../stores/auth';
import api from '../../utils/axios';

const authStore = useAuthStore();
const users = ref([]);
const isLoading = ref(true);
const isFormOpen = ref(false);
const isSubmitting = ref(false);
const errorMessage = ref('');
const editId = ref(null);

const showFormPassword = ref(false);

const form = reactive({
  name: '',
  username: '',
  password: '',
  role: 'mekanik'
});

const fetchUsers = async () => {
  try {
    isLoading.value = true;
    const response = await api.get('/users');
    users.value = response.data;
  } catch (error) {
    console.error('Failed to fetch users', error);
  } finally {
    isLoading.value = false;
  }
};

const openForm = (user = null) => {
  errorMessage.value = '';
  showFormPassword.value = false;
  if (user && user.id) {
    editId.value = user.id;
    form.name = user.name;
    form.username = user.username || '';
    form.password = '';
    form.role = user.role;
  } else {
    editId.value = null;
    form.name = '';
    form.username = '';
    form.password = '';
    form.role = 'mekanik';
  }
  isFormOpen.value = true;
};

const closeForm = () => {
  isFormOpen.value = false;
};

const submitForm = async () => {
  try {
    isSubmitting.value = true;
    errorMessage.value = '';
    if (editId.value) {
      await api.put(`/users/${editId.value}`, form);
    } else {
      await api.post('/users', form);
    }
    closeForm();
    await fetchUsers(); // Refresh tabel
  } catch (error) {
    errorMessage.value = error.response?.data?.message || 'Gagal menyimpan data pegawai. Pastikan username belum terdaftar.';
  } finally {
    isSubmitting.value = false;
  }
};

const confirmDelete = async (user) => {
  if (await Swal.fire({
      title: 'Konfirmasi',
      text: `Anda yakin ingin menghapus akun pegawai ${user.name}?`,
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#0d9488',
      cancelButtonColor: '#ef4444',
      confirmButtonText: 'Ya, Lanjutkan!',
      cancelButtonText: 'Batal'
    }).then(result => result.isConfirmed)) {
    try {
      await api.delete(`/users/${user.id}`);
      await fetchUsers();
    } catch (error) {
      alert(error.response?.data?.message || 'Gagal menghapus pegawai.');
    }
  }
};

onMounted(() => {
  fetchUsers();
});

onActivated(() => {
  fetchUsers();
});
</script>

<style scoped>
.animate-fade-in-up {
  animation: fadeInUp 0.3s ease-out forwards;
}

@keyframes fadeInUp {
  from {
    opacity: 0;
    transform: translateY(20px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}
</style>
