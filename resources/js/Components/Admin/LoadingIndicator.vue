<script setup>
import { ref, onMounted, onUnmounted } from 'vue';
import { router } from '@inertiajs/vue3';

const loading = ref(false);
const percent = ref(0);
let showTimer = null;
let trickle = null;
let offStart = null;
let offProgress = null;
let offFinish = null;

const startTrickle = () => {
    clearInterval(trickle);
    trickle = setInterval(() => {
        // ค่อยๆ ไต่ขึ้นหา 90% (ยังไม่ถึง 100 จนกว่าจะโหลดเสร็จ)
        if (percent.value < 90) {
            const remaining = 90 - percent.value;
            percent.value = Math.min(90, percent.value + Math.max(0.6, remaining * 0.06));
        }
    }, 180);
};

const reset = () => {
    clearTimeout(showTimer);
    clearInterval(trickle);
};

onMounted(() => {
    offStart = router.on('start', () => {
        if (window.__pjsSilentNav) return; // ค้นหาแบบเงียบ — ไม่ต้องขึ้น overlay
        clearInterval(trickle);
        percent.value = 0;
        showTimer = setTimeout(() => {
            loading.value = true;
            percent.value = 8;
            startTrickle();
        }, 150);
    });

    // % จริงระหว่างอัปโหลดไฟล์ (สร้าง/แก้ไขข่าวที่มีรูป)
    offProgress = router.on('progress', (event) => {
        const p = event.detail?.progress?.percentage;
        if (p) {
            clearInterval(trickle);
            loading.value = true;
            percent.value = Math.max(percent.value, Math.round(p) * 0.95); // เผื่อเวลาประมวลผลฝั่งเซิร์ฟเวอร์
        }
    });

    offFinish = router.on('finish', () => {
        window.__pjsSilentNav = false;
        reset();
        if (loading.value) {
            percent.value = 100;
            setTimeout(() => {
                loading.value = false;
                percent.value = 0;
            }, 300);
        } else {
            loading.value = false;
        }
    });
});

onUnmounted(() => {
    offStart?.();
    offProgress?.();
    offFinish?.();
    reset();
});
</script>

<template>
    <Transition
        enter-active-class="transition-opacity duration-200"
        enter-from-class="opacity-0"
        leave-active-class="transition-opacity duration-200"
        leave-to-class="opacity-0"
    >
        <div v-if="loading" class="fixed inset-0 z-[100] flex flex-col items-center justify-center gap-3 bg-white/60 backdrop-blur-[2px]">
            <!-- Progress ring with percentage -->
            <div class="relative h-16 w-16">
                <svg class="h-16 w-16 -rotate-90" viewBox="0 0 50 50">
                    <circle cx="25" cy="25" r="20" fill="none" stroke="#dbeafe" stroke-width="5" />
                    <circle
                        cx="25"
                        cy="25"
                        r="20"
                        fill="none"
                        stroke="#2563eb"
                        stroke-width="5"
                        stroke-linecap="round"
                        :stroke-dasharray="125.6"
                        :stroke-dashoffset="125.6 - (125.6 * Math.min(percent, 100)) / 100"
                        style="transition: stroke-dashoffset 0.2s ease"
                    />
                </svg>
                <span class="absolute inset-0 flex items-center justify-center text-sm font-semibold text-pjs-blue-dark">{{ Math.round(percent) }}%</span>
            </div>
            <p class="text-xs font-medium text-slate-500">กำลังโหลด…</p>
        </div>
    </Transition>
</template>
