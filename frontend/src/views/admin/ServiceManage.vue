<template>
  <div>
    <div class="space-y-6" v-if="service">
    
    <!-- Header: Informasi Singkat -->
    <div class="bg-white p-4 md:p-6 rounded-2xl shadow-sm border border-slate-100 flex flex-col md:flex-row md:items-center justify-between gap-4">
      <div>
        <div class="flex flex-wrap items-center gap-3 mb-2">
          <h1 class="text-2xl font-bold text-slate-800">Ruang Kerja: {{ service.nomor_polisi }} <span class="text-lg text-slate-500 font-normal">({{ service.kendaraan?.model }})</span></h1>
          <span :class="statusClass(service.status)">{{ service.status }}</span>
          
          <!-- Tombol Kontrol Status Manual -->
          <div v-if="service.status !== 'Selesai'" class="flex flex-wrap bg-slate-100 rounded-lg p-1 border border-slate-200">
            <button @click="updateStatus('Menunggu')" :disabled="isChangingStatus" :class="['px-3 py-1 text-xs font-bold rounded-md transition-colors', service.status === 'Menunggu' ? 'bg-white shadow-sm text-yellow-700 border border-slate-200' : 'text-slate-500 hover:text-slate-700']">Menunggu</button>
            <button @click="updateStatus('Dikerjakan')" :disabled="isChangingStatus" :class="['px-3 py-1 text-xs font-bold rounded-md transition-colors', service.status === 'Dikerjakan' ? 'bg-white shadow-sm text-blue-700 border border-slate-200' : 'text-slate-500 hover:text-slate-700']">Dikerjakan</button>
          </div>
        </div>
        <p class="text-sm text-slate-500">Pemilik: <span class="font-bold text-slate-700">{{ service.kendaraan?.pelanggan?.nama }}</span> | HP: {{ service.kendaraan?.pelanggan?.nomor_hp }}</p>
      </div>
      <div class="text-left md:text-right mt-2 md:mt-0 border-t md:border-0 border-slate-100 pt-4 md:pt-0">
        <p class="text-xs text-slate-500 uppercase font-bold tracking-wider mb-1">Total Biaya Servis</p>
        <p class="text-3xl font-extrabold text-teal-600 mb-3">Rp{{ parseInt(service.total_biaya).toLocaleString('id-ID') }}</p>
        <button v-if="service.status === 'Selesai'" @click="downloadNota" :disabled="isGeneratingPdf" class="w-full md:w-auto bg-indigo-600 hover:bg-indigo-700 disabled:opacity-60 text-white font-bold py-2.5 px-4 rounded-xl flex items-center justify-center gap-2 transition-colors shadow-sm text-sm md:ml-auto">
          <svg v-if="isGeneratingPdf" class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path></svg>
          <svg v-else class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
          {{ isGeneratingPdf ? 'Memproses...' : 'Cetak Nota (PDF)' }}
        </button>
      </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
      
      <!-- Kiri: Detail & Foto -->
      <div class="lg:col-span-1 space-y-6">
        <!-- Keluhan Box -->
        <div class="bg-amber-50 p-6 rounded-2xl border border-amber-100">
          <h3 class="text-xs font-bold text-amber-800 uppercase tracking-wider mb-2">Keluhan Kendaraan</h3>
          <p class="text-amber-900 text-sm">{{ service.keluhan }}</p>
        </div>

        <!-- Catatan Riwayat Sistem (Jika Ada) -->
        <div v-if="service.catatan" class="bg-blue-50 p-6 rounded-2xl border border-blue-100">
          <h3 class="text-xs font-bold text-blue-800 uppercase tracking-wider mb-2">Catatan Sistem</h3>
          <p class="text-blue-900 text-sm whitespace-pre-line">{{ service.catatan }}</p>
        </div>

        <!-- BAGIAN B: Transparansi Visual (Foto) -->
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
          <div class="p-4 border-b border-slate-100 bg-slate-50">
            <h2 class="font-bold text-slate-800">Transparansi Visual</h2>
          </div>
          <div class="p-6 space-y-6">
            
            <!-- Foto Before -->
            <div>
              <p class="text-sm font-semibold text-slate-700 mb-2">Foto Sebelum (Before)</p>
              <div v-if="previewBefore || service.service_photo?.foto_before" class="mb-3 relative">
                <img :src="previewBefore || ('http://localhost:8000' + service.service_photo.foto_before)" class="w-full h-40 object-cover rounded-xl border border-slate-200">
                <span v-if="previewBefore" class="absolute top-2 right-2 bg-yellow-500 text-white text-xs font-bold px-2 py-1 rounded-md shadow-sm">Belum Disimpan</span>
              </div>
              <div v-if="service.status !== 'Selesai'">
                <input type="file" accept="image/*" capture="environment" @change="e => handleFileUpload(e, 'foto_before')" class="block w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-teal-50 file:text-teal-700 hover:file:bg-teal-100 transition-colors">
              </div>
            </div>

            <!-- Foto After -->
            <div>
              <p class="text-sm font-semibold text-slate-700 mb-2">Foto Sesudah (After)</p>
              <div v-if="previewAfter || service.service_photo?.foto_after" class="mb-3 relative">
                <img :src="previewAfter || ('http://localhost:8000' + service.service_photo.foto_after)" class="w-full h-40 object-cover rounded-xl border border-slate-200">
                <span v-if="previewAfter" class="absolute top-2 right-2 bg-yellow-500 text-white text-xs font-bold px-2 py-1 rounded-md shadow-sm">Belum Disimpan</span>
              </div>
              <div v-if="service.status !== 'Selesai'">
                <input type="file" accept="image/*" capture="environment" @change="e => handleFileUpload(e, 'foto_after')" class="block w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-teal-50 file:text-teal-700 hover:file:bg-teal-100 transition-colors">
              </div>
            </div>
            
            <button v-if="service.status !== 'Selesai'" @click="uploadPhotos" :disabled="isUploading" class="w-full bg-slate-800 hover:bg-slate-900 text-white font-medium py-2 rounded-xl transition-colors disabled:opacity-70 flex justify-center items-center">
              {{ isUploading ? 'Mengunggah...' : 'Simpan Foto' }}
            </button>
          </div>
        </div>
      </div>

      <!-- Kanan: Sparepart & Penyelesaian -->
      <div class="lg:col-span-2 space-y-6">
        
        <!-- BAGIAN A: Penggunaan Sparepart -->
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
          <div class="p-4 border-b border-slate-100 bg-slate-50 flex justify-between items-center">
            <h2 class="font-bold text-slate-800">Rincian Sparepart & Jasa</h2>
          </div>
          
          <!-- Form Tambah Sparepart -->
          <div v-if="service.status !== 'Selesai'" class="p-4 bg-slate-50 border-b border-slate-100">
            <form @submit.prevent="addSparepart" class="flex flex-col sm:flex-row gap-3">
              <div class="flex-1">
                <SearchableSelect 
                  v-model="sparepartForm.id" 
                  :options="sparepartOptions" 
                  placeholder="Cari barang/jasa..." 
                />
              </div>
              <input v-model="sparepartForm.qty" type="number" min="1" required placeholder="Qty" class="w-24 px-4 py-2 bg-white border border-slate-200 rounded-xl focus:ring-2 focus:ring-teal-500 outline-none text-sm">
              <button type="submit" :disabled="isAddingSp" class="bg-teal-600 hover:bg-teal-700 text-white px-4 py-2 rounded-xl font-medium transition-colors disabled:opacity-70">
                Tambah
              </button>
            </form>
          </div>

          <!-- Tabel Rincian -->
          <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-100">
              <thead class="bg-white">
                <tr>
                  <th class="px-6 py-3 text-left text-xs font-bold text-slate-500 uppercase">Item</th>
                  <th class="px-6 py-3 text-center text-xs font-bold text-slate-500 uppercase">Qty</th>
                  <th class="px-6 py-3 text-right text-xs font-bold text-slate-500 uppercase">Harga</th>
                  <th class="px-6 py-3 text-right text-xs font-bold text-slate-500 uppercase">Subtotal</th>
                  <th v-if="service.status !== 'Selesai'" class="px-6 py-3"></th>
                </tr>
              </thead>
              <tbody class="divide-y divide-slate-50">
                <tr v-if="!service.service_details || service.service_details.length === 0">
                  <td colspan="5" class="px-6 py-8 text-center text-slate-500 text-sm">Belum ada barang/jasa yang ditambahkan.</td>
                </tr>
                <tr v-for="detail in service.service_details" :key="detail.id" class="hover:bg-slate-50 transition-colors">
                  <td class="px-6 py-3 text-sm font-medium text-slate-800">
                    <span class="text-xs text-teal-600 font-mono mr-1">[{{ detail.sparepart?.kode_barang }}]</span>
                    {{ detail.sparepart?.nama_barang }}
                  </td>
                  <td class="px-6 py-3 text-sm text-center">{{ detail.qty }}</td>
                  <td class="px-6 py-3 text-sm text-right text-slate-600">Rp{{ parseInt(detail.sparepart?.harga).toLocaleString('id-ID') }}</td>
                  <td class="px-6 py-3 text-sm text-right font-bold text-teal-700">Rp{{ parseInt(detail.subtotal).toLocaleString('id-ID') }}</td>
                  <td v-if="service.status !== 'Selesai'" class="px-4 py-3 text-right">
                    <button @click="removeSparepart(detail.id)" class="text-red-500 hover:text-red-700">
                      <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                    </button>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>

        <!-- BAGIAN C: Penyelesaian - The Smart Trigger -->
        <div v-if="service.status !== 'Selesai'" class="bg-gradient-to-r from-teal-900 to-slate-900 p-8 rounded-3xl shadow-xl text-white relative overflow-hidden">
          <div class="absolute inset-0 opacity-10 bg-[url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMjAiIGhlaWdodD0iMjAiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+PGNpcmNsZSBjeD0iMiIgY3k9IjIiIHI9IjIiIGZpbGw9IiNmZmZmZmYiLz48L3N2Zz4=')]"></div>
          
          <div class="relative z-10 text-center">
            <h2 class="text-2xl font-bold mb-2">Tandai Servis Selesai</h2>
            <p class="text-teal-200 text-sm mb-6 max-w-sm mx-auto">
              Sistem akan otomatis memotong stok barang yang terpakai dan menerbitkan masa garansi (default 30 hari).
            </p>
            
            <div v-if="!showFinishForm">
              <button @click="openFinishForm" :disabled="isFinishing" class="bg-teal-500 hover:bg-teal-400 text-white font-extrabold text-lg py-3 px-6 md:py-4 md:px-12 rounded-full shadow-lg hover:shadow-teal-500/50 transition-all transform hover:scale-105 disabled:opacity-70 disabled:hover:scale-100 flex justify-center items-center mx-auto">
                <span v-if="!isFinishing">SELESAIKAN SERVIS</span>
                <span v-else class="animate-spin w-6 h-6 border-4 border-white border-t-transparent rounded-full"></span>
              </button>
            </div>
            
            <div v-else class="mt-4 bg-teal-800 p-4 rounded-xl text-left max-w-md mx-auto border border-teal-700">
              <label class="block text-sm font-semibold text-teal-100 mb-2">Garansi Berakhir Pada (Default 30 Hari):</label>
              <input v-model="finishGaransiDate" type="date" class="w-full px-3 py-2 rounded-lg text-sm outline-none text-slate-800 bg-white mb-4 shadow-inner">
              <div class="flex flex-wrap gap-2 justify-end">
                <button @click="showFinishForm = false" class="px-4 py-2 text-sm font-medium text-teal-200 hover:bg-teal-700 rounded-lg transition-colors flex-1 sm:flex-none">Batal</button>
                <button @click="finishService" :disabled="isFinishing" class="px-4 py-2 text-sm font-medium bg-teal-500 text-white rounded-lg hover:bg-teal-400 transition-colors flex justify-center items-center gap-2 flex-1 sm:flex-none">
                  <span v-if="!isFinishing">Potong Stok & Terbitkan</span>
                  <span v-else class="animate-spin w-4 h-4 border-2 border-white border-t-transparent rounded-full"></span>
                </button>
              </div>
            </div>
          </div>
        </div>
        
        <!-- Jika sudah selesai -->
        <div v-else class="bg-green-50 border border-green-200 p-6 rounded-3xl">
          <div class="flex items-center gap-3 mb-4">
            <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center text-green-600">
              <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
            </div>
            <div>
              <h3 class="font-bold text-green-900 text-lg">Servis Telah Selesai</h3>
              <p class="text-green-700 text-sm">Diselesaikan pada {{ service.tanggal_selesai }}</p>
            </div>
          </div>

          <!-- Tombol Buka Kembali Nota -->
          <button @click="reopenService" :disabled="isReopening" class="w-full mt-2 mb-4 bg-red-50 hover:bg-red-100 text-red-600 border border-red-200 font-bold py-2 rounded-xl text-sm transition-colors flex justify-center items-center gap-2">
            <span v-if="!isReopening">⚠️ Revisi / Buka Kembali Nota (Retur Stok)</span>
            <span v-else class="animate-spin w-4 h-4 border-2 border-red-600 border-t-transparent rounded-full"></span>
          </button> 
            
            <div v-if="service.warranty" class="mt-4">
              <div v-if="!isEditingWarranty" class="inline-block bg-white border border-green-200 px-4 py-2 rounded-lg text-sm font-bold text-green-700 shadow-sm">
                🛡️ Garansi {{ service.warranty.status_garansi }} s.d {{ service.warranty.tanggal_berakhir }}
                <button @click="openEditWarranty" class="ml-2 text-teal-600 hover:text-teal-800 underline font-normal">Edit</button>
              </div>
              <div v-else class="mt-2 bg-white border border-slate-200 p-4 rounded-xl text-left shadow-sm">
                <h3 class="text-sm font-bold mb-3 text-slate-700">Edit Garansi</h3>
                <form @submit.prevent="saveWarranty" class="space-y-3">
                  <div>
                    <label class="text-xs font-semibold text-slate-600">Berakhir Pada:</label>
                    <input v-model="warrantyForm.tanggal_berakhir" type="date" required class="w-full mt-1 px-3 py-2 border rounded-lg text-sm outline-none focus:border-teal-500">
                  </div>
                  <div>
                    <label class="text-xs font-semibold text-slate-600">Status:</label>
                    <select v-model="warrantyForm.status_garansi" class="w-full mt-1 px-3 py-2 border rounded-lg text-sm outline-none focus:border-teal-500">
                      <option value="Aktif">Aktif</option>
                      <option value="Hangus">Hangus</option>
                      <option value="Selesai">Selesai</option>
                    </select>
                  </div>
                  <div class="flex gap-2 justify-end pt-2">
                    <button type="button" @click="isEditingWarranty = false" class="px-3 py-1.5 text-xs font-medium text-slate-600 hover:bg-slate-100 rounded-lg transition-colors">Batal</button>
                    <button type="submit" :disabled="isSavingWarranty" class="px-3 py-1.5 text-xs font-medium bg-teal-600 text-white rounded-lg hover:bg-teal-700 transition-colors">Simpan</button>
                  </div>
                </form>
              </div>
              
              <!-- Form Klaim Garansi In-Place -->
              <div v-if="service.warranty.status_garansi === 'Aktif'" class="mt-4 pt-4 border-t border-green-200">
                <button v-if="!showClaimForm" @click="showClaimForm = true" class="w-full bg-amber-500 hover:bg-amber-600 text-white font-bold py-3 rounded-xl shadow-sm transition-all flex justify-center items-center gap-2">
                  Ajukan Klaim Garansi / Revisi
                </button>
                
                <div v-else class="bg-amber-50 border border-amber-200 p-4 rounded-xl text-left shadow-sm">
                  <h3 class="text-sm font-bold mb-3 text-amber-800">Form Klaim Garansi</h3>
                  <form @submit.prevent="claimWarranty" class="space-y-3">
                    <div>
                      <label class="text-xs font-semibold text-amber-900">Apa yang direvisi / dikerjakan ulang?</label>
                      <textarea v-model="claimForm.catatan_klaim" required rows="3" placeholder="Contoh: Busi dibersihkan ulang karena pemasangan kurang pas..." class="w-full mt-1 px-3 py-2 border border-amber-200 rounded-lg text-sm outline-none focus:border-amber-500 bg-white"></textarea>
                    </div>
                    <div>
                      <label class="text-xs font-semibold text-amber-900">Perpanjang Garansi Sampai:</label>
                      <input v-model="claimForm.tanggal_garansi_baru" type="date" required class="w-full mt-1 px-3 py-2 border border-amber-200 rounded-lg text-sm outline-none focus:border-amber-500 bg-white">
                    </div>
                    <div class="flex gap-2 justify-end pt-2">
                      <button type="button" @click="showClaimForm = false" class="px-3 py-1.5 text-xs font-medium text-amber-800 hover:bg-amber-100 rounded-lg transition-colors">Batal</button>
                      <button type="submit" :disabled="isClaiming" class="px-3 py-1.5 text-xs font-medium bg-amber-600 text-white rounded-lg hover:bg-amber-700 transition-colors flex items-center gap-1">
                        <span v-if="isClaiming" class="animate-spin w-3 h-3 border-2 border-white border-t-transparent rounded-full"></span>
                        Simpan Klaim
                      </button>
                    </div>
                  </form>
                </div>
              </div>
              <div v-else-if="service.warranty.status_garansi === 'Diklaim'" class="mt-4 p-3 bg-blue-50 text-blue-700 text-sm rounded-lg border border-blue-100 font-medium">
                ℹ️ Garansi nota ini telah diclaim. Silakan cek catatan sistem untuk melihat nomor nota servis lanjutannya.
              </div>
            </div>
          </div>
        </div>
    </div>
  </div>
  <div v-else class="flex justify-center items-center h-64">
    <div class="animate-spin w-8 h-8 border-4 border-teal-600 border-t-transparent rounded-full"></div>
  </div>

  <!-- Modal Preview PDF -->
  <div v-if="isPdfModalOpen" class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-slate-900/80 backdrop-blur-sm animate-fade-in-up">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-4xl h-[85vh] overflow-hidden flex flex-col">
      <div class="px-6 py-4 border-b border-slate-100 flex justify-between items-center bg-indigo-50">
        <h3 class="text-lg font-bold text-indigo-900 flex items-center gap-2">
          <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
          Preview Nota Servis
        </h3>
        <div class="flex items-center gap-3">
          <a :href="pdfPreviewUrl" :download="'Nota_Servis_' + service?.nomor_polisi + '.pdf'" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg text-sm font-bold flex items-center gap-2 transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
            Download PDF
          </a>
          <button @click="isPdfModalOpen = false" class="text-slate-400 hover:text-slate-600 transition-colors bg-white rounded-full p-1 border border-slate-200">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
          </button>
        </div>
      </div>
      <div class="flex-1 p-0 bg-slate-200">
        <iframe :src="pdfPreviewUrl" class="w-full h-full border-0" title="PDF Preview"></iframe>
      </div>
    </div>
  </div>
</div>
</template>

<script setup>
import Swal from 'sweetalert2';
import { ref, reactive, onMounted, onActivated, computed } from 'vue';
import { useRoute, useRouter } from 'vue-router';
import api from '../../utils/axios';
import { generateInvoicePDF } from '../../utils/pdfGenerator';
import SearchableSelect from '../../components/SearchableSelect.vue';

const route = useRoute();
const router = useRouter();

const service = ref(null);

const isPdfModalOpen = ref(false);
const pdfPreviewUrl = ref(null);
const isGeneratingPdf = ref(false);

const downloadNota = async () => {
  if (!service.value || isGeneratingPdf.value) return;
  try {
    isGeneratingPdf.value = true;
    pdfPreviewUrl.value = await generateInvoicePDF(service.value);
    isPdfModalOpen.value = true;
  } catch (e) {
    console.error('PDF Error:', e);
    Swal.fire('Error', 'Gagal membuat PDF: ' + e.message, 'error');
  } finally {
    isGeneratingPdf.value = false;
  }
};

const sparepartsList = ref([]);
const sparepartForm = reactive({ id: '', qty: 1 });
const isAddingSp = ref(false);

const sparepartOptions = computed(() => {
  return sparepartsList.value.map(sp => ({
    label: `[${sp.kode_barang}] ${sp.nama_barang} - Sisa: ${sp.stok_sekarang} (Rp${parseInt(sp.harga).toLocaleString('id-ID')})`,
    value: sp.id
  }));
});

const fotoBefore = ref(null);
const fotoAfter = ref(null);
const isUploading = ref(false);
const isFinishing = ref(false);
const isChangingStatus = ref(false);
const isClaiming = ref(false);
const isReopening = ref(false);
const showClaimForm = ref(false);
const showFinishForm = ref(false);
const finishGaransiDate = ref('');

const claimForm = reactive({
  catatan_klaim: '',
  tanggal_garansi_baru: ''
});

const isEditingWarranty = ref(false);
const isSavingWarranty = ref(false);
const warrantyForm = reactive({
  tanggal_berakhir: '',
  status_garansi: 'Aktif'
});

const openEditWarranty = () => {
  warrantyForm.tanggal_berakhir = service.value.warranty.tanggal_berakhir;
  warrantyForm.status_garansi = service.value.warranty.status_garansi;
  isEditingWarranty.value = true;
};

const saveWarranty = async () => {
  isSavingWarranty.value = true;
  try {
    await api.put(`/service/${route.params.id}/warranty`, warrantyForm);
    isEditingWarranty.value = false;
    await fetchData();
  } catch (err) {
    let msg = err.response?.data?.message || 'Gagal mengubah garansi.';
    if (err.response?.data?.errors) {
       msg += '\n' + JSON.stringify(err.response.data.errors);
    }
    alert(msg);
  } finally {
    isSavingWarranty.value = false;
  }
};

const fetchData = async () => {
  service.value = null; // Bersihkan data lama
  try {
    const res = await api.get(`/service/${route.params.id}`);
    service.value = res.data;
  } catch (err) {
    console.error(err);
    // Tidak perlu alert keras, biarkan state kosong (null) yang akan memicu tampilan "Data Tidak Ditemukan"
  }
};

const fetchSpareparts = async () => {
  try {
    const res = await api.get('/sparepart');
    sparepartsList.value = res.data;
  } catch (err) {
    console.error(err);
  }
};

onMounted(() => {
  fetchData();
  fetchSpareparts();
});

onActivated(() => {
  fetchData();
  fetchSpareparts();
});

// Aksi Tambah Sparepart
const addSparepart = async () => {
  if (!sparepartForm.id) return;
  isAddingSp.value = true;
  try {
    await api.post(`/service/${route.params.id}/sparepart`, {
      sparepart_id: sparepartForm.id,
      qty: sparepartForm.qty
    });
    sparepartForm.id = '';
    sparepartForm.qty = 1;
    await fetchData(); // Refresh data
    await fetchSpareparts(); // Refresh stok di dropdown
  } catch (err) {
    alert(err.response?.data?.message || 'Gagal menambahkan barang.');
  } finally {
    isAddingSp.value = false;
  }
};

// Aksi Hapus Sparepart
const removeSparepart = async (detailId) => {
  if (await Swal.fire({
      title: 'Konfirmasi',
      text: `Hapus item ini dari nota?`,
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#0d9488',
      cancelButtonColor: '#ef4444',
      confirmButtonText: 'Ya, Lanjutkan!',
      cancelButtonText: 'Batal'
    }).then(result => result.isConfirmed)) {
    try {
      await api.delete(`/service/${route.params.id}/sparepart/${detailId}`);
      await fetchData();
    } catch (err) {
      alert('Gagal menghapus item.');
    }
  }
};

// Aksi Upload Foto
const previewBefore = ref(null);
const previewAfter = ref(null);

import heic2any from 'heic2any';

const handleFileUpload = async (e, type) => {
  let file = e.target.files[0];
  if (!file) return;

  // Cek apakah file dari iPhone (HEIC/HEIF)
  const isHeic = file.name.toLowerCase().endsWith('.heic') || file.name.toLowerCase().endsWith('.heif');
  
  if (isHeic) {
    try {
      alert('Memproses format foto iPhone (HEIC)... Mohon tunggu sebentar.');
      const convertedBlob = await heic2any({
        blob: file,
        toType: 'image/jpeg',
        quality: 0.8
      });
      
      const blob = Array.isArray(convertedBlob) ? convertedBlob[0] : convertedBlob;
      file = new File([blob], file.name.replace(/\.hei[cf]$/i, '.jpg'), {
        type: 'image/jpeg',
        lastModified: new Date().getTime()
      });
    } catch (error) {
      console.error(error);
      return alert('Gagal memproses foto iPhone. Silakan gunakan format JPG biasa.');
    }
  }

  if (type === 'foto_before') {
    fotoBefore.value = file;
    previewBefore.value = URL.createObjectURL(file);
  }
  if (type === 'foto_after') {
    fotoAfter.value = file;
    previewAfter.value = URL.createObjectURL(file);
  }
};

const uploadPhotos = async () => {
  if (!fotoBefore.value && !fotoAfter.value) {
    return alert('Pilih minimal satu foto untuk diunggah.');
  }
  
  isUploading.value = true;
  const formData = new FormData();
  
  // NOTE: Jangan console.log file langsung jika menggunakan proxy, tapi ref.value aman.
  if (fotoBefore.value) formData.append('foto_before', fotoBefore.value);
  if (fotoAfter.value) formData.append('foto_after', fotoAfter.value);

  try {
    await api.post(`/service/${route.params.id}/upload-photos`, formData);
    fotoBefore.value = null;
    fotoAfter.value = null;
    previewBefore.value = null;
    previewAfter.value = null;
    alert('Foto berhasil diunggah!');
    await fetchData();
  } catch (err) {
    let msg = err.response?.data?.message || 'Gagal mengunggah foto.';
    if (err.response?.data?.errors) {
       msg += '\n' + JSON.stringify(err.response.data.errors);
    }
    alert(msg);
  } finally {
    isUploading.value = false;
  }
};

// Form Selesaikan Servis
const openFinishForm = () => {
  showFinishForm.value = true;
  // Default 30 hari dari sekarang
  const d = new Date();
  d.setDate(d.getDate() + 30);
  finishGaransiDate.value = d.toISOString().split('T')[0];
};

// Aksi Selesaikan Servis (Smart Trigger)
const finishService = async () => {
  isFinishing.value = true;
  try {
    const res = await api.post(`/service/${route.params.id}/finish`, {
      tanggal_garansi: finishGaransiDate.value
    });
    alert(res.data.message);
    showFinishForm.value = false;
    await fetchData();
  } catch (err) {
    alert(err.response?.data?.message || 'Gagal menyelesaikan servis.');
  } finally {
    isFinishing.value = false;
  }
};

// Aksi Update Status (Menunggu/Dikerjakan) - Optimistic Update
const updateStatus = async (newStatus) => {
  if (service.value.status === 'Selesai') {
    alert('Servis yang sudah selesai tidak dapat diubah statusnya secara langsung. Gunakan fitur Revisi Nota.');
    return;
  }
  
  // 1. OPTIMISTIC UPDATE: Langsung ubah di layar (0 milidetik delay!)
  const oldStatus = service.value.status;
  service.value.status = newStatus;
  
  isChangingStatus.value = true;
  try {
    // 2. Kirim ke database di latar belakang
    const res = await api.put(`/service/${route.params.id}/status`, { status: newStatus });
    alert(res.data.message);
    // Tidak perlu fetchData() lagi karena layar sudah di-update di langkah 1
  } catch (err) {
    // 3. Jika internet putus atau error, kembalikan ke status semula
    service.value.status = oldStatus;
    alert(err.response?.data?.message || 'Gagal mengubah status');
  } finally {
    isChangingStatus.value = false;
  }
};

// Aksi Revisi Nota
const reopenService = async () => {
  const confirmed = await Swal.fire({
      title: 'PERINGATAN!',
      html: 'Membuka kembali nota ini akan:<br><br>1. Mengembalikan stok barang yang terpotong ke gudang secara otomatis.<br>2. Mengubah status servis kembali menjadi "Dikerjakan".<br>3. Menghapus garansi yang sudah terbit.<br><br><b>Apakah Anda yakin ingin meralat nota ini?</b>',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#0d9488',
      cancelButtonColor: '#ef4444',
      confirmButtonText: 'Ya, Ralat Nota!',
      cancelButtonText: 'Batal'
  });
  if (!confirmed.isConfirmed) return;
  
  isReopening.value = true;
  try {
    const res = await api.post(`/service/${route.params.id}/reopen`);
    alert(res.data.message);
    await fetchData();
  } catch (err) {
    alert(err.response?.data?.message || 'Gagal merevisi nota.');
  } finally {
    isReopening.value = false;
  }
};

// Aksi Klaim Garansi In-Place
const claimWarranty = async () => {
  isClaiming.value = true;
  try {
    const res = await api.post(`/service/${route.params.id}/claim-warranty`, claimForm);
    alert(res.data.message);
    showClaimForm.value = false;
    claimForm.catatan_klaim = '';
    await fetchData(); // Refresh data untuk memunculkan catatan baru
  } catch (err) {
    alert(err.response?.data?.message || 'Gagal mendaftarkan klaim garansi.');
  } finally {
    isClaiming.value = false;
  }
};

const statusClass = (status) => {
  switch (status) {
    case 'Menunggu': return 'px-3 py-1 bg-yellow-100 text-yellow-700 rounded-full text-xs font-bold shadow-sm';
    case 'Dikerjakan': return 'px-3 py-1 bg-blue-100 text-blue-700 rounded-full text-xs font-bold shadow-sm';
    case 'Selesai': return 'px-3 py-1 bg-green-100 text-green-700 rounded-full text-xs font-bold shadow-sm';
    default: return 'px-3 py-1 bg-slate-100 text-slate-700 rounded-full text-xs font-bold shadow-sm';
  }
};
</script>
