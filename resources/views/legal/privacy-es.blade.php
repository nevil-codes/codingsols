@php($lang = 'es')
<x-legal-page lang="es" title="Política de privacidad" :updated="config('legal.privacy_updated')">
    <p>Esta política explica qué datos personales recoge Codingsols, para qué y qué derechos tienes según el Reglamento General de Protección de Datos (RGPD). Codingsols no usa publicidad, ni herramientas de analítica, ni cookies de seguimiento.</p>

    <h2>1. Responsable del tratamiento</h2>
    <p>El responsable del tratamiento de datos en este sitio web es:</p>
    @include('legal.partials.operator')
    <p>También puedes escribirnos mediante el <a href="{{ route('contact') }}">formulario de contacto</a>.</p>

    <h2>2. Visita al sitio web</h2>
    <p>Cuando abres una página, nuestro proveedor de alojamiento trata automáticamente los datos técnicos que envía tu navegador: tu dirección IP, la fecha y hora, la página solicitada, la página de procedencia y tu navegador y sistema operativo (user agent). Es necesario para mostrar el sitio, mantenerlo seguro y detectar errores. Estos registros del servidor solo se conservan durante poco tiempo.</p>
    <p><strong>Base jurídica:</strong> art. 6.1.f) RGPD (nuestro interés legítimo en un sitio web seguro y que funcione).</p>

    <h2>3. Cookies y almacenamiento local</h2>
    <p>Solo usamos lo estrictamente necesario para que el sitio funcione:</p>
    <ul>
        <li><strong><code>codingsols-session</code></strong>: mantiene tu sesión iniciada y recuerda lo que escribes en los formularios entre páginas. Caduca tras 2 horas de inactividad o al cerrar sesión.</li>
        <li><strong><code>XSRF-TOKEN</code></strong>: protege los formularios contra la falsificación de peticiones en sitios cruzados (CSRF). Caduca a las 2 horas.</li>
        <li><strong><code>locale</code></strong>: recuerda el idioma que elegiste en el menú de idiomas. Solo se crea si eliges uno; caduca al cabo de 1 año.</li>
        <li><strong><code>theme</code></strong> (almacenamiento local del navegador): recuerda si elegiste el modo claro u oscuro. Nunca sale de tu dispositivo.</li>
    </ul>
    <p>Como son estrictamente necesarios para un servicio que has solicitado, no se requiere consentimiento (art. 5.3 de la Directiva 2002/58/CE, en España art. 22.2 de la LSSI, y § 25.2 n.º 2 TDDDG). Los datos de sesión guardados en nuestro servidor incluyen tu dirección IP y tu user agent para proteger tu cuenta; se eliminan cuando caduca la sesión.</p>

    <h2>4. Tu cuenta</h2>
    <p>Al registrarte guardamos tu <strong>nombre, dirección de correo electrónico y contraseña</strong> (solo como hash seguro, nunca legible), y la fecha en que aceptaste las <a href="{{ route('legal.terms', ['lang' => 'es']) }}">condiciones de uso</a>. Usamos tu correo para verificar tu cuenta, restablecer tu contraseña y, si quieres, avisarte de las respuestas a tus preguntas.</p>
    <p><strong>Base jurídica:</strong> art. 6.1.b) RGPD (prestación del servicio en el que te has registrado).</p>
    <p><strong>Plazo de conservación:</strong> hasta que elimines tu cuenta, algo que puedes hacer tú mismo en cualquier momento desde la configuración de tu perfil.</p>

    <h2>5. Preguntas, respuestas, votos y denuncias</h2>
    <p>Las preguntas y respuestas que publicas son <strong>públicas</strong>: cualquiera puede leerlas junto con tu nombre y la fecha, y los buscadores pueden indexarlas. Los votos y denuncias están vinculados a tu cuenta pero no se muestran a otros miembros; las denuncias las ven los administradores.</p>
    <p>Si eliminas tu cuenta, se eliminan también tus preguntas, respuestas, votos y denuncias. Pueden quedar copias durante un tiempo en la caché de los buscadores, algo que no podemos controlar.</p>
    <p><strong>Base jurídica:</strong> art. 6.1.b) RGPD y, para la moderación, art. 6.1.f) RGPD (nuestro interés legítimo en un foro seguro).</p>

    <h2>6. Notificaciones</h2>
    <p>Cuando alguien responde a tu pregunta recibes una notificación en el sitio y, salvo que lo desactives en la configuración de tu perfil, un correo electrónico (como máximo uno por pregunta cada 15 minutos). Las notificaciones se eliminan junto con tu cuenta.</p>

    <h2>7. Formulario de contacto</h2>
    <p>Si usas el formulario de contacto, guardamos tu nombre, tu correo electrónico y tu mensaje para responderte. Los eliminamos cuando ya no son necesarios para atender tu consulta.</p>
    <p><strong>Base jurídica:</strong> art. 6.1.b) RGPD si tu mensaje está relacionado con un contrato o con tu cuenta; en caso contrario, art. 6.1.f) RGPD (nuestro interés legítimo en responder a las consultas).</p>

    <h2>8. Protección contra abusos</h2>
    <p>Para frenar el spam y los ataques, los formularios incluyen un campo oculto y una comprobación de tiempo, y limitamos la frecuencia con la que pueden repetirse ciertas acciones. Para ello, tu dirección IP o el identificador de tu cuenta se guarda en un contador temporal durante 24 horas como máximo.</p>
    @if (config('services.turnstile.site_key'))
        <p>Los formularios de registro y de contacto también usan <strong>Cloudflare Turnstile</strong>, una comprobación anti-bots de Cloudflare, Inc. (EE. UU.). Al cargar el formulario, Cloudflare recibe tu dirección IP e información técnica sobre tu navegador para distinguir a personas de bots. Consulta la <a href="https://www.cloudflare.com/es-es/privacypolicy/" rel="noopener">política de privacidad de Cloudflare</a>.</p>
    @endif
    <p><strong>Base jurídica:</strong> art. 6.1.f) RGPD (nuestro interés legítimo en proteger el sitio y a sus usuarios).</p>

    <h2>9. Proveedores de servicios</h2>
    <p>Trabajamos con los siguientes encargados del tratamiento, con los que hemos firmado contratos de encargo (art. 28 RGPD):</p>
    <ul>
        <li><strong>Vercel Inc.</strong> (EE. UU.): alojamiento. Las peticiones se procesan en Fráncfort (Alemania) siempre que es posible. <a href="https://vercel.com/legal/privacy-policy" rel="noopener">Política de privacidad</a></li>
        <li><strong>Neon Inc.</strong> (EE. UU.): base de datos. Los datos se almacenan en {{ config('legal.database_location.es') }}. <a href="https://neon.tech/privacy-policy" rel="noopener">Política de privacidad</a></li>
        <li><strong>Resend, Inc.</strong> (EE. UU.): envío de correos electrónicos desde servidores en la UE (Irlanda). <a href="https://resend.com/legal/privacy-policy" rel="noopener">Política de privacidad</a></li>
        @if (config('sentry.dsn'))
            <li><strong>Functional Software, Inc. (Sentry)</strong> (EE. UU.): informes de errores para poder corregirlos. Los informes contienen detalles técnicos del error; hemos desactivado el envío de direcciones IP y otros datos personales. <a href="https://sentry.io/privacy/" rel="noopener">Política de privacidad</a></li>
        @endif
    </ul>
    <p>Cuando se transfieren datos a EE. UU., la transferencia se basa en el Marco de Privacidad de Datos UE-EE. UU. si el proveedor está certificado y, en caso contrario, en las cláusulas contractuales tipo de la UE (art. 46.2.c) RGPD).</p>

    <h2>10. Tus derechos</h2>
    <p>Tienes derecho a:</p>
    <ul>
        <li>acceder a los datos personales que tenemos sobre ti (art. 15 RGPD),</li>
        <li>rectificar los datos inexactos (art. 16 RGPD),</li>
        <li>solicitar la supresión de tus datos (art. 17 RGPD) o la limitación de su tratamiento (art. 18 RGPD),</li>
        <li>recibir tus datos en un formato estructurado, de uso común y lectura mecánica (art. 20 RGPD),</li>
        <li><strong>oponerte</strong> en cualquier momento, por motivos relacionados con tu situación particular, al tratamiento basado en nuestro interés legítimo (art. 21 RGPD),</li>
        <li>presentar una reclamación ante una autoridad de control, en particular en el Estado miembro de la UE en el que residas o trabajes (art. 77 RGPD); en España, la Agencia Española de Protección de Datos (AEPD).</li>
    </ul>
    <p>Para ejercer estos derechos, contacta con nosotros a través de los datos de la sección 1. Puedes cambiar tu nombre y tu correo, y eliminar tu cuenta, tú mismo desde la configuración de tu perfil.</p>

    <h2>11. Datos obligatorios</h2>
    <p>Puedes leer el foro sin cuenta. Para publicar necesitas una cuenta, que requiere nombre, correo electrónico y contraseña.</p>

    <h2>12. Sin decisiones automatizadas</h2>
    <p>No tomamos decisiones automatizadas ni elaboramos perfiles en el sentido del art. 22 RGPD.</p>

    <h2>13. Cambios</h2>
    <p>Actualizamos esta política cuando cambian el sitio o la ley. La versión vigente está siempre disponible en esta página.</p>
</x-legal-page>
