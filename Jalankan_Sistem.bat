@echo off
color 0A
title Smart Workshop - Doles Radiator Start Server

echo =======================================================
echo          MEMULAI SISTEM SMART WORKSHOP...
echo =======================================================
echo.
echo Sedang menyiapkan server untuk pengujian/sidang...
echo Pastikan Laragon (MySQL) sudah dalam keadaan menyala!
echo.
timeout /t 3 >nul

echo [1/2] Menjalankan Backend Laravel (Port 8000)...
cd /d "C:\laragon\www\Smart_Workshop\backend"
start "Backend (Laravel)" cmd /k "php artisan serve"

echo [2/2] Menjalankan Frontend Vue (Port 5173)...
cd /d "C:\laragon\www\Smart_Workshop\frontend"
start "Frontend (Vue.js)" cmd /k "npm run dev"

echo.
echo =======================================================
echo SERVER BERHASIL DINYALAKAN!
echo 2 jendela Terminal (hitam) baru telah terbuka.
echo Biarkan kedua jendela tersebut terbuka selama pengujian.
echo.
echo Jika pengujian sudah selesai, tutup kedua jendela hitam
echo tersebut untuk mematikan server.
echo =======================================================
echo.
pause
