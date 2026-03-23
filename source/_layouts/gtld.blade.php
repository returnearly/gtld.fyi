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
                Many languages have built-in methods for validating email addresses. These methods are usually the best way to validate email addresses as they are maintained by the core developers of the language and are kept up to date with the latest standards. Avoid writing your own regular expression for email validation &mdash; it is almost always wrong and is the #1 cause of gTLD rejection.
            </p>

            <h5>HTML</h5>
            <p>
                Use the <a href="https://developer.mozilla.org/en-US/docs/Web/HTML/Element/input/email" target="_blank"><code>type="email"</code></a> attribute on the <code>&lt;input&gt;</code> element. The browser validates against the RFC 5322 spec and accepts all valid TLDs.
            </p>
            <pre><code>&lt;input type="email" name="email" required&gt;</code></pre>

            <h5>PHP</h5>
            <p>
                Use the <a href="https://www.php.net/manual/en/function.filter-var.php" target="_blank"><code>filter_var()</code></a> function with the <code>FILTER_VALIDATE_EMAIL</code> filter. This follows the RFC spec and does not restrict TLD length or format.
            </p>
            <pre><code>$valid = filter_var($email, FILTER_VALIDATE_EMAIL) !== false;</code></pre>

            <h5>Python</h5>
            <p>
                Use the <a href="https://pypi.org/project/email-validator/" target="_blank"><code>email-validator</code></a> package for robust validation that checks syntax and optionally verifies DNS. For basic parsing, the standard library's <a href="https://docs.python.org/3/library/email.utils.html#email.utils.parseaddr" target="_blank"><code>email.utils.parseaddr()</code></a> works but does not validate deliverability.
            </p>
            <pre><code>from email_validator import validate_email
result = validate_email("user@example.{{ $page->name }}")</code></pre>

            <h5>JavaScript / TypeScript</h5>
            <p>
                Avoid writing a custom regex. Use the browser's built-in <code>&lt;input type="email"&gt;</code> constraint validation API, or on the server side use a well-maintained library like <a href="https://www.npmjs.com/package/validator" target="_blank"><code>validator.js</code></a>.
            </p>
            <pre><code>import validator from 'validator';
validator.isEmail('user@example.{{ $page->name }}'); // true</code></pre>

            <h5>Ruby</h5>
            <p>
                Use the built-in <code>URI::MailTo::EMAIL_REGEXP</code> constant which follows the RFC spec and accepts all valid TLDs.
            </p>
            <pre><code>valid = email.match?(URI::MailTo::EMAIL_REGEXP)</code></pre>

            <h5>Java</h5>
            <p>
                Use the <code>jakarta.mail.internet.InternetAddress</code> class (or <code>javax.mail</code> in older versions) which parses per RFC 822. Alternatively, use the Bean Validation <code>@Email</code> annotation from Hibernate Validator.
            </p>
            <pre><code>import jakarta.mail.internet.InternetAddress;
InternetAddress addr = new InternetAddress(email);
addr.validate();</code></pre>

            <h5>C# / .NET</h5>
            <p>
                Use <code>System.Net.Mail.MailAddress</code> which parses email addresses per RFC spec, or use the <code>[EmailAddress]</code> data annotation for model validation.
            </p>
            <pre><code>try {
    var addr = new System.Net.Mail.MailAddress(email);
    bool valid = addr.Address == email;
} catch (FormatException) {
    // invalid
}</code></pre>

            <h5>Go</h5>
            <p>
                Use the standard library's <a href="https://pkg.go.dev/net/mail#ParseAddress" target="_blank"><code>net/mail.ParseAddress()</code></a> function which parses addresses per RFC 5322.
            </p>
            <pre><code>import "net/mail"
_, err := mail.ParseAddress(email)
valid := err == nil</code></pre>

            <h5>Swift</h5>
            <p>
                Use <code>NSDataDetector</code> with the <code>.link</code> checking type to detect valid email addresses without restrictive regex patterns.
            </p>
            <pre><code>import Foundation
let detector = try NSDataDetector(types: NSTextCheckingResult.CheckingType.link.rawValue)
let range = NSRange(email.startIndex..&lt;email.endIndex, in: email)
let match = detector.firstMatch(in: email, options: [], range: range)
let valid = match?.url?.scheme == "mailto"</code></pre>

            <h5>Kotlin</h5>
            <p>
                Use the <code>android.util.Patterns.EMAIL_ADDRESS</code> pattern on Android, or on the JVM use the same <code>jakarta.mail.internet.InternetAddress</code> approach as Java.
            </p>
            <pre><code>// Android
val valid = android.util.Patterns.EMAIL_ADDRESS.matcher(email).matches()

// JVM
val addr = jakarta.mail.internet.InternetAddress(email)
addr.validate()</code></pre>

            <h5>Rust</h5>
            <p>
                Use the <a href="https://crates.io/crates/email_address" target="_blank"><code>email_address</code></a> crate which validates against RFC 5321.
            </p>
            <pre><code>use email_address::EmailAddress;
let valid = EmailAddress::is_valid("user@example.{{ $page->name }}");</code></pre>

            <h5>Elixir</h5>
            <p>
                Use the built-in <code>Email</code> changeset validation or the <a href="https://hex.pm/packages/email_checker" target="_blank"><code>email_checker</code></a> package.
            </p>
            <pre><code># Ecto changeset
validate_format(changeset, :email, ~r/^[^\s]+@[^\s]+\.[^\s]+$/)</code></pre>

            <h4>Framework Specific Helpers</h4>

            <h5>Laravel (PHP)</h5>
            <p>
                Use the <a href="https://laravel.com/docs/master/validation#rule-email" target="_blank"><code>email</code></a> validation rule. The <code>dns</code> and <code>rfc</code> options provide additional checks.
            </p>
            <pre><code>$request->validate([
    'email' => 'required|email:rfc,dns',
]);</code></pre>

            <h5>Symfony (PHP)</h5>
            <p>
                Use the <a href="https://symfony.com/doc/current/reference/constraints/Email.html" target="_blank"><code>Email</code></a> constraint with the desired validation mode.
            </p>
            <pre><code>use Symfony\Component\Validator\Constraints as Assert;

#[Assert\Email(mode: 'strict')]
private string $email;</code></pre>

            <h5>Django (Python)</h5>
            <p>
                Use the built-in <a href="https://docs.djangoproject.com/en/stable/ref/validators/#emailvalidator" target="_blank"><code>EmailValidator</code></a> or the <code>EmailField</code> on forms and models. Both follow the RFC spec.
            </p>
            <pre><code># In a model
from django.db import models
email = models.EmailField()

# In a form
from django.core.validators import validate_email
validate_email('user@example.{{ $page->name }}')</code></pre>

            <h5>Flask / WTForms (Python)</h5>
            <p>
                Use the <code>Email</code> validator from WTForms which checks RFC compliance.
            </p>
            <pre><code>from wtforms import StringField
from wtforms.validators import Email

class MyForm(FlaskForm):
    email = StringField('Email', validators=[Email()])</code></pre>

            <h5>Ruby on Rails</h5>
            <p>
                Use the built-in <code>URI::MailTo::EMAIL_REGEXP</code> with a model validation.
            </p>
            <pre><code>class User &lt; ApplicationRecord
  validates :email, format: { with: URI::MailTo::EMAIL_REGEXP }
end</code></pre>

            <h5>Spring Boot (Java)</h5>
            <p>
                Use the <code>@Email</code> annotation from Jakarta Bean Validation (Hibernate Validator).
            </p>
            <pre><code>import jakarta.validation.constraints.Email;

public class UserDTO {
    @Email
    private String email;
}</code></pre>

            <h5>ASP.NET (C#)</h5>
            <p>
                Use the <code>[EmailAddress]</code> data annotation on your model properties.
            </p>
            <pre><code>using System.ComponentModel.DataAnnotations;

public class UserModel {
    [Required]
    [EmailAddress]
    public string Email { get; set; }
}</code></pre>

            <h5>Express.js / Node.js</h5>
            <p>
                Use <a href="https://express-validator.github.io/" target="_blank"><code>express-validator</code></a> which wraps <code>validator.js</code> for RFC-compliant email checks.
            </p>
            <pre><code>import { body } from 'express-validator';

app.post('/register',
  body('email').isEmail(),
  (req, res) => { /* ... */ }
);</code></pre>

            <h5>Angular</h5>
            <p>
                Use the built-in <code>Validators.email</code> which follows the same spec as the HTML5 <code>type="email"</code> input.
            </p>
            <pre><code>import { Validators } from '@angular/forms';

this.form = this.fb.group({
  email: ['', [Validators.required, Validators.email]]
});</code></pre>

            <h5>Phoenix (Elixir)</h5>
            <p>
                Use Ecto changeset validations to check email format.
            </p>
            <pre><code>def changeset(user, attrs) do
  user
  |> cast(attrs, [:email])
  |> validate_required([:email])
  |> validate_format(:email, ~r/^[^\s]+@[^\s]+\.[^\s]+$/)
end</code></pre>

            <h5>Next.js / React</h5>
            <p>
                Use the native HTML5 email input for client-side validation. For server-side validation in API routes, use <code>validator.js</code>.
            </p>
            <pre><code>// Client-side (React component)
&lt;input type="email" name="email" required /&gt;

// Server-side (API route)
import validator from 'validator';
if (!validator.isEmail(req.body.email)) {
  return res.status(400).json({ error: 'Invalid email' });
}</code></pre>

            <h5>Vue.js (Vuelidate)</h5>
            <p>
                Use the <a href="https://vuelidate-next.netlify.app/" target="_blank"><code>Vuelidate</code></a> library's built-in email validator.
            </p>
            <pre><code>import { required, email } from '@vuelidate/validators';

const rules = {
  email: { required, email }
};</code></pre>

            <h5>Gin (Go)</h5>
            <p>
                Use the <code>binding:"email"</code> struct tag which validates email format using the <code>go-playground/validator</code> package.
            </p>
            <pre><code>type RegisterInput struct {
    Email string `json:"email" binding:"required,email"`
}</code></pre>
        </div>
    </div>
</section>
@endsection
