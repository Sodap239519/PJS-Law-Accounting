# Deploy Staging/Demo บน Railway (ให้ลูกค้าลองก่อน deploy จริง)

โปรเจกต์นี้มี `Dockerfile` + `railway.json` เตรียมไว้แล้ว — Railway จะใช้ Dockerfile build ให้อัตโนมัติ

---

## ขั้นตอน (ครั้งแรก)

### 1) push โค้ดขึ้น GitHub ให้ครบ
```powershell
git push
```

### 2) สร้างโปรเจกต์บน Railway
1. เข้า https://railway.app → สมัคร/ล็อกอิน (ใช้ GitHub ได้)
2. **New Project → Deploy from GitHub repo → เลือก repo นี้**
3. Railway จะเจอ `Dockerfile` แล้วเริ่ม build เอง (ปล่อยให้ build รอบแรกไปก่อน อาจ error เรื่อง DB — ปกติ ค่อยตั้ง env ต่อ)

### 3) เพิ่มฐานข้อมูล MySQL
- ในโปรเจกต์ กด **+ New → Database → Add MySQL**

### 4) ตั้งค่า Environment Variables (ที่ service ของแอป → Variables)

> ⚠️ **APP_KEY ต้องสร้างเองใหม่ ห้าม commit ลงโค้ด** — รันในเครื่อง `php artisan key:generate --show`
> จะได้ค่า `base64:....` แล้วเอาไปวางในช่อง `APP_KEY` บน Railway (เก็บเป็นความลับ ไม่ต้องใส่ในไฟล์)

วางตัวแปรเหล่านี้ (ค่า DB ใช้ **reference** ชี้ไป plugin MySQL):

```
APP_NAME=PJS
APP_ENV=production
APP_KEY=<< วางคีย์จาก php artisan key:generate --show >>
APP_DEBUG=false
APP_URL=https://${{RAILWAY_PUBLIC_DOMAIN}}

DB_CONNECTION=mysql
DB_HOST=${{MySQL.MYSQLHOST}}
DB_PORT=${{MySQL.MYSQLPORT}}
DB_DATABASE=${{MySQL.MYSQLDATABASE}}
DB_USERNAME=${{MySQL.MYSQLUSER}}
DB_PASSWORD=${{MySQL.MYSQLPASSWORD}}

SESSION_DRIVER=database
SESSION_LIFETIME=4320
CACHE_STORE=database
QUEUE_CONNECTION=sync
LOG_CHANNEL=stderr
MEDIA_URL=/storage
```

> `${{MySQL.MYSQLHOST}}` = อ้างค่าจาก plugin MySQL ที่เพิ่งเพิ่ม (พิมพ์ตามนี้ Railway จะเชื่อมให้เอง ถ้าชื่อ service ไม่ใช่ "MySQL" ให้แก้ตามชื่อจริง)

### 5) เปิด public URL
- ที่ service แอป → **Settings → Networking → Generate Domain**
- จะได้ลิงก์ เช่น `https://pjs-xxxx.up.railway.app`

### 6) ใส่ข้อมูลตัวอย่าง (รันครั้งเดียว)
- ที่ service แอป → เมนู **⋮ → ...** เปิด **Shell / Command** แล้วรัน:
```
php artisan migrate:fresh --seed --force
php artisan storage:link
```
(ถ้าไม่มี Shell ใน UI: ตั้ง `startCommand` ชั่วคราวเป็นคำสั่งข้างบน 1 รอบ แล้วค่อยเปลี่ยนกลับ — หรือใช้ Railway CLI `railway run php artisan migrate:fresh --seed --force`)

---

## เสร็จแล้ว — ส่งให้ลูกค้า
- **หน้าเว็บ:** `https://<domain>`
- **เข้า admin:** `https://<domain>/login`
- **บัญชีทดสอบ:** `admin@pjs-law.com` / `password` (แนะนำเปลี่ยนรหัสก่อนส่ง)

---

## อัปเดตเวอร์ชันใหม่
แค่ `git push` — Railway จะ build + deploy ใหม่อัตโนมัติ (start command จะรัน `migrate --force` ให้ทุกครั้ง ไม่ลบข้อมูล)

## ข้อควรรู้
- ไฟล์ที่ **อัปโหลดใหม่บน staging (รูป/เอกสาร) จะหายเมื่อ redeploy** เพราะ Railway ใช้ดิสก์ชั่วคราว — โอเคสำหรับ demo (อยากถาวรค่อยใช้ Volume หรือ S3 ตอน prod จริง)
- ค่าใช้จ่าย: มีเครดิตฟรีช่วงแรก หลังหมดคิดตามการใช้ (สำหรับ demo ใช้ไม่กี่บาท) — ปิด service ได้เมื่อเลิกเทส
- นี่คือ **staging** แยกจาก production จริงบน Plesk — ข้อมูลคนละชุด
