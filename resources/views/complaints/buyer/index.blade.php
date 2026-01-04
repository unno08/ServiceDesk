<x-app-layout>
    <div class="max-w-5xl mx-auto py-8">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h1 class="text-2xl font-bold">My Complaints</h1>
                <p class="text-sm text-gray-500">Senarai aduan yang anda buat.</p>
            </div>

            <a href="{{ route('complaints.create') }}"
               class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700">
                + New Complaint
            </a>
        </div>

        @if($complaints->isEmpty())
            <div class="bg-white p-6 rounded-xl border">
                Tiada aduan lagi.
            </div>
        @else
            <div class="space-y-3">
                @foreach($complaints as $c)
                    <a href="{{ route('complaints.show', $c) }}"
                       class="block bg-white p-5 rounded-xl border hover:border-green-400">
                        <div class="flex items-center justify-between">
                            <div class="font-semibold">
                                Complaint #{{ $c->id }}
                            </div>
                            <span class="text-xs px-2 py-1 rounded-full
                                {{ $c->status === 'open' ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-600' }}">
                                {{ strtoupper($c->status) }}
                            </span>
                        </div>

                        <div class="text-sm text-gray-600 mt-2 line-clamp-2">
                            {{ $c->complaint_message }}
                        </div>

                        <div class="text-xs text-gray-400 mt-2">
                            {{ $c->created_at?->format('d M Y, h:i A') }}
                        </div>
                    </a>
                @endforeach
            </div>
        @endif
    </div>
</x-app-layout>
