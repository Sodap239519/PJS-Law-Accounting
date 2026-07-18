<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Concerns\HandlesMediaAndLinks;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Document;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class DocumentController extends Controller
{
    use HandlesMediaAndLinks;

    public function index(): Response
    {
        $documents = Document::with('category')->latest()->get()
            ->map(fn (Document $d) => [
                'id' => $d->id,
                'title' => $d->title,
                'category' => $d->category?->name,
                'downloads' => $d->downloads,
                'is_active' => $d->is_active,
                'file' => $this->fileInfo($d),
            ]);

        return Inertia::render('Admin/Documents/Index', ['documents' => $documents]);
    }

    public function create(): Response
    {
        return Inertia::render('Admin/Documents/Form', ['categories' => $this->categories()]);
    }

    public function store(Request $request)
    {
        $document = Document::create($this->validated($request));
        $this->syncCover($document, $request, 'file');

        return redirect()->route('admin.documents.index')->with('success', 'อัปโหลดเอกสารเรียบร้อยแล้ว');
    }

    public function edit(Document $document): Response
    {
        return Inertia::render('Admin/Documents/Form', [
            'categories' => $this->categories(),
            'document' => [
                'id' => $document->id,
                'title' => $document->title,
                'description' => $document->description,
                'category_id' => $document->category_id,
                'is_active' => $document->is_active,
                'translations' => $document->translations,
                'file' => $this->fileInfo($document),
            ],
        ]);
    }

    public function update(Request $request, Document $document)
    {
        $document->update($this->validated($request));
        $this->syncCover($document, $request, 'file');

        return redirect()->route('admin.documents.index')->with('success', 'อัปเดตเอกสารเรียบร้อยแล้ว');
    }

    public function destroy(Document $document)
    {
        $document->delete();

        return redirect()->route('admin.documents.index')->with('success', 'ลบเอกสารเรียบร้อยแล้ว');
    }

    private function fileInfo(Document $document): ?array
    {
        $media = $document->getFirstMedia('file');

        return $media ? [
            'url' => $media->getUrl(),
            'name' => $media->file_name,
            'size' => $media->human_readable_size,
        ] : null;
    }

    private function categories(): array
    {
        return Category::query()
            ->where('type', 'document')
            ->orWhereNull('type')
            ->get(['id', 'name'])
            ->toArray();
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'category_id' => ['nullable', 'exists:categories,id'],
            'is_active' => ['boolean'],
            'file' => ['nullable', 'file', 'mimes:pdf,doc,docx,xls,xlsx,ppt,pptx,jpg,jpeg,png', 'max:10240'],
            'remove_file' => ['boolean'],
            'translations' => ['nullable', 'array'],
        ]);
    }
}
