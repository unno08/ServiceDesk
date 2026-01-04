@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-b from-green-50 via-white to-white">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs text-green-700 font-semibold">Aether & Leaf.Co</p>
                <h1 class="text-2xl font-extrabold text-slate-900">New Complaint</h1>
                <p class="text-slate-600 mt-1">Hantar aduan atau pertanyaan kepada seller.</p>
            </div>

            <a href="{{ route('complaints.buyer') }}"
               class="rounded-xl border border-slate-200 px-4 py-2 font-semibold text-slate-700 hover:bg-slate-50 transition">
                Back
            </a>
        </div>

        <form method="POST" action="{{ route('complaints.store') }}"
              class="mt-6 rounded-2xl bg-white border border-slate-100 shadow-sm p-6 space-y-5">
            @csrf

            {{-- ✅ seller_id auto assign dalam store(), jadi tak perlu hidden input --}}

            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-1">
                    Order ID <span class="text-slate-400">(optional)</span>
                </label>
                <input type="number" name="order_id"
                       placeholder="Contoh: 10234"
                       class="w-full rounded-xl border border-slate-200 px-4 py-3 focus:border-green-500 focus:ring-green-500">
            </div>

            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-1">
                    Message <span class="text-red-500">*</span>
                </label>
                <textarea name="message" rows="5" required
                          placeholder="Terangkan masalah atau pertanyaan anda di sini..."
                          class="w-full rounded-xl border border-slate-200 px-4 py-3 focus:border-green-500 focus:ring-green-500"></textarea>
            </div>

            @if ($errors->any())
                <div class="rounded-xl bg-red-50 border border-red-200 p-4 text-sm text-red-700">
                    <ul class="list-disc list-inside space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="pt-2">
                <button type="submit"
                        class="w-full rounded-xl bg-green-600 text-white py-3 font-semibold hover:bg-green-700 transition">
                    Submit Complaint
                </button>
            </div>
        </form>

    </div>
</div>
@endsection
