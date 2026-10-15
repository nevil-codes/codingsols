@php($lang = 'de')
<x-legal-page lang="de" title="Nutzungsbedingungen" :updated="config('legal.terms_version')" :other="route('legal.terms')">
    <p>Diese Nutzungsbedingungen gelten für die Nutzung von Codingsols, einem kostenlosen Frage-und-Antwort-Forum für Programmiererinnen und Programmierer. Mit der Registrierung erklärst du dich mit ihnen einverstanden. Wie wir mit personenbezogenen Daten umgehen, erklären wir gesondert in unserer <a href="{{ route('legal.privacy.de') }}">Datenschutzerklärung</a>.</p>

    <h2>1. Betreiber</h2>
    @include('legal.partials.operator')

    <h2>2. Leistungsbeschreibung</h2>
    <p>Auf Codingsols kannst du Fragen und Antworten ohne Konto lesen und mit einem Konto Fragen stellen, antworten, Beiträge bewerten und Inhalte melden. Die Nutzung ist kostenlos. Wir bemühen uns um eine möglichst hohe Verfügbarkeit, ein Anspruch auf eine bestimmte Verfügbarkeit oder bestimmte Funktionen besteht jedoch nicht. Wir können den Dienst ändern oder einstellen.</p>

    <h2>3. Dein Konto</h2>
    <ul>
        <li>Für ein Konto musst du mindestens 16 Jahre alt sein.</li>
        <li>Verwende eine gültige E-Mail-Adresse, auf die du Zugriff hast. Jedes Konto ist für eine Person bestimmt.</li>
        <li>Halte dein Passwort geheim. Du bist für Aktivitäten über dein Konto verantwortlich; informiere uns sofort, wenn du vermutest, dass jemand anderes Zugriff darauf hat.</li>
    </ul>

    <h2>4. Regeln für Inhalte und Verhalten</h2>
    <p>Du bist für deine Beiträge verantwortlich. Unzulässig sind insbesondere Inhalte und Handlungen, die:</p>
    <ul>
        <li>rechtswidrig sind oder Rechte Dritter verletzen, etwa Urheber-, Marken- oder Persönlichkeitsrechte;</li>
        <li>andere belästigen, bedrohen, beleidigen oder diskriminieren;</li>
        <li>Spam, Werbung oder Eigenwerbung ohne Bezug zur Frage darstellen;</li>
        <li>Schadsoftware, Phishing-Links oder schädlichen Code enthalten;</li>
        <li>personenbezogene Daten, Passwörter oder Geheimnisse anderer (auch deine eigenen API-Schlüssel) offenlegen;</li>
        <li>sich als eine andere Person ausgeben oder versuchen, Ratenbegrenzungen zu umgehen, die Sicherheit der Website zu verletzen oder massenhaft Daten abzugreifen.</li>
    </ul>
    <p>Antworten stammen von Mitgliedern und können fehlerhaft oder veraltet sein. Prüfe Code, bevor du ihn verwendest, insbesondere in Produktivsystemen. Die Verwendung erfolgt auf eigenes Risiko.</p>

    <h2>5. Rechte an deinen Inhalten</h2>
    <p>Die Rechte an deinen Beiträgen bleiben bei dir. Du räumst dem Betreiber ein unentgeltliches, nicht ausschließliches, weltweites Nutzungsrecht ein, deine Inhalte auf Codingsols zu speichern, anzuzeigen, öffentlich zugänglich zu machen und für die Darstellung zu formatieren, solange sie auf der Website veröffentlicht sind. Außerdem erlaubst du anderen Mitgliedern, von dir veröffentlichte Code-Snippets für beliebige Zwecke zu nutzen, zu kopieren und anzupassen. Veröffentliche nur Inhalte, zu deren Weitergabe du berechtigt bist.</p>

    <h2>6. Moderation</h2>
    <p>Inhalte, die gegen diese Bedingungen oder geltendes Recht verstoßen, kannst du über die Melden-Funktion an jedem Beitrag oder über das <a href="{{ route('contact') }}">Kontaktformular</a> melden. Administratoren können Themen sperren oder Inhalte entfernen, die gegen diese Bedingungen oder geltendes Recht verstoßen, und in schweren oder wiederholten Fällen Konten sperren oder löschen. Soweit gesetzlich vorgeschrieben, teilen wir dir die Gründe für die Entfernung deiner Inhalte oder die Einschränkung deines Kontos mit; du kannst der Entscheidung über die Kontaktmöglichkeiten widersprechen.</p>

    <h2>7. Haftung</h2>
    <p>Da der Dienst unentgeltlich ist, haftet der Betreiber nur für Vorsatz und grobe Fahrlässigkeit. Diese Beschränkung gilt nicht bei Verletzung von Leben, Körper oder Gesundheit, bei einer Haftung nach dem Produkthaftungsgesetz oder bei Übernahme einer Garantie. Von Mitgliedern veröffentlichte Inhalte machen wir uns nicht zu eigen; für deren Richtigkeit übernehmen wir keine Gewähr.</p>

    <h2>8. Beendigung</h2>
    <p>Du kannst dein Konto jederzeit in deinen Profileinstellungen löschen. Wir können die Nutzung mit angemessener Frist beenden, bei schwerwiegenden Verstößen gegen diese Bedingungen auch fristlos.</p>

    <h2>9. Änderungen dieser Bedingungen</h2>
    <p>Wir können diese Bedingungen anpassen, etwa wenn wir neue Funktionen einführen oder sich die Rechtslage ändert. Über wesentliche Änderungen informieren wir registrierte Mitglieder mindestens vier Wochen vor ihrem Inkrafttreten per E-Mail. Wenn du nicht einverstanden bist, kannst du dein Konto vorher löschen.</p>

    <h2>10. Anwendbares Recht</h2>
    <p>Es gilt das Recht der Bundesrepublik Deutschland. Bist du Verbraucher, bleibt der Schutz durch zwingende Vorschriften des Staates, in dem du deinen gewöhnlichen Aufenthalt hast, unberührt. Sollte eine Bestimmung unwirksam sein, bleiben die übrigen Bestimmungen wirksam.</p>
</x-legal-page>
