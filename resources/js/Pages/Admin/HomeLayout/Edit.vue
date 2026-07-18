<script setup>
import { ref } from 'vue';
import { Head, useForm } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';

const props = defineProps({
    sections: { type: Array, default: () => [] },
    available: { type: Object, default: () => ({}) },
});

const form = useForm({
    sections: props.sections.map((s) => ({ ...s, items: s.items ? [...s.items] : [] })),
});

const expanded = ref(null); // key ของ section ที่กางตัวเลือกอยู่

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

const toggleItem = (s, id) => {
    const i = s.items.indexOf(id);
    if (i === -1) s.items.push(id);
    else s.items.splice(i, 1);
};

const submit = () => form.put(route('admin.home-layout.update'), { preserveScroll: true });
</script>

<template>
    <Head title="จัดการหน้าแรก" />
    <AdminLayout>
        <div id="form-actions-top" class="flex flex-wrap items-center justify-between gap-3">
            <h1 class="text-lg font-semibold text-slate-800">จัดการหน้าแรก</h1>
            <button type="button" :disabled="form.processing" class="btn-primary btn-sm" @click="submit"><i class="bi bi-check-lg"></i> บันทึก</button>
        </div>

        <p class="mb-4 mt-2 rounded-xl border border-pjs-blue/15 bg-pjs-blue/5 px-4 py-2.5 text-sm text-pjs-blue-dark">
            <i class="bi bi-info-circle"></i> ลากจัดลำดับ · เปิด/ปิดการแสดง · ส่วนที่มีปุ่ม <i class="bi bi-list-check"></i> เลือกได้ว่าจะแสดงรายการไหน — แล้วกด <strong>บันทึก</strong>
        </p>

        <div class="mx-auto max-w-2xl space-y-2">
            <div v-for="(s, i) in form.sections" :key="s.key" class="rounded-2xl border bg-white shadow-sm transition" :class="[overIndex === i && dragIndex !== i ? 'border-pjs-blue/40 ring-1 ring-inset ring-pjs-blue/40' : 'border-slate-100', !s.visible ? 'bg-slate-50' : '']">
                <div
                    draggable="true"
                    class="flex items-center gap-3 p-3.5"
                    :class="dragIndex === i ? 'opacity-40' : ''"
                    @dragstart="onDragStart(i)"
                    @dragover="onDragOver(i, $event)"
                    @drop="onDrop(i)"
                    @dragend="onDragEnd"
                >
                    <i class="bi bi-grip-vertical cursor-grab text-lg text-slate-300"></i>
                    <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-pjs-blue/10 text-pjs-blue"><i :class="s.icon"></i></span>

                    <div class="min-w-0 flex-1">
                        <p class="truncate text-sm font-medium" :class="s.visible ? 'text-slate-800' : 'text-slate-400'">{{ s.label }}</p>
                        <p class="text-[11px]" :class="s.visible ? 'text-green-600' : 'text-slate-400'">
                            <i class="bi" :class="s.visible ? 'bi-eye' : 'bi-eye-slash'"></i> {{ s.visible ? 'แสดง' : 'ซ่อน' }} · ลำดับที่ {{ i + 1 }}
                            <span v-if="s.selectable" class="text-slate-400">· {{ s.mode === 'selected' ? `เลือก ${s.items.length} รายการ` : 'ล่าสุดอัตโนมัติ' }}</span>
                        </p>
                    </div>

                    <!-- ปุ่มเลือกรายการ (เฉพาะ section ที่เลือกได้) -->
                    <button v-if="s.selectable" type="button" class="shrink-0 rounded-lg px-2 py-1 text-xs" :class="expanded === s.key ? 'bg-pjs-blue text-white' : 'text-pjs-blue hover:bg-pjs-blue/10'" @click="expanded = expanded === s.key ? null : s.key">
                        <i class="bi bi-list-check"></i>
                    </button>

                    <div class="flex flex-col">
                        <button type="button" class="px-1 text-slate-300 hover:text-pjs-blue disabled:opacity-30" :disabled="i === 0" @click="move(i, -1)"><i class="bi bi-chevron-up text-xs"></i></button>
                        <button type="button" class="px-1 text-slate-300 hover:text-pjs-blue disabled:opacity-30" :disabled="i === form.sections.length - 1" @click="move(i, 1)"><i class="bi bi-chevron-down text-xs"></i></button>
                    </div>

                    <button type="button" class="relative h-6 w-11 shrink-0 rounded-full transition" :class="s.visible ? 'bg-pjs-blue' : 'bg-slate-200'" role="switch" :aria-checked="s.visible" @click="s.visible = !s.visible">
                        <span class="absolute top-0.5 h-5 w-5 rounded-full bg-white shadow transition-all" :class="s.visible ? 'left-[22px]' : 'left-0.5'"></span>
                    </button>
                </div>

                <!-- ตัวเลือกรายการ -->
                <div v-if="s.selectable && expanded === s.key" class="border-t border-slate-100 p-3.5">
                    <div class="mb-3 inline-flex gap-1 rounded-full bg-slate-100 p-1 text-xs">
                        <button type="button" class="rounded-full px-3 py-1 font-medium transition" :class="s.mode === 'latest' ? 'bg-white text-pjs-blue shadow-sm' : 'text-slate-500'" @click="s.mode = 'latest'">ล่าสุดอัตโนมัติ</button>
                        <button type="button" class="rounded-full px-3 py-1 font-medium transition" :class="s.mode === 'selected' ? 'bg-white text-pjs-blue shadow-sm' : 'text-slate-500'" @click="s.mode = 'selected'">เลือกเอง</button>
                    </div>

                    <div v-if="s.mode === 'selected'" class="max-h-64 space-y-1 overflow-y-auto pr-1">
                        <label v-for="opt in (available[s.key] || [])" :key="opt.id" class="flex cursor-pointer items-center gap-2.5 rounded-lg px-2.5 py-2 text-sm hover:bg-slate-50" :class="s.items.includes(opt.id) ? 'bg-pjs-blue/5' : ''">
                            <input type="checkbox" :checked="s.items.includes(opt.id)" class="rounded" @change="toggleItem(s, opt.id)" />
                            <span class="min-w-0 flex-1 truncate text-slate-700">{{ opt.title }}</span>
                            <span class="shrink-0 text-[11px] text-slate-400">{{ opt.date }}</span>
                        </label>
                        <p v-if="!(available[s.key] || []).length" class="py-4 text-center text-xs text-slate-400">ยังไม่มีรายการที่เผยแพร่</p>
                    </div>
                    <p v-else class="text-xs text-slate-400">ระบบจะแสดงรายการล่าสุดโดยอัตโนมัติ</p>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>
