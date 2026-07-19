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

const pastTop = ref(false); // เลื่อนพ้นแถบปุ่มบนแล้ว
const docked = ref(false); // เลื่อนถึงท้ายฟอร์มแล้ว (แสดงเป็นการ์ดล็อค)
const anchor = ref(null);
let topObs = null;
let dockObs = null;

// fallback: หน้าที่ไม่มีแถบปุ่มบน (sentinel)
const computeScroll = () => {
    pastTop.value = window.scrollY > 220;
};

onMounted(() => {
    const IO = window.IntersectionObserver;
    const topEl = document.getElementById(props.target);
    if (topEl && IO) {
        topObs = new IO(([e]) => (pastTop.value = !e.isIntersecting), { root: null, rootMargin: '-64px 0px 0px 0px', threshold: 0 });
        topObs.observe(topEl);
    } else {
        computeScroll();
        window.addEventListener('scroll', computeScroll, { passive: true });
        window.addEventListener('resize', computeScroll, { passive: true });
    }
    // anchor อยู่ "เหนือ" การ์ดล็อค → พอ anchor โผล่ในจอ = ถึงท้ายฟอร์ม
    // (การ์ดที่โผล่อยู่ใต้ anchor จึงไม่ดัน anchor ออก = ไม่กระพริบ)
    if (anchor.value && IO) {
        dockObs = new IO(([e]) => (docked.value = e.isIntersecting), { root: null, threshold: 0 });
        dockObs.observe(anchor.value);
    }
});
onBeforeUnmount(() => {
    if (topObs) topObs.disconnect();
    if (dockObs) dockObs.disconnect();
    window.removeEventListener('scroll', computeScroll);
    window.removeEventListener('resize', computeScroll);
});
</script>

<template>
    <!-- จุดสังเกตท้ายฟอร์ม (อยู่เหนือการ์ดล็อค กันกระพริบ) -->
    <div ref="anchor" aria-hidden="true" class="h-px w-full"></div>

    <!-- การ์ดล็อคท้ายฟอร์ม (in-flow) — โผล่เมื่อเลื่อนถึงล่างสุด สวยพอดีกับการ์ดอื่น ไม่บังกัน -->
    <Transition enter-active-class="transition duration-200 ease-out" enter-from-class="translate-y-2 opacity-0">
        <div v-if="docked" class="pjs-card flex flex-col items-stretch gap-1.5 p-3 sm:flex-row sm:items-center sm:justify-end sm:gap-2">
            <slot>
                <button type="button" class="btn-outline btn-sm" @click="emit('cancel')">{{ cancelLabel }}</button>
                <button type="button" :disabled="processing" class="btn-primary btn-sm" @click="emit('save')"><i class="bi bi-check-lg"></i> {{ saveLabel }}</button>
            </slot>
        </div>
    </Transition>

    <!-- แถบลอย (teleport) — โผล่ตอนเลื่อนกลาง (พ้นแถบบน แต่ยังไม่ถึงล่างสุด) -->
    <Teleport to="body">
        <Transition
            enter-active-class="transition duration-200 ease-out"
            enter-from-class="translate-y-4 opacity-0"
            leave-active-class="transition duration-150 ease-in"
            leave-to-class="translate-y-4 opacity-0"
        >
            <div v-if="pastTop && !docked" class="fixed inset-x-0 bottom-24 z-[9999] flex justify-center px-4">
                <div class="flex max-w-full flex-col items-stretch gap-1.5 rounded-2xl border border-slate-200/80 bg-white/95 px-3 py-2 shadow-[0_8px_30px_-8px_rgba(37,99,235,0.35)] backdrop-blur sm:flex-row sm:items-center sm:gap-2">
                    <slot>
                        <button type="button" class="btn-outline btn-sm" @click="emit('cancel')">{{ cancelLabel }}</button>
                        <button type="button" :disabled="processing" class="btn-primary btn-sm" @click="emit('save')"><i class="bi bi-check-lg"></i> {{ saveLabel }}</button>
                    </slot>
                </div>
            </div>
        </Transition>
    </Teleport>
</template>
