@php($lang = 'nl')
<x-legal-page lang="nl" title="Privacyverklaring" :updated="config('legal.privacy_updated')">
    <p>In deze verklaring lees je welke persoonsgegevens Codingsols verwerkt, waarom, en welke rechten je hebt op grond van de Algemene verordening gegevensbescherming (AVG). Codingsols gebruikt geen advertenties, geen analysetools en geen trackingcookies.</p>

    <h2>1. Verwerkingsverantwoordelijke</h2>
    <p>Verantwoordelijk voor de verwerking van gegevens op deze website is:</p>
    @include('legal.partials.operator')
    <p>Je kunt ons ook bereiken via het <a href="{{ route('contact') }}">contactformulier</a>.</p>

    <h2>2. Bezoek aan de website</h2>
    <p>Als je een pagina opent, verwerkt onze hostingprovider automatisch technische gegevens die je browser meestuurt: je IP-adres, datum en tijd, de opgevraagde pagina, de verwijzende pagina en je browser en besturingssysteem (user agent). Dit is nodig om de website te tonen, te beveiligen en fouten op te sporen. Deze serverlogs worden maar kort bewaard.</p>
    <p><strong>Rechtsgrond:</strong> art. 6 lid 1 sub f AVG (ons gerechtvaardigd belang bij een veilige, goed werkende website).</p>

    <h2>3. Cookies en lokale opslag</h2>
    <p>We gebruiken alleen wat strikt noodzakelijk is om de site te laten werken:</p>
    <ul>
        <li><strong><code>codingsols-session</code></strong>: houdt je ingelogd en onthoudt formulierinvoer tussen pagina's. Verloopt na 2 uur inactiviteit of wanneer je uitlogt.</li>
        <li><strong><code>XSRF-TOKEN</code></strong>: beschermt formulieren tegen cross-site request forgery. Verloopt na 2 uur.</li>
        <li><strong><code>locale</code></strong>: onthoudt de taal die je in het taalmenu hebt gekozen. Wordt alleen geplaatst als je een taal kiest; verloopt na 1 jaar.</li>
        <li><strong><code>theme</code></strong> (lokale opslag in je browser): onthoudt of je de lichte of donkere modus hebt gekozen. Deze waarde verlaat je apparaat nooit.</li>
    </ul>
    <p>Omdat deze strikt noodzakelijk zijn voor een dienst waar je zelf om hebt gevraagd, is geen toestemming nodig (art. 5 lid 3 van Richtlijn 2002/58/EG, in Nederland art. 11.7a Telecommunicatiewet, en § 25 lid 2 nr. 2 TDDDG). De sessiegegevens op onze server bevatten je IP-adres en user agent, zodat we je account kunnen beschermen; ze worden verwijderd zodra de sessie verloopt.</p>

    <h2>4. Je account</h2>
    <p>Bij je registratie slaan we je <strong>naam, e-mailadres en wachtwoord</strong> op (alleen als veilige hash, nooit leesbaar), en de datum waarop je de <a href="{{ route('legal.terms', ['lang' => 'nl']) }}">gebruiksvoorwaarden</a> hebt geaccepteerd. Je e-mailadres gebruiken we om je account te bevestigen, je wachtwoord te herstellen en je, als je dat wilt, te laten weten dat er op je vragen is gereageerd.</p>
    <p><strong>Rechtsgrond:</strong> art. 6 lid 1 sub b AVG (het leveren van de dienst waarvoor je je hebt aangemeld).</p>
    <p><strong>Bewaartermijn:</strong> tot je je account verwijdert. Dat kun je op elk moment zelf doen in je profielinstellingen.</p>

    <h2>5. Vragen, antwoorden, stemmen en meldingen</h2>
    <p>Vragen en antwoorden die je plaatst zijn <strong>openbaar</strong>: iedereen kan ze lezen, samen met je naam en de datum, en zoekmachines kunnen ze indexeren. Stemmen en meldingen zijn aan je account gekoppeld maar zijn niet zichtbaar voor andere leden; meldingen worden bekeken door beheerders.</p>
    <p>Als je je account verwijdert, worden je vragen, antwoorden, stemmen en meldingen ook verwijderd. Kopieën kunnen nog een tijd in de cache van zoekmachines staan; daar hebben wij geen invloed op.</p>
    <p><strong>Rechtsgrond:</strong> art. 6 lid 1 sub b AVG, en voor moderatie art. 6 lid 1 sub f AVG (ons gerechtvaardigd belang bij een veilig forum).</p>

    <h2>6. Meldingen over reacties</h2>
    <p>Als iemand op je vraag reageert, krijg je een melding op de site en, tenzij je dit uitzet in je profielinstellingen, een e-mail (maximaal één per vraag per 15 minuten). Meldingen worden samen met je account verwijderd.</p>

    <h2>7. Contactformulier</h2>
    <p>Als je het contactformulier gebruikt, slaan we je naam, e-mailadres en bericht op om je te antwoorden. We verwijderen deze gegevens zodra ze niet meer nodig zijn voor je vraag.</p>
    <p><strong>Rechtsgrond:</strong> art. 6 lid 1 sub b AVG als je bericht over een overeenkomst of je account gaat, anders art. 6 lid 1 sub f AVG (ons gerechtvaardigd belang bij het beantwoorden van vragen).</p>

    <h2>8. Bescherming tegen misbruik</h2>
    <p>Om spam en aanvallen tegen te gaan, bevatten formulieren een verborgen veld en een tijdscontrole, en beperken we hoe vaak acties herhaald kunnen worden. Daarvoor wordt je IP-adres of account-ID maximaal 24 uur in een tijdelijke teller bewaard.</p>
    @if (config('services.turnstile.site_key'))
        <p>De registratie- en contactformulieren gebruiken ook <strong>Cloudflare Turnstile</strong>, een botcontrole van Cloudflare, Inc. (VS). Bij het laden van het formulier ontvangt Cloudflare je IP-adres en technische informatie over je browser om mensen van bots te onderscheiden. Zie de <a href="https://www.cloudflare.com/nl-nl/privacypolicy/" rel="noopener">privacyverklaring van Cloudflare</a>.</p>
    @endif
    <p><strong>Rechtsgrond:</strong> art. 6 lid 1 sub f AVG (ons gerechtvaardigd belang bij de bescherming van de site en haar gebruikers).</p>

    <h2>9. Dienstverleners</h2>
    <p>We werken met de volgende verwerkers, met wie verwerkersovereenkomsten zijn gesloten (art. 28 AVG):</p>
    <ul>
        <li><strong>Vercel Inc.</strong> (VS): hosting. Verzoeken worden waar mogelijk in Frankfurt (Duitsland) verwerkt. <a href="https://vercel.com/legal/privacy-policy" rel="noopener">Privacyverklaring</a></li>
        <li><strong>Neon Inc.</strong> (VS): database. De gegevens worden opgeslagen in {{ config('legal.database_location.nl') }}. <a href="https://neon.tech/privacy-policy" rel="noopener">Privacyverklaring</a></li>
        <li><strong>Resend, Inc.</strong> (VS): verzenden van e-mails, vanaf servers in de EU (Ierland). <a href="https://resend.com/legal/privacy-policy" rel="noopener">Privacyverklaring</a></li>
        @if (config('sentry.dsn'))
            <li><strong>Functional Software, Inc. (Sentry)</strong> (VS): foutrapporten, zodat we bugs kunnen oplossen. De rapporten bevatten technische details over de fout; het versturen van IP-adressen en andere persoonsgegevens hebben we uitgeschakeld. <a href="https://sentry.io/privacy/" rel="noopener">Privacyverklaring</a></li>
        @endif
    </ul>
    <p>Waar gegevens naar de VS worden doorgegeven, gebeurt dit op basis van het EU-VS Data Privacy Framework als de dienstverlener gecertificeerd is, en anders op basis van de standaardcontractbepalingen van de EU (art. 46 lid 2 sub c AVG).</p>

    <h2>10. Je rechten</h2>
    <p>Je hebt het recht om:</p>
    <ul>
        <li>de persoonsgegevens in te zien die we over je hebben (art. 15 AVG),</li>
        <li>onjuiste gegevens te laten corrigeren (art. 16 AVG),</li>
        <li>je gegevens te laten wissen (art. 17 AVG) of de verwerking te laten beperken (art. 18 AVG),</li>
        <li>je gegevens te ontvangen in een gangbaar, machineleesbaar formaat (art. 20 AVG),</li>
        <li>op elk moment <strong>bezwaar</strong> te maken tegen verwerking op basis van ons gerechtvaardigd belang, om redenen die met je specifieke situatie te maken hebben (art. 21 AVG),</li>
        <li>een klacht in te dienen bij een toezichthoudende autoriteit, met name in de EU-lidstaat waar je woont of werkt (art. 77 AVG); in Nederland is dat de Autoriteit Persoonsgegevens.</li>
    </ul>
    <p>Neem voor het uitoefenen van deze rechten contact met ons op via de gegevens in sectie 1. Je naam en e-mailadres wijzigen en je account verwijderen kun je zelf in je profielinstellingen.</p>

    <h2>11. Verplichte gegevens</h2>
    <p>Je kunt het forum lezen zonder account. Om iets te plaatsen heb je een account nodig, waarvoor een naam, e-mailadres en wachtwoord verplicht zijn.</p>

    <h2>12. Geen geautomatiseerde besluiten</h2>
    <p>We gebruiken geen geautomatiseerde besluitvorming of profilering in de zin van art. 22 AVG.</p>

    <h2>13. Wijzigingen</h2>
    <p>We passen deze verklaring aan als de site of de wet verandert. De actuele versie staat altijd op deze pagina.</p>
</x-legal-page>
