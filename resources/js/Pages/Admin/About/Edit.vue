<script setup>
import { ref } from 'vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import RichEditor from '@/Components/Admin/RichEditor.vue';

const props = defineProps({
    about: { type: Object, default: () => ({}) },
    positions: { type: Object, default: () => ({}) },
});

const form = useForm({
    intro_title: props.about.intro_title || '',
    intro_subtitle: props.about.intro_subtitle || '',
    vision: props.about.vision || '',
    mission: props.about.mission || '',
    sections: (props.about.sections || []).map((s) => ({ ...s })),
});

const emptySection = () => ({ icon: 'bi bi-star', heading: '', content: '', image: '', position: 'left' });
const addSection = () => form.sections.push(emptySection());
const removeSection = (i) => form.sections.splice(i, 1);

// drag เรียง section
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
    const [m] = form.sections.splice(from, 1);
    form.sections.splice(i, 0, m);
};
const onDragEnd = () => {
    dragIndex.value = null;
    overIndex.value = null;
};

// อัปโหลดรูป section (ใช้ปลายทางเดียวกับ editor)
const uploadSectionImage = (section, e) => {
    const file = e.target.files[0];
    if (!file) return;
    const fd = new FormData();
    fd.append('file', file);
    const xsrf = decodeURIComponent((document.cookie.match(/XSRF-TOKEN=([^;]+)/) || [])[1] || '');
    fetch('/admin/editor/image', { method: 'POST', headers: { 'X-XSRF-TOKEN': xsrf, Accept: 'application/json' }, body: fd })
        .then((r) => r.json())
        .then((d) => (section.image = d.location));
    e.target.value = '';
};

// เติมเนื้อหาตัวอย่าง (ตรงกับที่แสดงบนหน้าเว็บตอนนี้)
const prefillDefaults = () => {
    if (form.sections.length && !confirm('จะแทนที่เนื้อหาปัจจุบันด้วยตัวอย่างเริ่มต้น?')) return;
    form.intro_title = 'บริษัท PJS กฎหมายและการบัญชี จำกัด';
    form.intro_subtitle = 'ผู้เชี่ยวชาญด้านกฎหมายและบัญชีที่คุณไว้วางใจ';
    form.vision = 'ความเชี่ยวชาญเหนือระดับ เปลี่ยนเรื่องกฎหมายให้เป็นเรื่องง่าย เพื่อทุกความสำเร็จของคุณและธุรกิจ';
    form.mission = 'ให้บริการด้านกฎหมายและบัญชีอย่างมืออาชีพ ด้วยทีมงานที่มีความรู้และประสบการณ์';
    form.sections = [
        {
            icon: 'bi bi-briefcase',
            heading: 'ด้านกฎหมาย',
            content: '<p>ทางบริษัท PJS กฎหมายและการบัญชี จำกัด คือ บริษัทกฎหมายที่ยึดมั่นในความถูกต้องและรักษาผลประโยชน์สูงสุดของลูกความเป็นสำคัญ ด้วยทีมทนายความผู้เชี่ยวชาญที่มีประสบการณ์สะสมมาอย่างยาวนาน</p><p>เราให้บริการครอบคลุมตั้งแต่งานที่ปรึกษาทั่วไป การร่างสัญญา สืบทรัพย์ ไปจนถึงการว่าความในศาล</p>',
            image: '/frontend/images/portfolio/law.jpg',
            position: 'right',
        },
        {
            icon: 'bi bi-graph-up-arrow',
            heading: 'ด้านบัญชี',
            content: '<p>บริษัท PJS กฎหมายและการบัญชี จำกัด มีผู้เชี่ยวชาญทางด้านบัญชีและภาษี ด้วยทีมงานที่ประกอบด้วยผู้สอบบัญชีรับอนุญาต (CPA) และที่ปรึกษาทางบัญชีมืออาชีพ</p><p>เราให้บริการดูแลบัญชีแบบครบวงจร ตั้งแต่วางระบบบัญชีดิจิทัล จัดทำภาษีรายเดือน ไปจนถึงการวางแผนภาษีเชิงรุก</p>',
            image: '/frontend/images/main/accounting.jpg',
            position: 'left',
        },
    ];
};

const submit = () => {
    form.transform((d) => ({ ...d, _method: 'put' })).post(route('admin.about.update'));
};
</script>

<template>
    <Head title="เกี่ยวกับเรา" />
    <AdminLayout>
        <form class="space-y-6" @submit.prevent="submit">
            <div class="flex flex-wrap items-center justify-between gap-3">
                <h1 class="text-lg font-semibold text-slate-800">หน้าเกี่ยวกับเรา</h1>
                <div class="pjs-card flex items-center gap-2 py-2 pl-4 pr-2">
                    <button type="button" class="btn-soft btn-sm" @click="prefillDefaults"><i class="bi bi-magic"></i> เติมตัวอย่าง</button>
                    <Link :href="route('admin.dashboard')" class="btn-outline btn-sm">ยกเลิก</Link>
                    <button type="submit" :disabled="form.processing" class="btn-primary btn-sm">บันทึก</button>
                </div>
            </div>

            <div class="grid gap-6 lg:grid-cols-3">
                <!-- LEFT: builder -->
                <div class="space-y-5 lg:col-span-2">
                    <!-- Intro -->
                    <div class="rounded-2xl border border-slate-100 bg-white p-5 shadow-sm">
                        <h3 class="mb-3 text-sm font-semibold text-slate-700">ส่วนหัว</h3>
                        <label class="field-label">หัวข้อหลัก (ชื่อบริษัท)</label>
                        <input v-model="form.intro_title" type="text" class="field" placeholder="บริษัท PJS กฎหมายและการบัญชี จำกัด" />
                        <label class="field-label mt-3">คำโปรย</label>
                        <input v-model="form.intro_subtitle" type="text" class="field" placeholder="ผู้เชี่ยวชาญด้านกฎหมายและบัญชีที่คุณไว้วางใจ" />
                    </div>

                    <!-- Vision / Mission -->
                    <div class="rounded-2xl border border-slate-100 bg-white p-5 shadow-sm">
                        <h3 class="mb-3 text-sm font-semibold text-slate-700">วิสัยทัศน์ / พันธกิจ <span class="text-xs font-normal text-slate-400">(เว้นว่างเพื่อซ่อน)</span></h3>
                        <div class="grid gap-4 sm:grid-cols-2">
                            <div>
                                <label class="field-label"><i class="bi bi-eye text-pjs-blue"></i> วิสัยทัศน์</label>
                                <textarea v-model="form.vision" rows="3" class="field"></textarea>
                            </div>
                            <div>
                                <label class="field-label"><i class="bi bi-bullseye text-red-500"></i> พันธกิจ</label>
                                <textarea v-model="form.mission" rows="3" class="field"></textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Sections -->
                    <div class="rounded-2xl border border-slate-100 bg-white p-5 shadow-sm">
                        <div class="mb-3 flex items-center justify-between">
                            <h3 class="text-sm font-semibold text-slate-700">ส่วนเนื้อหา (Section)</h3>
                            <button type="button" class="btn-soft btn-sm" @click="addSection"><i class="bi bi-plus-lg"></i> เพิ่ม Section</button>
                        </div>

                        <div v-if="!form.sections.length" class="rounded-xl border border-dashed border-slate-200 py-8 text-center text-sm text-slate-400">
                            ยังไม่มี Section — กด “เพิ่ม Section” หรือ “เติมตัวอย่าง”
                        </div>

                        <div class="space-y-4">
                            <div
                                v-for="(s, i) in form.sections"
                                :key="i"
                                class="rounded-xl border bg-slate-50/60 p-4 transition-colors"
                                :class="overIndex === i && dragIndex !== i ? 'ring-1 ring-inset ring-pjs-blue/40 border-pjs-blue/30' : 'border-slate-200'"
                                @dragover="onDragOver(i, $event)"
                                @drop="onDrop(i)"
                            >
                                <div class="mb-3 flex items-center gap-2" draggable="true" @dragstart="onDragStart(i)" @dragend="onDragEnd">
                                    <i class="bi bi-grip-vertical cursor-grab text-slate-400"></i>
                                    <span class="text-xs font-semibold text-slate-500">Section {{ i + 1 }}</span>
                                    <select v-model="s.position" class="field w-auto py-1 text-xs">
                                        <option v-for="(label, key) in positions" :key="key" :value="key">{{ label }}</option>
                                    </select>
                                    <button type="button" class="ml-auto text-red-400 hover:text-red-600" @click="removeSection(i)"><i class="bi bi-trash"></i></button>
                                </div>

                                <div class="grid gap-3 sm:grid-cols-[auto_1fr]">
                                    <div>
                                        <label class="field-label text-xs">ไอคอน <i :class="s.icon" class="ml-1 text-pjs-blue"></i></label>
                                        <input v-model="s.icon" type="text" placeholder="bi bi-briefcase" class="field w-40 text-xs" />
                                    </div>
                                    <div>
                                        <label class="field-label text-xs">หัวข้อ</label>
                                        <input v-model="s.heading" type="text" class="field text-sm" placeholder="เช่น ด้านกฎหมาย" />
                                    </div>
                                </div>

                                <label class="field-label mt-3 text-xs">เนื้อหา</label>
                                <RichEditor v-model="s.content" :height="420" />

                                <label class="field-label mt-3 text-xs">รูปประกอบ</label>
                                <div class="flex items-center gap-3">
                                    <div class="h-16 w-24 shrink-0 overflow-hidden rounded-lg bg-slate-200">
                                        <img v-if="s.image" :src="s.image" class="h-full w-full object-cover" />
                                        <div v-else class="flex h-full items-center justify-center text-slate-400"><i class="bi bi-image"></i></div>
                                    </div>
                                    <label class="btn-outline btn-sm cursor-pointer">
                                        <i class="bi bi-upload"></i> อัปโหลดรูป
                                        <input type="file" accept="image/*" class="hidden" @change="(e) => uploadSectionImage(s, e)" />
                                    </label>
                                    <button v-if="s.image" type="button" class="text-xs text-red-400 hover:text-red-600" @click="s.image = ''">ลบรูป</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- RIGHT: live preview -->
                <div class="space-y-5">
                    <div class="rounded-2xl border border-slate-100 bg-white p-4 shadow-sm">
                        <p class="mb-2 flex items-center gap-1.5 text-xs font-semibold text-slate-500"><i class="bi bi-eye text-pjs-blue/70"></i> ตัวอย่างการแสดงผล</p>
                        <div class="max-h-[70vh] space-y-4 overflow-auto rounded-xl border border-slate-100 bg-white p-3 thin-scroll">
                            <!-- intro -->
                            <div class="text-center">
                                <h4 class="font-bold text-slate-800">{{ form.intro_title || 'ชื่อบริษัท' }}</h4>
                                <p class="text-xs text-slate-400">{{ form.intro_subtitle }}</p>
                            </div>

                            <!-- vision/mission -->
                            <div v-if="form.vision || form.mission" class="grid grid-cols-2 gap-2">
                                <div v-if="form.vision" class="rounded-lg bg-slate-50 p-2 text-center">
                                    <i class="bi bi-eye text-pjs-blue"></i>
                                    <p class="text-[11px] font-semibold text-slate-600">วิสัยทัศน์</p>
                                    <p class="text-[10px] leading-snug text-slate-400">{{ form.vision }}</p>
                                </div>
                                <div v-if="form.mission" class="rounded-lg bg-slate-50 p-2 text-center">
                                    <i class="bi bi-bullseye text-red-500"></i>
                                    <p class="text-[11px] font-semibold text-slate-600">พันธกิจ</p>
                                    <p class="text-[10px] leading-snug text-slate-400">{{ form.mission }}</p>
                                </div>
                            </div>

                            <!-- sections -->
                            <div v-for="(s, i) in form.sections" :key="i" class="border-t border-slate-100 pt-3">
                                <div :class="s.position === 'full' ? '' : 'flex gap-2 ' + (s.position === 'right' ? 'flex-row-reverse' : '')">
                                    <img v-if="s.image && s.position !== 'full'" :src="s.image" class="h-16 w-20 shrink-0 rounded-md object-cover" />
                                    <div class="min-w-0 flex-1">
                                        <p class="text-xs font-bold text-slate-700"><i :class="s.icon" class="mr-1 text-pjs-gold-dark"></i>{{ s.heading || '(หัวข้อ)' }}</p>
                                        <div class="prose prose-sm mt-1 max-w-none text-[11px] leading-snug text-slate-500" v-html="s.content"></div>
                                        <img v-if="s.image && s.position === 'full'" :src="s.image" class="mt-2 w-full rounded-md object-cover" />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <p class="mt-2 text-[11px] text-slate-400">อัปเดตอัตโนมัติเมื่อแก้ไข</p>
                    </div>
                </div>
            </div>
        </form>
    </AdminLayout>
</template>
