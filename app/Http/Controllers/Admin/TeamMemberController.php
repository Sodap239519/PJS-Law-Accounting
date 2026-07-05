<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Concerns\HandlesMediaAndLinks;
use App\Http\Controllers\Controller;
use App\Models\TeamMember;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class TeamMemberController extends Controller
{
    use HandlesMediaAndLinks;

    public function index(): Response
    {
        $members = TeamMember::orderBy('order')->orderBy('id')->get()
            ->map(fn (TeamMember $m) => [
                'id' => $m->id,
                'name' => $m->name,
                'position' => $m->position,
                'is_active' => $m->is_active,
                'photo' => $m->getFirstMediaUrl('photo'),
            ]);

        return Inertia::render('Admin/TeamMembers/Index', ['members' => $members]);
    }

    public function create(): Response
    {
        return Inertia::render('Admin/TeamMembers/Form');
    }

    public function store(Request $request)
    {
        $member = TeamMember::create($this->validated($request));
        $this->syncCover($member, $request, 'photo');

        return redirect()->route('admin.team-members.index')->with('success', 'เพิ่มบุคลากรเรียบร้อยแล้ว');
    }

    public function edit(TeamMember $teamMember): Response
    {
        return Inertia::render('Admin/TeamMembers/Form', [
            'member' => [
                'id' => $teamMember->id,
                'name' => $teamMember->name,
                'position' => $teamMember->position,
                'bio' => $teamMember->bio,
                'socials' => $teamMember->socials ?: [],
                'order' => $teamMember->order,
                'is_active' => $teamMember->is_active,
                'photo' => $teamMember->getFirstMediaUrl('photo') ? ['url' => $teamMember->getFirstMediaUrl('photo')] : null,
            ],
        ]);
    }

    public function update(Request $request, TeamMember $teamMember)
    {
        $teamMember->update($this->validated($request));
        $this->syncCover($teamMember, $request, 'photo');

        return redirect()->route('admin.team-members.index')->with('success', 'อัปเดตบุคลากรเรียบร้อยแล้ว');
    }

    public function destroy(TeamMember $teamMember)
    {
        $teamMember->delete();

        return redirect()->route('admin.team-members.index')->with('success', 'ลบบุคลากรเรียบร้อยแล้ว');
    }

    public function reorder(Request $request)
    {
        $ids = $request->validate([
            'ids' => ['required', 'array'],
            'ids.*' => ['integer', 'exists:team_members,id'],
        ])['ids'];

        foreach ($ids as $position => $id) {
            TeamMember::where('id', $id)->update(['order' => $position + 1]);
        }

        return back(status: 303);
    }

    private function validated(Request $request): array
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'position' => ['required', 'string', 'max:255'],
            'bio' => ['nullable', 'string'],
            'socials' => ['nullable', 'array'],
            'socials.facebook' => ['nullable', 'string', 'max:500'],
            'socials.line' => ['nullable', 'string', 'max:255'],
            'socials.email' => ['nullable', 'string', 'max:255'],
            'socials.phone' => ['nullable', 'string', 'max:100'],
            'order' => ['nullable', 'integer'],
            'is_active' => ['boolean'],
            'photo' => ['nullable', 'image', 'max:5120'],
            'remove_photo' => ['boolean'],
        ]);

        // เก็บเฉพาะช่องทางที่กรอกจริง
        $data['socials'] = array_filter($data['socials'] ?? []);

        return $data;
    }
}
