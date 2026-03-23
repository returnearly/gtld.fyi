<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="{{ $page->description ?? $page->siteDescription }}">

        <meta property="og:site_name" content="{{ $page->siteName }}"/>
        <meta property="og:title" content="{{ $page->title ?  $page->title . ' | ' : '' }}{{ $page->siteName }}"/>
        <meta property="og:description" content="{{ $page->description ?? $page->siteDescription }}"/>
        <meta property="og:url" content="{{ $page->getUrl() }}"/>
        <meta property="og:image" content="/assets/img/logo.png"/>
        <meta property="og:type" content="website"/>

        <meta name="twitter:image:alt" content="{{ $page->siteName }}">
        <meta name="twitter:card" content="summary_large_image">

        <title>{{ $page->siteName }}{{ $page->title ? ' | ' . $page->title : '' }}</title>

        <link rel="home" href="{{ $page->baseUrl }}">
        <link rel="icon" href="/favicon.ico">

        @stack('meta')

        @if ($page->production)
            <script defer data-domain="gtld.fyi" src="https://pa.returnearly.net/js/script.outbound-links.js"></script>
            <script>window.plausible = window.plausible || function() { (window.plausible.q = window.plausible.q || []).push(arguments) }</script>
        @endif

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="{{ mix('css/main.css', 'assets/build') }}">
    </head>

    <body class="flex flex-col justify-between min-h-screen bg-slate-50 text-slate-800 leading-normal font-sans">
        <header class="bg-white border-b border-slate-200" role="banner">
            <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 flex items-center justify-between h-16">
                <a href="/" class="text-xl font-bold text-slate-900 hover:text-indigo-700 transition-colors">
                    gTLD<span class="text-indigo-600">.fyi</span>
                </a>

                <nav class="flex items-center gap-6 text-sm font-medium">
                    <a href="/" class="text-slate-600 hover:text-slate-900 transition-colors">Home</a>
                    <a href="/all" class="text-slate-600 hover:text-slate-900 transition-colors">All TLDs</a>
                    <a href="https://github.com/returnearly/gtld.fyi/" target="_blank" class="text-slate-600 hover:text-slate-900 transition-colors">GitHub</a>
                </nav>
            </div>
        </header>

        <main role="main" class="w-full flex-auto">
            @yield('body')
        </main>

        <script src="{{ mix('js/main.js', 'assets/build') }}"></script>
        @stack('scripts')

        <footer class="border-t border-slate-200 bg-white text-center text-sm text-slate-500 py-6 mt-12" role="contentinfo">
            <p class="my-0">&copy; {{ date('Y') }} <a href="https://returnearly.net" class="text-slate-600 hover:text-slate-900">Return Early, LLC</a></p>
        </footer>
    </body>
</html>
