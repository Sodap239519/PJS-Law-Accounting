<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactChannel;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class ContactChannelController extends Controller
{
    /** ประเภทช่องทาง + ไอคอนเริ่มต้น */
    public const TYPES = [
        'phone' => ['label' => 'โทรศัพท์', 'icon' => 'bi bi-telephone'],
        'email' => ['label' => 'อีเมล', 'icon' => 'bi bi-envelope'],
        'line' => ['label' => 'LINE', 'icon' => 'bi bi-line'],
        'facebook' => ['label' => 'Facebook', 'icon' => 'bi bi-facebook'],
        'instagram' => ['label' => 'Instagram', 'icon' => 'bi bi-instagram'],
        'tiktok' => ['label' => 'TikTok', 'icon' => 'bi bi-tiktok'],
        'youtube' => ['label' => 'YouTube', 'icon' => 'bi bi-youtube'],
        'address' => ['label' => 'ที่อยู่', 'icon' => 'bi bi-geo-alt'],
        'map' => ['label' => 'แผนที่ (ลิงก์)', 'icon' => 'bi bi-map'],
    ];

    public function index(): Response
    {
        $channels = ContactChannel::orderBy('sort_order')->orderBy('id')->get()
            ->map(fn (ContactChannel $c) => [
                'id' => $c->id,
                'type' => $c->type,
                'type_label' => self::TYPES[$c->type]['label'] ?? $c->type,
                'label' => $c->label,
                'value' => $c->value,
                'icon' => $c->icon,
                'is_active' => $c->is_active,
            ]);

        return Inertia::render('Admin/ContactChannels/Index', [
            'channels' => $channels,
            'types' => self::TYPES,
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('Admin/ContactChannels/Form', ['types' => self::TYPES]);
    }

    public function store(Request $request)
    {
        ContactChannel::create($this->validated($request));

        return redirect()->route('admin.contact-channels.index')->with('success', 'เพิ่มช่องทางติดต่อเรียบร้อยแล้ว');
    }

    public function edit(ContactChannel $contactChannel): Response
    {
        return Inertia::render('Admin/ContactChannels/Form', [
            'types' => self::TYPES,
            'channel' => [
                'id' => $contactChannel->id,
                'type' => $contactChannel->type,
                'label' => $contactChannel->label,
                'value' => $contactChannel->value,
                'icon' => $contactChannel->icon,
                'sort_order' => $contactChannel->sort_order,
                'is_active' => $contactChannel->is_active,
                'translations' => $contactChannel->translations,
            ],
        ]);
    }

    public function update(Request $request, ContactChannel $contactChannel)
    {
        $contactChannel->update($this->validated($request));

        return redirect()->route('admin.contact-channels.index')->with('success', 'อัปเดตช่องทางติดต่อเรียบร้อยแล้ว');
    }

    public function destroy(ContactChannel $contactChannel)
    {
        $contactChannel->delete();

        return redirect()->route('admin.contact-channels.index')->with('success', 'ลบช่องทางติดต่อเรียบร้อยแล้ว');
    }

    public function reorder(Request $request)
    {
        $ids = $request->validate([
            'ids' => ['required', 'array'],
            'ids.*' => ['integer', 'exists:contact_channels,id'],
        ])['ids'];

        foreach ($ids as $position => $id) {
            ContactChannel::where('id', $id)->update(['sort_order' => $position + 1]);
        }

        return back(status: 303);
    }

    private function validated(Request $request): array
    {
        $data = $request->validate([
            'type' => ['required', 'string', 'in:'.implode(',', array_keys(self::TYPES))],
            'label' => ['nullable', 'string', 'max:255'],
            'value' => ['required', 'string', 'max:1000'],
            'icon' => ['nullable', 'string', 'max:100'],
            'sort_order' => ['nullable', 'integer'],
            'is_active' => ['boolean'],
            'translations' => ['nullable', 'array'],
        ]);

        // ใส่ไอคอนเริ่มต้นตามประเภทหากไม่ได้ระบุ
        if (empty($data['icon'])) {
            $data['icon'] = self::TYPES[$data['type']]['icon'] ?? null;
        }

        return $data;
    }
}
