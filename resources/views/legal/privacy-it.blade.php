@php($lang = 'it')
<x-legal-page lang="it" title="Informativa sulla privacy" :updated="config('legal.privacy_updated')">
    <p>Questa informativa spiega quali dati personali raccoglie Codingsols, per quali scopi e quali diritti hai ai sensi del Regolamento generale sulla protezione dei dati (GDPR). Codingsols non usa pubblicità, strumenti di analisi o cookie di tracciamento.</p>

    <h2>1. Titolare del trattamento</h2>
    <p>Il titolare del trattamento dei dati su questo sito è:</p>
    @include('legal.partials.operator')
    <p>Puoi contattarci anche tramite il <a href="{{ route('contact') }}">modulo di contatto</a>.</p>

    <h2>2. Visita del sito</h2>
    <p>Quando apri una pagina, il nostro fornitore di hosting tratta automaticamente i dati tecnici inviati dal tuo browser: indirizzo IP, data e ora, pagina richiesta, pagina di provenienza, browser e sistema operativo (user agent). Ciò è necessario per mostrare il sito, proteggerlo e individuare gli errori. Questi log del server vengono conservati solo per breve tempo.</p>
    <p><strong>Base giuridica:</strong> art. 6, par. 1, lett. f) GDPR (nostro legittimo interesse a gestire un sito sicuro e funzionante).</p>

    <h2>3. Cookie e archiviazione locale</h2>
    <p>Usiamo solo ciò che è strettamente necessario al funzionamento del sito:</p>
    <ul>
        <li><strong><code>codingsols-session</code></strong>: ti mantiene connesso e ricorda i dati inseriti nei moduli tra una pagina e l'altra. Scade dopo 2 ore di inattività o quando esci.</li>
        <li><strong><code>XSRF-TOKEN</code></strong>: protegge i moduli dagli attacchi di tipo cross-site request forgery. Scade dopo 2 ore.</li>
        <li><strong><code>locale</code></strong>: ricorda la lingua che hai scelto nel menu delle lingue. Viene impostato solo se ne scegli una; scade dopo 1 anno.</li>
        <li><strong><code>theme</code></strong> (archiviazione locale del browser): ricorda se hai scelto la modalità chiara o scura. Non lascia mai il tuo dispositivo.</li>
    </ul>
    <p>Poiché sono strettamente necessari per un servizio da te richiesto, non serve il consenso (art. 5, par. 3, della direttiva 2002/58/CE, in Italia art. 122 del Codice privacy, e § 25, comma 2, n. 2 TDDDG). I dati di sessione memorizzati sul nostro server comprendono il tuo indirizzo IP e il tuo user agent, per proteggere il tuo account; vengono cancellati alla scadenza della sessione.</p>

    <h2>4. Il tuo account</h2>
    <p>Al momento della registrazione memorizziamo il tuo <strong>nome, indirizzo e-mail e password</strong> (solo come hash sicuro, mai in chiaro), oltre alla data in cui hai accettato le <a href="{{ route('legal.terms', ['lang' => 'it']) }}">condizioni d'uso</a>. Usiamo il tuo indirizzo e-mail per verificare l'account, reimpostare la password e, se lo desideri, avvisarti delle risposte alle tue domande.</p>
    <p><strong>Base giuridica:</strong> art. 6, par. 1, lett. b) GDPR (fornitura del servizio a cui ti sei registrato).</p>
    <p><strong>Periodo di conservazione:</strong> fino alla cancellazione del tuo account, che puoi effettuare tu stesso in qualsiasi momento dalle impostazioni del profilo.</p>

    <h2>5. Domande, risposte, voti e segnalazioni</h2>
    <p>Le domande e le risposte che pubblichi sono <strong>pubbliche</strong>: chiunque può leggerle insieme al tuo nome e alla data, e i motori di ricerca possono indicizzarle. Voti e segnalazioni sono collegati al tuo account ma non vengono mostrati agli altri membri; le segnalazioni sono visibili agli amministratori.</p>
    <p>Se cancelli il tuo account, vengono cancellati anche domande, risposte, voti e segnalazioni. Alcune copie possono restare per un po' nella cache dei motori di ricerca, su cui non abbiamo controllo.</p>
    <p><strong>Base giuridica:</strong> art. 6, par. 1, lett. b) GDPR e, per la moderazione, art. 6, par. 1, lett. f) GDPR (nostro legittimo interesse a un forum sicuro).</p>

    <h2>6. Notifiche</h2>
    <p>Quando qualcuno risponde alla tua domanda ricevi una notifica sul sito e, a meno che tu non la disattivi nelle impostazioni del profilo, un'e-mail (al massimo una per domanda ogni 15 minuti). Le notifiche vengono cancellate insieme al tuo account.</p>

    <h2>7. Modulo di contatto</h2>
    <p>Se usi il modulo di contatto, memorizziamo il tuo nome, il tuo indirizzo e-mail e il tuo messaggio per risponderti. Li cancelliamo quando non sono più necessari per gestire la tua richiesta.</p>
    <p><strong>Base giuridica:</strong> art. 6, par. 1, lett. b) GDPR se il messaggio riguarda un contratto o il tuo account, altrimenti art. 6, par. 1, lett. f) GDPR (nostro legittimo interesse a rispondere alle richieste).</p>

    <h2>8. Protezione dagli abusi</h2>
    <p>Per bloccare spam e attacchi, i moduli contengono un campo nascosto e un controllo dei tempi, e limitiamo la frequenza con cui alcune azioni possono essere ripetute. A tal fine il tuo indirizzo IP o l'ID del tuo account viene conservato in un contatore temporaneo per massimo 24 ore.</p>
    @if (config('services.turnstile.site_key'))
        <p>I moduli di registrazione e di contatto usano anche <strong>Cloudflare Turnstile</strong>, un controllo anti-bot di Cloudflare, Inc. (USA). Al caricamento del modulo, Cloudflare riceve il tuo indirizzo IP e informazioni tecniche sul browser per distinguere le persone dai bot. Vedi l'<a href="https://www.cloudflare.com/it-it/privacypolicy/" rel="noopener">informativa sulla privacy di Cloudflare</a>.</p>
    @endif
    <p><strong>Base giuridica:</strong> art. 6, par. 1, lett. f) GDPR (nostro legittimo interesse a proteggere il sito e i suoi utenti).</p>

    <h2>9. Fornitori di servizi</h2>
    <p>Ci avvaliamo dei seguenti responsabili del trattamento, vincolati da accordi sul trattamento dei dati (art. 28 GDPR):</p>
    <ul>
        <li><strong>Vercel Inc.</strong> (USA): hosting. Le richieste vengono elaborate a Francoforte (Germania) quando possibile. <a href="https://vercel.com/legal/privacy-policy" rel="noopener">Informativa sulla privacy</a></li>
        <li><strong>Neon Inc.</strong> (USA): database. I dati sono conservati {{ config('legal.database_location.it') }}. <a href="https://neon.tech/privacy-policy" rel="noopener">Informativa sulla privacy</a></li>
        <li><strong>Resend, Inc.</strong> (USA): invio delle e-mail da server nell'UE (Irlanda). <a href="https://resend.com/legal/privacy-policy" rel="noopener">Informativa sulla privacy</a></li>
        @if (config('sentry.dsn'))
            <li><strong>Functional Software, Inc. (Sentry)</strong> (USA): segnalazioni di errore, per correggere i bug. Le segnalazioni contengono dettagli tecnici sull'errore; abbiamo disattivato l'invio di indirizzi IP e di altri dati personali. <a href="https://sentry.io/privacy/" rel="noopener">Informativa sulla privacy</a></li>
        @endif
    </ul>
    <p>Quando i dati vengono trasferiti negli USA, il trasferimento si basa sul Data Privacy Framework UE-USA se il fornitore è certificato e, in caso contrario, sulle clausole contrattuali tipo dell'UE (art. 46, par. 2, lett. c) GDPR).</p>

    <h2>10. I tuoi diritti</h2>
    <p>Hai il diritto di:</p>
    <ul>
        <li>accedere ai dati personali che conserviamo su di te (art. 15 GDPR),</li>
        <li>ottenere la rettifica dei dati inesatti (art. 16 GDPR),</li>
        <li>ottenere la cancellazione dei tuoi dati (art. 17 GDPR) o la limitazione del trattamento (art. 18 GDPR),</li>
        <li>ricevere i tuoi dati in un formato strutturato, di uso comune e leggibile da dispositivo automatico (art. 20 GDPR),</li>
        <li><strong>opporti</strong> in qualsiasi momento, per motivi connessi alla tua situazione particolare, al trattamento basato sul nostro legittimo interesse (art. 21 GDPR),</li>
        <li>proporre reclamo a un'autorità di controllo, in particolare nello Stato membro dell'UE in cui risiedi o lavori (art. 77 GDPR); in Italia, il Garante per la protezione dei dati personali.</li>
    </ul>
    <p>Per esercitare questi diritti, contattaci ai recapiti indicati nella sezione 1. Puoi modificare nome ed e-mail, e cancellare il tuo account, da solo nelle impostazioni del profilo.</p>

    <h2>11. Dati obbligatori</h2>
    <p>Puoi leggere il forum senza account. Per pubblicare ti serve un account, che richiede nome, indirizzo e-mail e password.</p>

    <h2>12. Nessuna decisione automatizzata</h2>
    <p>Non adottiamo processi decisionali automatizzati né profilazione ai sensi dell'art. 22 GDPR.</p>

    <h2>13. Modifiche</h2>
    <p>Aggiorniamo questa informativa quando cambiano il sito o la legge. La versione in vigore è sempre disponibile su questa pagina.</p>
</x-legal-page>
