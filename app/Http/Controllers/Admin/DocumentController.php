<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Document;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DocumentController extends Controller
{
    public function index()
    {
        $documents = Document::with('category')->latest()->paginate(15);
        return view('admin.documents.index', compact('documents'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.documents.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title_th' => 'required|string|max:255',
            'title_en' => 'required|string|max:255',
            'description_th' => 'nullable|string',
            'description_en' => 'nullable|string',
            'file' => 'required|file|mimes:pdf,doc,docx,xls,xlsx|max:10240',
            'category_id' => 'nullable|exists:categories,id',
            'is_active' => 'boolean',
        ]);

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $validated['file_path'] = $file->store('documents', 'public');
            $validated['file_name'] = $file->getClientOriginalName();
            $validated['file_size'] = $file->getSize();
        }

        Document::create($validated);

        return redirect()->route('admin.documents.index')
            ->with('success', 'Document uploaded successfully.');
    }

    public function show(string $id)
    {
        $document = Document::with('category')->findOrFail($id);
        return view('admin.documents.show', compact('document'));
    }

    public function edit(string $id)
    {
        $document = Document::findOrFail($id);
        $categories = Category::all();
        return view('admin.documents.edit', compact('document', 'categories'));
    }

    public function update(Request $request, string $id)
    {
        $document = Document::findOrFail($id);

        $validated = $request->validate([
            'title_th' => 'required|string|max:255',
            'title_en' => 'required|string|max:255',
            'description_th' => 'nullable|string',
            'description_en' => 'nullable|string',
            'file' => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx|max:10240',
            'category_id' => 'nullable|exists:categories,id',
            'is_active' => 'boolean',
        ]);

        if ($request->hasFile('file')) {
            if ($document->file_path) {
                Storage::disk('public')->delete($document->file_path);
            }
            
            $file = $request->file('file');
            $validated['file_path'] = $file->store('documents', 'public');
            $validated['file_name'] = $file->getClientOriginalName();
            $validated['file_size'] = $file->getSize();
        }

        $document->update($validated);

        return redirect()->route('admin.documents.index')
            ->with('success', 'Document updated successfully.');
    }

    public function destroy(string $id)
    {
        $document = Document::findOrFail($id);

        if ($document->file_path) {
            Storage::disk('public')->delete($document->file_path);
        }

        $document->delete();

        return redirect()->route('admin.documents.index')
            ->with('success', 'Document deleted successfully.');
    }
}
