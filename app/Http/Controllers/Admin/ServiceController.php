<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Concerns\HandlesMediaAndLinks;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ServiceRequest;
use App\Models\Service;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class ServiceController extends Controller
{
    use HandlesMediaAndLinks;

    public function index(): Response
    {
        $services = Service::orderBy('sort_order')->orderBy('id')->get()
            ->map(fn (Service $s) => [
                'id' => $s->id,
                'title' => $s->title,
                'group' => $s->group,
                'icon' => $s->icon,
                'sort_order' => $s->sort_order,
                'is_active' => $s->is_active,
                'cover' => $s->getFirstMediaUrl('cover'),
            ]);

        return Inertia::render('Admin/Services/Index', [
            'services' => $services,
        ]);
    }

    public function reorder(Request $request)
    {
        $ids = $request->validate([
            'ids' => ['required', 'array'],
            'ids.*' => ['integer', 'exists:services,id'],
        ])['ids'];

        foreach ($ids as $position => $id) {
            Service::where('id', $id)->update(['sort_order' => $position + 1]);
        }

        return back(status: 303);
    }

    public function create(): Response
    {
        return Inertia::render('Admin/Services/Form');
    }

    public function store(ServiceRequest $request)
    {
        $service = Service::create($this->data($request));
        $this->syncCover($service, $request);

        return redirect()->route('admin.services.index')->with('success', 'สร้างบริการเรียบร้อยแล้ว');
    }

    public function edit(Service $service): Response
    {
        return Inertia::render('Admin/Services/Form', [
            'service' => [
                'id' => $service->id,
                'title' => $service->title,
                'group' => $service->group,
                'icon' => $service->icon,
                'content' => $service->content,
                'translations' => $service->translations,
                'sort_order' => $service->sort_order,
                'is_active' => $service->is_active,
                ...$this->mediaPayload($service, withLinks: false),
            ],
        ]);
    }

    public function update(ServiceRequest $request, Service $service)
    {
        $service->update($this->data($request));
        $this->syncCover($service, $request);

        return redirect()->route('admin.services.index')->with('success', 'อัปเดตบริการเรียบร้อยแล้ว');
    }

    public function destroy(Service $service)
    {
        $service->delete();

        return redirect()->route('admin.services.index')->with('success', 'ลบบริการเรียบร้อยแล้ว');
    }

    private function data(ServiceRequest $request): array
    {
        return [
            'title' => $request->input('title'),
            'group' => $request->input('group'),
            'icon' => $request->input('icon'),
            'content' => $request->input('content'),
            'translations' => $request->input('translations'),
            'sort_order' => $request->filled('sort_order') ? (int) $request->input('sort_order') : null,
            'is_active' => $request->boolean('is_active'),
        ];
    }
}
