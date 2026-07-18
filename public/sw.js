// Service worker ขั้นต่ำ — จำเป็นเพื่อให้ติดตั้ง PWA ได้ (beforeinstallprompt)
// ไม่ทำ offline cache เพื่อไม่ให้ค้างเวอร์ชันเก่าของ admin
const VERSION = 'pjs-v1';

self.addEventListener('install', () => {
    self.skipWaiting();
});

self.addEventListener('activate', (event) => {
    event.waitUntil(self.clients.claim());
});

// ผ่านทุก request ตรงไปยังเครือข่าย (network passthrough)
self.addEventListener('fetch', (event) => {
    // ต้องมี fetch handler เพื่อให้เข้าเงื่อนไขติดตั้งได้
    return;
});
