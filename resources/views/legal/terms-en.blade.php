@php($lang = 'en')
<x-legal-page lang="en" title="Terms of Use" :updated="config('legal.terms_version')" :other="route('legal.terms.de')">
    <p>These terms apply to the use of Codingsols, a free question-and-answer forum for programmers. By creating an account you agree to them. How we handle personal data is explained separately in our <a href="{{ route('legal.privacy') }}">Privacy Policy</a>.</p>

    <h2>1. Operator</h2>
    @include('legal.partials.operator')

    <h2>2. The service</h2>
    <p>Codingsols lets you read questions and answers without an account and, with an account, ask questions, reply, vote and report content. The service is free of charge. We work to keep it available, but there is no right to any particular availability or feature, and we may change or discontinue the service.</p>

    <h2>3. Your account</h2>
    <ul>
        <li>You must be at least 16 years old to create an account.</li>
        <li>Use a valid email address that you can access. Each account is for one person.</li>
        <li>Keep your password secret. You are responsible for activity under your account; tell us straight away if you think someone else has access to it.</li>
    </ul>

    <h2>4. Rules for content and conduct</h2>
    <p>You are responsible for what you post. Do not post or do anything that:</p>
    <ul>
        <li>is illegal, or infringes the rights of others, such as copyright, trademarks or personality rights;</li>
        <li>harasses, threatens, insults or discriminates against anyone;</li>
        <li>is spam, advertising or self-promotion unrelated to the question;</li>
        <li>contains malware, phishing links or code intended to cause harm;</li>
        <li>discloses other people's personal data, passwords or secrets (including your own API keys);</li>
        <li>impersonates another person, or tries to bypass rate limits, break the site's security or collect data from it at scale.</li>
    </ul>
    <p>Answers are written by members and may be wrong or out of date. Check code before you use it, especially in production. You use it at your own risk.</p>

    <h2>5. Rights to your content</h2>
    <p>You keep the rights to what you post. You grant the operator a free, non-exclusive, worldwide licence to store, display and make your content publicly available on Codingsols and to format it for display, for as long as it is on the site. You also allow other members to use, copy and adapt the code snippets you post for any purpose. Only post content you have the right to share.</p>

    <h2>6. Moderation</h2>
    <p>You can report content that breaks these terms or the law using the report button on every post, or through the <a href="{{ route('contact') }}">contact form</a>. Administrators may lock threads or remove content that breaks these terms or the law, and may suspend or delete accounts in serious or repeated cases. Where required by law, we tell you why your content was removed or your account restricted, and you can contact us to disagree with the decision.</p>

    <h2>7. Liability</h2>
    <p>Because the service is free, the operator is only liable for intent and gross negligence. This limitation does not apply to injury to life, body or health, to liability under the German Product Liability Act, or where a guarantee was given. We do not adopt content posted by members as our own and are not responsible for its accuracy.</p>

    <h2>8. Ending your use</h2>
    <p>You can delete your account at any time in your profile settings. We may end your use with reasonable notice, or immediately if you seriously breach these terms.</p>

    <h2>9. Changes to these terms</h2>
    <p>We may update these terms, for example when we add features or the law changes. We will email registered members about significant changes at least four weeks before they take effect. If you don't agree, you can delete your account before then.</p>

    <h2>10. Applicable law</h2>
    <p>These terms are governed by the law of the Federal Republic of Germany. If you are a consumer, this does not take away the protection of the mandatory laws of the country where you normally live. If one provision is invalid, the rest remain in effect.</p>
</x-legal-page>
