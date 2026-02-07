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
        $newsCount = News::count();
        $documentsCount = Document::count();
        $caseStudiesCount = CaseStudy::count();
        $teamMembersCount = TeamMember::count();
        $unreadContactsCount = Contact::where('is_read', false)->count();

        return view('dashboard', compact(
            'newsCount',
            'documentsCount',
            'caseStudiesCount',
            'teamMembersCount',
            'unreadContactsCount'
        ));
    }
}
