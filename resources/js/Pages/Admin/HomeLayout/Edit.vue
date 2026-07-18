<script setup>
import { ref } from 'vue';
import { Head, useForm } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';

const props = defineProps({
    sections: { type: Array, default: () => [] },
});

const form = useForm({
    sections: props.sections.map((s) => ({ ...s })),
});

const dragIndex = ref(null);
const overIndex = ref(null);

const onDragStart = (i) => (dragIndex.value = i);
const onDragOver = (i, e) => {
    e.preventDefault();
    overIndex.value = i;
};
const onDrop = (i) => {
    const from = dragIndex.value;
    dragIndex.value = null;
    overIndex.value = null;
    if (from === null || from === i) return;
    const list = [...form.sections];
    const [moved] = list.splice(from, 1);
    list.splice(i, 0, moved);
    form.sections = list;
};
const onDragEnd = () => {
    dragIndex.value = null;
    overIndex.value = null;
};

const move = (i, dir) => {
    const j = i + dir;
    if (j < 0 || j >= form.sections.length) return;
    const list = [...form.sections];
    [list[i], list[j]] = [list[j], list[i]];
    form.sections = list;
};

const submit = () => {
    form.put(route('admin.home-layout.update'), { preserveScroll: true });
};
</script>

<template>
    <Head title="จัดการหน้าแรก" />
    <AdminLayout>
        <div class="flex flex-wrap items-center justify-between gap-3">
            <h1 class="text-lg font-semibold text-slate-800">จัดการหน้าแรก</h1>
            <button type="button" :disabled="form.processing" class="btn-primary btn-sm" @click="submit">
                <i class="bi bi-check-lg"></i> บันทึก
            </button>
        </div>

        <p class="mb-4 mt-2 rounded-xl border border-pjs-blue/15 bg-pjs-blue/5 px-4 py-2.5 text-sm text-pjs-blue-dark">
            <i class="bi bi-info-circle"></i> ลากเพื่อจัดลำดับ และเปิด/ปิดการแสดงผลแต่ละส่วนบนหน้าแรก — กด <strong>บันทึก</strong> เพื่อใช้งาน
        </p>

        <div class="mx-auto max-w-2xl space-y-2">
            <div
                v-for="(s, i) in form.sections"
                :key="s.key"
                draggable="true"
                class="flex items-center gap-3 rounded-2xl border bg-white p-3.5 shadow-sm transition"
                :class="[
                    dragIndex === i ? 'opacity-40' : 'hover:border-pjs-blue/30',
                    overIndex === i && dragIndex !== i ? 'border-pjs-blue/40 ring-1 ring-inset ring-pjs-blue/40' : 'border-slate-100',
                    !s.visible ? 'bg-slate-50' : '',
                ]"
                @dragstart="onDragStart(i)"
                @dragover="onDragOver(i, $event)"
                @drop="onDrop(i)"
                @dragend="onDragEnd"
            >
                <i class="bi bi-grip-vertical cursor-grab text-lg text-slate-300"></i>

                <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-pjs-blue/10 text-pjs-blue">
                    <i :class="s.icon"></i>
                </span>

                <div class="min-w-0 flex-1">
                    <p class="truncate text-sm font-medium" :class="s.visible ? 'text-slate-800' : 'text-slate-400'">{{ s.label }}</p>
                    <p class="text-[11px]" :class="s.visible ? 'text-green-600' : 'text-slate-400'">
                        <i class="bi" :class="s.visible ? 'bi-eye' : 'bi-eye-slash'"></i> {{ s.visible ? 'แสดงบนหน้าแรก' : 'ซ่อนอยู่' }} · ลำดับที่ {{ i + 1 }}
                    </p>
                </div>

                <!-- ปุ่มเลื่อน (เผื่อจอสัมผัส) -->
                <div class="flex flex-col">
                    <button type="button" class="px-1 text-slate-300 hover:text-pjs-blue disabled:opacity-30" :disabled="i === 0" @click="move(i, -1)"><i class="bi bi-chevron-up text-xs"></i></button>
                    <button type="button" class="px-1 text-slate-300 hover:text-pjs-blue disabled:opacity-30" :disabled="i === form.sections.length - 1" @click="move(i, 1)"><i class="bi bi-chevron-down text-xs"></i></button>
                </div>

                <!-- toggle -->
                <button
                    type="button"
                    class="relative h-6 w-11 shrink-0 rounded-full transition"
                    :class="s.visible ? 'bg-pjs-blue' : 'bg-slate-200'"
                    role="switch"
                    :aria-checked="s.visible"
                    @click="s.visible = !s.visible"
                >
                    <span class="absolute top-0.5 h-5 w-5 rounded-full bg-white shadow transition-all" :class="s.visible ? 'left-[22px]' : 'left-0.5'"></span>
                </button>
            </div>
        </div>
    </AdminLayout>
</template>
