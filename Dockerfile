# ============================================================
#  Dockerfile สำหรับ deploy staging/demo บน Railway
#  (multi-stage: build assets ด้วย Node → รันด้วย PHP)
# ============================================================

# ---- 1) build frontend assets ----
FROM node:20-alpine AS assets
WORKDIR /app
COPY package*.json ./
RUN npm ci
COPY . .
RUN npm run build

# ---- 2) PHP application ----
# ล็อก Debian 12 (bookworm) — เสถียรกว่า tag ล่าสุด (Debian 13/Trixie ที่ build extension มีปัญหา)
FROM php:8.2-cli-bookworm

# ติดตั้ง PHP extensions แบบชัวร์ด้วย docker-php-extension-installer
# (จัดการ system lib: gd(png/jpeg/freetype), zip ให้อัตโนมัติ — เลี่ยงปัญหา compile ข้ามเวอร์ชัน Debian)
ADD https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions /usr/local/bin/
RUN chmod +x /usr/local/bin/install-php-extensions \
 && install-php-extensions gd pdo_mysql zip exif bcmath \
 && apt-get update && apt-get install -y --no-install-recommends unzip git \
 && rm -rf /var/lib/apt/lists/*

# composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /app
COPY . .
# ใช้ assets ที่ build จาก stage แรก
COPY --from=assets /app/public/build ./public/build

RUN composer install --no-dev --optimize-autoloader --no-interaction \
 && chmod -R 775 storage bootstrap/cache

# Railway จะ inject ตัวแปร PORT ให้เอง
CMD php artisan config:clear \
 && php artisan migrate --force \
 && (php artisan storage:link || true) \
 && php artisan serve --host 0.0.0.0 --port ${PORT:-8080}
