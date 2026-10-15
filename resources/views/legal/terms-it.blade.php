@php($lang = 'it')
<x-legal-page lang="it" title="Condizioni d'uso" :updated="config('legal.terms_version')">
    <p>Le presenti condizioni si applicano all'uso di Codingsols, un forum gratuito di domande e risposte per programmatori. Creando un account le accetti. Come trattiamo i dati personali è spiegato separatamente nella nostra <a href="{{ route('legal.privacy', ['lang' => 'it']) }}">informativa sulla privacy</a>.</p>

    <h2>1. Gestore</h2>
    @include('legal.partials.operator')

    <h2>2. Il servizio</h2>
    <p>Codingsols ti permette di leggere domande e risposte senza account e, con un account, di fare domande, rispondere, votare e segnalare contenuti. Il servizio è gratuito. Ci impegniamo a mantenerlo disponibile, ma non esiste un diritto a una determinata disponibilità o funzione, e possiamo modificare o interrompere il servizio.</p>

    <h2>3. Il tuo account</h2>
    <ul>
        <li>Per creare un account devi avere almeno 16 anni.</li>
        <li>Usa un indirizzo e-mail valido a cui hai accesso. Ogni account è destinato a una sola persona.</li>
        <li>Mantieni segreta la tua password. Sei responsabile delle attività svolte con il tuo account; avvisaci subito se pensi che qualcun altro vi abbia accesso.</li>
    </ul>

    <h2>4. Regole su contenuti e comportamento</h2>
    <p>Sei responsabile di ciò che pubblichi. Non pubblicare e non fare nulla che:</p>
    <ul>
        <li>sia illecito o violi diritti altrui, come diritto d'autore, marchi o diritti della personalità;</li>
        <li>molesti, minacci, insulti o discrimini chiunque;</li>
        <li>sia spam, pubblicità o autopromozione non pertinente alla domanda;</li>
        <li>contenga malware, link di phishing o codice destinato a causare danni;</li>
        <li>diffonda dati personali, password o segreti altrui (comprese le tue chiavi API);</li>
        <li>impersoni un'altra persona, o tenti di aggirare i limiti di frequenza, violare la sicurezza del sito o estrarne dati su larga scala.</li>
    </ul>
    <p>Le risposte sono scritte dai membri e possono essere errate o non aggiornate. Controlla il codice prima di usarlo, soprattutto in produzione. Lo usi a tuo rischio.</p>

    <h2>5. Diritti sui tuoi contenuti</h2>
    <p>I diritti su ciò che pubblichi restano tuoi. Concedi al gestore una licenza gratuita, non esclusiva e mondiale per memorizzare, mostrare e rendere pubblici i tuoi contenuti su Codingsols e per formattarli per la visualizzazione, finché restano pubblicati sul sito. Consenti inoltre agli altri membri di usare, copiare e adattare per qualsiasi scopo i frammenti di codice che pubblichi. Pubblica solo contenuti che hai il diritto di condividere.</p>

    <h2>6. Moderazione</h2>
    <p>Puoi segnalare contenuti contrari a queste condizioni o alla legge con il pulsante di segnalazione presente in ogni post o tramite il <a href="{{ route('contact') }}">modulo di contatto</a>. Gli amministratori possono chiudere discussioni o rimuovere contenuti contrari a queste condizioni o alla legge, e sospendere o cancellare account nei casi gravi o ripetuti. Ove previsto dalla legge, ti comunichiamo perché i tuoi contenuti sono stati rimossi o il tuo account limitato, e puoi contattarci per contestare la decisione.</p>

    <h2>7. Responsabilità</h2>
    <p>Poiché il servizio è gratuito, il gestore risponde solo per dolo e colpa grave. Questa limitazione non si applica ai danni alla vita, all'integrità fisica o alla salute, alla responsabilità ai sensi della legge tedesca sulla responsabilità per danno da prodotti (Produkthaftungsgesetz) né in caso di garanzia prestata. Non facciamo nostri i contenuti pubblicati dai membri e non rispondiamo della loro correttezza.</p>

    <h2>8. Cessazione</h2>
    <p>Puoi cancellare il tuo account in qualsiasi momento nelle impostazioni del profilo. Possiamo porre fine al tuo utilizzo con un preavviso ragionevole, o immediatamente in caso di grave violazione di queste condizioni.</p>

    <h2>9. Modifiche alle condizioni</h2>
    <p>Possiamo aggiornare queste condizioni, ad esempio quando aggiungiamo funzioni o cambia la legge. Informeremo via e-mail i membri registrati delle modifiche rilevanti almeno quattro settimane prima che entrino in vigore. Se non sei d'accordo, puoi cancellare il tuo account prima di allora.</p>

    <h2>10. Legge applicabile</h2>
    <p>Le presenti condizioni sono regolate dal diritto della Repubblica Federale di Germania. Se sei un consumatore, mantieni la tutela delle norme imperative del Paese in cui risiedi abitualmente. Se una disposizione è invalida, le altre restano valide.</p>
</x-legal-page>
