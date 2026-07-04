<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Concerns\HandlesMediaAndLinks;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\NewsRequest;
use App\Models\Category;
use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Inertia\Inertia;
use Inertia\Response;

class NewsController extends Controller
{
    use HandlesMediaAndLinks;

    public function index(Request $request): Response
    {
        $news = News::query()
            ->with('category')
            ->when($request->search, fn ($q, $s) => $q->where('title', 'like', "%{$s}%"))
            ->when($request->status !== null && $request->status !== '', fn ($q) => $q->where('is_published', $request->status === 'published'))
            ->latest()
            ->paginate(12)
            ->withQueryString()
            ->through(fn (News $n) => [
                'id' => $n->id,
                'title' => $n->title,
                'category' => $n->category?->name,
                'is_published' => $n->is_published,
                'published_at' => $n->published_at?->format('d/m/Y'),
                'views' => $n->views,
                'cover' => $n->getFirstMediaUrl('cover'),
            ]);

        return Inertia::render('Admin/News/Index', [
            'news' => $news,
            'filters' => $request->only('search', 'status'),
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('Admin/News/Form', [
            'categories' => $this->categories(),
        ]);
    }

    public function store(NewsRequest $request)
    {
        $news = News::create($this->data($request));

        $this->syncCover($news, $request);
        $this->addFiles($news, $request, 'gallery', 'gallery');
        $this->addFiles($news, $request, 'attachments', 'attachments');
        $this->syncLinks($news, $request);

        return redirect()->route('admin.news.index')->with('success', 'สร้างข่าวเรียบร้อยแล้ว');
    }

    public function edit(News $news): Response
    {
        return Inertia::render('Admin/News/Form', [
            'categories' => $this->categories(),
            'news' => [
                'id' => $news->id,
                'title' => $news->title,
                'slug' => $news->slug,
                'excerpt' => $news->excerpt,
                'content' => $news->content,
                'translations' => $news->translations,
                'category_id' => $news->category_id,
                'is_published' => $news->is_published,
                'published_at' => $news->published_at?->format('Y-m-d\TH:i'),
                ...$this->mediaPayload($news),
            ],
        ]);
    }

    public function update(NewsRequest $request, News $news)
    {
        $news->update($this->data($request));

        $this->deleteRemovedMedia($news, $request);
        $this->syncCover($news, $request);
        $this->addFiles($news, $request, 'gallery', 'gallery');
        $this->addFiles($news, $request, 'attachments', 'attachments');
        $this->syncLinks($news, $request);

        return redirect()->route('admin.news.index')->with('success', 'อัปเดตข่าวเรียบร้อยแล้ว');
    }

    public function destroy(News $news)
    {
        $news->delete();

        return redirect()->route('admin.news.index')->with('success', 'ลบข่าวเรียบร้อยแล้ว');
    }

    private function data(NewsRequest $request): array
    {
        $existing = $request->route('news');
        $slugInput = $request->input('slug');

        // ตอนแก้ไข: ถ้าไม่กรอก slug ใหม่ ให้คง slug เดิม (URL คงที่)
        $slug = ($existing && ! $slugInput)
            ? $existing->slug
            : $this->resolveSlug($slugInput, $request->input('title'), $existing?->id);

        return [
            'title' => $request->input('title'),
            'excerpt' => $request->input('excerpt'),
            'content' => $request->input('content'),
            'translations' => $request->input('translations'),
            'category_id' => $request->input('category_id'),
            'is_published' => $request->boolean('is_published'),
            'published_at' => $request->input('published_at'),
            'slug' => $slug,
        ];
    }

    private function categories(): array
    {
        return Category::where('type', 'news')->where('is_active', true)
            ->orderBy('name')->get(['id', 'name'])->toArray();
    }

    private function resolveSlug(?string $slug, string $title, ?int $ignoreId = null): string
    {
        $base = $slug ? Str::slug($slug) : Str::slug($title);

        if ($base === '') {
            $base = 'news-'.mb_substr(md5($title.microtime()), 0, 8);
        }

        $candidate = $base;
        $i = 2;
        while (News::where('slug', $candidate)->when($ignoreId, fn ($q) => $q->where('id', '!=', $ignoreId))->exists()) {
            $candidate = $base.'-'.$i++;
        }

        return $candidate;
    }
}
