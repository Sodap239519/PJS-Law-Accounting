<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Concerns\HandlesMediaAndLinks;
use App\Http\Controllers\Controller;
use App\Models\Banner;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class BannerController extends Controller
{
    use HandlesMediaAndLinks;

    public function index(): Response
    {
        $banners = Banner::orderBy('sort_order')->orderBy('id')->get()
            ->map(fn (Banner $b) => [
                'id' => $b->id,
                'title' => $b->title,
                'subtitle' => $b->subtitle,
                'link_url' => $b->link_url,
                'is_active' => $b->is_active,
                'image' => $b->getFirstMediaUrl('image'),
            ]);

        return Inertia::render('Admin/Banners/Index', ['banners' => $banners]);
    }

    public function create(): Response
    {
        return Inertia::render('Admin/Banners/Form');
    }

    public function store(Request $request)
    {
        $banner = Banner::create($this->validated($request));
        $this->syncCover($banner, $request, 'image');

        return redirect()->route('admin.banners.index')->with('success', 'เพิ่มแบนเนอร์เรียบร้อยแล้ว');
    }

    public function edit(Banner $banner): Response
    {
        return Inertia::render('Admin/Banners/Form', [
            'banner' => [
                'id' => $banner->id,
                'title' => $banner->title,
                'subtitle' => $banner->subtitle,
                'link_url' => $banner->link_url,
                'sort_order' => $banner->sort_order,
                'is_active' => $banner->is_active,
                'image' => $banner->getFirstMediaUrl('image') ? ['url' => $banner->getFirstMediaUrl('image')] : null,
            ],
        ]);
    }

    public function update(Request $request, Banner $banner)
    {
        $banner->update($this->validated($request));
        $this->syncCover($banner, $request, 'image');

        return redirect()->route('admin.banners.index')->with('success', 'อัปเดตแบนเนอร์เรียบร้อยแล้ว');
    }

    public function destroy(Banner $banner)
    {
        $banner->delete();

        return redirect()->route('admin.banners.index')->with('success', 'ลบแบนเนอร์เรียบร้อยแล้ว');
    }

    public function reorder(Request $request)
    {
        $ids = $request->validate([
            'ids' => ['required', 'array'],
            'ids.*' => ['integer', 'exists:banners,id'],
        ])['ids'];

        foreach ($ids as $position => $id) {
            Banner::where('id', $id)->update(['sort_order' => $position + 1]);
        }

        return back(status: 303);
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'title' => ['nullable', 'string', 'max:255'],
            'subtitle' => ['nullable', 'string', 'max:255'],
            'link_url' => ['nullable', 'string', 'max:500'],
            'sort_order' => ['nullable', 'integer'],
            'is_active' => ['boolean'],
            'image' => ['nullable', 'image', 'max:5120'],
            'remove_image' => ['boolean'],
        ]);
    }
}
