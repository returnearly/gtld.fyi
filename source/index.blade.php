@extends('_layouts.master')

@section('body')
<section class="bg-indigo-50 border-b border-indigo-100">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-16 md:py-24">
        <h1 class="text-4xl md:text-5xl font-extrabold text-slate-900 tracking-tight">
            Your email validation is broken.
        </h1>
        <p class="mt-4 text-xl text-slate-600 max-w-2xl">
            Hundreds of websites reject perfectly valid email addresses because they don't recognize newer top-level domains like <code>.tech</code>, <code>.dev</code>, or <code>.agency</code>. This site helps you understand and fix the problem.
        </p>

        <form class="mt-8 max-w-md" onsubmit="return false;">
            <label for="tld-lookup" class="block text-sm font-medium text-slate-700 mb-2">Look up a TLD</label>
            <div class="flex gap-2">
                <input
                    type="text"
                    id="tld-lookup"
                    placeholder="e.g. tech, dev, agency"
                    class="flex-1 rounded-lg border border-slate-300 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                >
                <button type="submit" onclick="var v=document.getElementById('tld-lookup').value.trim().toUpperCase().replace(/^\./,'');if(v)window.location.href='/tld/'+encodeURIComponent(v)" class="rounded-lg bg-indigo-600 px-5 py-2.5 text-sm font-medium text-white hover:bg-indigo-700 transition-colors">
                    Look up
                </button>
            </div>
        </form>
    </div>
</section>

<section class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
    <h2 class="text-2xl font-bold text-slate-900 mb-10">How does this happen?</h2>

    <div class="grid md:grid-cols-3 gap-8">
        <div class="bg-white rounded-xl p-6 border border-slate-200">
            <div class="text-3xl font-bold text-indigo-600 mb-3">1</div>
            <h3 class="text-lg font-semibold text-slate-900 mt-0 mb-2">Customer signs up</h3>
            <p class="text-slate-600 text-sm my-0">
                A customer tries to create an account using their email address like <code>jane@company.tech</code>.
            </p>
        </div>

        <div class="bg-white rounded-xl p-6 border border-slate-200">
            <div class="text-3xl font-bold text-indigo-600 mb-3">2</div>
            <h3 class="text-lg font-semibold text-slate-900 mt-0 mb-2">Your site rejects it</h3>
            <p class="text-slate-600 text-sm my-0">
                Your application's email validation incorrectly flags their address as invalid and blocks signup.
            </p>
        </div>

        <div class="bg-white rounded-xl p-6 border border-slate-200">
            <div class="text-3xl font-bold text-indigo-600 mb-3">3</div>
            <h3 class="text-lg font-semibold text-slate-900 mt-0 mb-2">You lose a customer</h3>
            <p class="text-slate-600 text-sm my-0">
                They either abandon your service or are forced to use a different email address they may not prefer.
            </p>
        </div>
    </div>
</section>

<section class="bg-white border-y border-slate-200">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <h2 class="text-2xl font-bold text-slate-900 mb-6">What are gTLDs?</h2>
        <p class="text-slate-600 max-w-3xl">
            Generic top-level domains (gTLDs) are the extensions at the end of a domain name. Beyond the classic <code>.com</code>, <code>.net</code>, and <code>.org</code>, ICANN introduced over 1,200 new gTLDs starting in 2014. Extensions like <code>.tech</code>, <code>.dev</code>, <code>.agency</code>, and <code>.photography</code> are used by millions of people and organizations worldwide. They are all completely valid for email.
        </p>

        <div class="grid sm:grid-cols-3 gap-6 mt-10">
            <div class="text-center">
                <div class="text-4xl font-extrabold text-indigo-700">{{ number_format($gtlds->count()) }}+</div>
                <div class="text-sm text-slate-500 mt-1">valid gTLD extensions</div>
            </div>
            <div class="text-center">
                <div class="text-4xl font-extrabold text-indigo-700">2014</div>
                <div class="text-sm text-slate-500 mt-1">introduced by ICANN</div>
            </div>
            <div class="text-center">
                <div class="text-4xl font-extrabold text-indigo-700">Millions</div>
                <div class="text-sm text-slate-500 mt-1">of domains registered</div>
            </div>
        </div>
    </div>
</section>

<section class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
    <h2 class="text-2xl font-bold text-slate-900 mb-6">Common causes of broken validation</h2>

    <ul class="space-y-4 text-slate-600 list-none pl-0">
        <li class="flex gap-3 items-start">
            <span class="mt-1 flex-shrink-0 w-5 h-5 rounded-full bg-red-100 flex items-center justify-center">
                <span class="w-2 h-2 rounded-full bg-red-500"></span>
            </span>
            <span><strong class="text-slate-900">Hardcoded TLD whitelist</strong> &mdash; your code only allows a handful of TLDs like .com, .net, .org, and rejects everything else.</span>
        </li>
        <li class="flex gap-3 items-start">
            <span class="mt-1 flex-shrink-0 w-5 h-5 rounded-full bg-red-100 flex items-center justify-center">
                <span class="w-2 h-2 rounded-full bg-red-500"></span>
            </span>
            <span><strong class="text-slate-900">Restrictive regex</strong> &mdash; your regular expression limits the TLD to 2-4 characters, rejecting valid extensions like <code>.photography</code> (11 characters).</span>
        </li>
        <li class="flex gap-3 items-start">
            <span class="mt-1 flex-shrink-0 w-5 h-5 rounded-full bg-red-100 flex items-center justify-center">
                <span class="w-2 h-2 rounded-full bg-red-500"></span>
            </span>
            <span><strong class="text-slate-900">Outdated validation library</strong> &mdash; you're using a third-party library that hasn't been updated to support newer TLDs.</span>
        </li>
    </ul>

    <div class="mt-10">
        <a href="/all" class="inline-flex items-center gap-2 rounded-lg bg-slate-900 px-5 py-2.5 text-sm font-medium text-white hover:bg-slate-800 transition-colors">
            Browse all {{ number_format($gtlds->count()) }} TLDs
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
        </a>
    </div>
</section>
@endsection
