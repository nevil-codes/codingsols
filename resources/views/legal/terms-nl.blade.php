@php($lang = 'nl')
<x-legal-page lang="nl" title="Gebruiksvoorwaarden" :updated="config('legal.terms_version')">
    <p>Deze voorwaarden gelden voor het gebruik van Codingsols, een gratis vraag-en-antwoordforum voor programmeurs. Door een account aan te maken ga je ermee akkoord. Hoe we met persoonsgegevens omgaan, lees je apart in onze <a href="{{ route('legal.privacy', ['lang' => 'nl']) }}">privacyverklaring</a>.</p>

    <h2>1. Beheerder</h2>
    @include('legal.partials.operator')

    <h2>2. De dienst</h2>
    <p>Op Codingsols kun je zonder account vragen en antwoorden lezen en met een account vragen stellen, antwoorden, stemmen en inhoud melden. De dienst is gratis. We doen ons best om hem beschikbaar te houden, maar er bestaat geen recht op een bepaalde beschikbaarheid of functie, en we kunnen de dienst wijzigen of stopzetten.</p>

    <h2>3. Je account</h2>
    <ul>
        <li>Je moet minstens 16 jaar oud zijn om een account aan te maken.</li>
        <li>Gebruik een geldig e-mailadres waar je toegang toe hebt. Elk account is voor één persoon.</li>
        <li>Houd je wachtwoord geheim. Je bent verantwoordelijk voor wat er met je account gebeurt; laat het ons direct weten als je denkt dat iemand anders toegang heeft.</li>
    </ul>

    <h2>4. Regels voor inhoud en gedrag</h2>
    <p>Je bent verantwoordelijk voor wat je plaatst. Plaats of doe niets wat:</p>
    <ul>
        <li>onrechtmatig is of inbreuk maakt op rechten van anderen, zoals auteursrecht, merkrecht of persoonlijkheidsrechten;</li>
        <li>iemand lastigvalt, bedreigt, beledigt of discrimineert;</li>
        <li>spam, reclame of zelfpromotie is zonder verband met de vraag;</li>
        <li>malware, phishinglinks of code bevat die bedoeld is om schade aan te richten;</li>
        <li>persoonsgegevens, wachtwoorden of geheimen van anderen openbaar maakt (ook je eigen API-sleutels);</li>
        <li>zich voordoet als iemand anders, of probeert snelheidslimieten te omzeilen, de beveiliging van de site te doorbreken of op grote schaal gegevens te verzamelen.</li>
    </ul>
    <p>Antwoorden worden door leden geschreven en kunnen onjuist of verouderd zijn. Controleer code voordat je die gebruikt, zeker in productie. Je gebruikt hem op eigen risico.</p>

    <h2>5. Rechten op je inhoud</h2>
    <p>De rechten op wat je plaatst blijven bij jou. Je geeft de beheerder een kosteloze, niet-exclusieve, wereldwijde licentie om je inhoud op Codingsols op te slaan, te tonen, openbaar te maken en voor weergave op te maken, zolang die op de site staat. Ook sta je andere leden toe de codefragmenten die je plaatst voor elk doel te gebruiken, te kopiëren en aan te passen. Plaats alleen inhoud die je mag delen.</p>

    <h2>6. Moderatie</h2>
    <p>Inhoud die in strijd is met deze voorwaarden of de wet kun je melden met de meldknop bij elk bericht of via het <a href="{{ route('contact') }}">contactformulier</a>. Beheerders kunnen discussies sluiten of inhoud verwijderen die in strijd is met deze voorwaarden of de wet, en bij ernstige of herhaalde overtredingen accounts blokkeren of verwijderen. Waar de wet dat vereist, laten we je weten waarom je inhoud is verwijderd of je account is beperkt, en kun je contact met ons opnemen om de beslissing aan te vechten.</p>

    <h2>7. Aansprakelijkheid</h2>
    <p>Omdat de dienst gratis is, is de beheerder alleen aansprakelijk voor opzet en grove nalatigheid. Deze beperking geldt niet bij letsel aan leven, lichaam of gezondheid, bij aansprakelijkheid op grond van de Duitse productaansprakelijkheidswet (Produkthaftungsgesetz) of als er een garantie is gegeven. Inhoud die leden plaatsen maken we ons niet eigen en we zijn niet verantwoordelijk voor de juistheid ervan.</p>

    <h2>8. Beëindiging</h2>
    <p>Je kunt je account op elk moment verwijderen in je profielinstellingen. Wij kunnen je gebruik beëindigen met een redelijke opzegtermijn, of direct bij een ernstige overtreding van deze voorwaarden.</p>

    <h2>9. Wijziging van deze voorwaarden</h2>
    <p>We kunnen deze voorwaarden aanpassen, bijvoorbeeld als we functies toevoegen of de wet verandert. Over belangrijke wijzigingen sturen we geregistreerde leden ten minste vier weken voor de ingangsdatum een e-mail. Ben je het er niet mee eens, dan kun je je account vóór die datum verwijderen.</p>

    <h2>10. Toepasselijk recht</h2>
    <p>Op deze voorwaarden is het recht van de Bondsrepubliek Duitsland van toepassing. Ben je consument, dan behoud je de bescherming van de dwingende bepalingen van het land waar je gewoonlijk woont. Als een bepaling ongeldig is, blijven de overige bepalingen van kracht.</p>
</x-legal-page>
