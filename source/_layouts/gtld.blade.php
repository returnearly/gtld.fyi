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
            <h1>.{{ $page->name }}</h1>
            <p class="text-xl text-red-500 text-bold">
                If you've been sent here by a customer, it's likely because your application is broken.
            </p>
            <p>
                Your customer tried to use your website / application with an email address that looks like <code>john@mycompany.{{ $page->name }}</code>. While doing so, they received an error that their email address was not acceptable even though an address like this is completely valid.
            </p>
            <p>
                Extensions like <code>.{{ $page->name }}</code> are a newer version of the <code>.COM</code> and <code>.NET</code> domains that have been around since the 1980s. Not supporting the new extensions is likely impacting other potential customers as well, forcing them to restart the signup process with a different email address or abandoning your service all together.
            </p>

            <h2>Technical Information</h2>
            <p>
                Your customer's domain name uses a <a href="https://en.wikipedia.org/wiki/Generic_top-level_domain" target="_blank">generic top-level domain (gTLD)</a>, a concept that was introduced in 2014. The <code>.{{ $page->name }}</code> gTLD is one of those new domains and is used by hundreds of thousands of companies, organizations and individuals around the world.
            </p>

            <p>
                In fact, there are <span class="font-bold font-black underline">{{ number_format($gtlds->count()) }}</span> of these new gTLDs and they are all valid to be used for email addresses. You can see a full list of them <a href="/all">here</a>.
            </p>

            <h2>How to fix the problem?</h2>
            <p>
                To fix the problem, your technical team will need to update your application to allow email addresses with the <code>.{{ $page->name }}</code> TLD along with <a href="/all">the other {{ number_format($gtlds->count() - 1) }} TLDs</a>. This should be a fairly straightforward change to your validation logic that will allow your customers to use your service with their preferred email address.
            </p>

            <p>
                Usually, the problem is due to one of these few reasons:
                <ul class="list list-disc list-inside">
                    <li class="py-2">Your application is coded to only allow a specific whitelist of TLDs and that list only includes 5-10 of the most popular like .com, .net, .org, etc</li>
                    <li class="py-2">Your application is using a poorly formatted regular expression that is limiting the length of the TLD section to something arbitrary like 4 characters.</li>
                </ul>
            </p>

            <h3>Methods for Email Validation</h3>

            <code>
                \A(?:[a-z0-9!#$%&'*+/=?^_‘{|}~-]+(?:\.[a-z0-9!#$%&'*+/=?^_‘{|}~-]+)*
                |  "(?:[\x01-\x08\x0b\x0c\x0e-\x1f\x21\x23-\x5b\x5d-\x7f]
                |  \\[\x01-\x09\x0b\x0c\x0e-\x7f])*")
                @ (?:(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?
                |  \[(?:(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.){3}
                (?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?|[a-z0-9-]*[a-z0-9]:
                (?:[\x01-\x08\x0b\x0c\x0e-\x1f\x21-\x5a\x53-\x7f]
                |  \\[\x01-\x09\x0b\x0c\x0e-\x7f])+)
                \])\z
            </code>
        </div>
    </div>
</section>
@endsection
