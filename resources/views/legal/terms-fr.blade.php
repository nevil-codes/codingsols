@php($lang = 'fr')
<x-legal-page lang="fr" title="Conditions d'utilisation" :updated="config('legal.terms_version')">
    <p>Les présentes conditions s'appliquent à l'utilisation de Codingsols, un forum gratuit de questions-réponses pour les développeurs. En créant un compte, vous les acceptez. La manière dont nous traitons les données personnelles est expliquée séparément dans notre <a href="{{ route('legal.privacy', ['lang' => 'fr']) }}">politique de confidentialité</a>.</p>

    <h2>1. Exploitant</h2>
    @include('legal.partials.operator')

    <h2>2. Le service</h2>
    <p>Codingsols vous permet de lire les questions et réponses sans compte et, avec un compte, de poser des questions, de répondre, de voter et de signaler des contenus. Le service est gratuit. Nous faisons en sorte qu'il reste disponible, mais il n'existe aucun droit à une disponibilité ou à une fonctionnalité particulière, et nous pouvons modifier ou arrêter le service.</p>

    <h2>3. Votre compte</h2>
    <ul>
        <li>Vous devez avoir au moins 16 ans pour créer un compte.</li>
        <li>Utilisez une adresse e-mail valide à laquelle vous avez accès. Chaque compte est destiné à une seule personne.</li>
        <li>Gardez votre mot de passe secret. Vous êtes responsable de l'activité de votre compte ; prévenez-nous immédiatement si vous pensez que quelqu'un d'autre y a accès.</li>
    </ul>

    <h2>4. Règles relatives aux contenus et au comportement</h2>
    <p>Vous êtes responsable de ce que vous publiez. Ne publiez rien et ne faites rien qui :</p>
    <ul>
        <li>soit illégal ou porte atteinte aux droits d'autrui, comme le droit d'auteur, les marques ou les droits de la personnalité ;</li>
        <li>harcèle, menace, insulte ou discrimine qui que ce soit ;</li>
        <li>constitue du spam, de la publicité ou de l'autopromotion sans rapport avec la question ;</li>
        <li>contienne des logiciels malveillants, des liens d'hameçonnage ou du code destiné à nuire ;</li>
        <li>divulgue les données personnelles, mots de passe ou secrets d'autrui (y compris vos propres clés d'API) ;</li>
        <li>usurpe l'identité d'une autre personne, ou tente de contourner les limites de fréquence, de compromettre la sécurité du site ou d'en extraire des données à grande échelle.</li>
    </ul>
    <p>Les réponses sont rédigées par des membres et peuvent être erronées ou obsolètes. Vérifiez le code avant de l'utiliser, en particulier en production. Vous l'utilisez à vos propres risques.</p>

    <h2>5. Droits sur vos contenus</h2>
    <p>Vous conservez les droits sur ce que vous publiez. Vous accordez à l'exploitant une licence gratuite, non exclusive et mondiale pour stocker, afficher et rendre publics vos contenus sur Codingsols et pour les mettre en forme à l'affichage, aussi longtemps qu'ils sont publiés sur le site. Vous autorisez également les autres membres à utiliser, copier et adapter à toutes fins les extraits de code que vous publiez. Ne publiez que des contenus que vous avez le droit de partager.</p>

    <h2>6. Modération</h2>
    <p>Vous pouvez signaler un contenu contraire aux présentes conditions ou à la loi grâce au bouton de signalement présent sur chaque publication, ou via le <a href="{{ route('contact') }}">formulaire de contact</a>. Les administrateurs peuvent verrouiller des discussions ou supprimer des contenus contraires aux présentes conditions ou à la loi, et suspendre ou supprimer des comptes en cas de manquement grave ou répété. Lorsque la loi l'exige, nous vous indiquons pourquoi votre contenu a été retiré ou votre compte restreint, et vous pouvez nous contacter pour contester la décision.</p>

    <h2>7. Responsabilité</h2>
    <p>Le service étant gratuit, l'exploitant n'est responsable qu'en cas de faute intentionnelle ou de faute lourde. Cette limitation ne s'applique pas aux atteintes à la vie, à l'intégrité physique ou à la santé, à la responsabilité au titre de la loi allemande sur la responsabilité du fait des produits (Produkthaftungsgesetz), ni en cas de garantie donnée. Nous ne faisons pas nôtres les contenus publiés par les membres et ne sommes pas responsables de leur exactitude.</p>

    <h2>8. Fin de l'utilisation</h2>
    <p>Vous pouvez supprimer votre compte à tout moment dans les paramètres de votre profil. Nous pouvons mettre fin à votre utilisation moyennant un préavis raisonnable, ou immédiatement en cas de manquement grave aux présentes conditions.</p>

    <h2>9. Modification des conditions</h2>
    <p>Nous pouvons mettre à jour ces conditions, par exemple lorsque nous ajoutons des fonctionnalités ou que la loi change. Nous informerons les membres inscrits par e-mail des modifications importantes au moins quatre semaines avant leur entrée en vigueur. Si vous n'êtes pas d'accord, vous pouvez supprimer votre compte avant cette date.</p>

    <h2>10. Droit applicable</h2>
    <p>Les présentes conditions sont régies par le droit de la République fédérale d'Allemagne. Si vous êtes un consommateur, vous conservez la protection des dispositions impératives du pays où vous résidez habituellement. Si une disposition est invalide, les autres restent applicables.</p>
</x-legal-page>
