@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-b from-green-50 via-white to-white">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs text-slate-500">Complaint #{{ $complaint->complaint_id }}</p>
                <h1 class="text-2xl font-extrabold text-slate-900">Complaint Chat</h1>
                <p class="text-slate-600 mt-1">Order ID: {{ $complaint->order_id ?? '-' }}</p>
            </div>

            <a href="{{ route('complaints.index') }}"
               class="rounded-xl border border-slate-200 px-4 py-2 font-semibold hover:bg-slate-50 transition">
                Back
            </a>
        </div>

        <div class="mt-6 rounded-2xl bg-white border border-slate-100 shadow-sm p-5 space-y-4">
            @forelse($complaint->messages as $m)
                <div class="p-3 rounded-xl border border-slate-100">
                    <p class="text-xs text-slate-500">
                        {{ $m->sender->name ?? 'System' }} • {{ optional($m->created_at)->diffForHumans() }}
                    </p>
                    <p class="text-slate-900 mt-1">{{ $m->message }}</p>
                </div>
            @empty
                <p class="text-slate-600">No messages yet.</p>
            @endforelse
        </div>

        @if ($errors->any())
            <div class="mt-4 rounded-xl bg-red-50 border border-red-200 p-4 text-sm text-red-700">
                <ul class="list-disc list-inside space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('complaints.messages.store', $complaint) }}"
              class="mt-4 flex gap-2">
            @csrf

            <input name="message" required
                   placeholder="Type message..."
                   class="flex-1 rounded-xl border border-slate-200 px-4 py-3
                          focus:border-green-500 focus:ring-green-500" />

            <button class="rounded-xl bg-green-600 text-white px-5 font-semibold hover:bg-green-700 transition">
                Send
            </button>
        </form>

    </div>
</div>
@endsection
