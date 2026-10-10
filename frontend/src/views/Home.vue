<template>
  <div class="w-full bg-[#f8fafc] font-sans text-slate-800 antialiased selection:bg-indigo-500 selection:text-white">

    <!-- 1. HERO & NAVBAR SECTION (Premium Light Mode) -->
    <section class="relative bg-white text-slate-800 overflow-hidden min-h-[90vh] flex flex-col border-b border-slate-100">

      <div class="absolute inset-0 overflow-hidden pointer-events-none">
        <div class="absolute -top-[20%] -left-[10%] w-[50%] h-[50%] rounded-full bg-indigo-100 blur-[120px]"></div>
        <div class="absolute top-[20%] -right-[10%] w-[40%] h-[60%] rounded-full bg-fuchsia-100 blur-[120px]"></div>
        <div class="absolute -bottom-[20%] left-[20%] w-[60%] h-[50%] rounded-full bg-blue-100 blur-[120px]"></div>
        <div class="absolute inset-0 bg-[url('data:image/svg+xml;base64,PHN2ZyB2aWV3Qm94PSIwIDAgMjAwIDIwMCIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48ZmlsdGVyIGlkPSJub2lzZUZpbHRlciI+PGZlVHVyYnVsZW5jZSB0eXBlPSJmcmFjdGFsTm9pc2UiIGJhc2VGcmVxdWVuY3k9IjAuNjUiIG51bU9jdGF2ZXM9IjMiIHN0aXRjaFRpbGVzPSJzdGl0Y2giLz48L2ZpbHRlcj48cmVjdCB3aWR0aD0iMTAwJSIgaGVpZ2h0PSIxMDAlIiBmaWx0ZXI9InVybCgibm9pc2VGaWx0ZXIpIiBvcGFjaXR5PSIwLjAzIi8+PC9zdmc+')] opacity-50"></div>
      </div>

      <nav class="relative z-50 w-full pt-6 px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto">
          <div class="flex justify-between items-center h-20 bg-white/70 backdrop-blur-2xl border border-slate-200/50 rounded-3xl px-6 md:px-8 shadow-[0_4px_30px_rgba(0,0,0,0.03)]">
            <div class="flex items-center gap-4 cursor-pointer">
              <div class="w-10 h-10 rounded-full bg-gradient-to-tr from-indigo-500 to-fuchsia-500 p-[2px] shadow-sm">
                <img src="/logo.png" alt="Logo" class="w-full h-full object-contain bg-white rounded-full p-1" onerror="this.src='https://ui-avatars.com/api/?name=DR&background=fff&color=4f46e5'">
              </div>
              <span class="font-extrabold text-xl tracking-wider text-slate-800">DOLES <span class="text-transparent bg-clip-text bg-gradient-to-r from-indigo-600 to-fuchsia-600">RADIATOR</span></span>
            </div>
            <router-link to="/login" class="text-sm font-bold text-indigo-600 hover:text-white transition-all bg-indigo-50 hover:bg-indigo-600 px-6 py-2.5 rounded-full border border-indigo-100 hover:border-indigo-600 shadow-sm hover:shadow-md">
              Portal Admin
            </router-link>
          </div>
        </div>
      </nav>

      <div class="flex-1 flex flex-col items-center justify-center text-center px-4 sm:px-6 lg:px-8 relative z-20 mt-10 md:mt-0 pb-40 md:pb-56">
        <span class="inline-flex items-center gap-2 py-1.5 px-4 rounded-full bg-indigo-50 border border-indigo-100 text-indigo-600 text-xs font-bold tracking-widest mb-8">
          <span class="w-2 h-2 rounded-full bg-indigo-500 animate-pulse"></span>
          SPESIALIS RADIATOR NO.1 BANDA ACEH
        </span>
        <h1 class="text-5xl md:text-7xl lg:text-[5.5rem] font-extrabold tracking-tight mb-8 leading-[1.1] text-slate-900">
          Solusi Cerdas untuk <br />
          <span class="text-transparent bg-clip-text bg-gradient-to-r from-indigo-600 via-fuchsia-600 to-indigo-600 animate-gradient-x">Sistem Pendingin Anda</span>
        </h1>
        <p class="text-lg md:text-xl text-slate-500 max-w-2xl mx-auto mb-14 leading-relaxed font-light">
          Kami memastikan mesin kendaraan Anda selalu berada pada suhu optimal dengan layanan yang <span class="text-slate-800 font-medium">transparan, cepat, dan bergaransi</span>.
        </p>

        <div class="flex flex-col sm:flex-row gap-5">
          <a href="#tracking-section" class="group relative inline-flex items-center justify-center gap-3 bg-indigo-600 text-white font-bold py-4 px-10 rounded-full transition-all hover:bg-indigo-700 hover:-translate-y-1 shadow-lg hover:shadow-indigo-500/30">
            Lacak Servis Anda
            <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
            </svg>
          </a>
          <a href="#about-section" class="inline-flex items-center justify-center bg-white hover:bg-slate-50 text-slate-700 font-bold py-4 px-10 rounded-full transition-all border border-slate-200 hover:border-slate-300 shadow-sm hover:shadow-md">
            Lihat Layanan
          </a>
        </div>
      </div>
    </section>

    <!-- 2. FORM PELACAKAN SERVIS (Light Card Overlap) -->
    <section id="tracking-section" class="relative z-30 -mt-24 md:-mt-32 px-4 sm:px-6 lg:px-8 pb-20">
      <div class="max-w-4xl mx-auto">
        <div class="bg-white rounded-[2.5rem] p-8 md:p-12 border border-slate-100 shadow-[0_30px_60px_-15px_rgba(0,0,0,0.1)]">
          <div class="text-center mb-10">
            <h2 class="text-3xl font-extrabold text-slate-900 mb-3">Pantau Kendaraan Anda</h2>
            <p class="text-slate-500 font-light">Masukkan plat nomor dan 4 digit terakhir nomor HP Anda untuk melihat progress secara real-time.</p>
          </div>

          <form @submit.prevent="trackService" class="space-y-6">
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
              <div class="space-y-2">
                <label class="text-xs font-bold text-slate-500 uppercase tracking-wider ml-2">Nomor Polisi</label>
                <input v-model="form.nomor_polisi" type="text" placeholder="B 1234 ABC" required class="w-full bg-slate-50 border border-slate-200 text-slate-900 rounded-2xl px-6 py-4 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent uppercase transition-all placeholder-slate-400">
              </div>
              <div class="space-y-2">
                <label class="text-xs font-bold text-slate-500 uppercase tracking-wider ml-2">4 Digit Akhir No. HP</label>
                <input v-model="form.nomor_hp" type="text" maxlength="4" placeholder="8765" required class="w-full bg-slate-50 border border-slate-200 text-slate-900 rounded-2xl px-6 py-4 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all placeholder-slate-400">
              </div>
            </div>

            <button type="submit" :disabled="isLoading" class="w-full mt-4 bg-gradient-to-r from-indigo-600 to-fuchsia-600 hover:from-indigo-500 hover:to-fuchsia-500 text-white font-bold py-4 rounded-2xl transition-all shadow-md hover:shadow-lg flex justify-center items-center disabled:opacity-70 hover:-translate-y-1">
              <span v-if="!isLoading" class="tracking-wide">Lacak Status Kendaraan</span>
              <span v-else class="animate-spin w-6 h-6 border-2 border-white border-t-transparent rounded-full"></span>
            </button>
          </form>

          <!-- Tracking Result Card -->
          <div v-if="result" class="mt-10 bg-slate-50 rounded-3xl p-8 shadow-inner border border-slate-200 transform transition-all animate-fade-in-up">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 border-b border-slate-200 pb-6 gap-4">
              <div>
                <h3 class="text-2xl font-extrabold text-slate-900">{{ result.kendaraan.pelanggan.nama_pelanggan }}</h3>
                <p class="text-indigo-600 font-mono font-bold mt-1 text-lg tracking-wider bg-indigo-100/50 border border-indigo-100 inline-block px-3 py-1 rounded-lg">{{ result.kendaraan.nomor_polisi }}</p>
              </div>
              <span :class="['px-6 py-2.5 rounded-full text-sm font-bold shadow-sm tracking-wide uppercase', statusColor(result.status)]">
                {{ result.status }}
              </span>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
              <!-- Left Column -->
              <div class="space-y-5">
                <div class="grid grid-cols-2 gap-5">
                  <div class="bg-white p-5 rounded-2xl border border-slate-100 shadow-sm">
                    <p class="text-[10px] text-slate-500 uppercase font-bold tracking-wider">Tanggal Masuk</p>
                    <p class="font-bold text-slate-800 mt-1.5">{{ formatDate(result.tanggal_masuk) }}</p>
                  </div>
                  <div class="bg-white p-5 rounded-2xl border border-slate-100 shadow-sm">
                    <p class="text-[10px] text-slate-500 uppercase font-bold tracking-wider">Total Biaya</p>
                    <p class="font-extrabold text-indigo-600 mt-1.5 text-lg">Rp{{ parseInt(result.total_biaya || 0).toLocaleString('id-ID') }}</p>
                  </div>
                </div>

                <div class="bg-indigo-50 p-5 rounded-2xl border border-indigo-100">
                  <p class="text-[10px] text-indigo-600 uppercase font-bold tracking-wider">Keluhan Kendaraan</p>
                  <p class="font-semibold text-indigo-900 mt-1.5">{{ result.keluhan }}</p>
                </div>

                <div v-if="result.catatan" class="bg-amber-50 p-5 rounded-2xl border border-amber-100">
                  <p class="text-[10px] text-amber-600 uppercase font-bold tracking-wider">Catatan Mekanik</p>
                  <p class="font-medium text-amber-900 mt-1.5 whitespace-pre-line leading-relaxed">{{ result.catatan }}</p>
                </div>

                <!-- Warranty Info -->
                <div v-if="result.warranty && result.status === 'Selesai'" class="bg-gradient-to-br from-indigo-50 to-fuchsia-50 p-6 rounded-2xl border border-indigo-100 text-slate-800 shadow-sm relative overflow-hidden">
                  <div class="absolute top-0 right-0 w-32 h-32 bg-white rounded-full blur-2xl -mr-10 -mt-10 pointer-events-none"></div>
                  <div class="relative z-10">
                    <div class="flex justify-between items-center mb-2">
                      <p class="text-xs text-indigo-600 uppercase font-bold tracking-wider flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                        Status Garansi
                      </p>
                      <span class="px-3 py-1 rounded-full text-[10px] font-extrabold uppercase tracking-wider bg-indigo-100 text-indigo-700">{{ result.warranty.status }}</span>
                    </div>
                    <p class="font-bold text-lg mt-1 text-slate-900">{{ result.warranty.tanggal_selesai ? 'Berlaku s/d ' + formatDate(result.warranty.tanggal_selesai) : 'Tidak ada garansi' }}</p>
                    <button @click="downloadNota" class="mt-5 w-full bg-indigo-600 text-white hover:bg-indigo-700 font-extrabold py-3 rounded-xl flex items-center justify-center gap-2 transition-transform hover:-translate-y-0.5 shadow-sm">
                      <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                      Unduh E-Nota (PDF)
                    </button>
                  </div>
                </div>
              </div>

              <!-- Right Column (Photos) -->
              <div class="flex flex-col space-y-4">
                <p class="text-[10px] text-slate-500 uppercase font-bold tracking-wider">Dokumentasi Pengerjaan</p>
                <div v-if="result.service_photo?.foto_before || result.service_photo?.foto_after" class="grid grid-cols-1 sm:grid-cols-2 gap-4 h-full">
                  <div @click="selectedPhoto = 'http://localhost:8000' + result.service_photo.foto_before" v-if="result.service_photo?.foto_before" class="relative rounded-2xl overflow-hidden bg-white group h-56 cursor-pointer shadow-sm border border-slate-200">
                    <span class="absolute top-3 left-3 bg-white/90 backdrop-blur-md text-slate-800 text-[10px] uppercase font-bold px-3 py-1.5 rounded-lg z-10 shadow-sm border border-slate-100">Sebelum</span>
                    <img :src="'http://localhost:8000' + result.service_photo.foto_before" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                  </div>
                  <div @click="selectedPhoto = 'http://localhost:8000' + result.service_photo.foto_after" v-if="result.service_photo?.foto_after" class="relative rounded-2xl overflow-hidden bg-white group h-56 cursor-pointer shadow-sm border border-slate-200">
                    <span class="absolute top-3 left-3 bg-indigo-600/90 backdrop-blur-md text-white text-[10px] uppercase font-bold px-3 py-1.5 rounded-lg z-10 shadow-sm border border-indigo-500/20">Sesudah</span>
                    <img :src="'http://localhost:8000' + result.service_photo.foto_after" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                  </div>
                </div>
                <div v-else class="h-56 rounded-2xl border-2 border-dashed border-slate-200 bg-white flex flex-col items-center justify-center text-slate-400 gap-3">
                  <div class="p-4 bg-slate-50 rounded-full"><svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg></div>
                  <span class="text-sm font-semibold">Dokumentasi belum diunggah</span>
                </div>
              </div>
            </div>
          </div>

          <!-- Error Message -->
          <div v-if="errorMsg" class="mt-8 bg-red-50 border border-red-200 text-red-600 p-4 rounded-2xl text-center font-bold animate-pulse shadow-sm">
            {{ errorMsg }}
          </div>
        </div>
      </div>
    </section>

    <!-- 3. PROFIL BENGKEL -->
    <section id="about-section" class="py-24 bg-white relative border-b border-slate-100">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-16 items-center">
          <div class="relative group">
            <div class="absolute -inset-4 bg-gradient-to-tr from-indigo-100 to-fuchsia-100 rounded-[2.5rem] blur-xl opacity-60 group-hover:opacity-100 transition-opacity duration-500"></div>
            <img src="https://images.unsplash.com/photo-1580273916550-e323be2ae537?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="Mekanik Radiator" class="relative rounded-[2.5rem] shadow-[0_20px_40px_rgba(0,0,0,0.08)] transform -rotate-1 hover:rotate-0 transition-transform duration-500 object-cover w-full h-[450px]">
          </div>
          <div class="space-y-8">
            <div>
              <span class="text-indigo-600 font-bold tracking-widest text-sm uppercase mb-3 block">Tentang Kami</span>
              <h2 class="text-4xl font-extrabold text-slate-900 leading-tight">Spesialis Radiator Terpercaya <br><span class="text-transparent bg-clip-text bg-gradient-to-r from-indigo-600 to-fuchsia-600">Sejak 2005</span></h2>
            </div>
            <p class="text-slate-500 leading-relaxed text-lg font-light">
              Doles Radiator adalah bengkel spesialis yang berfokus pada perawatan, perbaikan, dan modifikasi sistem pendingin kendaraan. Dengan alat modern, kami memastikan mobil Anda anti-overheat.
            </p>
            <ul class="space-y-4">
              <li class="flex items-center text-slate-700 font-semibold text-lg bg-slate-50 p-4 rounded-2xl border border-slate-100">
                <div class="w-10 h-10 bg-white shadow-sm border border-slate-100 rounded-xl flex items-center justify-center mr-4 text-indigo-600">
                  <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path></svg>
                </div>
                Teknisi Ahli & Berpengalaman
              </li>
              <li class="flex items-center text-slate-700 font-semibold text-lg bg-slate-50 p-4 rounded-2xl border border-slate-100">
                <div class="w-10 h-10 bg-white shadow-sm border border-slate-100 rounded-xl flex items-center justify-center mr-4 text-fuchsia-600">
                  <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path></svg>
                </div>
                Suku Cadang Bergaransi
              </li>
            </ul>
          </div>
        </div>
      </div>
    </section>

    <!-- 4. LAYANAN KAMI -->
    <section id="services" class="py-24 relative overflow-hidden bg-slate-50">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-20">
          <span class="text-indigo-600 font-bold tracking-widest text-sm uppercase mb-2 block">Layanan Unggulan</span>
          <h2 class="text-4xl md:text-5xl font-extrabold text-slate-900 tracking-tight">Solusi Total Pendingin Mesin</h2>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
          <div class="bg-white rounded-[2rem] p-8 shadow-sm border border-slate-100 hover:shadow-xl hover:-translate-y-2 transition-all duration-300 group relative overflow-hidden">
            <div class="absolute top-0 right-0 w-32 h-32 bg-indigo-50 rounded-bl-full transition-transform group-hover:scale-150 duration-500 opacity-50"></div>
            <div class="w-16 h-16 bg-indigo-50 border border-indigo-100 rounded-2xl flex items-center justify-center mb-8 group-hover:bg-indigo-600 transition-colors duration-300">
              <svg class="w-8 h-8 text-indigo-600 group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
            </div>
            <h3 class="text-xl font-bold text-slate-900 mb-4 relative z-10">Servis Berkala Radiator</h3>
            <p class="text-slate-500 leading-relaxed relative z-10">Pengecekan dan pembersihan radiator secara menyeluruh untuk menjaga performa pendinginan mesin tetap optimal.</p>
          </div>
          <div class="bg-white rounded-[2rem] p-8 shadow-sm border border-slate-100 hover:shadow-xl hover:-translate-y-2 transition-all duration-300 group relative overflow-hidden">
            <div class="absolute top-0 right-0 w-32 h-32 bg-fuchsia-50 rounded-bl-full transition-transform group-hover:scale-150 duration-500 opacity-50"></div>
            <div class="w-16 h-16 bg-fuchsia-50 border border-fuchsia-100 rounded-2xl flex items-center justify-center mb-8 group-hover:bg-fuchsia-600 transition-colors duration-300">
              <svg class="w-8 h-8 text-fuchsia-600 group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path></svg>
            </div>
            <h3 class="text-xl font-bold text-slate-900 mb-4 relative z-10">Kuras Air Radiator</h3>
            <p class="text-slate-500 leading-relaxed relative z-10">Sistem pendingin dibersihkan tuntas, membuang kerak karat dan menggantinya dengan coolant berkualitas premium.</p>
          </div>
          <div class="bg-white rounded-[2rem] p-8 shadow-sm border border-slate-100 hover:shadow-xl hover:-translate-y-2 transition-all duration-300 group relative overflow-hidden">
            <div class="absolute top-0 right-0 w-32 h-32 bg-blue-50 rounded-bl-full transition-transform group-hover:scale-150 duration-500 opacity-50"></div>
            <div class="w-16 h-16 bg-blue-50 border border-blue-100 rounded-2xl flex items-center justify-center mb-8 group-hover:bg-blue-600 transition-colors duration-300">
              <svg class="w-8 h-8 text-blue-600 group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
            </div>
            <h3 class="text-xl font-bold text-slate-900 mb-4 relative z-10">Las & Tambal Kebocoran</h3>
            <p class="text-slate-500 leading-relaxed relative z-10">Perbaikan akurat pada titik kebocoran tanki atau kisi-kisi radiator menggunakan metode pengelasan presisi tingkat tinggi.</p>
          </div>
        </div>
      </div>
    </section>

    <!-- 5. GALERI -->
    <section class="py-24 bg-white relative border-t border-b border-slate-100">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
          <span class="text-indigo-600 font-bold tracking-widest text-sm uppercase mb-2 block">Portofolio</span>
          <h2 class="text-4xl font-extrabold text-slate-900 tracking-tight">Galeri Pengerjaan</h2>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
          <div class="relative overflow-hidden rounded-[2rem] group h-48 md:h-64 shadow-sm hover:shadow-xl transition-all duration-500 border border-slate-100">
            <img src="https://images.unsplash.com/photo-1486262715619-67b85e0b08d3?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
          </div>
          <div class="relative overflow-hidden rounded-[2rem] group h-48 md:h-64 shadow-sm hover:shadow-xl transition-all duration-500 border border-slate-100">
            <img src="https://images.unsplash.com/photo-1626668893632-6f3a4466d22f?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
          </div>
          <div class="relative overflow-hidden rounded-[2rem] group h-48 md:h-64 shadow-sm hover:shadow-xl transition-all duration-500 border border-slate-100">
            <img src="https://images.unsplash.com/photo-1492144534655-ae79c964c9d7?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
          </div>
          <div class="relative overflow-hidden rounded-[2rem] group h-48 md:h-64 shadow-sm hover:shadow-xl transition-all duration-500 border border-slate-100">
            <img src="https://images.unsplash.com/photo-1632733711679-529326f6db12?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
          </div>
        </div>
      </div>
    </section>

    <!-- 6. TESTIMONI -->
    <section class="py-24 bg-slate-50 relative overflow-hidden">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
          <span class="text-indigo-600 font-bold tracking-widest text-sm uppercase mb-2 block">Ulasan Pelanggan</span>
          <h2 class="text-4xl font-extrabold text-slate-900 tracking-tight mb-4">Apa Kata Pelanggan?</h2>
          <div class="inline-flex items-center gap-2 bg-white border border-slate-200 shadow-sm px-4 py-2 rounded-full">
            <svg class="w-5 h-5 text-indigo-600" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"></path></svg>
            <span class="text-sm font-bold text-slate-700">Review Asli dari Google Maps Kami</span>
          </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
          <div class="bg-white p-8 rounded-[2rem] shadow-sm hover:shadow-md transition-shadow border border-slate-200 relative group">
            <div class="flex text-yellow-400 mb-6 gap-1">
              <svg v-for="i in 5" :key="i" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
            </div>
            <p class="text-slate-600 italic mb-8 leading-relaxed">"Penanganan langsung dilakukan, penjelasan masalah/kendala radiator jelas dan to the point serta rencana tindakan yg akan dilakukan."</p>
            <div class="flex items-center gap-4">
              <div class="w-12 h-12 bg-indigo-50 text-indigo-700 border border-indigo-100 rounded-2xl flex items-center justify-center font-bold shadow-sm">R</div>
              <div>
                <h4 class="font-bold text-slate-900">Redha Maidatija</h4>
                <p class="text-[11px] text-slate-500 uppercase tracking-wider font-semibold mt-0.5">Google Maps Review</p>
              </div>
            </div>
          </div>
          <div class="bg-white p-8 rounded-[2rem] shadow-sm hover:shadow-md transition-shadow border border-slate-200 relative group">
            <div class="flex text-yellow-400 mb-6 gap-1">
              <svg v-for="i in 5" :key="i" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
            </div>
            <p class="text-slate-600 italic mb-8 leading-relaxed">"Benar" bagus kerjanya & profesional dlm segi pelayanan & memiliki kinerja yg sangat bagus, sukses selalu bos.."</p>
            <div class="flex items-center gap-4">
              <div class="w-12 h-12 bg-fuchsia-50 text-fuchsia-700 border border-fuchsia-100 rounded-2xl flex items-center justify-center font-bold shadow-sm">H</div>
              <div>
                <h4 class="font-bold text-slate-900">Heri Hanilo</h4>
                <p class="text-[11px] text-slate-500 uppercase tracking-wider font-semibold mt-0.5">Google Maps Review</p>
              </div>
            </div>
          </div>
          <div class="bg-white p-8 rounded-[2rem] shadow-sm hover:shadow-md transition-shadow border border-slate-200 relative group">
            <div class="flex text-yellow-400 mb-6 gap-1">
              <svg v-for="i in 5" :key="i" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
            </div>
            <p class="text-slate-600 italic mb-8 leading-relaxed">"Sangat membantu dgn hrg trjangkau baik dr service mau pun suku cadang yg paling mntp ada garansi perbaikan."</p>
            <div class="flex items-center gap-4">
              <div class="w-12 h-12 bg-blue-50 text-blue-700 border border-blue-100 rounded-2xl flex items-center justify-center font-bold shadow-sm">A</div>
              <div>
                <h4 class="font-bold text-slate-900">aalap alap</h4>
                <p class="text-[11px] text-slate-500 uppercase tracking-wider font-semibold mt-0.5">Google Maps Review</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- 7. FOOTER -->
    <footer class="bg-white text-slate-600 py-16 border-t border-slate-200">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 grid grid-cols-1 md:grid-cols-3 gap-12">
        <div>
          <div class="flex items-center gap-3 mb-6">
            <div class="w-8 h-8 bg-indigo-100 rounded-full flex items-center justify-center border border-indigo-200">
              <div class="w-4 h-4 bg-indigo-600 rounded-full"></div>
            </div>
            <span class="font-bold text-xl tracking-widest text-slate-800">DOLES <span class="text-transparent bg-clip-text bg-gradient-to-r from-indigo-600 to-fuchsia-600">RADIATOR</span></span>
          </div>
          <p class="text-sm leading-relaxed mb-6 font-light">
            Solusi inovatif perawatan sistem pendingin kendaraan di Banda Aceh, memadukan keahlian mekanik profesional dengan teknologi digital terdepan.
          </p>
        </div>
        <div>
          <h4 class="text-slate-900 font-bold mb-6 uppercase text-xs tracking-[0.2em]">Lokasi & Kontak</h4>
          <ul class="space-y-4 text-sm font-light">
            <li class="flex items-start gap-4">
              <svg class="w-5 h-5 text-indigo-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
              <a href="https://maps.app.goo.gl/hnBtqxGEp5XjAfrM7" target="_blank" class="hover:text-indigo-600 hover:underline transition-colors">
                Jl. Pembangunan, Lorong Himalaya<br>Banda Aceh, Indonesia<br>
                <span class="text-indigo-600 text-xs font-bold uppercase tracking-wider flex items-center gap-1 mt-1">Buka di Google Maps</span>
              </a>
            </li>
            <li class="flex items-center gap-4">
              <svg class="w-5 h-5 text-indigo-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
              <span>0821-6344-4129</span>
            </li>
          </ul>
        </div>
        <div>
          <h4 class="text-slate-900 font-bold mb-6 uppercase text-xs tracking-[0.2em]">Jam Operasional</h4>
          <ul class="space-y-4 text-sm font-light">
            <li class="flex justify-between border-b border-slate-100 pb-3"><span>Senin - Sabtu</span> <span class="text-slate-800 font-medium">08:00 - 18:00</span></li>
            <li class="flex justify-between pt-1"><span>Minggu</span> <span class="text-fuchsia-600 font-medium">Libur</span></li>
          </ul>
        </div>
      </div>
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-16 pt-8 border-t border-slate-100 text-xs text-center font-light tracking-wide text-slate-500">
        &copy; 2026 Doles Radiator. Smart Workshop System. All Rights Reserved.
      </div>
    </footer>

    <!-- Floating Chatbot Component -->
    <FloatingChatbot />

    <!-- Photo Zoom Modal -->
    <div v-if="selectedPhoto" class="fixed inset-0 z-[100] flex items-center justify-center bg-slate-900/80 backdrop-blur-sm p-4" @click="selectedPhoto = null">
      <div class="relative w-full max-w-4xl max-h-[90vh] flex flex-col items-center justify-center animate-fade-in-up" @click.stop>
        <button @click="selectedPhoto = null" class="absolute -top-12 right-0 md:-right-12 text-white hover:text-red-400 p-2 transition-colors bg-slate-800 rounded-full shadow-lg border border-slate-700">
          <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"></path></svg>
        </button>
        <img :src="selectedPhoto" class="max-w-full max-h-[85vh] object-contain rounded-2xl shadow-2xl ring-4 ring-white">
      </div>
    </div>

    <!-- Modal Preview PDF -->
    <div v-if="isPdfModalOpen" class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-slate-900/80 backdrop-blur-sm animate-fade-in-up">
      <div class="bg-white rounded-2xl shadow-2xl w-full max-w-4xl h-[85vh] overflow-hidden flex flex-col">
        <div class="px-6 py-4 border-b border-slate-100 flex justify-between items-center bg-slate-50">
          <h3 class="text-lg font-bold text-slate-900 flex items-center gap-2">
            <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
            E-Nota Servis
          </h3>
          <div class="flex items-center gap-3">
            <a :href="pdfPreviewUrl" :download="'Nota_Servis_' + (result?.kendaraan?.nomor_polisi || result?.nomor_polisi || form.nomor_polisi || 'servis') + '.pdf'" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg text-sm font-bold flex items-center gap-2 transition-colors shadow-sm">
              <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
              Unduh PDF
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
import { reactive, ref } from 'vue';
import FloatingChatbot from '../components/FloatingChatbot.vue';
import api from '../utils/axios';
import { generateInvoicePDF } from '../utils/pdfGenerator';

const form = reactive({
  nomor_polisi: '',
  nomor_hp: ''
});

const selectedPhoto = ref(null);

const isLoading = ref(false);
const result = ref(null);
const errorMsg = ref('');

const isPdfModalOpen = ref(false);
const pdfPreviewUrl = ref(null);
const isGeneratingPdf = ref(false);

const downloadNota = async () => {
  if (!result.value || isGeneratingPdf.value) return;
  try {
    isGeneratingPdf.value = true;
    pdfPreviewUrl.value = await generateInvoicePDF(result.value);
    isPdfModalOpen.value = true;
  } catch (e) {
    console.error('PDF Error:', e);
    alert('Gagal membuat PDF: ' + e.message);
  } finally {
    isGeneratingPdf.value = false;
  }
};

const formatDate = (dateString) => {
  if (!dateString) return '-';
  const hasTime = dateString.includes(' ');
  const options = { year: 'numeric', month: 'long', day: 'numeric' };
  if (hasTime) {
    options.hour = '2-digit';
    options.minute = '2-digit';
  }
  return new Date(dateString).toLocaleDateString('id-ID', options).replace(' pukul', ',');
};

const trackService = async () => {
  isLoading.value = true;
  result.value = null;
  errorMsg.value = '';

  try {
    const response = await api.post('/tracking-service', form);
    result.value = response.data.data;

    setTimeout(() => {
      window.scrollBy({ top: 300, behavior: 'smooth' });
    }, 100);
  } catch (error) {
    errorMsg.value = error.response?.data?.message || 'Data kendaraan tidak ditemukan atau nomor HP salah.';
  } finally {
    isLoading.value = false;
  }
};

const statusColor = (status) => {
  switch (status) {
    case 'Menunggu': return 'bg-yellow-100 text-yellow-800 border-yellow-200';
    case 'Diproses': return 'bg-blue-100 text-blue-800 border-blue-200';
    case 'Selesai': return 'bg-emerald-100 text-emerald-800 border-emerald-200';
    case 'Batal': return 'bg-red-100 text-red-800 border-red-200';
    default: return 'bg-slate-100 text-slate-700 border-slate-200';
  }
};
</script>

<style>
@keyframes fadeInUp {
  from { opacity: 0; transform: translateY(20px); }
  to { opacity: 1; transform: translateY(0); }
}

.animate-fade-in-up {
  animation: fadeInUp 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards;
}

@keyframes gradientX {
  0%, 100% { background-position: 0% 50%; }
  50% { background-position: 100% 50%; }
}

.animate-gradient-x {
  background-size: 200% auto;
  animation: gradientX 4s ease infinite;
}

html { scroll-behavior: smooth; }
</style>
