<script setup>
import { ref, onMounted, onUnmounted } from 'vue';
import { router } from '@inertiajs/vue3';

const loading = ref(false);
let timer = null;
let offStart = null;
let offFinish = null;

onMounted(() => {
    offStart = router.on('start', () => {
        timer = setTimeout(() => (loading.value = true), 150);
    });
    offFinish = router.on('finish', () => {
        clearTimeout(timer);
        loading.value = false;
    });
});

onUnmounted(() => {
    offStart?.();
    offFinish?.();
    clearTimeout(timer);
});
</script>

<template>
    <Transition
        enter-active-class="transition-opacity duration-200"
        enter-from-class="opacity-0"
        leave-active-class="transition-opacity duration-200"
        leave-to-class="opacity-0"
    >
        <div v-if="loading" class="fixed inset-0 z-[100] flex items-center justify-center bg-white/50 backdrop-blur-[2px]">
            <svg class="h-12 w-12 animate-spin" viewBox="0 0 50 50">
                <circle cx="25" cy="25" r="20" fill="none" stroke="#dbeafe" stroke-width="5" />
                <circle cx="25" cy="25" r="20" fill="none" stroke="#2563eb" stroke-width="5" stroke-linecap="round" stroke-dasharray="80 200" />
            </svg>
        </div>
    </Transition>
</template>
