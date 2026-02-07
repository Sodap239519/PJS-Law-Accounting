<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Illuminate\Support\Facades\Storage;

class DocumentController extends Controller
{
    public function index(Request $request): View
    {
        $query = Document::where('is_active', true)
            ->with('category')
            ->orderBy('created_at', 'desc');

        if ($request->has('category')) {
            $category = Category::where('slug', $request->category)
                ->where('type', 'document')
                ->where('is_active', true)
                ->first();

            if ($category) {
                $query->where('category_id', $category->id);
            }
        }

        $documents = $query->paginate(15);
        $categories = Category::where('type', 'document')
            ->where('is_active', true)
            ->get();

        return view('documents.index', compact('documents', 'categories'));
    }

    public function download(int $id): BinaryFileResponse
    {
        $document = Document::where('is_active', true)
            ->findOrFail($id);

        $document->incrementDownloads();

        return response()->download(
            storage_path('app/' . $document->file_path),
            $document->file_name
        );
    }
}
