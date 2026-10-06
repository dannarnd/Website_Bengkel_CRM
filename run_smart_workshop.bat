@echo off
title Smart Workshop Server
color 0b

echo ========================================================
echo       MEMULAI SERVER SMART WORKSHOP BENGKEL
echo ========================================================
echo.

echo [1/2] Menjalankan Backend Laravel (Port 8000)...
start "Backend Laravel" cmd /k "cd /d %~dp0Backend && php artisan serve"

echo [2/2] Menjalankan Frontend Vue JS...
start "Frontend Vue JS" cmd /k "cd /d %~dp0frontend && npm run dev"

echo.
echo ========================================================
echo Server sedang berjalan di dua jendela baru!
echo Silakan buka browser Anda di: http://localhost:5173
echo ========================================================
echo.
pause
