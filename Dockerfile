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
# ล็อก Debian 12 (bookworm) — เสถียรกว่า tag ล่าสุด (Debian 13/Trixie)
FROM php:8.2-cli-bookworm

# บังคับ compile ทีละ job กัน OOM (exit 137) บน builder RAM น้อย (Railway trial)
ENV MAKEFLAGS="-j1"

# ส่วนขยาย PHP ที่โปรเจกต์ต้องใช้ (gd=thumbnail, pdo_mysql=DB, exif/zip/bcmath)
RUN apt-get update && apt-get install -y --no-install-recommends \
        libpng-dev libjpeg-dev libfreetype6-dev libzip-dev libonig-dev unzip git \
 && docker-php-ext-configure gd --with-freetype --with-jpeg \
 && docker-php-ext-install -j1 pdo_mysql gd zip exif bcmath \
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
