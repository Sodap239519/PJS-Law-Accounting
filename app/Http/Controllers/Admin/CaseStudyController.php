<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Concerns\HandlesMediaAndLinks;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CaseStudyRequest;
use App\Models\CaseStudy;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Inertia\Inertia;
use Inertia\Response;

class CaseStudyController extends Controller
{
    use HandlesMediaAndLinks;

    public function index(Request $request): Response
    {
        $items = CaseStudy::query()
            ->with('category')
            ->when($request->search, fn ($q, $s) => $q->where('title', 'like', "%{$s}%"))
            ->when($request->status !== null && $request->status !== '', fn ($q) => $q->where('is_published', $request->status === 'published'))
            ->latest()
            ->paginate(12)
            ->withQueryString()
            ->through(fn (CaseStudy $c) => [
                'id' => $c->id,
                'title' => $c->title,
                'client_name' => $c->client_name,
                'category' => $c->category?->name,
                'is_published' => $c->is_published,
                'views' => $c->views,
                'cover' => $c->getFirstMediaUrl('cover'),
            ]);

        return Inertia::render('Admin/CaseStudies/Index', [
            'cases' => $items,
            'filters' => $request->only('search', 'status'),
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('Admin/CaseStudies/Form', [
            'categories' => $this->categories(),
        ]);
    }

    public function store(CaseStudyRequest $request)
    {
        $item = CaseStudy::create($this->data($request));

        $this->syncCover($item, $request);
        $this->addFiles($item, $request, 'gallery', 'gallery');
        $this->addFiles($item, $request, 'attachments', 'attachments');
        $this->syncLinks($item, $request);

        return redirect()->route('admin.case-studies.index')->with('success', 'สร้างคดีตัวอย่างเรียบร้อยแล้ว');
    }

    public function edit(CaseStudy $caseStudy): Response
    {
        return Inertia::render('Admin/CaseStudies/Form', [
            'categories' => $this->categories(),
            'caseStudy' => [
                'id' => $caseStudy->id,
                'title' => $caseStudy->title,
                'slug' => $caseStudy->slug,
                'client_name' => $caseStudy->client_name,
                'content' => $caseStudy->content,
                'translations' => $caseStudy->translations,
                'category_id' => $caseStudy->category_id,
                'is_published' => $caseStudy->is_published,
                ...$this->mediaPayload($caseStudy),
            ],
        ]);
    }

    public function update(CaseStudyRequest $request, CaseStudy $caseStudy)
    {
        $caseStudy->update($this->data($request));

        $this->deleteRemovedMedia($caseStudy, $request);
        $this->syncCover($caseStudy, $request);
        $this->addFiles($caseStudy, $request, 'gallery', 'gallery');
        $this->addFiles($caseStudy, $request, 'attachments', 'attachments');
        $this->syncLinks($caseStudy, $request);

        return redirect()->route('admin.case-studies.index')->with('success', 'อัปเดตคดีตัวอย่างเรียบร้อยแล้ว');
    }

    public function destroy(CaseStudy $caseStudy)
    {
        $caseStudy->delete();

        return redirect()->route('admin.case-studies.index')->with('success', 'ลบคดีตัวอย่างเรียบร้อยแล้ว');
    }

    private function data(CaseStudyRequest $request): array
    {
        $existing = $request->route('case_study');
        $slugInput = $request->input('slug');

        $slug = ($existing && ! $slugInput)
            ? $existing->slug
            : $this->resolveSlug($slugInput, $request->input('title'), $existing?->id);

        return [
            'title' => $request->input('title'),
            'client_name' => $request->input('client_name'),
            'content' => $request->input('content'),
            'translations' => $request->input('translations'),
            'category_id' => $request->input('category_id'),
            'is_published' => $request->boolean('is_published'),
            'slug' => $slug,
        ];
    }

    private function categories(): array
    {
        return Category::where('type', 'case_study')->where('is_active', true)
            ->orderBy('name')->get(['id', 'name'])->toArray();
    }

    private function resolveSlug(?string $slug, string $title, ?int $ignoreId = null): string
    {
        $base = $slug ? Str::slug($slug) : Str::slug($title);
        if ($base === '') {
            $base = 'case-'.mb_substr(md5($title.microtime()), 0, 8);
        }

        $candidate = $base;
        $i = 2;
        while (CaseStudy::where('slug', $candidate)->when($ignoreId, fn ($q) => $q->where('id', '!=', $ignoreId))->exists()) {
            $candidate = $base.'-'.$i++;
        }

        return $candidate;
    }
}
