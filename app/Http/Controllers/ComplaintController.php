<?php

namespace App\Http\Controllers;

use App\Models\Complaint;
use App\Models\ComplaintMessage;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ComplaintController extends Controller
{
    // BUYER: tengok complaint sendiri
    public function buyerIndex(Request $request): View
    {
        $complaints = Complaint::query()
            ->where('user_id', (int) $request->user()->id)
            ->latest()
            ->paginate(10);

        return view('complaints.buyer-index', compact('complaints'));
    }

    // BUYER: form create complaint
    public function create(Request $request): View
    {
        $sellerId = User::query()
            ->where('role', 'seller')
            ->value('id');

        if (!$sellerId) {
            abort(500, 'No seller account found. Please create a seller user.');
        }

        return view('complaints.create', compact('sellerId'));
    }

    // BUYER: submit complaint
    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'order_id' => ['nullable', 'integer'],
            'message'  => ['required', 'string'],
        ]);

        $sellerId = User::query()
            ->where('role', 'seller')
            ->value('id');

        if (!$sellerId) {
            abort(500, 'No seller account found. Please create a seller user.');
        }

        $complaint = Complaint::create([
            'user_id'           => (int) $request->user()->id,
            'seller_id'         => (int) $sellerId,
            'order_id'          => $data['order_id'] ?? null,
            'complaint_message' => $data['message'],
            'handled_by'        => null,
            'status'            => 'open',
        ]);

        ComplaintMessage::create([
            'complaint_id' => (int) $complaint->complaint_id,
            'sender_id'    => (int) $request->user()->id,
            'message'      => $data['message'],
            'is_read'      => 1,
        ]);

        return redirect()->route('complaints.show', $complaint->complaint_id);
    }

    // SELLER / ADMIN: inbox
    public function index(Request $request)
    {
        $user = $request->user();
        $role = $user->role ?? 'buyer';

        // buyer tak boleh masuk
        if ($role === 'buyer') {
            return redirect()->route('complaints.buyer');
        }

        $query = Complaint::query()->latest();

        if ($role === 'seller') {
            $query->where('seller_id', (int) $user->id);
        }

        $complaints = $query->paginate(10);

        return view('complaints.index', compact('complaints'));
    }

    public function show(Request $request, Complaint $complaint): View
    {
        $user = $request->user();
        $role = $user->role ?? 'buyer';

        if ($role === 'buyer' && (int) $complaint->user_id !== (int) $user->id) {
            abort(403);
        }

        if ($role === 'seller' && (int) $complaint->seller_id !== (int) $user->id) {
            abort(403);
        }

        $complaint->load(['messages.sender']);

        ComplaintMessage::query()
            ->where('complaint_id', (int) $complaint->complaint_id)
            ->where('sender_id', '!=', (int) $user->id)
            ->update(['is_read' => 1]);

        return view('complaints.show', compact('complaint'));
    }

    public function storeMessage(Request $request, Complaint $complaint): RedirectResponse
    {
        $user = $request->user();
        $role = $user->role ?? 'buyer';

        if ($role === 'buyer' && (int) $complaint->user_id !== (int) $user->id) {
            abort(403);
        }

        if ($role === 'seller' && (int) $complaint->seller_id !== (int) $user->id) {
            abort(403);
        }

        $data = $request->validate([
            'message' => ['required', 'string'],
        ]);

        ComplaintMessage::create([
            'complaint_id' => (int) $complaint->complaint_id,
            'sender_id'    => (int) $user->id,
            'message'      => $data['message'],
            'is_read'      => 0,
        ]);

        if (in_array($role, ['seller', 'admin'], true) && empty($complaint->handled_by)) {
            $complaint->handled_by = (int) $user->id;
            $complaint->save();
        }

        return back();
    }
}

