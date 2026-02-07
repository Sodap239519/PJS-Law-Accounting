<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CaseStudy;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class CaseStudyController extends Controller
{
    public function index()
    {
        $caseStudies = CaseStudy::with('category')->latest()->paginate(15);
        return view('admin.case-studies.index', compact('caseStudies'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.case-studies.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title_th' => 'required|string|max:255',
            'title_en' => 'required|string|max:255',
            'slug' => 'nullable|string|unique:case_studies,slug',
            'client_name' => 'nullable|string|max:255',
            'challenge_th' => 'nullable|string',
            'challenge_en' => 'nullable|string',
            'solution_th' => 'nullable|string',
            'solution_en' => 'nullable|string',
            'result_th' => 'nullable|string',
            'result_en' => 'nullable|string',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'category_id' => 'nullable|exists:categories,id',
            'is_published' => 'boolean',
        ]);

        $validated['slug'] = $validated['slug'] ?? Str::slug($validated['title_en']);

        if ($request->hasFile('featured_image')) {
            $validated['featured_image'] = $request->file('featured_image')->store('case-studies', 'public');
        }

        CaseStudy::create($validated);

        return redirect()->route('admin.case-studies.index')
            ->with('success', 'Case study created successfully.');
    }

    public function show(string $id)
    {
        $caseStudy = CaseStudy::with('category')->findOrFail($id);
        return view('admin.case-studies.show', compact('caseStudy'));
    }

    public function edit(string $id)
    {
        $caseStudy = CaseStudy::findOrFail($id);
        $categories = Category::all();
        return view('admin.case-studies.edit', compact('caseStudy', 'categories'));
    }

    public function update(Request $request, string $id)
    {
        $caseStudy = CaseStudy::findOrFail($id);

        $validated = $request->validate([
            'title_th' => 'required|string|max:255',
            'title_en' => 'required|string|max:255',
            'slug' => 'nullable|string|unique:case_studies,slug,' . $id,
            'client_name' => 'nullable|string|max:255',
            'challenge_th' => 'nullable|string',
            'challenge_en' => 'nullable|string',
            'solution_th' => 'nullable|string',
            'solution_en' => 'nullable|string',
            'result_th' => 'nullable|string',
            'result_en' => 'nullable|string',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'category_id' => 'nullable|exists:categories,id',
            'is_published' => 'boolean',
        ]);

        $validated['slug'] = $validated['slug'] ?? Str::slug($validated['title_en']);

        if ($request->hasFile('featured_image')) {
            if ($caseStudy->featured_image) {
                Storage::disk('public')->delete($caseStudy->featured_image);
            }
            $validated['featured_image'] = $request->file('featured_image')->store('case-studies', 'public');
        }

        $caseStudy->update($validated);

        return redirect()->route('admin.case-studies.index')
            ->with('success', 'Case study updated successfully.');
    }

    public function destroy(string $id)
    {
        $caseStudy = CaseStudy::findOrFail($id);

        if ($caseStudy->featured_image) {
            Storage::disk('public')->delete($caseStudy->featured_image);
        }

        $caseStudy->delete();

        return redirect()->route('admin.case-studies.index')
            ->with('success', 'Case study deleted successfully.');
    }
}
