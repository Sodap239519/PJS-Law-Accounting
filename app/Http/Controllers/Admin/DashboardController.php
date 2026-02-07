<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\News;
use App\Models\Document;
use App\Models\CaseStudy;
use App\Models\TeamMember;
use App\Models\Contact;

class DashboardController extends Controller
{
    public function index()
    {
        $statistics = [
            'news_count' => News::count(),
            'documents_count' => Document::count(),
            'case_studies_count' => CaseStudy::count(),
            'team_members_count' => TeamMember::count(),
            'unread_contacts_count' => Contact::where('is_read', false)->count(),
        ];

        return view('admin.dashboard.index', compact('statistics'));
    }
}
