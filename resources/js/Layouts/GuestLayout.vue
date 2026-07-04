<script setup>
// พื้นหลังนุ่มโทนน้ำเงินโมเดิร์น สำหรับหน้า auth ทั้งหมด
</script>

<template>
    <div class="relative flex min-h-screen items-center justify-center overflow-hidden bg-pjs-bg px-4 py-10">
        <!-- decorative blobs -->
        <div class="pointer-events-none absolute -left-24 -top-24 h-72 w-72 rounded-full bg-pjs-blue/10"></div>
        <div class="pointer-events-none absolute -bottom-32 -right-24 h-96 w-96 rounded-full bg-pjs-blue/10"></div>
        <div class="pointer-events-none absolute left-1/2 top-10 h-40 w-40 -translate-x-1/2 rounded-full bg-pjs-blue/5"></div>

        <div class="relative w-full max-w-md">
            <slot />
        </div>
    </div>
</template>
