<?php

namespace App\Http\Controllers;

use App\Models\TeamMember;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TeamController extends Controller
{
    public function index(): View
    {
        $teamMembers = TeamMember::where('is_active', true)
            ->orderBy('order')
            ->get();

        return view('team.index', compact('teamMembers'));
    }
}
