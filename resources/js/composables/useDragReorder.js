import { ref, watch } from 'vue';
import { router } from '@inertiajs/vue3';

/**
 * ลากจัดลำดับรายการด้วย native HTML5 drag-and-drop (ไม่ต้องพึ่ง npm)
 * ใช้ซ้ำได้กับทุกโมดูลที่มี sort_order (บริการ/ทีมงาน/แบนเนอร์ ฯลฯ)
 *
 * @param {Array}  source    รายการเริ่มต้น (แต่ละตัวต้องมี id)
 * @param {String} routeName ชื่อ route สำหรับบันทึกลำดับ (POST { ids: [...] })
 */
export function useDragReorder(source, routeName) {
    const items = ref([...source]);
    const dragIndex = ref(null);
    const overIndex = ref(null);
    const saving = ref(false);

    // ซิงก์เมื่อ props เปลี่ยน (เช่น หลังลบรายการ)
    watch(
        () => source,
        (val) => {
            if (dragIndex.value === null) items.value = [...val];
        },
        { deep: true },
    );

    const onDragStart = (index) => {
        dragIndex.value = index;
    };

    const onDragOver = (index, event) => {
        event.preventDefault();
        overIndex.value = index;
    };

    const onDrop = (index) => {
        const from = dragIndex.value;
        reset();
        if (from === null || from === index) return;

        const list = [...items.value];
        const [moved] = list.splice(from, 1);
        list.splice(index, 0, moved);
        items.value = list;

        saving.value = true;
        router.post(
            route(routeName),
            { ids: list.map((x) => x.id) },
            {
                preserveScroll: true,
                preserveState: true,
                onFinish: () => (saving.value = false),
            },
        );
    };

    const onDragEnd = () => reset();

    const reset = () => {
        dragIndex.value = null;
        overIndex.value = null;
    };

    return { items, dragIndex, overIndex, saving, onDragStart, onDragOver, onDrop, onDragEnd };
}
