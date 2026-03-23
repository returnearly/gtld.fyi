@extends('_layouts.master')

@section('body')
<section class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <h1 class="text-3xl font-bold text-slate-900">All Generic Top-Level Domains</h1>
    <p class="text-slate-600 mt-2 mb-8">
        Every one of these {{ number_format($gtlds->count()) }} gTLDs is valid for use in email addresses.
    </p>

    <div class="sticky top-0 z-10 bg-slate-50 py-4 -mx-4 px-4 sm:-mx-6 sm:px-6 lg:-mx-8 lg:px-8">
        <div class="flex items-center gap-4">
            <input
                type="text"
                id="tld-filter"
                placeholder="Filter TLDs..."
                class="w-full max-w-sm rounded-lg border border-slate-300 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
            >
            <span id="tld-count" class="text-sm text-slate-500 whitespace-nowrap">{{ number_format($gtlds->count()) }} TLDs</span>
        </div>
    </div>

    <div id="tld-grid" class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-2 mt-6">
        @foreach ($gtlds as $gtld)
        <a href="/tld/{{ $gtld->name }}" data-tld="{{ $gtld->name }}" class="block px-3 py-2 text-sm font-mono font-medium text-slate-700 hover:text-indigo-700 hover:bg-indigo-50 rounded-lg transition-colors">
            .{{ $gtld->name }}
        </a>
        @endforeach
    </div>
</section>
@endsection
