# แชร์เว็บให้ลูกค้าทดสอบ (โดยยังไม่ Deploy)

แนวคิด: รันเว็บบนเครื่องเราตามปกติ แล้วใช้ **tunnel** เปิดเป็นลิงก์ https ชั่วคราวให้ลูกค้าเข้าจากที่ไหนก็ได้ — ไม่ต้องอัปขึ้นโฮสต์จริง

---

## วิธีหลัก (แนะนำ): Cloudflare Tunnel
ฟรี · ไม่ต้องสมัคร · ได้ลิงก์ https สะอาด (ไม่มีหน้าเตือนคั่น)

### ครั้งแรก: ติดตั้ง cloudflared (ทำครั้งเดียว)
```powershell
winget install --id Cloudflare.cloudflared
```
(ถ้าไม่มี winget โหลด .exe จาก https://github.com/cloudflare/cloudflared/releases แล้ววางไว้ที่ที่ path เรียกถึง)

### ทุกครั้งที่จะแชร์
1. เปิด **MySQL** ใน XAMPP ให้รันอยู่
2. เตรียมระบบ (build + สลับไปใช้ไฟล์จริง):
   ```powershell
   powershell -ExecutionPolicy Bypass -File .\share-test.ps1
   ```
3. เปิด **Terminal 1** — เว็บเซิร์ฟเวอร์:
   ```powershell
   php artisan serve --host=127.0.0.1 --port=8000
   ```
4. เปิด **Terminal 2** — เปิดสู่อินเทอร์เน็ต:
   ```powershell
   cloudflared tunnel --url http://localhost:8000
   ```
5. คัดลอกลิงก์ที่ขึ้นมา เช่น `https://xxxx-xxxx.trycloudflare.com` → **ส่งให้ลูกค้า**

> ลูกค้าเปิดลิงก์นี้ได้ทั้งบนมือถือ/คอม รวมถึงกด "เพิ่ม PJS ลงหน้าจอหลัก" ได้ (เพราะเป็น https)

---

## วิธีสำรอง: ngrok
```powershell
winget install ngrok            # ติดตั้งครั้งเดียว
ngrok config add-authtoken <token>   # สมัครฟรีที่ ngrok.com เอา token มาใส่ (ครั้งเดียว)
# แล้วหลังรัน share-test.ps1 + artisan serve:
ngrok http 8000
```
ข้อเสีย: รุ่นฟรีมี **หน้าเตือนคั่น 1 ครั้ง** (ลูกค้าต้องกด Visit Site) และลิงก์เปลี่ยนทุกครั้ง

---

## ข้อมูลให้ลูกค้า
- **ลิงก์เข้า admin:** `<ลิงก์ tunnel>/login`
- **บัญชีทดสอบ** (จาก seeder):
  - ผู้ดูแลสูงสุด: `superadmin@pjs-law.com` / `password`
  - ผู้ดูแล: `admin@pjs-law.com` / `password`
- แนะนำ: เปลี่ยนรหัสผ่านก่อนส่ง หรือสร้างบัญชีเดโมแยก

---

## ข้อควรระวัง
- **เครื่องต้องเปิดค้าง + MySQL รันอยู่** ตลอดเวลาที่ลูกค้าเทส (ปิดเครื่อง = ลิงก์ตาย)
- **ลิงก์ tunnel เปลี่ยนทุกครั้งที่รันใหม่** — ส่งลิงก์ล่าสุดให้ลูกค้าเสมอ
- ปิด Sleep ของ Windows ไว้ระหว่างเทส (ไม่งั้นหลับแล้วเว็บหยุด)
- ลิงก์นี้ใครมีก็เข้าได้ — ส่งเฉพาะลูกค้า และปิด tunnel เมื่อเลิกเทส (กด Ctrl+C ทั้ง 2 terminal)

## กลับมาพัฒนาต่อ
รัน `npm run dev` ตามปกติ (ระบบจะสร้าง `public/hot` กลับมาเอง แล้วใช้ Vite dev เหมือนเดิม)

---

## ทางเลือกอื่น (ถ้าอยากได้ลิงก์อยู่นานๆ)
- **Expose** (`expose share http://localhost:8000`) — ทำมาเพื่อ Laravel โดยเฉพาะ จัดการ host header ดี
- ถ้าลูกค้าจะเทสยาวๆ หลายวัน แนะนำ **deploy ขึ้น staging** (subdomain ชั่วคราวบน Plesk) จะเสถียรกว่า tunnel
