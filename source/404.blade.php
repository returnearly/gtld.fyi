@extends('_layouts.master')

@section('body')
<section class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-24 text-center">
    <h1 class="text-6xl font-extrabold text-slate-300">404</h1>
    <h2 class="text-2xl font-bold text-slate-900 mt-4">Page not found</h2>
    <p class="text-slate-600 mt-2">The page you're looking for doesn't exist.</p>

    <div class="mt-8 max-w-sm mx-auto">
        <label for="tld-lookup" class="block text-sm font-medium text-slate-700 mb-2">Looking for a specific TLD?</label>
        <form class="flex gap-2" onsubmit="return false;">
            <input
                type="text"
                id="tld-lookup"
                placeholder="e.g. tech, dev"
                class="flex-1 rounded-lg border border-slate-300 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
            >
            <button type="submit" onclick="var v=document.getElementById('tld-lookup').value.trim().toUpperCase().replace(/^\./,'');if(v)window.location.href='/tld/'+encodeURIComponent(v)" class="rounded-lg bg-indigo-600 px-5 py-2.5 text-sm font-medium text-white hover:bg-indigo-700 transition-colors">
                Go
            </button>
        </form>
    </div>

    <div class="mt-6">
        <a href="/all" class="text-sm text-indigo-700 hover:text-indigo-900">Browse all TLDs &rarr;</a>
    </div>
</section>
@endsection
