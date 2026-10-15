@php($lang = 'fr')
<x-legal-page lang="fr" title="Politique de confidentialité" :updated="config('legal.privacy_updated')">
    <p>Cette politique explique quelles données personnelles Codingsols collecte, pourquoi, et quels sont vos droits au titre du Règlement général sur la protection des données (RGPD). Codingsols n'utilise ni publicité, ni outil d'analyse d'audience, ni cookies de suivi.</p>

    <h2>1. Responsable du traitement</h2>
    <p>Le responsable du traitement des données sur ce site est :</p>
    @include('legal.partials.operator')
    <p>Vous pouvez aussi nous écrire via le <a href="{{ route('contact') }}">formulaire de contact</a>.</p>

    <h2>2. Consultation du site</h2>
    <p>Lorsque vous ouvrez une page, notre hébergeur traite automatiquement les données techniques envoyées par votre navigateur : adresse IP, date et heure, page demandée, page de provenance, ainsi que navigateur et système d'exploitation (user agent). Ces données sont nécessaires pour afficher le site, le sécuriser et détecter les erreurs. Ces journaux serveur ne sont conservés que peu de temps.</p>
    <p><strong>Base juridique :</strong> art. 6, paragraphe 1, point f) du RGPD (notre intérêt légitime à exploiter un site sûr et fonctionnel).</p>

    <h2>3. Cookies et stockage local</h2>
    <p>Nous n'utilisons que ce qui est strictement nécessaire au fonctionnement du site :</p>
    <ul>
        <li><strong><code>codingsols-session</code></strong> : vous garde connecté et conserve vos saisies de formulaire d'une page à l'autre. Expire après 2 heures d'inactivité ou à la déconnexion.</li>
        <li><strong><code>XSRF-TOKEN</code></strong> : protège les formulaires contre la falsification de requêtes intersites (CSRF). Expire après 2 heures.</li>
        <li><strong><code>locale</code></strong> : mémorise la langue choisie dans le menu des langues. Créé uniquement si vous en choisissez une ; expire après 1 an.</li>
        <li><strong><code>theme</code></strong> (stockage local de votre navigateur) : mémorise votre choix entre mode clair et mode sombre. Il ne quitte jamais votre appareil.</li>
    </ul>
    <p>Ces éléments étant strictement nécessaires à un service que vous avez demandé, aucun consentement n'est requis (art. 5, paragraphe 3, de la directive 2002/58/CE « vie privée et communications électroniques » et § 25, al. 2, n° 2 TDDDG). Les données de session enregistrées sur notre serveur comprennent votre adresse IP et votre user agent afin de protéger votre compte ; elles sont supprimées à l'expiration de la session.</p>

    <h2>4. Votre compte</h2>
    <p>Lors de l'inscription, nous enregistrons votre <strong>nom, votre adresse e-mail et votre mot de passe</strong> (uniquement sous forme de hachage sécurisé, jamais en clair), ainsi que la date à laquelle vous avez accepté les <a href="{{ route('legal.terms', ['lang' => 'fr']) }}">conditions d'utilisation</a>. Nous utilisons votre adresse e-mail pour vérifier votre compte, réinitialiser votre mot de passe et, si vous le souhaitez, vous informer des réponses à vos questions.</p>
    <p><strong>Base juridique :</strong> art. 6, paragraphe 1, point b) du RGPD (fourniture du service auquel vous vous êtes inscrit).</p>
    <p><strong>Durée de conservation :</strong> jusqu'à la suppression de votre compte, que vous pouvez effectuer vous-même à tout moment dans les paramètres de votre profil.</p>

    <h2>5. Questions, réponses, votes et signalements</h2>
    <p>Les questions et réponses que vous publiez sont <strong>publiques</strong> : tout le monde peut les lire, avec votre nom et la date, et les moteurs de recherche peuvent les indexer. Les votes et signalements sont liés à votre compte mais ne sont pas visibles par les autres membres ; les signalements sont consultés par les administrateurs.</p>
    <p>Lorsque vous supprimez votre compte, vos questions, réponses, votes et signalements sont supprimés avec lui. Des copies peuvent subsister quelque temps dans le cache des moteurs de recherche, ce que nous ne maîtrisons pas.</p>
    <p><strong>Base juridique :</strong> art. 6, paragraphe 1, point b) du RGPD, et art. 6, paragraphe 1, point f) du RGPD pour la modération (notre intérêt légitime à un forum sûr).</p>

    <h2>6. Notifications</h2>
    <p>Lorsque quelqu'un répond à votre question, vous recevez une notification sur le site et, sauf si vous le désactivez dans les paramètres de votre profil, un e-mail (au maximum un par question toutes les 15 minutes). Les notifications sont supprimées avec votre compte.</p>

    <h2>7. Formulaire de contact</h2>
    <p>Si vous utilisez le formulaire de contact, nous enregistrons votre nom, votre adresse e-mail et votre message pour vous répondre. Nous les supprimons dès qu'ils ne sont plus nécessaires au traitement de votre demande.</p>
    <p><strong>Base juridique :</strong> art. 6, paragraphe 1, point b) du RGPD si votre message concerne un contrat ou votre compte, sinon art. 6, paragraphe 1, point f) du RGPD (notre intérêt légitime à répondre aux demandes).</p>

    <h2>8. Protection contre les abus</h2>
    <p>Pour bloquer le spam et les attaques, les formulaires contiennent un champ caché et un contrôle de délai, et nous limitons la fréquence à laquelle certaines actions peuvent être répétées. Pour cela, votre adresse IP ou l'identifiant de votre compte est conservé dans un compteur temporaire pendant 24 heures au maximum.</p>
    @if (config('services.turnstile.site_key'))
        <p>Les formulaires d'inscription et de contact utilisent également <strong>Cloudflare Turnstile</strong>, un contrôle anti-robots de Cloudflare, Inc. (États-Unis). Au chargement du formulaire, Cloudflare reçoit votre adresse IP et des informations techniques sur votre navigateur afin de distinguer les humains des robots. Voir la <a href="https://www.cloudflare.com/fr-fr/privacypolicy/" rel="noopener">politique de confidentialité de Cloudflare</a>.</p>
    @endif
    <p><strong>Base juridique :</strong> art. 6, paragraphe 1, point f) du RGPD (notre intérêt légitime à protéger le site et ses utilisateurs).</p>

    <h2>9. Prestataires</h2>
    <p>Nous faisons appel aux sous-traitants suivants, liés par des contrats de sous-traitance (art. 28 du RGPD) :</p>
    <ul>
        <li><strong>Vercel Inc.</strong> (États-Unis) : hébergement. Les requêtes sont traitées à Francfort (Allemagne) lorsque c'est possible. <a href="https://vercel.com/legal/privacy-policy" rel="noopener">Politique de confidentialité</a></li>
        <li><strong>Neon Inc.</strong> (États-Unis) : base de données. Les données sont stockées {{ config('legal.database_location.fr') }}. <a href="https://neon.tech/privacy-policy" rel="noopener">Politique de confidentialité</a></li>
        <li><strong>Resend, Inc.</strong> (États-Unis) : envoi des e-mails depuis des serveurs situés dans l'UE (Irlande). <a href="https://resend.com/legal/privacy-policy" rel="noopener">Politique de confidentialité</a></li>
        @if (config('sentry.dsn'))
            <li><strong>Functional Software, Inc. (Sentry)</strong> (États-Unis) : rapports d'erreurs, pour corriger les bugs. Les rapports contiennent des détails techniques sur l'erreur ; nous avons désactivé l'envoi des adresses IP et des autres données personnelles. <a href="https://sentry.io/privacy/" rel="noopener">Politique de confidentialité</a></li>
        @endif
    </ul>
    <p>Lorsque des données sont transférées vers les États-Unis, ce transfert repose sur le cadre de protection des données UE–États-Unis (Data Privacy Framework) si le prestataire est certifié, et à défaut sur les clauses contractuelles types de l'UE (art. 46, paragraphe 2, point c) du RGPD).</p>

    <h2>10. Vos droits</h2>
    <p>Vous avez le droit :</p>
    <ul>
        <li>d'accéder aux données personnelles que nous détenons sur vous (art. 15 du RGPD),</li>
        <li>de faire rectifier des données inexactes (art. 16 du RGPD),</li>
        <li>de faire effacer vos données (art. 17 du RGPD) ou d'en faire limiter le traitement (art. 18 du RGPD),</li>
        <li>de recevoir vos données dans un format courant et lisible par machine (art. 20 du RGPD),</li>
        <li>de vous <strong>opposer</strong> à tout moment, pour des raisons tenant à votre situation particulière, aux traitements fondés sur notre intérêt légitime (art. 21 du RGPD),</li>
        <li>d'introduire une réclamation auprès d'une autorité de contrôle, notamment dans l'État membre de l'UE de votre résidence ou de votre lieu de travail (art. 77 du RGPD) ; en France, la CNIL.</li>
    </ul>
    <p>Pour exercer ces droits, contactez-nous aux coordonnées indiquées à la section 1. Vous pouvez modifier votre nom et votre adresse e-mail, et supprimer votre compte, vous-même dans les paramètres de votre profil.</p>

    <h2>11. Données obligatoires</h2>
    <p>Vous pouvez lire le forum sans compte. Pour publier, il vous faut un compte, qui nécessite un nom, une adresse e-mail et un mot de passe.</p>

    <h2>12. Absence de décision automatisée</h2>
    <p>Nous n'avons recours à aucune prise de décision automatisée ni à aucun profilage au sens de l'art. 22 du RGPD.</p>

    <h2>13. Modifications</h2>
    <p>Nous mettons à jour cette politique lorsque le site ou la loi évolue. La version en vigueur est toujours disponible sur cette page.</p>
</x-legal-page>
