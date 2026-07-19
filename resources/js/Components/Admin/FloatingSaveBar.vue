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

const compute = () => {
    const el = document.getElementById(props.target);
    if (el) {
        // โผล่เมื่อแถบปุ่มบนเลื่อนพ้นจอ (ขอบล่างอยู่เหนือ header ~64px)
        show.value = el.getBoundingClientRect().bottom < 64;
        return;
    }
    // ไม่มีแถบปุ่มบน → โผล่เมื่อเลื่อนหน้าลงพอสมควร (ใช้ได้ทุกหน้า)
    show.value = window.scrollY > 220;
};

onMounted(() => {
    compute();
    window.addEventListener('scroll', compute, { passive: true });
    window.addEventListener('resize', compute, { passive: true });
});
onBeforeUnmount(() => {
    window.removeEventListener('scroll', compute);
    window.removeEventListener('resize', compute);
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
            <div v-if="show" class="fixed inset-x-0 bottom-20 z-50 flex justify-center px-4 lg:bottom-4">
                <div class="flex items-center gap-2 rounded-full border border-slate-200/80 bg-white/95 px-3 py-2 shadow-[0_8px_30px_-8px_rgba(37,99,235,0.35)] backdrop-blur">
                    <span class="hidden pl-2 pr-1 text-xs text-slate-400 sm:inline">มีการแก้ไข —</span>
                    <button type="button" class="btn-outline btn-sm" @click="emit('cancel')">{{ cancelLabel }}</button>
                    <button type="button" :disabled="processing" class="btn-primary btn-sm" @click="emit('save')">
                        <i class="bi bi-check-lg"></i> {{ saveLabel }}
                    </button>
                </div>
            </div>
        </Transition>
    </Teleport>
</template>
