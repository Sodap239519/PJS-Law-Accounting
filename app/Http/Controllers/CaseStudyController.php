<?php

namespace App\Http\Controllers;

use App\Models\CaseStudy;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CaseStudyController extends Controller
{
    public function index(Request $request): View
    {
        $query = CaseStudy::published()
            ->with('category')
            ->orderBy('created_at', 'desc');

        if ($request->has('category')) {
            $category = Category::where('slug', $request->category)
                ->where('type', 'case_study')
                ->where('is_active', true)
                ->first();

            if ($category) {
                $query->where('category_id', $category->id);
            }
        }

        $caseStudies = $query->paginate(9);
        $categories = Category::where('type', 'case_study')
            ->where('is_active', true)
            ->get();

        return view('case-studies.index', compact('caseStudies', 'categories'));
    }

    public function show(string $slug): View
    {
        $caseStudy = CaseStudy::published()
            ->with('category')
            ->where('slug', $slug)
            ->firstOrFail();

        $caseStudy->increment('views');

        $relatedCaseStudies = CaseStudy::published()
            ->where('id', '!=', $caseStudy->id)
            ->where('category_id', $caseStudy->category_id)
            ->limit(3)
            ->get();

        return view('case-studies.show', compact('caseStudy', 'relatedCaseStudies'));
    }
}
