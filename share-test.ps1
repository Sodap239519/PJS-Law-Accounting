# ============================================================
#  เตรียมแชร์เว็บให้ลูกค้าทดสอบ (โดยยังไม่ deploy)
#  วิธีรัน:  powershell -ExecutionPolicy Bypass -File .\share-test.ps1
# ============================================================

Write-Host "`n=== เตรียมระบบสำหรับให้ลูกค้าทดสอบ ===" -ForegroundColor Cyan

# 0) เตือนเรื่อง MySQL
Write-Host "`n[!] ตรวจสอบว่าเปิด MySQL ใน XAMPP แล้ว (ไม่งั้นเว็บจะค้าง)" -ForegroundColor Yellow

# 1) build assets สำหรับใช้งานจริง (ไม่พึ่ง Vite dev server)
Write-Host "`n[1/3] กำลัง build assets ..." -ForegroundColor Green
npm run build
if ($LASTEXITCODE -ne 0) { Write-Host "build ล้มเหลว — หยุด" -ForegroundColor Red; exit 1 }

# 2) ลบ public/hot เพื่อให้เว็บใช้ไฟล์ build (ไม่ชี้ไป localhost:5173)
if (Test-Path public\hot) {
    Remove-Item public\hot -Force
    Write-Host "[2/3] ลบ public/hot แล้ว — ใช้ไฟล์ build" -ForegroundColor Green
} else {
    Write-Host "[2/3] ไม่มี public/hot อยู่แล้ว (ใช้ไฟล์ build)" -ForegroundColor Green
}

# 3) ล้าง cache config/route
Write-Host "[3/3] ล้าง cache ..." -ForegroundColor Green
php artisan config:clear | Out-Null
php artisan route:clear | Out-Null

Write-Host "`n=== พร้อมแล้ว! เปิด 2 หน้าต่าง terminal ===" -ForegroundColor Cyan
Write-Host "  Terminal 1 (เว็บเซิร์ฟเวอร์):" -ForegroundColor White
Write-Host "     php artisan serve --host=127.0.0.1 --port=8000" -ForegroundColor Gray
Write-Host "  Terminal 2 (เปิดสู่อินเทอร์เน็ต):" -ForegroundColor White
Write-Host "     cloudflared tunnel --url http://localhost:8000" -ForegroundColor Gray
Write-Host "`n  แล้วคัดลอกลิงก์ https://xxxxx.trycloudflare.com ส่งให้ลูกค้า" -ForegroundColor Yellow
Write-Host "`n  * เครื่องต้องเปิดค้างไว้ + MySQL รันอยู่ตลอดที่ลูกค้าเทส" -ForegroundColor DarkYellow
Write-Host "  * เลิกเทสแล้วอยากกลับมาพัฒนาต่อ: รัน  npm run dev  (จะสร้าง hot กลับมาเอง)`n" -ForegroundColor DarkYellow
