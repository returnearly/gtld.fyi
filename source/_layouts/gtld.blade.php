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
            </p>
            <ul class="list list-disc list-inside">
                <li class="py-2">
                    Your application is coded to only allow a specific whitelist of TLDs and that list only includes 5-10 of the most popular like .com, .net, .org, etc
                </li>
                <li class="py-2">
                    Your application is using a poorly formatted regular expression that is limiting the length of the TLD section to something arbitrary like 4 characters.
                </li>
            </ul>

            <h3>Methods for Email Validation</h3>

            <h4>DNS Validation</h4>
            <p>
                The most reliable way to validate an email address is to check if the domain name has a valid MX record. If the domain name does not have a valid MX record, then the email address is not valid as no mail could be delivered without one.
            </p>

            <h4>Language Specific Helpers</h4>
            <p>
                Many languages have built-in methods for validating email addresses. These methods are usually the best way to validate email addresses as they are maintained by the core developers of the language and are kept up to date with the latest standards.
            </p>
            <ul class="list list-disc list-inside">
                <li class="py-2">
                    With HTML, you can use the <a href="https://developer.mozilla.org/en-US/docs/Web/HTML/Element/input/email" target="_blank"><code>type="email"</code></a> attribute on the <code>&lt;input&gt;</code> element to validate an email address on your website front-end.
                </li>
                <li class="py-2">
                    In PHP, you can use the <a href="https://www.php.net/manual/en/function.filter-var.php" target="_blank"><code>filter_var()</code></a> method with the <code>FILTER_VALIDATE_EMAIL</code> filter to validate an email address.
                </li>
                <li class="py-2">
                    In Ruby, you can use the built in <code>URI::MailTo::EMAIL_REGEXP</code> regular expression to validate an email address.
                </li>
                <li class="py-2">
                    In Python, you can use <a href="https://docs.python.org/3/library/email.utils.html#email.utils.parseaddr" target="_blank">the built in <code>email.utils.parseaddr()</code> method</a> to validate an email address.
                </li>
                <li class="py-2">
                    In JavaScript, you can use the <a href="https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/RegExp" target="_blank"><code>RegExp</code></a> object to validate an email address.
                </li>
            </ul>

            <h4>Framework Specific Helpers</h4>
            <ul class="list list-inside list-disc">
                <li class="py-2">
                    In Laravel, you can use the <a href="https://laravel.com/docs/master/validation#rule-email" target="_blank"><code>email</code></a> validation rule to validate an email address.
                </li>
            </ul>
        </div>
    </div>
</section>
@endsection
