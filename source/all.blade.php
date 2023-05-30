@extends('_layouts.master')

@section('nav-toggle')
@include('_nav.menu-toggle')
@endsection

@section('body')
<section class="container max-w-8xl mx-auto px-6 md:px-8 py-4">
    <div class="flex flex-col lg:flex-row">
        <nav id="js-nav-menu" class="nav-menu hidden lg:block">
            @include('_nav.menu', ['items' => $page->navigation])
        </nav>

        <div class="DocSearch-content w-full lg:w-3/5 break-words pb-16 lg:pl-4" v-pre>
            <h1>List of all current Generic Top Level domains (gTLDs)</h1>

            <div class="flex flex-wrap">
                @foreach ($gtlds as $gtld)
                <div class="w-full md:w-1/2 lg:w-1/3 p-2">
                    <div class="bg-white rounded-lg shadow-lg">
                        <div class="p-4">
                            <div class="text-2xl font-bold text-gray-800">
                                <a href="/tld/{{ $gtld->name }}">
                                    {{ $gtld->name }}
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

        </div>
    </div>
</section>
@endsection
