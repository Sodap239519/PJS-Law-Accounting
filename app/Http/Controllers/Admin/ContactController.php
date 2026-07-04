<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class ContactController extends Controller
{
    public function index(Request $request): Response
    {
        $contacts = Contact::query()
            ->when($request->filter === 'unread', fn ($q) => $q->where('is_read', false))
            ->latest()
            ->paginate(15)
            ->withQueryString()
            ->through(fn (Contact $c) => [
                'id' => $c->id,
                'name' => $c->name,
                'subject' => $c->subject,
                'phone' => $c->phone,
                'email' => $c->email,
                'is_read' => $c->is_read,
                'date' => $c->created_at->format('d/m/Y H:i'),
            ]);

        return Inertia::render('Admin/Contacts/Index', [
            'contacts' => $contacts,
            'filter' => $request->filter,
            'unreadCount' => Contact::where('is_read', false)->count(),
        ]);
    }

    public function show(Contact $contact): Response
    {
        if (! $contact->is_read) {
            $contact->markAsRead();
        }

        return Inertia::render('Admin/Contacts/Show', [
            'contact' => [
                'id' => $contact->id,
                'name' => $contact->name,
                'phone' => $contact->phone,
                'email' => $contact->email,
                'subject' => $contact->subject,
                'details' => $contact->details,
                'date' => $contact->created_at->timezone('Asia/Bangkok')->format('d/m/Y H:i'),
            ],
        ]);
    }

    public function destroy(Contact $contact)
    {
        $contact->delete();

        return redirect()->route('admin.contacts.index')->with('success', 'ลบข้อความเรียบร้อยแล้ว');
    }
}
