@php($lang = 'en')
<x-legal-page lang="en" title="Privacy Policy" :updated="config('legal.privacy_updated')">
    <p>This policy explains what personal data Codingsols collects, why, and what rights you have under the EU General Data Protection Regulation (GDPR). Codingsols has no advertising, no analytics and no tracking cookies.</p>

    <h2>1. Who is responsible</h2>
    <p>The controller responsible for data processing on this website is:</p>
    @include('legal.partials.operator')
    <p>You can also reach us through the <a href="{{ route('contact') }}">contact form</a>.</p>

    <h2>2. Visiting the website</h2>
    <p>When you open a page, our hosting provider automatically processes technical data that your browser sends: your IP address, the date and time, the page requested, the referring page, and your browser and operating system (user agent). This is needed to deliver the website, keep it secure and find errors. These server logs are kept only for a short time.</p>
    <p><strong>Legal basis:</strong> Art. 6(1)(f) GDPR (our legitimate interest in running a secure, working website).</p>

    <h2>3. Cookies and local storage</h2>
    <p>We only use what is strictly necessary for the site to work:</p>
    <ul>
        <li><strong><code>codingsols-session</code></strong>: keeps you logged in and remembers form input between pages. Expires after 2 hours of inactivity, or when you log out.</li>
        <li><strong><code>XSRF-TOKEN</code></strong>: protects forms against cross-site request forgery. Expires after 2 hours.</li>
        <li><strong><code>locale</code></strong>: remembers the language you picked in the language menu. Only set when you pick one; expires after 1 year.</li>
        <li><strong><code>theme</code></strong> (local storage in your browser): remembers whether you chose light or dark mode. It never leaves your device.</li>
    </ul>
    <p>Because these are strictly necessary for a service you requested, no consent is required (§ 25(2) no. 2 TDDDG). The session data stored on our server includes your IP address and user agent, so we can protect your account; it is deleted when the session expires.</p>

    <h2>4. Your account</h2>
    <p>When you sign up we store your <strong>name, email address and password</strong> (only as a secure hash, never in readable form), and the date you accepted the <a href="{{ route('legal.terms', ['lang' => 'en']) }}">Terms of Use</a>. We use your email address to verify your account, reset your password and, if you want, tell you about replies to your questions.</p>
    <p><strong>Legal basis:</strong> Art. 6(1)(b) GDPR (providing the service you signed up for).</p>
    <p><strong>Storage period:</strong> until you delete your account. You can do this yourself at any time in your profile settings.</p>

    <h2>5. Questions, replies, votes and reports</h2>
    <p>Questions and replies you post are <strong>public</strong>: anyone can read them, together with your name and the date, and search engines may index them. Votes and reports are linked to your account but are not shown to other members; reports are seen by administrators.</p>
    <p>When you delete your account, your questions, replies, votes and reports are deleted with it. Copies may remain in search engine caches for a while, which we cannot control.</p>
    <p><strong>Legal basis:</strong> Art. 6(1)(b) GDPR, and Art. 6(1)(f) GDPR for moderation (our legitimate interest in a safe forum).</p>

    <h2>6. Notifications</h2>
    <p>When someone replies to your question you get a notification on the site and, unless you turn it off in your profile settings, an email (at most one per question every 15 minutes). Notifications are deleted with your account.</p>

    <h2>7. Contact form</h2>
    <p>If you use the contact form, we store your name, email address and message to answer you. We delete them once they are no longer needed for your request.</p>
    <p><strong>Legal basis:</strong> Art. 6(1)(b) GDPR if your message relates to a contract or your account, otherwise Art. 6(1)(f) GDPR (our legitimate interest in answering enquiries).</p>

    <h2>8. Protection against abuse</h2>
    <p>To stop spam and attacks, forms contain a hidden field and a timing check, and we limit how often actions can be repeated. For this, your IP address or account ID is kept in a temporary counter for at most 24 hours.</p>
    @if (config('services.turnstile.site_key'))
        <p>The sign-up and contact forms also use <strong>Cloudflare Turnstile</strong>, a bot check by Cloudflare, Inc. (USA). When the form loads, Cloudflare receives your IP address and technical information about your browser to tell humans from bots. See <a href="https://www.cloudflare.com/privacypolicy/" rel="noopener">Cloudflare's privacy policy</a>.</p>
    @endif
    <p><strong>Legal basis:</strong> Art. 6(1)(f) GDPR (our legitimate interest in protecting the site and its users).</p>

    <h2>9. Service providers</h2>
    <p>We use these processors, bound by data processing agreements (Art. 28 GDPR):</p>
    <ul>
        <li><strong>Vercel Inc.</strong> (USA): hosting. Requests are processed in Frankfurt, Germany, where possible. <a href="https://vercel.com/legal/privacy-policy" rel="noopener">Privacy policy</a></li>
        <li><strong>Neon Inc.</strong> (USA): database. Data is stored in {{ config('legal.database_location.en') }}. <a href="https://neon.tech/privacy-policy" rel="noopener">Privacy policy</a></li>
        <li><strong>Resend, Inc.</strong> (USA): sending emails, from servers in the EU (Ireland). <a href="https://resend.com/legal/privacy-policy" rel="noopener">Privacy policy</a></li>
        @if (config('sentry.dsn'))
            <li><strong>Functional Software, Inc. (Sentry)</strong> (USA): error reports, so we can fix bugs. Reports contain technical details about the error; we have disabled sending IP addresses and other personal data. <a href="https://sentry.io/privacy/" rel="noopener">Privacy policy</a></li>
        @endif
    </ul>
    <p>Where data is transferred to the USA, this is based on the EU-U.S. Data Privacy Framework where the provider is certified, and otherwise on the EU Standard Contractual Clauses (Art. 46(2)(c) GDPR).</p>

    <h2>10. Your rights</h2>
    <p>You have the right to:</p>
    <ul>
        <li>access the personal data we hold about you (Art. 15 GDPR),</li>
        <li>have incorrect data corrected (Art. 16 GDPR),</li>
        <li>have your data deleted (Art. 17 GDPR) or its processing restricted (Art. 18 GDPR),</li>
        <li>receive your data in a common, machine-readable format (Art. 20 GDPR),</li>
        <li><strong>object</strong> at any time to processing based on our legitimate interests, on grounds relating to your particular situation (Art. 21 GDPR),</li>
        <li>lodge a complaint with a data protection supervisory authority, in particular in the EU member state where you live or work (Art. 77 GDPR).</li>
    </ul>
    <p>To exercise these rights, contact us using the details in section 1. You can change your name and email, and delete your account, yourself in your profile settings.</p>

    <h2>11. Required data</h2>
    <p>You can read the forum without an account. To post, you need an account, which requires a name, email address and password.</p>

    <h2>12. No automated decisions</h2>
    <p>We do not use automated decision-making or profiling within the meaning of Art. 22 GDPR.</p>

    <h2>13. Changes</h2>
    <p>We update this policy when the site or the law changes. The current version is always available on this page.</p>
</x-legal-page>
