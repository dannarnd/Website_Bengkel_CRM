<template>
  <div class="space-y-6">
    <div class="flex flex-col sm:flex-row justify-between sm:items-end gap-4">
      <div>
        <h1 class="text-2xl font-bold text-slate-800">Mutasi Stok Gudang</h1>
        <p class="text-slate-500">Kelola dan pantau pergerakan barang masuk dan keluar.</p>
      </div>
      <!-- Tab Navigation -->
      <div class="flex bg-slate-200 p-1 rounded-xl">
        <button @click="activeTab = 'masuk'"
          :class="['px-6 py-2 rounded-lg text-sm font-bold transition-all', activeTab === 'masuk' ? 'bg-white text-teal-600 shadow-sm' : 'text-slate-500 hover:text-slate-700']">
          Barang Masuk
        </button>
        <button @click="activeTab = 'keluar'"
          :class="['px-6 py-2 rounded-lg text-sm font-bold transition-all', activeTab === 'keluar' ? 'bg-white text-red-600 shadow-sm' : 'text-slate-500 hover:text-slate-700']">
          Barang Keluar
        </button>
        <button @click="activeTab = 'riwayat'"
          :class="['px-6 py-2 rounded-lg text-sm font-bold transition-all', activeTab === 'riwayat' ? 'bg-white text-slate-800 shadow-sm' : 'text-slate-500 hover:text-slate-700']">
          Riwayat Mutasi
        </button>
      </div>
    </div>

    <!-- Tab 1: Barang Masuk -->
    <div v-if="activeTab === 'masuk'"
      class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden max-w-2xl animate-fade-in-up">
      <div class="p-4 border-b border-slate-100 bg-teal-50 flex items-center gap-2 text-teal-800">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 11l5-5m0 0l5 5m-5-5v12"></path>
        </svg>
        <h2 class="font-bold">Formulir Barang Masuk (Restock)</h2>
      </div>
      <form @submit.prevent="submitAdjustment('masuk')" class="p-6 space-y-6">
        <!-- PANDUAN KODE BARANG (TOGGLE) -->
        <div class="bg-blue-50 border border-blue-200 rounded-xl overflow-hidden animate-fade-in-up">
          <button type="button" @click="showSOP = !showSOP"
            class="w-full flex items-center justify-between p-4 bg-blue-100/50 hover:bg-blue-100 transition-colors text-left focus:outline-none">
            <div class="flex items-center gap-2 text-blue-800">
              <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
              </svg>
              <span class="font-bold text-sm">SOP Pencatatan Barang Baru (Wajib 6 Karakter)</span>
            </div>
            <svg :class="['w-5 h-5 text-blue-600 transition-transform duration-300', showSOP ? 'rotate-180' : '']"
              fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
            </svg>
          </button>

          <div v-show="showSOP" class="p-4 border-t border-blue-200 bg-white">
            <div class="text-sm text-blue-700 leading-relaxed mb-3 space-y-1">
              <p>Jika barang belum terdaftar, Anda <strong>wajib</strong> menambahkannya di menu <span
                  class="font-bold">Manajemen Sparepart</span> dengan rumus baku:</p>
              <p
                class="font-mono bg-blue-50 inline-block px-2 py-1 rounded text-blue-800 font-bold border border-blue-200 mt-1 mb-2">
                [1 Huruf Jenis] + [1 Huruf Kategori] + [1 Huruf Merk] + [3 Angka Urutan]
              </p>
              <ul class="list-disc list-inside mt-2 text-xs">
                <li><strong>Jenis:</strong> R(Radiator), A(AC), D(Dinamo), C(Cairan)</li>
                <li><strong>Kategori:</strong> U(Upper), L(Lower), C(Core), P(Parts)</li>
                <li><strong>Merk:</strong> T(Toyota), H(Honda), S(Suzuki), U(Universal)</li>
              </ul>
              <p class="mt-2 text-xs italic">Contoh: <strong>RUT001</strong> (Radiator Upper Toyota 001),
                <strong>RUH001</strong> (Radiator Upper Honda 001)</p>
            </div>
            <router-link to="/admin/sparepart"
              class="inline-block bg-blue-600 text-white font-bold text-xs px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors shadow-sm mt-2">
              + Daftarkan Master Barang
            </router-link>
          </div>
        </div>

        <div v-if="alertMessageMasuk"
          :class="['p-4 rounded-xl text-sm font-bold flex items-center gap-2', isSuccessMasuk ? 'bg-green-50 text-green-700' : 'bg-red-50 text-red-700']">
          {{ alertMessageMasuk }}
        </div>
        <div class="space-y-4">
          <div v-for="(item, index) in formMasuk.items" :key="index"
            class="p-4 bg-slate-50 border border-slate-200 rounded-xl relative group">
            <button v-if="formMasuk.items.length > 1" @click="removeItem(index)" type="button"
              class="absolute -top-3 -right-3 bg-red-100 text-red-600 hover:bg-red-500 hover:text-white rounded-full p-1.5 transition-colors shadow-sm focus:outline-none">
              <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
              </svg>
            </button>
            <div class="grid grid-cols-1 md:grid-cols-12 gap-4">
              <div class="md:col-span-6">
                <label class="block text-xs font-semibold text-slate-700 mb-1">Cari Sparepart</label>
                <input :list="'spareparts_list_masuk_' + index" v-model="item.searchMasuk"
                  @change="onSelectMasuk(index)" required placeholder="Ketik nama / kode..."
                  class="w-full px-3 py-2 bg-white border border-slate-300 rounded-lg focus:ring-2 focus:ring-teal-500 outline-none text-sm">
                <datalist :id="'spareparts_list_masuk_' + index">
                  <option v-for="sp in spareparts" :key="sp.id" :value="`[${sp.kode_barang}] ${sp.nama_barang}`">Stok
                    saat ini: {{ sp.stok_sekarang }}</option>
                </datalist>
                <p v-if="item.kode_barang" class="text-[10px] text-teal-600 font-bold mt-1 flex items-center gap-1">
                  <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                  </svg>
                  Barang terpilih!
                </p>
              </div>
              <div class="md:col-span-2">
                <label class="block text-xs font-semibold text-slate-700 mb-1">Qty Masuk</label>
                <input v-model="item.qty" type="number" min="1" required
                  class="w-full px-3 py-2 bg-white border border-slate-300 rounded-lg focus:ring-2 focus:ring-teal-500 outline-none text-sm">
              </div>
              <div class="md:col-span-4">
                <label class="block text-xs font-semibold text-slate-700 mb-1">Harga Modal Satuan (Rp)</label>
                <input v-model="item.harga_modal" type="number" min="0" required placeholder="Contoh: 50000"
                  class="w-full px-3 py-2 bg-white border border-slate-300 rounded-lg focus:ring-2 focus:ring-teal-500 outline-none text-sm">
              </div>
            </div>
          </div>

          <button type="button" @click="addItem"
            class="text-sm text-teal-600 hover:text-teal-700 font-bold flex items-center gap-1 bg-teal-50 px-4 py-2 rounded-lg transition-colors border border-teal-100 w-max focus:outline-none">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6">
              </path>
            </svg>
            Tambah Barang Lain
          </button>
        </div>
        <div>
          <div class="flex items-center justify-between mb-2">
            <label class="block text-sm font-semibold text-slate-700">Distributor / Supplier</label>
            <button type="button" @click="isDistributorModalOpen = true" class="text-xs font-bold text-teal-600 hover:text-teal-700 bg-teal-50 hover:bg-teal-100 px-3 py-1 rounded-full transition-colors flex items-center gap-1">
              <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
              Distributor Baru
            </button>
          </div>
          <select v-model="formMasuk.id_distributor" required class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-teal-500 outline-none text-sm">
            <option value="" disabled>Pilih Distributor...</option>
            <option v-for="d in distributors" :key="d.id_distributor" :value="d.id_distributor">
              {{ d.nama_distributor }} ({{ d.no_hp }})
            </option>
          </select>
        </div>
        <div class="pt-2">
          <button type="submit" :disabled="isSubmitting"
            class="w-full bg-teal-600 hover:bg-teal-700 text-white font-bold py-4 rounded-xl transition-colors shadow-lg shadow-teal-600/20 disabled:opacity-70">
            {{ isSubmitting ? 'Memproses...' : 'Proses Barang Masuk' }}
          </button>
        </div>
      </form>
    </div>

    <!-- Tab 2: Barang Keluar -->
    <div v-if="activeTab === 'keluar'"
      class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden max-w-2xl animate-fade-in-up">
      <div class="p-4 border-b border-slate-100 bg-red-50 flex items-center gap-2 text-red-800">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 13l-5 5m0 0l-5-5m5 5V6"></path>
        </svg>
        <h2 class="font-bold">Formulir Barang Keluar (Manual)</h2>
      </div>
      <form @submit.prevent="submitAdjustment('keluar')" class="p-6 space-y-6">
        <div v-if="alertMessageKeluar"
          :class="['p-4 rounded-xl text-sm font-bold flex items-center gap-2', isSuccessKeluar ? 'bg-green-50 text-green-700' : 'bg-red-50 text-red-700']">
          {{ alertMessageKeluar }}
        </div>
        <div>
          <label class="block text-sm font-semibold text-slate-700 mb-2">Cari Sparepart</label>
          <input list="spareparts_list_keluar" v-model="searchKeluar" @change="onSelectKeluar" required
            placeholder="Ketik nama atau kode barang..."
            class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-red-500 outline-none">
          <datalist id="spareparts_list_keluar">
            <option v-for="sp in spareparts" :key="sp.id" :value="`[${sp.kode_barang}] ${sp.nama_barang}`">Stok saat
              ini: {{ sp.stok_sekarang }}</option>
          </datalist>
          <p v-if="formKeluar.kode_barang" class="text-xs text-red-600 font-bold mt-2 flex items-center gap-1">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
            </svg>
            Barang terpilih!
          </p>
        </div>
        <div>
          <label class="block text-sm font-semibold text-slate-700 mb-2">Jumlah Keluar (Qty)</label>
          <input v-model="formKeluar.qty" type="number" min="1" required
            class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-red-500 outline-none">
        </div>
        <div>
          <label class="block text-sm font-semibold text-slate-700 mb-2">Nama Pembeli (Umum)</label>
          <input v-model="formKeluar.nama_pembeli_umum" type="text" required
            placeholder="Contoh: Budi (Beli Eceran)"
            class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-red-500 outline-none">
        </div>
        <div class="pt-2">
          <button type="submit" :disabled="isSubmitting"
            class="w-full bg-slate-800 hover:bg-slate-900 text-white font-bold py-4 rounded-xl transition-colors shadow-lg shadow-slate-900/20 disabled:opacity-70">
            {{ isSubmitting ? 'Memproses...' : 'Proses Barang Keluar' }}
          </button>
        </div>
      </form>
    </div>

    <!-- Tab 3: Riwayat Mutasi -->
    <div v-if="activeTab === 'riwayat'"
      class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden animate-fade-in-up">
      <div class="p-4 border-b border-slate-100 bg-slate-50 flex items-center justify-between gap-4">
        <div class="flex items-center gap-3">
          <svg class="w-5 h-5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2">
            </path>
          </svg>
          <h2 class="font-bold text-slate-800 hidden sm:block">Laporan Mutasi Stok</h2>
        </div>
        <div class="flex items-center gap-2">
          <input v-model="searchHistory" type="text" placeholder="Cari barang, tipe, atau keterangan..."
            class="px-3 py-1.5 border border-slate-200 rounded-lg focus:ring-2 focus:ring-teal-500 outline-none text-sm w-48 sm:w-64 transition-all">
          <button @click="exportPDF" :disabled="isGeneratingPdf"
            class="bg-blue-600 hover:bg-blue-700 disabled:opacity-60 text-white font-medium py-1.5 px-4 rounded-lg shadow-sm flex items-center gap-2 transition-colors text-sm">
            <svg v-if="isGeneratingPdf" class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24">
              <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
              <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
            </svg>
            <svg v-else class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            <span class="hidden sm:inline">{{ isGeneratingPdf ? 'Memproses...' : 'Cetak PDF' }}</span>
          </button>
        </div>
      </div>
      <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-slate-100">
          <thead class="bg-slate-50/50">
            <tr>
              <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase">Tanggal</th>
              <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase">Oleh</th>
              <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase">Barang</th>
              <th class="px-6 py-4 text-center text-xs font-bold text-slate-500 uppercase">Tipe</th>
              <th class="px-6 py-4 text-center text-xs font-bold text-slate-500 uppercase">Qty</th>
              <th class="px-6 py-4 text-center text-xs font-bold text-slate-500 uppercase">Modal/Item</th>
              <th class="px-6 py-4 text-center text-xs font-bold text-slate-500 uppercase">Bukti</th>
              <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase">Keterangan</th>
            </tr>
          </thead>
          <tbody class="bg-white divide-y divide-slate-50">
            <tr v-if="isFetchingHistory">
              <td colspan="6" class="px-6 py-8 text-center text-slate-500">Memuat riwayat...</td>
            </tr>
            <tr v-else-if="filteredHistories.length === 0">
              <td colspan="6" class="px-6 py-8 text-center text-slate-500">Pencarian tidak ditemukan atau belum ada
                riwayat mutasi.</td>
            </tr>
            <tr v-for="h in filteredHistories" :key="h.id" class="hover:bg-slate-50 transition-colors">
              <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600">{{ new
                Date(h.tanggal).toLocaleString('id-ID') }}</td>
              <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-slate-700">{{ h.user?.name || '-' }}</td>
              <td class="px-6 py-4 text-sm font-medium text-slate-800">
                <span class="text-xs text-teal-600 font-mono mr-1">[{{ h.sparepart?.kode_barang }}]</span>
                {{ h.sparepart?.nama_barang }}
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-center">
                <span
                  :class="['px-3 py-1 rounded-full text-xs font-bold', h.tipe === 'Masuk' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700']">
                  {{ h.tipe }}
                </span>
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-center font-bold"
                :class="h.tipe === 'Masuk' ? 'text-green-600' : 'text-red-600'">
                {{ h.tipe === 'Masuk' ? '+' : '-' }}{{ h.qty }}
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-center">
                <div v-if="h.harga_modal" class="group relative inline-block cursor-pointer select-none">
                  <span class="text-sm text-slate-600 font-mono group-hover:hidden">Rp ***.***</span>
                  <span class="text-sm text-slate-800 font-mono font-bold hidden group-hover:inline-block">Rp {{
                    h.harga_modal.toLocaleString('id-ID') }}</span>
                  <span class="ml-1 text-[10px] text-slate-400 group-hover:hidden">👁️</span>
                </div>
                <span v-else class="text-xs text-slate-400 font-medium">-</span>
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-center">
                <button type="button" v-if="h.bukti_foto" @click="viewPhoto(h.bukti_foto)"
                  class="text-xs bg-slate-100 hover:bg-slate-200 text-slate-700 px-3 py-1.5 rounded-lg font-bold transition-colors inline-flex items-center gap-1 shadow-sm border border-slate-200">
                  📸 Lihat
                </button>
                <span v-else class="text-xs text-slate-400 font-medium">-</span>
              </td>
              <td class="px-6 py-4 text-sm text-slate-600">{{ h.keterangan }}</td>
            </tr>
          </tbody>
        </table>
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
            Pratinjau Laporan Mutasi Stok (Preview)
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

    <!-- Photo Preview Modal -->
    <div v-if="isPhotoModalOpen"
      class="fixed inset-0 z-[70] flex items-center justify-center p-4 bg-slate-900/80 backdrop-blur-sm animate-fade-in-up"
      @click="isPhotoModalOpen = false">
      <div class="bg-white rounded-2xl shadow-2xl max-w-3xl max-h-[90vh] overflow-hidden flex flex-col" @click.stop>
        <div class="px-6 py-4 border-b border-slate-100 flex justify-between items-center bg-slate-50">
          <h3 class="text-lg font-bold text-slate-800 flex items-center gap-2">
            <svg class="w-5 h-5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
              </path>
            </svg>
            Bukti Foto / Nota
          </h3>
          <button @click="isPhotoModalOpen = false" class="text-slate-400 hover:text-slate-600 transition-colors">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
          </button>
        </div>
        <div class="p-4 overflow-auto flex justify-center bg-slate-200">
          <img :src="photoPreviewUrl" class="max-w-full h-auto rounded-lg shadow-sm" alt="Bukti Foto">
        </div>
      </div>
    </div>
    
    <!-- Modal Tambah Distributor Cepat -->
    <div v-if="isDistributorModalOpen" class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/50 backdrop-blur-sm p-4">
      <div class="bg-white rounded-2xl shadow-xl w-full max-w-md overflow-hidden animate-fade-in-up">
        <div class="p-4 border-b border-slate-100 bg-slate-50 flex justify-between items-center">
          <h2 class="font-bold text-slate-800">Tambah Distributor Baru</h2>
          <button @click="isDistributorModalOpen = false" class="text-slate-400 hover:text-slate-600 transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
          </button>
        </div>
        <form @submit.prevent="submitDistributor" class="p-6 space-y-4">
          <div class="space-y-1">
            <label class="text-sm font-semibold text-slate-700">Nama Distributor</label>
            <input v-model="formDistributor.nama_distributor" type="text" required class="w-full px-4 py-2 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-teal-500 outline-none">
          </div>
          <div class="space-y-1">
            <label class="text-sm font-semibold text-slate-700">Nomor HP (Opsional)</label>
            <input v-model="formDistributor.no_hp" type="text" class="w-full px-4 py-2 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-teal-500 outline-none">
          </div>
          <div class="space-y-1">
            <label class="text-sm font-semibold text-slate-700">Alamat (Opsional)</label>
            <textarea v-model="formDistributor.alamat" rows="2" class="w-full px-4 py-2 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-teal-500 outline-none"></textarea>
          </div>
          <div class="pt-4 flex gap-3">
            <button type="button" @click="isDistributorModalOpen = false" class="flex-1 py-2 border rounded-xl hover:bg-slate-50 font-medium">Batal</button>
            <button type="submit" :disabled="isSubmittingDistributor" class="flex-1 py-2 bg-teal-600 hover:bg-teal-700 text-white rounded-xl font-medium disabled:opacity-70">
              {{ isSubmittingDistributor ? 'Menyimpan...' : 'Simpan' }}
            </button>
          </div>
        </form>
      </div>
    </div>
    
    <!-- Modal Tambah Distributor Cepat -->
    <div v-if="isDistributorModalOpen" class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/50 backdrop-blur-sm p-4">
      <div class="bg-white rounded-2xl shadow-xl w-full max-w-md overflow-hidden animate-fade-in-up">
        <div class="p-4 border-b border-slate-100 bg-slate-50 flex justify-between items-center">
          <h2 class="font-bold text-slate-800">Tambah Distributor Baru</h2>
          <button @click="isDistributorModalOpen = false" class="text-slate-400 hover:text-slate-600 transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
          </button>
        </div>
        <form @submit.prevent="submitDistributor" class="p-6 space-y-4">
          <div class="space-y-1">
            <label class="text-sm font-semibold text-slate-700">Nama Distributor</label>
            <input v-model="formDistributor.nama_distributor" type="text" required class="w-full px-4 py-2 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-teal-500 outline-none">
          </div>
          <div class="space-y-1">
            <label class="text-sm font-semibold text-slate-700">Nomor HP (Opsional)</label>
            <input v-model="formDistributor.no_hp" type="text" class="w-full px-4 py-2 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-teal-500 outline-none">
          </div>
          <div class="space-y-1">
            <label class="text-sm font-semibold text-slate-700">Alamat (Opsional)</label>
            <textarea v-model="formDistributor.alamat" rows="2" class="w-full px-4 py-2 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-teal-500 outline-none"></textarea>
          </div>
          <div class="pt-4 flex gap-3">
            <button type="button" @click="isDistributorModalOpen = false" class="flex-1 py-2 border rounded-xl hover:bg-slate-50 font-medium">Batal</button>
            <button type="submit" :disabled="isSubmittingDistributor" class="flex-1 py-2 bg-teal-600 hover:bg-teal-700 text-white rounded-xl font-medium disabled:opacity-70">
              {{ isSubmittingDistributor ? 'Menyimpan...' : 'Simpan' }}
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, reactive, onMounted, onActivated, watch, computed } from 'vue';
import api from '../../utils/axios';
import { jsPDF } from 'jspdf';
import autoTable from 'jspdf-autotable';

const activeTab = ref('masuk');
const spareparts = ref([]);
const histories = ref([]);
const searchHistory = ref('');
const isSubmitting = ref(false);
const isFetchingHistory = ref(false);
const isPdfModalOpen = ref(false);
const pdfPreviewUrl = ref(null);
const isPhotoModalOpen = ref(false);
const photoPreviewUrl = ref(null);
const showSOP = ref(false);

const alertMessageMasuk = ref('');
const isSuccessMasuk = ref(false);
const alertMessageKeluar = ref('');
const isSuccessKeluar = ref(false);

const searchKeluar = ref('');

const onSelectMasuk = (index) => {
  const item = formMasuk.items[index];
  const selected = spareparts.value.find(sp => `[${sp.kode_barang}] ${sp.nama_barang}` === item.searchMasuk);
  item.kode_barang = selected ? selected.kode_barang : '';
};

const onSelectKeluar = () => {
  const selected = spareparts.value.find(sp => `[${sp.kode_barang}] ${sp.nama_barang}` === searchKeluar.value);
  formKeluar.kode_barang = selected ? selected.kode_barang : '';
};

const filteredHistories = computed(() => {
  if (!searchHistory.value) return histories.value;
  const query = searchHistory.value.toLowerCase();
  return histories.value.filter(h => {
    const namaBarang = h.sparepart ? h.sparepart.nama_barang.toLowerCase() : '';
    const tipe = h.tipe.toLowerCase();
    const keterangan = (h.keterangan || '').toLowerCase();
    return namaBarang.includes(query) || tipe.includes(query) || keterangan.includes(query);
  });
});

const formatDate = (dateString) => {
  if (!dateString) return '-';
  const d = new Date(dateString);
  return d.toLocaleDateString('id-ID', { year: 'numeric', month: 'short', day: 'numeric', hour: '2-digit', minute: '2-digit' });
};

// Helper: ambil gambar dari /public dan konversi ke base64 data URL
const loadImageAsBase64 = (url) => {
  return new Promise((resolve, reject) => {
    const img = new Image();
    img.crossOrigin = 'anonymous';
    img.onload = () => {
      const canvas = document.createElement('canvas');
      canvas.width = img.naturalWidth;
      canvas.height = img.naturalHeight;
      const ctx = canvas.getContext('2d');
      ctx.fillStyle = '#FFFFFF';
      ctx.fillRect(0, 0, canvas.width, canvas.height);
      ctx.drawImage(img, 0, 0);
      resolve(canvas.toDataURL('image/jpeg', 0.7));
    };
    img.onerror = reject;
    img.src = url + '?t=' + Date.now();
  });
};

const isGeneratingPdf = ref(false);

const exportPDF = async () => {
  if (filteredHistories.value.length === 0) {
    alert("Tidak ada data riwayat untuk dicetak.");
    return;
  }

  if (isGeneratingPdf.value) return;

  try {
    isGeneratingPdf.value = true;
    const logoBase64 = await loadImageAsBase64('/logo.png');
    const doc = new jsPDF();
    const pageWidth = doc.internal.pageSize.getWidth();

    // ====================================
    // 1. KOP SURAT - Logo & Teks
    // ====================================
    // Logo di sebelah kiri
    doc.addImage(logoBase64, 'JPEG', 14, 10, 24, 24);

    // Teks Kop Surat di sebelah kanan logo
    doc.setFont('helvetica', 'bold');
    doc.setFontSize(20);
    doc.setTextColor(13, 148, 136); // Teal-600
    doc.text('DOLES RADIATOR', 42, 17);

    doc.setFontSize(9);
    doc.setFont('helvetica', 'normal');
    doc.setTextColor(80, 80, 80);
    doc.text('Alamat: Jl. Pembangunan lorong himalaya, Peunayong, Kec. Kuta Alam, Kota Banda Aceh, Aceh', 42, 23);
    doc.text('Telepon / Whatsapp: 0812-3097-0997', 42, 28);

    // Garis pembatas tebal di bawah kop
    doc.setDrawColor(13, 148, 136);
    doc.setLineWidth(0.8);
    doc.line(10, 38, pageWidth - 10, 38);
    doc.setLineWidth(0.2);

    // ====================================
    // 2. JUDUL LAPORAN
    // ====================================
    doc.setFontSize(14);
    doc.setTextColor(15, 23, 42); // slate-900
    doc.setFont('helvetica', 'bold');
    doc.text("Laporan Stok", 14, 48);

    doc.setFontSize(10);
    doc.setFont('helvetica', 'normal');
    doc.setTextColor(100);
    doc.text(`Dicetak pada: ${new Date().toLocaleDateString('id-ID', { weekday: 'long', day: 'numeric', month: 'long', year: 'numeric' })}`, 14, 55);

    // Data Tabel
    const tableColumn = ["Tanggal", "Oleh", "Barang", "Tipe", "Qty", "Keterangan"];
    const tableRows = [];

    filteredHistories.value.forEach(h => {
      tableRows.push([
        formatDate(h.tanggal),
        h.user?.name || h.keterangan?.match(/oleh (.+)/)?.[1] || 'Sistem',
        h.sparepart ? h.sparepart.nama_barang : 'Barang Terhapus',
        h.tipe,
        h.qty.toString(),
        h.keterangan || '-'
      ]);
    });

    autoTable(doc, {
      head: [tableColumn],
      body: tableRows,
      startY: 60,
      theme: 'grid',
      styles: { fontSize: 10, cellPadding: 3 },
      headStyles: { fillColor: [13, 148, 136] }, // Warna teal-600
    });

    // ====================================
    // 3. TANDA TANGAN & FOOTER
    // ====================================
    const finalY = doc.lastAutoTable.finalY || 60;

    doc.setFontSize(10);
    doc.setFont('helvetica', 'normal');
    doc.setTextColor(0);
    doc.text('Mengetahui,', pageWidth - 50, finalY + 20, { align: 'center' });

    // Watermark stempel logo bengkel di tanda tangan
    doc.setGState(new doc.GState({ opacity: 0.15 }));
    doc.addImage(logoBase64, 'JPEG', pageWidth - 66, finalY + 23, 32, 32);
    doc.setGState(new doc.GState({ opacity: 1.0 }));

    doc.setFont('helvetica', 'bold');
    doc.text('Doles Radiator Service', pageWidth - 50, finalY + 60, { align: 'center' });
    doc.setFont('helvetica', 'normal');
    doc.setFontSize(9);
    doc.setTextColor(100, 100, 100);
    doc.text('Pemilik Bengkel', pageWidth - 50, finalY + 65, { align: 'center' });

    const blob = doc.output('blob');
    const url = URL.createObjectURL(blob);
    pdfPreviewUrl.value = url;
    isPdfModalOpen.value = true;

  } catch (e) {
    console.error("PDF Error:", e);
    alert("Gagal mencetak PDF: " + e.message);
  } finally {
    isGeneratingPdf.value = false;
  }
};

const distributors = ref([]);

// Modal Distributor Cepat
const isDistributorModalOpen = ref(false);
const isSubmittingDistributor = ref(false);
const formDistributor = reactive({
  nama_distributor: '',
  no_hp: '',
  alamat: ''
});

const submitDistributor = async () => {
  isSubmittingDistributor.value = true;
  try {
    const res = await api.post('/distributor', formDistributor);
    await fetchDistributors();
    formMasuk.id_distributor = res.data.id_distributor; // Auto select newly added distributor
    isDistributorModalOpen.value = false;
    formDistributor.nama_distributor = '';
    formDistributor.no_hp = '';
    formDistributor.alamat = '';
  } catch (err) {
    alert("Gagal menambahkan distributor!");
  } finally {
    isSubmittingDistributor.value = false;
  }
};

const formMasuk = reactive({
  id_distributor: '',
  items: [
    { kode_barang: '', qty: 1, harga_modal: '', searchMasuk: '' }
  ]
});

const addItem = () => {
  formMasuk.items.push({ kode_barang: '', qty: 1, harga_modal: '', searchMasuk: '' });
};

const removeItem = (index) => {
  formMasuk.items.splice(index, 1);
};

const handleFileUpload = (e) => {
  formMasuk.bukti_foto = e.target.files[0];
};

const viewPhoto = (path) => {
  photoPreviewUrl.value = `http://localhost:8000/storage/${path}`;
  isPhotoModalOpen.value = true;
};

const formKeluar = reactive({
  kode_barang: '',
  qty: 1,
  nama_pembeli_umum: ''
});

const fetchDistributors = async () => {
  try {
    const res = await api.get('/distributor');
    distributors.value = res.data;
  } catch (err) {
    console.error("Gagal memuat distributor", err);
  }
};

const fetchSpareparts = async () => {
  try {
    const res = await api.get('/sparepart');
    spareparts.value = res.data;
  } catch (err) {
    console.error("Gagal memuat sparepart", err);
  }
};

const fetchHistories = async () => {
  isFetchingHistory.value = true;
  try {
    const res = await api.get('/mutasi');
    histories.value = res.data;
  } catch (err) {
    console.error("Gagal memuat riwayat", err);
  } finally {
    isFetchingHistory.value = false;
  }
};

// Pantau perubahan tab, muat riwayat jika tab riwayat diklik
watch(activeTab, (newTab) => {
  if (newTab === 'riwayat') {
    fetchHistories();
  }
});

onMounted(() => {
  fetchSpareparts();
  fetchDistributors();
});

onActivated(() => {
  fetchSpareparts();
  fetchDistributors();
  if (activeTab.value === 'riwayat') {
    fetchHistories();
  }
});

const submitAdjustment = async (type) => {
  isSubmitting.value = true;

  const isMasuk = type === 'masuk';
  if (isMasuk) {
    alertMessageMasuk.value = '';
  } else {
    alertMessageKeluar.value = '';
  }

  try {
    const endpoint = isMasuk ? '/pembelian' : '/penjualan';
    let payload;
    let config = {};

    // Ambil user auth dari localstorage (sama seperti service)
    const userStr = localStorage.getItem('user');
    const user = userStr ? JSON.parse(userStr) : null;
    const id_karyawan = user ? (user.id_karyawan || user.id) : 'K001';

    if (isMasuk) {
      payload = {
        id_distributor: formMasuk.id_distributor,
        id_karyawan: id_karyawan,
        details: formMasuk.items.map(i => ({
          kode_barang: i.kode_barang,
          qty_masuk: i.qty,
          harga_beli: i.harga_modal
        }))
      };
    } else {
      payload = {
        id_karyawan: id_karyawan,
        nama_pembeli_umum: formKeluar.nama_pembeli_umum,
        details: [{
          kode_barang: formKeluar.kode_barang,
          qty: formKeluar.qty
        }]
      };
    }

    const res = await api.post(endpoint, payload, config);

    if (isMasuk) {
      isSuccessMasuk.value = true;
      alertMessageMasuk.value = res.data.message || 'Barang masuk berhasil dicatat';
      formMasuk.items = [{ kode_barang: '', qty: 1, harga_modal: '', searchMasuk: '' }];
      formMasuk.id_distributor = '';
    } else {
      isSuccessKeluar.value = true;
      let msg = res.data.message || 'Barang keluar berhasil dicatat';
      if (res.data.alert) msg += " " + res.data.alert;
      alertMessageKeluar.value = msg;
      formKeluar.kode_barang = '';
      formKeluar.qty = 1;
      formKeluar.nama_pembeli_umum = '';
      searchKeluar.value = '';
    }

    // Refresh spareparts untuk update stok di dropdown
    await fetchSpareparts();
  } catch (err) {
    if (isMasuk) {
      isSuccessMasuk.value = false;
      alertMessageMasuk.value = err.response?.data?.message || 'Gagal memproses data.';
    } else {
      isSuccessKeluar.value = false;
      alertMessageKeluar.value = err.response?.data?.message || 'Gagal memproses data.';
    }
  } finally {
    isSubmitting.value = false;
  }
};
</script>

<style scoped>
.animate-fade-in-up {
  animation: fadeInUp 0.3s ease-out forwards;
}

@keyframes fadeInUp {
  from {
    opacity: 0;
    transform: translateY(10px);
  }

  to {
    opacity: 1;
    transform: translateY(0);
  }
}
</style>
