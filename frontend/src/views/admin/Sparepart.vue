<template>
  <div class="space-y-6">
    <div class="flex flex-col sm:flex-row justify-between sm:items-center gap-4">
      <h1 class="text-2xl font-bold text-slate-800">Manajemen Sparepart</h1>
      <div class="flex items-center gap-4">
        <!-- Search Bar -->
        <div class="relative">
          <input v-model="searchQuery" type="text" placeholder="Cari nama barang..."
            class="pl-10 pr-4 py-2 border border-slate-200 rounded-lg focus:ring-2 focus:ring-teal-500 outline-none w-64 transition-all">
          <svg class="w-5 h-5 text-slate-400 absolute left-3 top-2.5" fill="none" stroke="currentColor"
            viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
          </svg>
        </div>
        <button @click="openAddModal"
          class="bg-teal-600 hover:bg-teal-700 text-white font-medium py-2 px-4 rounded-lg shadow-sm flex items-center gap-2 transition-colors">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
          </svg>
          Registrasi Master Barang
        </button>
        <button @click="exportPDF"
          class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg shadow-sm flex items-center gap-2 transition-colors">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
          </svg>
          Cetak Laporan Stok
        </button>
      </div>
    </div>

    <!-- Table -->
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
      <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-slate-100">
          <thead class="bg-slate-50">
            <tr>
              <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase">Kode Barang</th>
              <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase">Nama Barang</th>
              <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase">Harga</th>
              <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase">Stok</th>
              <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase">Min. Stok</th>
              <th class="px-6 py-4 text-right text-xs font-bold text-slate-500 uppercase">Aksi</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-slate-50">
            <tr v-if="isLoading" class="text-center">
              <td colspan="6" class="px-6 py-8 text-slate-400">Loading data...</td>
            </tr>
            <tr v-else-if="filteredItems.length === 0">
              <td colspan="6" class="px-6 py-8 text-center text-slate-500">Barang tidak ditemukan.</td>
            </tr>
            <tr v-for="item in filteredItems" :key="item.id" class="hover:bg-slate-50">
              <td class="px-6 py-4 whitespace-nowrap text-sm font-mono text-teal-600">{{ item.kode_barang }}</td>
              <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-slate-800">{{ item.nama_barang }}</td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600">Rp{{
                parseInt(item.harga).toLocaleString('id-ID') }}</td>
              <td class="px-6 py-4 whitespace-nowrap text-sm">
                <span
                  :class="['px-2 py-1 rounded-full text-xs font-bold', item.stok_sekarang <= item.batas_minimum ? 'bg-red-100 text-red-700' : 'bg-green-100 text-green-700']">
                  {{ item.stok_sekarang }}
                </span>
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-500">{{ item.batas_minimum }}</td>
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
    <div v-if="isModalOpen"
      class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/50 backdrop-blur-sm">
      <div class="bg-white rounded-2xl shadow-xl w-full max-w-md overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-100 flex justify-between items-center bg-slate-50">
          <h3 class="text-lg font-bold text-slate-800">{{ isEdit ? 'Edit Data Barang' : 'Registrasi Master Barang' }}
          </h3>
          <button @click="closeModal" class="text-slate-400 hover:text-slate-600">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
          </button>
        </div>
        <form @submit.prevent="saveItem" class="p-6 space-y-4">
          <!-- Area Kode Barang -->
          <div v-if="!isEdit" class="p-4 bg-teal-50 rounded-xl border border-teal-100 space-y-3 relative">
            <div class="flex justify-between items-center">
              <div class="flex items-center gap-2">
                <h4 class="text-xs font-bold text-teal-800 uppercase tracking-wider">Generator Kode Otomatis</h4>
                <button @click.prevent="isInfoOpen = true"
                  class="text-teal-600 hover:text-teal-800 focus:outline-none transition-transform hover:scale-110"
                  title="Lihat Panduan Kode">
                  <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                  </svg>
                </button>
              </div>
              <label class="flex items-center gap-2 text-xs font-bold text-slate-600 cursor-pointer">
                <input type="checkbox" v-model="isManualCode" class="rounded text-teal-600 focus:ring-teal-500 w-4 h-4">
                Input Manual
              </label>
            </div>

            <div v-if="!isManualCode" class="grid grid-cols-3 gap-3">
              <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">Jenis</label>
                <select v-model="codeParams.jenis"
                  class="w-full px-3 py-2 bg-white border border-slate-200 rounded-lg text-sm focus:ring-2 focus:ring-teal-500 outline-none">
                  <option value="" disabled>Pilih Jenis</option>
                  <option value="R">R - Radiator</option>
                  <option value="A">A - AC</option>
                  <option value="D">D - Dinamo</option>
                  <option value="C">C - Cairan</option>
                  <option value="B">B - Brakes/Rem</option>
                  <option value="J">J - Jasa</option>
                </select>
              </div>
              <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">Kategori</label>
                <select v-model="codeParams.kategori"
                  class="w-full px-3 py-2 bg-white border border-slate-200 rounded-lg text-sm focus:ring-2 focus:ring-teal-500 outline-none">
                  <option value="" disabled>Pilih Kategori</option>
                  <option value="U">U - Upper Tank</option>
                  <option value="L">L - Lower / Liquid</option>
                  <option value="C">C - Core / Sarang</option>
                  <option value="K">K - Kampas Rem</option>
                  <option value="P">P - Parts AC</option>
                  <option value="S">S - Starter / Servis</option>
                  <option value="A">A - Alternator</option>
                  <option value="O">O - Others</option>
                </select>
              </div>
              <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">Merk</label>
                <select v-model="codeParams.merk"
                  class="w-full px-3 py-2 bg-white border border-slate-200 rounded-lg text-sm focus:ring-2 focus:ring-teal-500 outline-none">
                  <option value="" disabled>Pilih Merk</option>
                  <option value="T">T - Toyota</option>
                  <option value="H">H - Honda</option>
                  <option value="D">D - Daihatsu</option>
                  <option value="S">S - Suzuki</option>
                  <option value="M">M - Mitsubishi</option>
                  <option value="N">N - Nissan</option>
                  <option value="U">U - Universal</option>
                  <option value="O">O - Others</option>
                </select>
              </div>
            </div>

            <div v-if="!isManualCode">
              <label class="block text-sm font-semibold text-slate-700 mb-1">Hasil Kode Barang (Otomatis)</label>
              <div class="relative">
                <input v-model="form.kode_barang" type="text" readonly required
                  placeholder="Pilih ketiga menu di atas..."
                  class="w-full px-4 py-2 bg-slate-200 border border-slate-300 rounded-xl text-slate-700 font-mono font-bold focus:outline-none cursor-not-allowed">
                <span v-if="isGeneratingCode"
                  class="absolute right-3 top-2.5 text-xs text-teal-600 font-bold">Memuat...</span>
              </div>
            </div>

            <div v-if="isManualCode">
              <label class="block text-sm font-semibold text-slate-700 mb-1">Input Kode Barang Manual</label>
              <input v-model="form.kode_barang" type="text" required placeholder="Contoh: RUT001"
                class="w-full px-4 py-2 bg-white border border-slate-300 rounded-xl text-slate-700 font-mono font-bold focus:outline-none focus:ring-2 focus:ring-teal-500 uppercase">
            </div>
          </div>

          <div v-else>
            <label class="block text-sm font-semibold text-slate-700 mb-1">Kode Barang</label>
            <input v-model="form.kode_barang" type="text" readonly
              class="w-full px-4 py-2 bg-slate-200 border border-slate-300 rounded-xl text-slate-600 font-mono font-bold focus:outline-none cursor-not-allowed">
          </div>

          <div>
            <label class="block text-sm font-semibold text-slate-700 mb-1">Nama Barang / Jasa</label>
            <input v-model="form.nama_barang" type="text" required
              class="w-full px-4 py-2 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-teal-500 outline-none">
          </div>
          <div>
            <label class="block text-sm font-semibold text-slate-700 mb-1">Harga (Rp)</label>
            <input v-model="form.harga" type="number" required
              class="w-full px-4 py-2 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-teal-500 outline-none">
          </div>
          <div class="grid grid-cols-2 gap-4">
            <div>
              <label class="block text-sm font-semibold text-slate-700 mb-1">Batas Minimum Stok</label>
              <input v-model="form.batas_minimum" type="number" required
                class="w-full px-4 py-2 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-teal-500 outline-none">
            </div>
          </div>
          <div class="pt-4 flex justify-end gap-3">
            <button type="button" @click="closeModal"
              class="px-4 py-2 text-slate-600 hover:bg-slate-100 rounded-xl font-medium transition-colors">Batal</button>
            <button type="submit" :disabled="isSaving"
              class="px-4 py-2 bg-teal-600 text-white rounded-xl font-bold shadow-sm hover:bg-teal-700 transition-colors disabled:opacity-50">
              {{ isSaving ? 'Menyimpan...' : 'Simpan Data' }}
            </button>
          </div>
        </form>
      </div>
    </div>

    <!-- Info Panduan Kode Modal -->
    <div v-if="isInfoOpen"
      class="fixed inset-0 z-[60] flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm">
      <div class="bg-white rounded-2xl shadow-2xl w-full max-w-2xl overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-100 flex justify-between items-center bg-teal-50">
          <h3 class="text-lg font-bold text-teal-900 flex items-center gap-2">
            <svg class="w-5 h-5 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            Panduan Pengkodean Master Barang
          </h3>
          <button @click="isInfoOpen = false" class="text-slate-400 hover:text-slate-600">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
          </button>
        </div>
        <div class="p-6 space-y-4 text-sm text-slate-700">
          <p>Format Standar: <strong
              class="font-mono bg-slate-100 px-2 py-1 rounded text-teal-700">[Jenis][Kategori][Merk][3 Angka
              Urut]</strong> (Contoh: RUT001)</p>

          <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="border border-slate-200 rounded-xl overflow-hidden">
              <div class="bg-slate-50 font-bold px-3 py-2 border-b border-slate-200 text-center">1. JENIS</div>
              <ul class="p-3 space-y-1">
                <li><strong class="font-mono text-teal-600">R</strong> = Radiator</li>
                <li><strong class="font-mono text-teal-600">A</strong> = AC</li>
                <li><strong class="font-mono text-teal-600">D</strong> = Dinamo</li>
                <li><strong class="font-mono text-teal-600">C</strong> = Cairan</li>
                <li><strong class="font-mono text-teal-600">B</strong> = Brakes (Rem)</li>
                <li><strong class="font-mono text-teal-600">J</strong> = Jasa</li>
              </ul>
            </div>
            <div class="border border-slate-200 rounded-xl overflow-hidden">
              <div class="bg-slate-50 font-bold px-3 py-2 border-b border-slate-200 text-center">2. KATEGORI</div>
              <ul class="p-3 space-y-1">
                <li><strong class="font-mono text-teal-600">U</strong> = Upper Tank</li>
                <li><strong class="font-mono text-teal-600">L</strong> = Lower / Liquid</li>
                <li><strong class="font-mono text-teal-600">C</strong> = Core / Sarang</li>
                <li><strong class="font-mono text-teal-600">K</strong> = Kampas Rem</li>
                <li><strong class="font-mono text-teal-600">P</strong> = Parts AC</li>
                <li><strong class="font-mono text-teal-600">S</strong> = Starter/Servis</li>
                <li><strong class="font-mono text-teal-600">A</strong> = Alternator</li>
                <li><strong class="font-mono text-teal-600">O</strong> = Others</li>
              </ul>
            </div>
            <div class="border border-slate-200 rounded-xl overflow-hidden">
              <div class="bg-slate-50 font-bold px-3 py-2 border-b border-slate-200 text-center">3. MERK</div>
              <ul class="p-3 space-y-1">
                <li><strong class="font-mono text-teal-600">T</strong> = Toyota</li>
                <li><strong class="font-mono text-teal-600">H</strong> = Honda</li>
                <li><strong class="font-mono text-teal-600">D</strong> = Daihatsu</li>
                <li><strong class="font-mono text-teal-600">M</strong> = Mitsubishi</li>
                <li><strong class="font-mono text-teal-600">N</strong> = Nissan</li>
                <li><strong class="font-mono text-teal-600">S</strong> = Suzuki</li>
                <li><strong class="font-mono text-teal-600">U</strong> = Universal</li>
                <li><strong class="font-mono text-teal-600">O</strong> = Others</li>
              </ul>
            </div>
          </div>
          <div class="pt-2 text-right">
            <button @click="isInfoOpen = false"
              class="px-4 py-2 bg-teal-600 text-white rounded-xl font-bold shadow-sm hover:bg-teal-700 transition-colors">Tutup
              Panduan</button>
          </div>
        </div>
      </div>
    </div>
    <!-- PDF Preview Modal -->
    <div v-if="isPdfModalOpen"
      class="fixed inset-0 z-[70] flex items-center justify-center p-4 bg-slate-900/70 backdrop-blur-sm animate-fade-in-up">
      <div class="bg-white rounded-2xl shadow-2xl w-full max-w-5xl h-[90vh] overflow-hidden flex flex-col">
        <div class="px-6 py-4 border-b border-slate-100 flex justify-between items-center bg-teal-50">
          <h3 class="text-lg font-bold text-teal-900 flex items-center gap-2">
            <svg class="w-5 h-5 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
              </path>
            </svg>
            Pratinjau Laporan (Preview)
          </h3>
          <button @click="isPdfModalOpen = false" class="text-slate-400 hover:text-slate-600 transition-colors">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
          </button>
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
import { ref, reactive, onMounted, onActivated, computed, watch } from 'vue';
import api from '../../utils/axios';
import { jsPDF } from 'jspdf';
import autoTable from 'jspdf-autotable';

const items = ref([]);
const searchQuery = ref('');
const isLoading = ref(true);
const isSaving = ref(false);
const isModalOpen = ref(false);
const isInfoOpen = ref(false);
const isPdfModalOpen = ref(false);
const pdfPreviewUrl = ref(null);
const isEdit = ref(false);
const editId = ref(null);

const filteredItems = computed(() => {
  if (!searchQuery.value) return items.value;
  const lowerCaseQuery = searchQuery.value.toLowerCase();
  return items.value.filter(item =>
    item.nama_barang.toLowerCase().includes(lowerCaseQuery) ||
    item.kode_barang.toLowerCase().includes(lowerCaseQuery)
  );
});

const form = reactive({
  kode_barang: '',
  nama_barang: '',
  harga: 0,
  stok_sekarang: 0,
  batas_minimum: 0
});

const codeParams = reactive({
  jenis: '',
  kategori: '',
  merk: ''
});
const isGeneratingCode = ref(false);
const isManualCode = ref(false);

const checkNextCode = async () => {
  if (codeParams.jenis && codeParams.kategori && codeParams.merk) {
    const prefix = `${codeParams.jenis}${codeParams.kategori}${codeParams.merk}`;
    isGeneratingCode.value = true;
    try {
      const res = await api.get(`/sparepart/next-code/${prefix}`);
      form.kode_barang = res.data.next_code;
    } catch (err) {
      console.error("Gagal mendapatkan kode otomatis:", err);
    } finally {
      isGeneratingCode.value = false;
    }
  } else {
    form.kode_barang = '';
  }
};

watch(() => ({ ...codeParams }), () => {
  if (!isEdit.value && !isManualCode.value) {
    checkNextCode();
  }
}, { deep: true });

watch(isManualCode, (newVal) => {
  if (newVal) {
    form.kode_barang = ''; // Bersihkan saat pindah ke manual
  } else {
    checkNextCode(); // Cek ulang saat kembali ke otomatis
  }
});

const fetchItems = async () => {
  try {
    const res = await api.get('/sparepart');
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
  isManualCode.value = false;
  Object.assign(codeParams, { jenis: 'R', kategori: 'U', merk: 'T' });
  Object.assign(form, { kode_barang: '', nama_barang: '', harga: '', batas_minimum: 5 });
  isModalOpen.value = true;
};

const exportPDF = () => {
  if (filteredItems.value.length === 0) {
    return Swal.fire({
      icon: 'warning',
      title: 'Data Kosong',
      text: 'Tidak ada data stok sparepart untuk dicetak.',
    });
  }

  const doc = new jsPDF();

  // Kop Laporan
  doc.setFontSize(18);
  doc.setTextColor(15, 23, 42); // slate-900
  doc.text("Laporan Stok Doles Radiator", 14, 22);

  doc.setFontSize(11);
  doc.setTextColor(100);
  doc.text(`Dicetak pada: ${new Date().toLocaleDateString('id-ID', { weekday: 'long', day: 'numeric', month: 'long', year: 'numeric' })}`, 14, 30);

  // Data Tabel
  const tableColumn = ["Kode Barang", "Nama Barang", "Harga", "Stok", "Min. Stok"];
  const tableRows = [];

  filteredItems.value.forEach(item => {
    tableRows.push([
      item.kode_barang,
      item.nama_barang,
      `Rp${parseInt(item.harga).toLocaleString('id-ID')}`,
      item.stok_sekarang.toString(),
      item.batas_minimum.toString()
    ]);
  });

  autoTable(doc, {
    head: [tableColumn],
    body: tableRows,
    startY: 35,
    theme: 'grid',
    styles: { fontSize: 10, cellPadding: 3 },
    headStyles: { fillColor: [13, 148, 136] }, // Warna teal-600 agar senada
  });

  // Tanda Tangan di Kanan Bawah
  const finalY = doc.lastAutoTable.finalY || 35;
  const pageWidth = doc.internal.pageSize.getWidth();

  doc.setFontSize(11);
  doc.setTextColor(0);
  // Geser teks ke kanan (sekitar 50 point dari tepi kanan)
  doc.text('Mengetahui,', pageWidth - 50, finalY + 20);
  doc.text('Pemilik Bengkel', pageWidth - 50, finalY + 45);

  const blob = doc.output('blob');
  const url = URL.createObjectURL(blob);
  pdfPreviewUrl.value = url;
  isPdfModalOpen.value = true;
};

const openEditModal = (item) => {
  isEdit.value = true;
  editId.value = item.id;
  form.kode_barang = item.kode_barang;
  form.nama_barang = item.nama_barang;
  form.harga = item.harga;
  form.stok_sekarang = item.stok_sekarang;
  form.batas_minimum = item.batas_minimum;
  isModalOpen.value = true;
};

const closeModal = () => {
  isModalOpen.value = false;
};

const saveItem = async () => {
  isSaving.value = true;
  try {
    if (isEdit.value) {
      await api.put(`/sparepart/${editId.value}`, form);
    } else {
      await api.post('/sparepart', form);
    }
    closeModal();
    fetchItems();
  } catch (err) {
    alert("Gagal menyimpan data.");
  } finally {
    isSaving.value = false;
  }
};

const deleteItem = async (id) => {
  if (await Swal.fire({
    title: 'Konfirmasi',
    text: `Yakin ingin menghapus barang ini?`,
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#0d9488',
    cancelButtonColor: '#ef4444',
    confirmButtonText: 'Ya, Lanjutkan!',
    cancelButtonText: 'Batal'
  }).then(result => result.isConfirmed)) {
    try {
      await api.delete(`/sparepart/${id}`);
      fetchItems();
    } catch (err) {
      alert("Gagal menghapus data.");
    }
  }
};
</script>
