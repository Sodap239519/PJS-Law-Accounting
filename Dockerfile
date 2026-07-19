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
# ใช้ image ที่ extension (gd/pdo_mysql/zip/bcmath) ติดตั้งมาแล้ว → ไม่ต้อง compile
# (เลี่ยง OOM/exit 137 ตอน compile บน builder ที่ RAM น้อย)
FROM serversideup/php:8.2-cli
USER root
ENTRYPOINT []
WORKDIR /var/www/html

# composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

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
