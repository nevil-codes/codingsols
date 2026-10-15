@php($lang = 'es')
<x-legal-page lang="es" title="Condiciones de uso" :updated="config('legal.terms_version')">
    <p>Estas condiciones se aplican al uso de Codingsols, un foro gratuito de preguntas y respuestas para programadores. Al crear una cuenta las aceptas. Cómo tratamos los datos personales se explica por separado en nuestra <a href="{{ route('legal.privacy', ['lang' => 'es']) }}">política de privacidad</a>.</p>

    <h2>1. Titular del sitio</h2>
    @include('legal.partials.operator')

    <h2>2. El servicio</h2>
    <p>Codingsols te permite leer preguntas y respuestas sin cuenta y, con una cuenta, hacer preguntas, responder, votar y denunciar contenido. El servicio es gratuito. Procuramos mantenerlo disponible, pero no existe derecho a una disponibilidad o función concreta, y podemos modificar o interrumpir el servicio.</p>

    <h2>3. Tu cuenta</h2>
    <ul>
        <li>Debes tener al menos 16 años para crear una cuenta.</li>
        <li>Usa una dirección de correo válida a la que tengas acceso. Cada cuenta es para una sola persona.</li>
        <li>Mantén tu contraseña en secreto. Eres responsable de la actividad de tu cuenta; avísanos de inmediato si crees que otra persona tiene acceso a ella.</li>
    </ul>

    <h2>4. Normas sobre contenido y conducta</h2>
    <p>Eres responsable de lo que publicas. No publiques ni hagas nada que:</p>
    <ul>
        <li>sea ilegal o vulnere derechos de terceros, como derechos de autor, marcas o derechos de la personalidad;</li>
        <li>acose, amenace, insulte o discrimine a cualquier persona;</li>
        <li>sea spam, publicidad o autopromoción sin relación con la pregunta;</li>
        <li>contenga malware, enlaces de phishing o código destinado a causar daño;</li>
        <li>revele datos personales, contraseñas o secretos de otras personas (incluidas tus propias claves de API);</li>
        <li>suplante a otra persona, o intente eludir los límites de frecuencia, vulnerar la seguridad del sitio o extraer datos de forma masiva.</li>
    </ul>
    <p>Las respuestas las escriben los miembros y pueden ser incorrectas o estar desactualizadas. Revisa el código antes de usarlo, sobre todo en producción. Lo usas bajo tu propia responsabilidad.</p>

    <h2>5. Derechos sobre tu contenido</h2>
    <p>Conservas los derechos sobre lo que publicas. Concedes al titular una licencia gratuita, no exclusiva y mundial para almacenar, mostrar y hacer público tu contenido en Codingsols y darle formato para su visualización, mientras esté publicado en el sitio. Además, permites que otros miembros usen, copien y adapten para cualquier fin los fragmentos de código que publiques. Publica solo contenido que tengas derecho a compartir.</p>

    <h2>6. Moderación</h2>
    <p>Puedes denunciar contenido contrario a estas condiciones o a la ley con el botón de denuncia de cada publicación o mediante el <a href="{{ route('contact') }}">formulario de contacto</a>. Los administradores pueden cerrar hilos o eliminar contenido contrario a estas condiciones o a la ley, y suspender o eliminar cuentas en casos graves o reiterados. Cuando la ley lo exija, te explicaremos por qué se eliminó tu contenido o se restringió tu cuenta, y podrás contactarnos para impugnar la decisión.</p>

    <h2>7. Responsabilidad</h2>
    <p>Como el servicio es gratuito, el titular solo responde en caso de dolo o culpa grave. Esta limitación no se aplica a los daños a la vida, la integridad física o la salud, a la responsabilidad conforme a la ley alemana de responsabilidad por productos (Produkthaftungsgesetz) ni cuando se haya dado una garantía. No hacemos nuestro el contenido publicado por los miembros ni respondemos de su exactitud.</p>

    <h2>8. Fin del uso</h2>
    <p>Puedes eliminar tu cuenta en cualquier momento desde la configuración de tu perfil. Podemos poner fin a tu uso con un preaviso razonable, o de inmediato si incumples gravemente estas condiciones.</p>

    <h2>9. Cambios en estas condiciones</h2>
    <p>Podemos actualizar estas condiciones, por ejemplo cuando añadimos funciones o cambia la ley. Avisaremos por correo a los miembros registrados de los cambios importantes al menos cuatro semanas antes de que entren en vigor. Si no estás de acuerdo, puedes eliminar tu cuenta antes de esa fecha.</p>

    <h2>10. Legislación aplicable</h2>
    <p>Estas condiciones se rigen por el derecho de la República Federal de Alemania. Si eres consumidor, conservas la protección de las normas imperativas del país en el que tengas tu residencia habitual. Si alguna disposición no es válida, las demás seguirán vigentes.</p>
</x-legal-page>
