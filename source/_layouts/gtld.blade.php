@extends('_layouts.master')

@section('body')
<section class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-12" v-pre>

    {{-- Alert banner --}}
    <div class="bg-red-50 border-l-4 border-red-500 rounded-r-lg p-4 mb-10">
        <p class="text-red-800 font-semibold my-0">If you were sent here by a customer, your application has a bug.</p>
        <p class="text-red-700 text-sm my-1">It is rejecting valid email addresses. The information below explains the problem and how to fix it.</p>
    </div>

    {{-- TLD identity --}}
    <h1 class="text-5xl md:text-6xl font-extrabold tracking-tight">
        <span class="text-indigo-600">.</span>{{ $page->name }}
    </h1>
    <p class="text-xl text-slate-500 mt-2 mb-8">is a valid generic top-level domain (gTLD)</p>

    <p>
        Your customer tried to use an email address like <code>john@mycompany.{{ $page->name }}</code> and your application rejected it. This extension has been valid since 2014 and is one of <a href="/all">{{ number_format($gtlds->count()) }} gTLDs</a> recognized by <a href="{{ $page->iana_db_url }}" target="_blank">IANA</a> for use in domain names and email addresses.
    </p>
    <p>
        Extensions like <code>.{{ $page->name }}</code> are newer versions of the classic <code>.COM</code> and <code>.NET</code> domains. Not supporting them means you're likely turning away other customers too &mdash; forcing them to restart signup with a different email or abandon your service entirely.
    </p>

    {{-- Why this happens --}}
    <h2 id="why">Why does this happen?</h2>
    <p>Most of the time, this is caused by one of a few common mistakes in how the website checks whether an email address is valid:</p>
    <ul class="list-disc list-outside pl-5 space-y-3 text-slate-700">
        <li><strong>Only allowing a short list of known extensions</strong> &mdash; the website was programmed to only accept email addresses ending in <code>.com</code>, <code>.net</code>, <code>.org</code>, and a handful of others. Anything outside that list &mdash; including <code>.{{ $page->name }}</code> &mdash; gets rejected even though it's perfectly valid.</li>
        <li><strong>Limiting how long the extension can be</strong> &mdash; the website's code assumes the part after the last dot (like "com" or "net") can only be 2 to 4 characters long. Extensions like <code>.{{ $page->name }}</code> are longer than that, so they get incorrectly rejected.</li>
        <li><strong>Using an outdated validation library</strong> &mdash; the website relies on a third-party tool or plugin to check email addresses, but that tool hasn't been updated to recognize the newer extensions that have been available since 2014.</li>
    </ul>

    {{-- How to fix --}}
    <h2 id="fix">How to fix it</h2>
    <p>
        Use your language or framework's built-in email validation instead of writing your own regex. The examples below show the correct approach for every major language and framework.
    </p>

    <p class="text-sm text-slate-500 italic">
        Avoid writing your own regular expression for email validation &mdash; it is almost always wrong and is the #1 cause of gTLD rejection.
    </p>

    {{-- DNS Validation --}}
    <h3 id="dns">DNS Validation</h3>
    <p>
        The most reliable way to validate an email address is to check if the domain has a valid MX record. If the domain has no MX record, no mail can be delivered to it.
    </p>

    {{-- Language tabs --}}
    <h3 id="languages">Language Examples</h3>

    <div data-tab-group="languages">
        <div class="tab-bar">
            <button class="tab-button active" data-tab="lang-html">HTML</button>
            <button class="tab-button" data-tab="lang-php">PHP</button>
            <button class="tab-button" data-tab="lang-python">Python</button>
            <button class="tab-button" data-tab="lang-js">JS / TS</button>
            <button class="tab-button" data-tab="lang-ruby">Ruby</button>
            <button class="tab-button" data-tab="lang-java">Java</button>
            <button class="tab-button" data-tab="lang-csharp">C#</button>
            <button class="tab-button" data-tab="lang-go">Go</button>
            <button class="tab-button" data-tab="lang-swift">Swift</button>
            <button class="tab-button" data-tab="lang-kotlin">Kotlin</button>
            <button class="tab-button" data-tab="lang-rust">Rust</button>
            <button class="tab-button" data-tab="lang-elixir">Elixir</button>
        </div>

        <div id="lang-html" class="tab-panel active">
            <p>Use the <a href="https://developer.mozilla.org/en-US/docs/Web/HTML/Element/input/email" target="_blank"><code>type="email"</code></a> attribute. The browser validates against the RFC spec and accepts all valid TLDs.</p>
            <pre><code class="language-html">&lt;input type="email" name="email" required&gt;</code></pre>
        </div>

        <div id="lang-php" class="tab-panel">
            <p>Use <a href="https://www.php.net/manual/en/function.filter-var.php" target="_blank"><code>filter_var()</code></a> with <code>FILTER_VALIDATE_EMAIL</code>. This follows the RFC spec and does not restrict TLD length or format.</p>
            <pre><code class="language-php">$valid = filter_var($email, FILTER_VALIDATE_EMAIL) !== false;</code></pre>
        </div>

        <div id="lang-python" class="tab-panel">
            <p>Use the <a href="https://pypi.org/project/email-validator/" target="_blank"><code>email-validator</code></a> package for robust validation with optional DNS checks. For basic parsing, the standard library's <a href="https://docs.python.org/3/library/email.utils.html#email.utils.parseaddr" target="_blank"><code>email.utils.parseaddr()</code></a> also works.</p>
            <pre><code class="language-python">from email_validator import validate_email
result = validate_email("user@example.{{ $page->name }}")</code></pre>
        </div>

        <div id="lang-js" class="tab-panel">
            <p>Avoid writing a custom regex. Use the browser's built-in <code>&lt;input type="email"&gt;</code> constraint validation, or use <a href="https://www.npmjs.com/package/validator" target="_blank"><code>validator.js</code></a> on the server.</p>
            <pre><code class="language-javascript">import validator from 'validator';
validator.isEmail('user@example.{{ $page->name }}'); // true</code></pre>
        </div>

        <div id="lang-ruby" class="tab-panel">
            <p>Use the built-in <code>URI::MailTo::EMAIL_REGEXP</code> constant which follows the RFC spec and accepts all valid TLDs.</p>
            <pre><code class="language-ruby">valid = email.match?(URI::MailTo::EMAIL_REGEXP)</code></pre>
        </div>

        <div id="lang-java" class="tab-panel">
            <p>Use <code>jakarta.mail.internet.InternetAddress</code> which parses per RFC 822, or the <code>@Email</code> annotation from Hibernate Validator.</p>
            <pre><code class="language-java">import jakarta.mail.internet.InternetAddress;
InternetAddress addr = new InternetAddress(email);
addr.validate();</code></pre>
        </div>

        <div id="lang-csharp" class="tab-panel">
            <p>Use <code>System.Net.Mail.MailAddress</code> which parses per RFC spec, or the <code>[EmailAddress]</code> data annotation for model validation.</p>
            <pre><code class="language-csharp">try {
    var addr = new System.Net.Mail.MailAddress(email);
    bool valid = addr.Address == email;
} catch (FormatException) {
    // invalid
}</code></pre>
        </div>

        <div id="lang-go" class="tab-panel">
            <p>Use the standard library's <a href="https://pkg.go.dev/net/mail#ParseAddress" target="_blank"><code>net/mail.ParseAddress()</code></a> which parses addresses per RFC 5322.</p>
            <pre><code class="language-go">import "net/mail"
_, err := mail.ParseAddress(email)
valid := err == nil</code></pre>
        </div>

        <div id="lang-swift" class="tab-panel">
            <p>Use <code>NSDataDetector</code> with the <code>.link</code> checking type to validate email addresses without restrictive regex.</p>
            <pre><code class="language-swift">import Foundation
let detector = try NSDataDetector(
    types: NSTextCheckingResult.CheckingType.link.rawValue
)
let range = NSRange(email.startIndex..&lt;email.endIndex, in: email)
let match = detector.firstMatch(in: email, options: [], range: range)
let valid = match?.url?.scheme == "mailto"</code></pre>
        </div>

        <div id="lang-kotlin" class="tab-panel">
            <p>On Android use <code>Patterns.EMAIL_ADDRESS</code>. On the JVM, use <code>InternetAddress</code> from Jakarta Mail.</p>
            <pre><code class="language-kotlin">// Android
val valid = android.util.Patterns.EMAIL_ADDRESS
    .matcher(email).matches()

// JVM
val addr = jakarta.mail.internet.InternetAddress(email)
addr.validate()</code></pre>
        </div>

        <div id="lang-rust" class="tab-panel">
            <p>Use the <a href="https://crates.io/crates/email_address" target="_blank"><code>email_address</code></a> crate which validates against RFC 5321.</p>
            <pre><code class="language-rust">use email_address::EmailAddress;
let valid = EmailAddress::is_valid("user@example.{{ $page->name }}");</code></pre>
        </div>

        <div id="lang-elixir" class="tab-panel">
            <p>Use the <a href="https://hex.pm/packages/email_checker" target="_blank"><code>email_checker</code></a> package or Ecto changeset validation.</p>
            <pre><code class="language-elixir"># Ecto changeset
validate_format(changeset, :email, ~r/^[^\s]+@[^\s]+\.[^\s]+$/)</code></pre>
        </div>
    </div>

    {{-- Framework tabs --}}
    <h3 id="frameworks">Framework Examples</h3>

    <div data-tab-group="frameworks">
        <div class="tab-bar">
            <button class="tab-button active" data-tab="fw-laravel">Laravel</button>
            <button class="tab-button" data-tab="fw-symfony">Symfony</button>
            <button class="tab-button" data-tab="fw-django">Django</button>
            <button class="tab-button" data-tab="fw-flask">Flask</button>
            <button class="tab-button" data-tab="fw-rails">Rails</button>
            <button class="tab-button" data-tab="fw-spring">Spring</button>
            <button class="tab-button" data-tab="fw-aspnet">ASP.NET</button>
            <button class="tab-button" data-tab="fw-express">Express</button>
            <button class="tab-button" data-tab="fw-angular">Angular</button>
            <button class="tab-button" data-tab="fw-phoenix">Phoenix</button>
            <button class="tab-button" data-tab="fw-nextjs">Next.js</button>
            <button class="tab-button" data-tab="fw-vue">Vue.js</button>
            <button class="tab-button" data-tab="fw-gin">Gin</button>
        </div>

        <div id="fw-laravel" class="tab-panel active">
            <p>Use the <a href="https://laravel.com/docs/master/validation#rule-email" target="_blank"><code>email</code></a> validation rule. The <code>rfc</code> and <code>dns</code> options provide additional checks.</p>
            <pre><code class="language-php">$request-&gt;validate([
    'email' =&gt; 'required|email:rfc,dns',
]);</code></pre>
        </div>

        <div id="fw-symfony" class="tab-panel">
            <p>Use the <a href="https://symfony.com/doc/current/reference/constraints/Email.html" target="_blank"><code>Email</code></a> constraint with the desired validation mode.</p>
            <pre><code class="language-php">use Symfony\Component\Validator\Constraints as Assert;

#[Assert\Email(mode: 'strict')]
private string $email;</code></pre>
        </div>

        <div id="fw-django" class="tab-panel">
            <p>Use the built-in <a href="https://docs.djangoproject.com/en/stable/ref/validators/#emailvalidator" target="_blank"><code>EmailValidator</code></a> or <code>EmailField</code> on forms and models.</p>
            <pre><code class="language-python"># In a model
from django.db import models
email = models.EmailField()

# In a form
from django.core.validators import validate_email
validate_email('user@example.{{ $page->name }}')</code></pre>
        </div>

        <div id="fw-flask" class="tab-panel">
            <p>Use the <code>Email</code> validator from WTForms which checks RFC compliance.</p>
            <pre><code class="language-python">from wtforms import StringField
from wtforms.validators import Email

class MyForm(FlaskForm):
    email = StringField('Email', validators=[Email()])</code></pre>
        </div>

        <div id="fw-rails" class="tab-panel">
            <p>Use the built-in <code>URI::MailTo::EMAIL_REGEXP</code> with a model validation.</p>
            <pre><code class="language-ruby">class User &lt; ApplicationRecord
  validates :email, format: { with: URI::MailTo::EMAIL_REGEXP }
end</code></pre>
        </div>

        <div id="fw-spring" class="tab-panel">
            <p>Use the <code>@Email</code> annotation from Jakarta Bean Validation (Hibernate Validator).</p>
            <pre><code class="language-java">import jakarta.validation.constraints.Email;

public class UserDTO {
    @Email
    private String email;
}</code></pre>
        </div>

        <div id="fw-aspnet" class="tab-panel">
            <p>Use the <code>[EmailAddress]</code> data annotation on your model properties.</p>
            <pre><code class="language-csharp">using System.ComponentModel.DataAnnotations;

public class UserModel {
    [Required]
    [EmailAddress]
    public string Email { get; set; }
}</code></pre>
        </div>

        <div id="fw-express" class="tab-panel">
            <p>Use <a href="https://express-validator.github.io/" target="_blank"><code>express-validator</code></a> which wraps <code>validator.js</code> for RFC-compliant checks.</p>
            <pre><code class="language-javascript">import { body } from 'express-validator';

app.post('/register',
  body('email').isEmail(),
  (req, res) =&gt; { /* ... */ }
);</code></pre>
        </div>

        <div id="fw-angular" class="tab-panel">
            <p>Use the built-in <code>Validators.email</code> which follows the HTML5 email spec.</p>
            <pre><code class="language-javascript">import { Validators } from '@angular/forms';

this.form = this.fb.group({
  email: ['', [Validators.required, Validators.email]]
});</code></pre>
        </div>

        <div id="fw-phoenix" class="tab-panel">
            <p>Use Ecto changeset validations to check email format.</p>
            <pre><code class="language-elixir">def changeset(user, attrs) do
  user
  |&gt; cast(attrs, [:email])
  |&gt; validate_required([:email])
  |&gt; validate_format(:email, ~r/^[^\s]+@[^\s]+\.[^\s]+$/)
end</code></pre>
        </div>

        <div id="fw-nextjs" class="tab-panel">
            <p>Use native HTML5 email input for client-side validation. For API routes, use <code>validator.js</code>.</p>
            <pre><code class="language-javascript">// Client-side (React component)
&lt;input type="email" name="email" required /&gt;

// Server-side (API route)
import validator from 'validator';
if (!validator.isEmail(req.body.email)) {
  return res.status(400).json({ error: 'Invalid email' });
}</code></pre>
        </div>

        <div id="fw-vue" class="tab-panel">
            <p>Use <a href="https://vuelidate-next.netlify.app/" target="_blank">Vuelidate</a>'s built-in email validator.</p>
            <pre><code class="language-javascript">import { required, email } from '@vuelidate/validators';

const rules = {
  email: { required, email }
};</code></pre>
        </div>

        <div id="fw-gin" class="tab-panel">
            <p>Use the <code>binding:"email"</code> struct tag which validates using the <code>go-playground/validator</code> package.</p>
            <pre><code class="language-go">type RegisterInput struct {
    Email string `json:"email" binding:"required,email"`
}</code></pre>
        </div>
    </div>

</section>
@endsection
