<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ContactMessageController extends Controller
{
    /**
     * Display stored contact messages.
     */
    public function index(): View
    {
        $messages = ContactMessage::query()->latest()->get();

        ContactMessage::query()->where('is_read', false)->update(['is_read' => true]);

        return view('admin.messages.index', [
            'title' => 'Pesan Kontak',
            'messages' => $messages,
        ]);
    }

    /**
     * Remove the specified message.
     */
    public function destroy(ContactMessage $message): RedirectResponse
    {
        $message->delete();

        return redirect()
            ->route('admin.messages.index')
            ->with('status', 'Pesan kontak berhasil dihapus.');
    }
}
