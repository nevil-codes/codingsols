@php($lang = 'de')
<x-legal-page lang="de" title="Datenschutzerklärung" :updated="config('legal.privacy_updated')" :other="route('legal.privacy')">
    <p>Diese Datenschutzerklärung informiert dich darüber, welche personenbezogenen Daten Codingsols verarbeitet, zu welchem Zweck und welche Rechte du nach der Datenschutz-Grundverordnung (DSGVO) hast. Codingsols verwendet keine Werbung, keine Analyse-Tools und keine Tracking-Cookies.</p>

    <h2>1. Verantwortlicher</h2>
    <p>Verantwortlich für die Datenverarbeitung auf dieser Website ist:</p>
    @include('legal.partials.operator')
    <p>Du erreichst uns außerdem über das <a href="{{ route('contact') }}">Kontaktformular</a>.</p>

    <h2>2. Aufruf der Website</h2>
    <p>Beim Aufruf einer Seite verarbeitet unser Hosting-Anbieter automatisch technische Daten, die dein Browser übermittelt: IP-Adresse, Datum und Uhrzeit, aufgerufene Seite, verweisende Seite sowie Browser und Betriebssystem (User-Agent). Das ist erforderlich, um die Website auszuliefern, sie abzusichern und Fehler zu finden. Diese Server-Logs werden nur kurze Zeit gespeichert.</p>
    <p><strong>Rechtsgrundlage:</strong> Art. 6 Abs. 1 lit. f DSGVO (berechtigtes Interesse an einem sicheren und funktionsfähigen Betrieb der Website).</p>

    <h2>3. Cookies und lokaler Speicher</h2>
    <p>Wir setzen ausschließlich technisch notwendige Speichertechnologien ein:</p>
    <ul>
        <li><strong><code>codingsols-session</code></strong>: hält dich angemeldet und merkt sich Formulareingaben zwischen Seiten. Läuft nach 2 Stunden Inaktivität oder beim Abmelden ab.</li>
        <li><strong><code>XSRF-TOKEN</code></strong>: schützt Formulare vor Cross-Site-Request-Forgery. Läuft nach 2 Stunden ab.</li>
        <li><strong><code>theme</code></strong> (lokaler Speicher im Browser): merkt sich, ob du den hellen oder dunklen Modus gewählt hast. Dieser Wert verlässt dein Gerät nicht.</li>
    </ul>
    <p>Da diese Speicherungen für einen von dir ausdrücklich gewünschten Dienst unbedingt erforderlich sind, ist keine Einwilligung nötig (§ 25 Abs. 2 Nr. 2 TDDDG). Zu einer Sitzung speichern wir auf dem Server auch deine IP-Adresse und deinen User-Agent, um dein Konto zu schützen; diese Daten werden mit Ablauf der Sitzung gelöscht.</p>

    <h2>4. Dein Benutzerkonto</h2>
    <p>Bei der Registrierung speichern wir deinen <strong>Namen, deine E-Mail-Adresse und dein Passwort</strong> (nur als sicherer Hash, nie im Klartext) sowie den Zeitpunkt, zu dem du den <a href="{{ route('legal.terms.de') }}">Nutzungsbedingungen</a> zugestimmt hast. Deine E-Mail-Adresse nutzen wir, um dein Konto zu bestätigen, dein Passwort zurückzusetzen und dich – wenn du möchtest – über Antworten auf deine Fragen zu informieren.</p>
    <p><strong>Rechtsgrundlage:</strong> Art. 6 Abs. 1 lit. b DSGVO (Bereitstellung des Dienstes, für den du dich registriert hast).</p>
    <p><strong>Speicherdauer:</strong> bis du dein Konto löschst. Das kannst du jederzeit selbst in deinen Profileinstellungen tun.</p>

    <h2>5. Fragen, Antworten, Bewertungen und Meldungen</h2>
    <p>Fragen und Antworten, die du veröffentlichst, sind <strong>öffentlich</strong>: Jeder kann sie zusammen mit deinem Namen und dem Datum lesen, und Suchmaschinen können sie indexieren. Bewertungen (Votes) und Meldungen sind deinem Konto zugeordnet, werden anderen Mitgliedern aber nicht angezeigt; Meldungen sehen nur Administratoren.</p>
    <p>Wenn du dein Konto löschst, werden deine Fragen, Antworten, Bewertungen und Meldungen mitgelöscht. Kopien in Zwischenspeichern von Suchmaschinen können noch eine Weile bestehen; darauf haben wir keinen Einfluss.</p>
    <p><strong>Rechtsgrundlage:</strong> Art. 6 Abs. 1 lit. b DSGVO sowie für die Moderation Art. 6 Abs. 1 lit. f DSGVO (berechtigtes Interesse an einem sicheren Forum).</p>

    <h2>6. Benachrichtigungen</h2>
    <p>Wenn jemand auf deine Frage antwortet, erhältst du eine Benachrichtigung auf der Website und – sofern du das nicht in deinen Profileinstellungen abschaltest – eine E-Mail (höchstens eine pro Frage alle 15 Minuten). Benachrichtigungen werden mit deinem Konto gelöscht.</p>

    <h2>7. Kontaktformular</h2>
    <p>Wenn du das Kontaktformular nutzt, speichern wir deinen Namen, deine E-Mail-Adresse und deine Nachricht, um dir zu antworten. Wir löschen diese Daten, sobald sie für die Bearbeitung deiner Anfrage nicht mehr erforderlich sind.</p>
    <p><strong>Rechtsgrundlage:</strong> Art. 6 Abs. 1 lit. b DSGVO, wenn deine Anfrage dein Konto oder einen Vertrag betrifft, ansonsten Art. 6 Abs. 1 lit. f DSGVO (berechtigtes Interesse an der Beantwortung von Anfragen).</p>

    <h2>8. Schutz vor Missbrauch</h2>
    <p>Zum Schutz vor Spam und Angriffen enthalten Formulare ein verstecktes Feld und eine Zeitprüfung, und wir begrenzen, wie oft Aktionen wiederholt werden können. Dafür wird deine IP-Adresse bzw. Konto-ID höchstens 24 Stunden in einem temporären Zähler gespeichert.</p>
    @if (config('services.turnstile.site_key'))
        <p>Die Formulare für Registrierung und Kontakt nutzen zusätzlich <strong>Cloudflare Turnstile</strong>, eine Bot-Erkennung der Cloudflare, Inc. (USA). Beim Laden des Formulars erhält Cloudflare deine IP-Adresse und technische Informationen über deinen Browser, um Menschen von Bots zu unterscheiden. Siehe die <a href="https://www.cloudflare.com/de-de/privacypolicy/" rel="noopener">Datenschutzerklärung von Cloudflare</a>.</p>
    @endif
    <p><strong>Rechtsgrundlage:</strong> Art. 6 Abs. 1 lit. f DSGVO (berechtigtes Interesse am Schutz der Website und ihrer Nutzer).</p>

    <h2>9. Dienstleister</h2>
    <p>Wir setzen folgende Auftragsverarbeiter ein, mit denen Verträge zur Auftragsverarbeitung (Art. 28 DSGVO) bestehen:</p>
    <ul>
        <li><strong>Vercel Inc.</strong> (USA): Hosting. Anfragen werden nach Möglichkeit in Frankfurt am Main verarbeitet. <a href="https://vercel.com/legal/privacy-policy" rel="noopener">Datenschutzerklärung</a></li>
        <li><strong>Neon Inc.</strong> (USA): Datenbank. Die Daten werden in {{ config('legal.database_location.de') }} gespeichert. <a href="https://neon.tech/privacy-policy" rel="noopener">Datenschutzerklärung</a></li>
        <li><strong>Resend, Inc.</strong> (USA): Versand von E-Mails über Server in der EU (Irland). <a href="https://resend.com/legal/privacy-policy" rel="noopener">Datenschutzerklärung</a></li>
        @if (config('sentry.dsn'))
            <li><strong>Functional Software, Inc. (Sentry)</strong> (USA): Fehlerberichte, damit wir Fehler beheben können. Die Berichte enthalten technische Angaben zum Fehler; die Übermittlung von IP-Adressen und anderen personenbezogenen Daten haben wir deaktiviert. <a href="https://sentry.io/privacy/" rel="noopener">Datenschutzerklärung</a></li>
        @endif
    </ul>
    <p>Soweit Daten in die USA übermittelt werden, erfolgt dies auf Grundlage des EU-US Data Privacy Framework, sofern der Anbieter zertifiziert ist, und andernfalls auf Grundlage der EU-Standardvertragsklauseln (Art. 46 Abs. 2 lit. c DSGVO).</p>

    <h2>10. Deine Rechte</h2>
    <p>Du hast das Recht auf:</p>
    <ul>
        <li>Auskunft über die zu dir gespeicherten Daten (Art. 15 DSGVO),</li>
        <li>Berichtigung unrichtiger Daten (Art. 16 DSGVO),</li>
        <li>Löschung (Art. 17 DSGVO) oder Einschränkung der Verarbeitung (Art. 18 DSGVO),</li>
        <li>Datenübertragbarkeit in einem gängigen, maschinenlesbaren Format (Art. 20 DSGVO),</li>
        <li><strong>Widerspruch</strong> gegen Verarbeitungen, die auf unserem berechtigten Interesse beruhen, aus Gründen, die sich aus deiner besonderen Situation ergeben (Art. 21 DSGVO),</li>
        <li>Beschwerde bei einer Datenschutz-Aufsichtsbehörde, insbesondere in dem EU-Mitgliedstaat deines Wohnorts oder Arbeitsplatzes (Art. 77 DSGVO).</li>
    </ul>
    <p>Um diese Rechte auszuüben, wende dich an die in Abschnitt 1 genannten Kontaktdaten. Name und E-Mail-Adresse kannst du selbst in deinen Profileinstellungen ändern und dort auch dein Konto löschen.</p>

    <h2>11. Pflicht zur Bereitstellung</h2>
    <p>Das Forum kannst du ohne Konto lesen. Zum Veröffentlichen brauchst du ein Konto, für das Name, E-Mail-Adresse und Passwort erforderlich sind.</p>

    <h2>12. Keine automatisierte Entscheidungsfindung</h2>
    <p>Wir setzen keine automatisierte Entscheidungsfindung oder Profiling im Sinne von Art. 22 DSGVO ein.</p>

    <h2>13. Änderungen</h2>
    <p>Wir passen diese Datenschutzerklärung an, wenn sich die Website oder die Rechtslage ändert. Die aktuelle Fassung findest du immer auf dieser Seite.</p>
</x-legal-page>
