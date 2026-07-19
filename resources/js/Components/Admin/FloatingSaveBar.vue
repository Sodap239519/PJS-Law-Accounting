<script setup>
import { ref, onMounted, onBeforeUnmount } from 'vue';

const props = defineProps({
    processing: { type: Boolean, default: false },
    saveLabel: { type: String, default: 'บันทึก' },
    cancelLabel: { type: String, default: 'ยกเลิก' },
    // id ของแถบปุ่มด้านบน (sentinel) — เมื่อเลื่อนพ้นแถบนี้จะโผล่ปุ่มลอย
    target: { type: String, default: 'form-actions-top' },
});
const emit = defineEmits(['save', 'cancel']);

const show = ref(false);
let observer = null;

// fallback: หน้าที่ไม่มีแถบปุ่มบน (sentinel) — โผล่เมื่อเลื่อนหน้าลงพอสมควร
const computeScroll = () => {
    show.value = window.scrollY > 220;
};

onMounted(() => {
    const el = document.getElementById(props.target);
    if (el && 'IntersectionObserver' in window) {
        // โผล่เมื่อแถบปุ่มบนหลุดจอ (เผื่อ header sticky ~64px) — ทำงานไม่ว่าจะ scroll ที่ container ไหน
        observer = new IntersectionObserver(
            ([entry]) => {
                show.value = !entry.isIntersecting;
            },
            { root: null, rootMargin: '-64px 0px 0px 0px', threshold: 0 },
        );
        observer.observe(el);
        return;
    }
    // ไม่มี sentinel → ใช้ scroll ของ window
    computeScroll();
    window.addEventListener('scroll', computeScroll, { passive: true });
    window.addEventListener('resize', computeScroll, { passive: true });
});
onBeforeUnmount(() => {
    if (observer) observer.disconnect();
    window.removeEventListener('scroll', computeScroll);
    window.removeEventListener('resize', computeScroll);
});
</script>

<template>
    <Teleport to="body">
        <Transition
            enter-active-class="transition duration-200 ease-out"
            enter-from-class="translate-y-4 opacity-0"
            leave-active-class="transition duration-150 ease-in"
            leave-to-class="translate-y-4 opacity-0"
        >
            <div v-if="show" class="fixed inset-x-0 bottom-24 z-[9999] flex justify-center px-4">
                <div class="flex items-center gap-2 rounded-full border border-slate-200/80 bg-white/95 px-3 py-2 shadow-[0_8px_30px_-8px_rgba(37,99,235,0.35)] backdrop-blur">
                    <span class="hidden pl-2 pr-1 text-xs text-slate-400 sm:inline">มีการแก้ไข —</span>
                    <!-- แต่ละฟอร์มส่งชุดปุ่มของตัวเองมา (ให้ตรงกับแถบบน); ถ้าไม่ส่งใช้ค่าเริ่มต้น ยกเลิก/บันทึก -->
                    <slot>
                        <button type="button" class="btn-outline btn-sm" @click="emit('cancel')">{{ cancelLabel }}</button>
                        <button type="button" :disabled="processing" class="btn-primary btn-sm" @click="emit('save')">
                            <i class="bi bi-check-lg"></i> {{ saveLabel }}
                        </button>
                    </slot>
                </div>
            </div>
        </Transition>
    </Teleport>
</template>
