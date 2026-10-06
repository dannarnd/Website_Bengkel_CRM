import { jsPDF } from 'jspdf';
import autoTable from 'jspdf-autotable';

const loadImageAsBase64 = (url) => {
  return new Promise((resolve, reject) => {
    const img = new Image();
    img.crossOrigin = 'anonymous';
    img.onload = () => {
      const canvas = document.createElement('canvas');
      canvas.width = img.naturalWidth;
      canvas.height = img.naturalHeight;
      const ctx = canvas.getContext('2d');
      // Isi dengan putih agar PNG transparan tidak menjadi hitam saat di-convert ke JPEG
      ctx.fillStyle = '#FFFFFF';
      ctx.fillRect(0, 0, canvas.width, canvas.height);
      ctx.drawImage(img, 0, 0);
      // Kompresi ke JPEG (quality 0.7) agar ukuran PDF tidak membengkak dan menyebabkan blank iframe
      resolve(canvas.toDataURL('image/jpeg', 0.7));
    };
    img.onerror = reject;
    img.src = url + '?t=' + Date.now(); // cache-bust
  });
};

export const generateInvoicePDF = async (service) => {
  // Load gambar logo dari folder public
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
  // 2. JUDUL NOTA
  // ====================================
  doc.setFontSize(13);
  doc.setFont('helvetica', 'bold');
  doc.setTextColor(20, 20, 20);
  doc.text('NOTA SERVIS', 14, 48);

  doc.setFontSize(9);
  doc.setFont('helvetica', 'normal');
  doc.setTextColor(80, 80, 80);
  const tglServis = new Date(service.tanggal_masuk).toLocaleDateString('id-ID', {
    day: '2-digit', month: 'long', year: 'numeric'
  });
  doc.text(`Tgl. Servis : ${tglServis}`, pageWidth - 14, 48, { align: 'right' });

  // ====================================
  // 3. INFO PELANGGAN & KENDARAAN
  // ====================================
  doc.setDrawColor(220, 220, 220);
  doc.setLineWidth(0.2);
  doc.line(14, 52, pageWidth - 14, 52);

  doc.setFontSize(9);
  doc.setFont('helvetica', 'normal');
  doc.setTextColor(60, 60, 60);

  // Kolom Kiri
  doc.text('Nama Pelanggan', 14, 59);
  doc.text(`: ${service.kendaraan?.pelanggan?.nama || '-'}`, 50, 59);
  doc.text('No. HP', 14, 65);
  doc.text(`: ${service.kendaraan?.pelanggan?.nomor_hp || '-'}`, 50, 65);
  doc.text('Mekanik', 14, 71);
  doc.text(`: ${service.mekanik?.name || 'Admin'}`, 50, 71);

  // Kolom Kanan
  doc.text('No. Polisi', 115, 59);
  doc.text(`: ${service.nomor_polisi}`, 138, 59);
  doc.text('Kendaraan', 115, 65);
  doc.text(`: ${service.kendaraan?.model || '-'}`, 138, 65);
  doc.text('Keluhan', 115, 71);
  const keluhan = service.keluhan || '-';
  doc.text(`: ${keluhan.substring(0, 38)}${keluhan.length > 38 ? '...' : ''}`, 138, 71);

  doc.setDrawColor(220, 220, 220);
  doc.line(14, 76, pageWidth - 14, 76);

  // ====================================
  // 4. TABEL RINCIAN PEKERJAAN
  // ====================================
  const tableData = [];
  let no = 1;

  if (service.service_details && service.service_details.length > 0) {
    service.service_details.forEach(detail => {
      const isJasa = detail.sparepart?.kode_barang?.startsWith('JASA');
      tableData.push([
        no++,
        detail.sparepart?.nama_barang || '-',
        isJasa ? '-' : (detail.qty || '-'),
        isJasa ? '-' : `Rp ${parseInt(detail.sparepart?.harga || 0).toLocaleString('id-ID')}`,
        `Rp ${parseInt(detail.subtotal || 0).toLocaleString('id-ID')}`
      ]);
    });
  } else {
    tableData.push(['-', 'Belum ada rincian pekerjaan', '-', '-', '-']);
  }

  autoTable(doc, {
    startY: 80,
    head: [['No', 'Item / Pekerjaan', 'Qty', 'Harga Satuan', 'Subtotal']],
    body: tableData,
    theme: 'grid',
    headStyles: {
      fillColor: [13, 148, 136],
      textColor: [255, 255, 255],
      fontStyle: 'bold',
      fontSize: 9,
      halign: 'center'
    },
    bodyStyles: { fontSize: 9, cellPadding: 3 },
    columnStyles: {
      0: { halign: 'center', cellWidth: 12 },
      2: { halign: 'center', cellWidth: 18 },
      3: { halign: 'right', cellWidth: 38 },
      4: { halign: 'right', cellWidth: 40 },
    },
    alternateRowStyles: { fillColor: [248, 250, 252] }
  });

  // ====================================
  // 5. GRAND TOTAL
  // ====================================
  const finalY = (doc.lastAutoTable?.finalY || 130) + 6;

  doc.setFillColor(13, 148, 136);
  doc.roundedRect(pageWidth - 82, finalY, 72, 14, 2, 2, 'F');
  doc.setFontSize(9);
  doc.setFont('helvetica', 'bold');
  doc.setTextColor(255, 255, 255);
  doc.text('TOTAL BIAYA', pageWidth - 78, finalY + 5.5);
  doc.setFontSize(11);
  doc.text(`Rp ${parseInt(service.total_biaya || 0).toLocaleString('id-ID')}`, pageWidth - 14, finalY + 10, { align: 'right' });
  doc.setTextColor(0, 0, 0);

  // ====================================
  // 6. INFO GARANSI
  // ====================================
  let nextY = finalY + 22;
  if (service.warranty && service.warranty.status_garansi !== 'Tidak Berlaku') {
    doc.setFillColor(240, 253, 250);
    doc.roundedRect(14, nextY - 2, 100, 18, 2, 2, 'F');
    doc.setFontSize(9);
    doc.setFont('helvetica', 'bold');
    doc.setTextColor(13, 148, 136);
    doc.text('INFORMASI GARANSI', 18, nextY + 4);
    doc.setFont('helvetica', 'normal');
    doc.setTextColor(50, 50, 50);
    const tglBerakhir = new Date(service.warranty.tanggal_berakhir).toLocaleDateString('id-ID', {
      day: '2-digit', month: 'long', year: 'numeric'
    });
    doc.text(`Status: ${service.warranty.status_garansi}  |  Berlaku s/d: ${tglBerakhir}`, 18, nextY + 11);
    nextY += 24;
  }

  // ====================================
  // 7. TANDA TANGAN (Logo Kecil + Nama)
  // ====================================
  doc.setFontSize(9);
  doc.setFont('helvetica', 'normal');
  doc.setTextColor(80, 80, 80);
  doc.text('Hormat Kami,', pageWidth - 50, nextY + 4, { align: 'center' });

  // Set transparansi (opacity) untuk logo stempel
  doc.setGState(new doc.GState({ opacity: 0.15 }));
  doc.addImage(logoBase64, 'JPEG', pageWidth - 66, nextY + 7, 32, 32);
  // Kembalikan opacity ke 1.0 agar teks tidak ikut transparan
  doc.setGState(new doc.GState({ opacity: 1.0 }));

  doc.setFontSize(9);
  doc.setFont('helvetica', 'bold');
  doc.setTextColor(20, 20, 20);
  doc.text('Doles Radiator Service', pageWidth - 50, nextY + 44, { align: 'center' });
  doc.setFont('helvetica', 'normal');
  doc.setFontSize(8);
  doc.setTextColor(100, 100, 100);
  doc.text('Pemilik / Admin', pageWidth - 50, nextY + 49, { align: 'center' });

  // ====================================
  // 8. FOOTER
  // ====================================
  const pageHeight = doc.internal.pageSize.getHeight();
  doc.setDrawColor(13, 148, 136);
  doc.setLineWidth(0.5);
  doc.line(10, pageHeight - 20, pageWidth - 10, pageHeight - 20);

  doc.setFontSize(7.5);
  doc.setFont('helvetica', 'italic');
  doc.setTextColor(100, 100, 100);
  doc.text('Terima kasih telah mempercayakan kendaraan Anda kepada Doles Radiator Service.', pageWidth / 2, pageHeight - 14, { align: 'center' });
  doc.text('Jl. Pembangunan, Peunayong, Kec. Kuta Alam, Kota Banda Aceh  |  WA: 0812-3097-0997', pageWidth / 2, pageHeight - 9, { align: 'center' });

  const blob = doc.output('blob');
  return URL.createObjectURL(blob);
};

