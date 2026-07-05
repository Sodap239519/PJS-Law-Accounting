<script setup>
import { ref, computed } from 'vue';
import { Cropper } from 'vue-advanced-cropper';
import 'vue-advanced-cropper/dist/style.css';

const props = defineProps({
    existing: { type: Object, default: null }, // { id, url, name }
    ratio: { type: Number, default: 16 / 9 },
    label: { type: String, default: 'รูปปก' },
    hint: { type: String, default: '' },
});
const emit = defineEmits(['update:file', 'update:remove']);

const rawImage = ref(null);
const croppedUrl = ref(null);
const removed = ref(false);
const cropperRef = ref(null);
const inputRef = ref(null);

const onSelect = (e) => {
    const file = e.target.files[0];
    if (!file) return;
    const reader = new FileReader();
    reader.onload = () => (rawImage.value = reader.result);
    reader.readAsDataURL(file);
    e.target.value = '';
};

const confirmCrop = () => {
    const result = cropperRef.value?.getResult();
    if (!result?.canvas) return;
    result.canvas.toBlob(
        (blob) => {
            croppedUrl.value = URL.createObjectURL(blob);
            emit('update:file', new File([blob], 'cover.jpg', { type: 'image/jpeg' }));
            emit('update:remove', false);
            removed.value = false;
            rawImage.value = null;
        },
        'image/jpeg',
        0.9,
    );
};

const clearImage = () => {
    croppedUrl.value = null;
    removed.value = true;
    emit('update:file', null);
    emit('update:remove', true);
};

const preview = computed(() => croppedUrl.value || (!removed.value ? props.existing?.url : null) || null);
const boxStyle = computed(() => ({ aspectRatio: String(props.ratio) }));
const ratioLabel = computed(() => (Math.abs(props.ratio - 16 / 9) < 0.01 ? '16:9' : Math.abs(props.ratio - 4 / 5) < 0.01 ? '4:5' : ''));
</script>

<template>
    <div>
        <label class="mb-1 block text-sm font-medium text-slate-600">
            {{ label }}
            <span v-if="ratioLabel" class="ml-1 text-xs text-slate-400">(อัตราส่วน {{ ratioLabel }})</span>
        </label>

        <!-- Cropping mode -->
        <div v-if="rawImage" class="space-y-2">
            <div class="overflow-hidden rounded-lg border bg-gray-900">
                <Cropper
                    ref="cropperRef"
                    :src="rawImage"
                    :stencil-props="{ aspectRatio: ratio }"
                    class="max-h-[360px]"
                />
            </div>
            <div class="flex gap-2">
                <button type="button" class="rounded-lg bg-pjs-blue px-4 py-2 text-sm text-white" @click="confirmCrop">
                    ครอบตัด &amp; ใช้รูปนี้
                </button>
                <button type="button" class="rounded-lg border px-4 py-2 text-sm text-slate-600" @click="rawImage = null">
                    ยกเลิก
                </button>
            </div>
        </div>

        <!-- Preview / picker -->
        <div v-else>
            <div class="relative overflow-hidden rounded-lg border bg-slate-50" :style="boxStyle">
                <img v-if="preview" :src="preview" class="h-full w-full object-cover" />
                <div v-else class="flex h-full items-center justify-center text-sm text-slate-400">ยังไม่มีรูป</div>
            </div>
            <div class="mt-2 flex gap-2">
                <button type="button" class="rounded-lg border px-3 py-1.5 text-sm text-slate-700 hover:bg-slate-50" @click="inputRef.click()">
                    เลือกรูป
                </button>
                <button v-if="preview" type="button" class="rounded-lg border border-red-200 px-3 py-1.5 text-sm text-red-500 hover:bg-red-50" @click="clearImage">
                    ลบรูป
                </button>
                <input ref="inputRef" type="file" accept="image/*" class="hidden" @change="onSelect" />
            </div>
            <p v-if="hint" class="mt-1 text-xs text-slate-400">{{ hint }}</p>
        </div>
    </div>
</template>
