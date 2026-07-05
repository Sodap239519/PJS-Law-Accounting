<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use Inertia\Inertia;
use Inertia\Response;

class UserController extends Controller
{
    public const ROLES = [
        User::ROLE_ADMIN => 'ผู้ดูแลระบบ',
        User::ROLE_SUPER_ADMIN => 'ผู้ดูแลระบบสูงสุด',
    ];

    public function index(): Response
    {
        $users = User::orderBy('name')->get()
            ->map(fn (User $u) => [
                'id' => $u->id,
                'name' => $u->name,
                'email' => $u->email,
                'role' => $u->role,
                'role_label' => self::ROLES[$u->role] ?? $u->role,
                'avatar' => $u->avatar_url,
                'is_self' => $u->id === request()->user()->id,
            ]);

        return Inertia::render('Admin/Users/Index', [
            'users' => $users,
            'roles' => self::ROLES,
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('Admin/Users/Form', ['roles' => self::ROLES]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'confirmed', Password::defaults()],
            'role' => ['required', Rule::in(array_keys(self::ROLES))],
        ]);

        $data['password'] = Hash::make($data['password']);
        User::create($data);

        return redirect()->route('admin.users.index')->with('success', 'เพิ่มผู้ใช้เรียบร้อยแล้ว');
    }

    public function edit(User $user): Response
    {
        return Inertia::render('Admin/Users/Form', [
            'roles' => self::ROLES,
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'role' => $user->role,
                'is_self' => $user->id === request()->user()->id,
            ],
        ]);
    }

    public function update(Request $request, User $user)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users', 'email')->ignore($user->id)],
            'password' => ['nullable', 'confirmed', Password::defaults()],
            'role' => ['required', Rule::in(array_keys(self::ROLES))],
        ]);

        // กันไม่ให้ super_admin ลดสิทธิ์ตัวเอง (จะเหลือ super_admin คนสุดท้ายไม่ได้)
        if ($user->id === $request->user()->id && $data['role'] !== User::ROLE_SUPER_ADMIN) {
            return back()->with('error', 'ไม่สามารถลดสิทธิ์บัญชีของตนเองได้');
        }

        $user->name = $data['name'];
        $user->email = $data['email'];
        $user->role = $data['role'];
        if (! empty($data['password'])) {
            $user->password = Hash::make($data['password']);
        }
        $user->save();

        return redirect()->route('admin.users.index')->with('success', 'อัปเดตผู้ใช้เรียบร้อยแล้ว');
    }

    public function destroy(Request $request, User $user)
    {
        if ($user->id === $request->user()->id) {
            return back()->with('error', 'ไม่สามารถลบบัญชีของตนเองได้');
        }

        $user->delete();

        return redirect()->route('admin.users.index')->with('success', 'ลบผู้ใช้เรียบร้อยแล้ว');
    }
}
