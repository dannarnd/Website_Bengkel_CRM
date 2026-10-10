import { jsPDF } from 'jspdf';
import autoTable from 'jspdf-autotable';

const loadImageAsBase64 = (url) => {
  return new Promise((resolve) => {
    const img = new Image();
    img.crossOrigin = 'anonymous';
    img.onload = () => {
      try {
        const canvas = document.createElement('canvas');
        canvas.width = img.naturalWidth || 100;
        canvas.height = img.naturalHeight || 100;
        const ctx = canvas.getContext('2d');
        ctx.fillStyle = '#FFFFFF';
        ctx.fillRect(0, 0, canvas.width, canvas.height);
        ctx.drawImage(img, 0, 0);
        resolve(canvas.toDataURL('image/jpeg', 0.8));
      } catch {
        resolve(null);
      }
    };
    img.onerror = () => resolve(null);
    img.src = url + '?t=' + Date.now();
  });
};

export const generateInvoicePDF = async (serviceData) => {
  if (!serviceData) throw new Error('Data servis tidak ditemukan');

  // Normalisasi data dari berbagai format (ServiceController vs TrackingController)
  const service = serviceData.service ? {
    ...serviceData.service,
    kendaraan: serviceData.kendaraan || serviceData.service.kendaraan,
    pelanggan: serviceData.pelanggan || serviceData.kendaraan?.pelanggan || serviceData.service.kendaraan?.pelanggan
  } : serviceData;

  // Load logo (fallback null jika gagal agar tidak crash)
  let logoBase64 = null;
  try {
    logoBase64 = await loadImageAsBase64('/logo.png');
  } catch (err) {
    console.warn('Gagal memuat logo untuk PDF:', err);
  }

  const doc = new jsPDF({
    orientation: 'portrait',
    unit: 'mm',
    format: 'a4'
  });

  const pageWidth = doc.internal.pageSize.getWidth();
  const pageHeight = doc.internal.pageSize.getHeight();

  // ====================================
  // 1. KOP SURAT
  // ====================================
  if (logoBase64) {
    doc.addImage(logoBase64, 'JPEG', 14, 10, 22, 22);
  }

  const textStartX = logoBase64 ? 40 : 14;
  doc.setFont('helvetica', 'bold');
  doc.setFontSize(18);
  doc.setTextColor(13, 148, 136); // Teal-600
  doc.text('DOLES RADIATOR', textStartX, 17);

  doc.setFontSize(8.5);
  doc.setFont('helvetica', 'normal');
  doc.setTextColor(80, 80, 80);
  doc.text('Alamat: Jl. Pembangunan lorong himalaya, Peunayong, Kec. Kuta Alam, Kota Banda Aceh, Aceh', textStartX, 23);
  doc.text('Telepon / WhatsApp: 0812-3097-0997', textStartX, 28);

  // Garis pembatas tebal di bawah kop
  doc.setDrawColor(13, 148, 136);
  doc.setLineWidth(0.8);
  doc.line(14, 35, pageWidth - 14, 35);

  // ====================================
  // 2. JUDUL NOTA & TANGGAL
  // ====================================
  doc.setFontSize(13);
  doc.setFont('helvetica', 'bold');
  doc.setTextColor(20, 20, 20);
  doc.text('NOTA SERVIS', 14, 44);

  // Nomor Invoice
  const invoiceNum = service.invoice_number || service.id_service || '-';
  doc.setFontSize(9);
  doc.setFont('helvetica', 'normal');
  doc.setTextColor(100, 100, 100);
  doc.text(`No: ${invoiceNum}`, 14, 49);

  // Tanggal Servis
  const rawDate = service.tanggal_masuk || service.created_at || service.tanggal;
  let tglServis = '-';
  if (rawDate) {
    const d = new Date(rawDate);
    if (!isNaN(d.getTime())) {
      tglServis = d.toLocaleDateString('id-ID', {
        day: '2-digit', month: 'long', year: 'numeric'
      });
    }
  }
  doc.text(`Tgl. Servis : ${tglServis}`, pageWidth - 14, 44, { align: 'right' });

  // ====================================
  // 3. INFO PELANGGAN & KENDARAAN
  // ====================================
  doc.setDrawColor(226, 232, 240); // slate-200
  doc.setLineWidth(0.3);
  doc.line(14, 52, pageWidth - 14, 52);

  doc.setFontSize(8.5);
  doc.setFont('helvetica', 'normal');
  doc.setTextColor(70, 70, 70);

  // Data Pelanggan
  const namaPelanggan = service.kendaraan?.pelanggan?.nama_pelanggan ||
                        service.kendaraan?.pelanggan?.nama ||
                        service.pelanggan?.nama_pelanggan ||
                        service.pelanggan?.nama ||
                        '-';

  const noHp = service.kendaraan?.pelanggan?.nomor_hp ||
               service.pelanggan?.nomor_hp ||
               '-';

  const mekanik = service.karyawan?.nama_karyawan ||
                  service.karyawan?.name ||
                  service.karyawan?.nama ||
                  service.mekanik?.name ||
                  'Admin';

  // Data Kendaraan
  const noPolisi = service.kendaraan?.nomor_polisi ||
                   service.nomor_polisi ||
                   '-';

  const kendaraan = service.kendaraan?.merk_mobil ||
                    service.kendaraan?.model ||
                    service.kendaraan?.nama_kendaraan ||
                    '-';

  const rawKeluhan = service.catatan || service.keluhan || '-';
  const keluhanText = rawKeluhan.split('\n[')[0];
  const keluhan = keluhanText.replace(/\n/g, ' ');

  // Kolom Kiri
  doc.text('Nama Pelanggan', 14, 58);
  doc.text(`: ${namaPelanggan}`, 46, 58);
  doc.text('No. HP', 14, 64);
  doc.text(`: ${noHp}`, 46, 64);
  doc.text('Mekanik', 14, 70);
  doc.text(`: ${mekanik}`, 46, 70);

  // Kolom Kanan
  doc.text('No. Polisi', 115, 58);
  doc.text(`: ${noPolisi}`, 138, 58);
  doc.text('Kendaraan', 115, 64);
  doc.text(`: ${kendaraan}`, 138, 64);
  doc.text('Keluhan', 115, 70);
  doc.text(`: ${keluhan.substring(0, 36)}${keluhan.length > 36 ? '...' : ''}`, 138, 70);

  doc.setDrawColor(226, 232, 240);
  doc.line(14, 74, pageWidth - 14, 74);

  // ====================================
  // 4. TABEL RINCIAN PEKERJAAN
  // ====================================
  const tableData = [];
  const details = (service.details && service.details.length > 0)
    ? service.details
    : (service.service_details && service.service_details.length > 0)
      ? service.service_details
      : [];

  if (details.length > 0) {
    details.forEach((detail, idx) => {
      const sp = detail.sparepart || {};
      const kode = sp.kode_barang || detail.kode_barang || '';
      const nama = sp.nama_barang || detail.nama_barang || detail.item || '-';
      const isJasa = kode.toUpperCase().startsWith('JASA');
      const qty = isJasa ? '-' : (detail.qty || 1);
      const hargaSatuan = isJasa ? '-' : `Rp ${parseInt(sp.harga || detail.harga || 0).toLocaleString('id-ID')}`;
      const subtotal = `Rp ${parseInt(detail.subtotal || 0).toLocaleString('id-ID')}`;
      tableData.push([idx + 1, nama, qty, hargaSatuan, subtotal]);
    });
  } else {
    tableData.push(['-', 'Belum ada rincian pekerjaan', '-', '-', '-']);
  }

  autoTable(doc, {
    startY: 78,
    margin: { left: 14, right: 14 },
    head: [['No', 'Item / Pekerjaan', 'Qty', 'Harga Satuan', 'Subtotal']],
    body: tableData,
    theme: 'grid',
    headStyles: {
      fillColor: [13, 148, 136],
      textColor: [255, 255, 255],
      fontStyle: 'bold',
      fontSize: 8.5,
      halign: 'center'
    },
    bodyStyles: { fontSize: 8.5, cellPadding: 3 },
    columnStyles: {
      0: { halign: 'center', cellWidth: 12 },
      1: { cellWidth: 'auto' },
      2: { halign: 'center', cellWidth: 18 },
      3: { halign: 'right', cellWidth: 38 },
      4: { halign: 'right', cellWidth: 40 },
    },
    alternateRowStyles: { fillColor: [248, 250, 252] }
  });

  // ====================================
  // 5. GRAND TOTAL & INFO GARANSI
  // ====================================
  let currentY = (doc.lastAutoTable?.finalY || 120) + 6;

  // Cek apakah sisa halaman muat untuk Total + Garansi + Tanda Tangan (butuh ~60mm)
  if (currentY + 60 > pageHeight - 25) {
    doc.addPage();
    currentY = 20;
  }

  // Box Garansi (Kiri)
  const warranty = service.warranty;
  const hasWarranty = warranty && (warranty.status || warranty.status_garansi);

  if (hasWarranty) {
    const wStatus = warranty.status || warranty.status_garansi || 'Aktif';
    let wDateStr = '-';
    const rawWDate = warranty.tanggal_selesai || warranty.tanggal_berakhir;
    if (rawWDate) {
      const wd = new Date(rawWDate);
      if (!isNaN(wd.getTime())) {
        wDateStr = wd.toLocaleDateString('id-ID', {
          day: '2-digit', month: 'long', year: 'numeric'
        });
      }
    }

    doc.setFillColor(240, 253, 250);
    doc.setDrawColor(204, 251, 241);
    doc.roundedRect(14, currentY, 95, 16, 2, 2, 'FD');

    doc.setFontSize(8.5);
    doc.setFont('helvetica', 'bold');
    doc.setTextColor(13, 148, 136);
    doc.text('INFORMASI GARANSI', 18, currentY + 5.5);

    doc.setFont('helvetica', 'normal');
    doc.setFontSize(8);
    doc.setTextColor(50, 50, 50);
    doc.text(`Status: ${wStatus}   |   Berlaku s/d: ${wDateStr}`, 18, currentY + 11.5);
  }

  // Box Total Biaya (Kanan)
  doc.setFillColor(13, 148, 136);
  doc.roundedRect(pageWidth - 84, currentY, 70, 16, 2, 2, 'F');

  doc.setFontSize(8.5);
  doc.setFont('helvetica', 'bold');
  doc.setTextColor(255, 255, 255);
  doc.text('TOTAL BIAYA', pageWidth - 80, currentY + 6);

  doc.setFontSize(11);
  doc.text(`Rp ${parseInt(service.total_biaya || 0).toLocaleString('id-ID')}`, pageWidth - 18, currentY + 12, { align: 'right' });

  // ====================================
  // 6. TANDA TANGAN (Hormat Kami)
  // ====================================
  let sigY = currentY + 22;

  // Pastikan Tanda Tangan tidak menabrak footer
  if (sigY + 42 > pageHeight - 25) {
    doc.addPage();
    sigY = 20;
  }

  doc.setFontSize(8.5);
  doc.setFont('helvetica', 'normal');
  doc.setTextColor(80, 80, 80);
  doc.text('Hormat Kami,', pageWidth - 48, sigY + 4, { align: 'center' });

  // Watermark logo stempel jika ada
  if (logoBase64) {
    try {
      doc.setGState(new doc.GState({ opacity: 0.15 }));
      doc.addImage(logoBase64, 'JPEG', pageWidth - 60, sigY + 6, 24, 24);
      doc.setGState(new doc.GState({ opacity: 1.0 }));
    } catch {
      // Abaikan jika watermark gagal
    }
  }

  doc.setFontSize(9);
  doc.setFont('helvetica', 'bold');
  doc.setTextColor(20, 20, 20);
  doc.text('Doles Radiator Service', pageWidth - 48, sigY + 33, { align: 'center' });

  doc.setFont('helvetica', 'normal');
  doc.setFontSize(7.5);
  doc.setTextColor(100, 100, 100);
  doc.text('Pemilik / Admin', pageWidth - 48, sigY + 38, { align: 'center' });

  // ====================================
  // 7. FOOTER PADA SEMUA HALAMAN
  // ====================================
  const totalPages = doc.internal.getNumberOfPages();
  for (let i = 1; i <= totalPages; i++) {
    doc.setPage(i);
    doc.setDrawColor(13, 148, 136);
    doc.setLineWidth(0.5);
    doc.line(14, pageHeight - 18, pageWidth - 14, pageHeight - 18);

    doc.setFontSize(7.5);
    doc.setFont('helvetica', 'italic');
    doc.setTextColor(100, 100, 100);
    doc.text('Terima kasih telah mempercayakan kendaraan Anda kepada Doles Radiator Service.', pageWidth / 2, pageHeight - 12, { align: 'center' });
    doc.text('Jl. Pembangunan, Peunayong, Kec. Kuta Alam, Kota Banda Aceh  |  WA: 0812-3097-0997', pageWidth / 2, pageHeight - 7.5, { align: 'center' });
  }

  const blob = doc.output('blob');
  return URL.createObjectURL(blob);
};
