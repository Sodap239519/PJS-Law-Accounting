<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Concerns\HandlesMediaAndLinks;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AnnouncementRequest;
use App\Models\Announcement;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Inertia\Inertia;
use Inertia\Response;

class AnnouncementController extends Controller
{
    use HandlesMediaAndLinks;

    public function index(Request $request): Response
    {
        $items = Announcement::query()
            ->with('category')
            ->when($request->search, fn ($q, $s) => $q->where('title', 'like', "%{$s}%"))
            ->when($request->status !== null && $request->status !== '', fn ($q) => $q->where('is_published', $request->status === 'published'))
            ->latest()
            ->paginate(12)
            ->withQueryString()
            ->through(fn (Announcement $a) => [
                'id' => $a->id,
                'title' => $a->title,
                'category' => $a->category?->name,
                'is_published' => $a->is_published,
                'published_at' => $a->published_at?->format('d/m/Y'),
                'views' => $a->views,
                'cover' => $a->getFirstMediaUrl('cover'),
            ]);

        return Inertia::render('Admin/Announcements/Index', [
            'announcements' => $items,
            'filters' => $request->only('search', 'status'),
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('Admin/Announcements/Form', [
            'categories' => $this->categories(),
        ]);
    }

    public function store(AnnouncementRequest $request)
    {
        $item = Announcement::create($this->data($request));

        $this->syncCover($item, $request);
        $this->addFiles($item, $request, 'gallery', 'gallery');
        $this->addFiles($item, $request, 'attachments', 'attachments');
        $this->syncLinks($item, $request);

        return redirect()->route('admin.announcements.index')->with('success', 'สร้างประชาสัมพันธ์เรียบร้อยแล้ว');
    }

    public function edit(Announcement $announcement): Response
    {
        return Inertia::render('Admin/Announcements/Form', [
            'categories' => $this->categories(),
            'announcement' => [
                'id' => $announcement->id,
                'title' => $announcement->title,
                'slug' => $announcement->slug,
                'excerpt' => $announcement->excerpt,
                'content' => $announcement->content,
                'category_id' => $announcement->category_id,
                'is_published' => $announcement->is_published,
                'published_at' => $announcement->published_at?->format('Y-m-d\TH:i'),
                ...$this->mediaPayload($announcement),
            ],
        ]);
    }

    public function update(AnnouncementRequest $request, Announcement $announcement)
    {
        $announcement->update($this->data($request));

        $this->deleteRemovedMedia($announcement, $request);
        $this->syncCover($announcement, $request);
        $this->addFiles($announcement, $request, 'gallery', 'gallery');
        $this->addFiles($announcement, $request, 'attachments', 'attachments');
        $this->syncLinks($announcement, $request);

        return redirect()->route('admin.announcements.index')->with('success', 'อัปเดตประชาสัมพันธ์เรียบร้อยแล้ว');
    }

    public function destroy(Announcement $announcement)
    {
        $announcement->delete();

        return redirect()->route('admin.announcements.index')->with('success', 'ลบประชาสัมพันธ์เรียบร้อยแล้ว');
    }

    private function data(AnnouncementRequest $request): array
    {
        $existing = $request->route('announcement');
        $slugInput = $request->input('slug');

        $slug = ($existing && ! $slugInput)
            ? $existing->slug
            : $this->resolveSlug($slugInput, $request->input('title'), $existing?->id);

        return [
            'title' => $request->input('title'),
            'excerpt' => $request->input('excerpt'),
            'content' => $request->input('content'),
            'category_id' => $request->input('category_id'),
            'is_published' => $request->boolean('is_published'),
            'published_at' => $request->input('published_at'),
            'slug' => $slug,
        ];
    }

    private function categories(): array
    {
        return Category::where('type', 'announcement')->where('is_active', true)
            ->orderBy('name')->get(['id', 'name'])->toArray();
    }

    private function resolveSlug(?string $slug, string $title, ?int $ignoreId = null): string
    {
        $base = $slug ? Str::slug($slug) : Str::slug($title);
        if ($base === '') {
            $base = 'pr-'.mb_substr(md5($title.microtime()), 0, 8);
        }

        $candidate = $base;
        $i = 2;
        while (Announcement::where('slug', $candidate)->when($ignoreId, fn ($q) => $q->where('id', '!=', $ignoreId))->exists()) {
            $candidate = $base.'-'.$i++;
        }

        return $candidate;
    }
}
