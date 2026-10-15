@php($lang = 'pt')
<x-legal-page lang="pt" title="Política de privacidade" :updated="config('legal.privacy_updated')">
    <p>Esta política explica que dados pessoais o Codingsols recolhe, para quê e que direitos você tem ao abrigo do Regulamento Geral sobre a Proteção de Dados (RGPD). O Codingsols não usa publicidade, ferramentas de análise nem cookies de rastreamento.</p>

    <h2>1. Responsável pelo tratamento</h2>
    <p>O responsável pelo tratamento de dados neste site é:</p>
    @include('legal.partials.operator')
    <p>Também pode contactar-nos através do <a href="{{ route('contact') }}">formulário de contacto</a>.</p>

    <h2>2. Visita ao site</h2>
    <p>Quando abre uma página, o nosso fornecedor de alojamento trata automaticamente os dados técnicos enviados pelo seu navegador: endereço IP, data e hora, página pedida, página de origem, e navegador e sistema operativo (user agent). Isto é necessário para mostrar o site, mantê-lo seguro e detetar erros. Estes registos do servidor só são guardados durante pouco tempo.</p>
    <p><strong>Fundamento jurídico:</strong> art. 6.º, n.º 1, alínea f), do RGPD (o nosso interesse legítimo num site seguro e funcional).</p>

    <h2>3. Cookies e armazenamento local</h2>
    <p>Só usamos o que é estritamente necessário para o site funcionar:</p>
    <ul>
        <li><strong><code>codingsols-session</code></strong>: mantém a sua sessão iniciada e guarda o que escreve nos formulários entre páginas. Expira após 2 horas de inatividade ou quando termina a sessão.</li>
        <li><strong><code>XSRF-TOKEN</code></strong>: protege os formulários contra falsificação de pedidos entre sites (CSRF). Expira após 2 horas.</li>
        <li><strong><code>locale</code></strong>: guarda o idioma que escolheu no menu de idiomas. Só é criado se escolher um; expira após 1 ano.</li>
        <li><strong><code>theme</code></strong> (armazenamento local do navegador): guarda se escolheu o modo claro ou escuro. Nunca sai do seu dispositivo.</li>
    </ul>
    <p>Como são estritamente necessários para um serviço que pediu, não é necessário consentimento (art. 5.º, n.º 3, da Diretiva 2002/58/CE e § 25, n.º 2, ponto 2, TDDDG). Os dados de sessão guardados no nosso servidor incluem o seu endereço IP e user agent, para proteger a sua conta; são apagados quando a sessão expira.</p>

    <h2>4. A sua conta</h2>
    <p>Quando se regista, guardamos o seu <strong>nome, endereço de e-mail e palavra-passe</strong> (apenas como hash seguro, nunca legível), bem como a data em que aceitou os <a href="{{ route('legal.terms', ['lang' => 'pt']) }}">termos de utilização</a>. Usamos o seu e-mail para verificar a conta, redefinir a palavra-passe e, se quiser, avisá-lo de respostas às suas perguntas.</p>
    <p><strong>Fundamento jurídico:</strong> art. 6.º, n.º 1, alínea b), do RGPD (prestação do serviço em que se registou).</p>
    <p><strong>Prazo de conservação:</strong> até eliminar a sua conta, o que pode fazer a qualquer momento nas definições do perfil.</p>

    <h2>5. Perguntas, respostas, votos e denúncias</h2>
    <p>As perguntas e respostas que publica são <strong>públicas</strong>: qualquer pessoa pode lê-las, juntamente com o seu nome e a data, e os motores de pesquisa podem indexá-las. Os votos e as denúncias estão associados à sua conta, mas não são mostrados a outros membros; as denúncias são vistas pelos administradores.</p>
    <p>Quando elimina a sua conta, as suas perguntas, respostas, votos e denúncias são eliminados com ela. Podem permanecer cópias durante algum tempo na cache dos motores de pesquisa, o que não podemos controlar.</p>
    <p><strong>Fundamento jurídico:</strong> art. 6.º, n.º 1, alínea b), do RGPD e, para a moderação, art. 6.º, n.º 1, alínea f), do RGPD (o nosso interesse legítimo num fórum seguro).</p>

    <h2>6. Notificações</h2>
    <p>Quando alguém responde à sua pergunta, recebe uma notificação no site e, a menos que a desative nas definições do perfil, um e-mail (no máximo um por pergunta a cada 15 minutos). As notificações são eliminadas com a sua conta.</p>

    <h2>7. Formulário de contacto</h2>
    <p>Se usar o formulário de contacto, guardamos o seu nome, e-mail e mensagem para lhe responder. Eliminamo-los quando deixarem de ser necessários para o seu pedido.</p>
    <p><strong>Fundamento jurídico:</strong> art. 6.º, n.º 1, alínea b), do RGPD se a mensagem disser respeito a um contrato ou à sua conta; caso contrário, art. 6.º, n.º 1, alínea f), do RGPD (o nosso interesse legítimo em responder a pedidos).</p>

    <h2>8. Proteção contra abusos</h2>
    <p>Para travar spam e ataques, os formulários contêm um campo oculto e uma verificação de tempo, e limitamos a frequência com que certas ações podem ser repetidas. Para isso, o seu endereço IP ou o ID da sua conta é guardado num contador temporário durante, no máximo, 24 horas.</p>
    @if (config('services.turnstile.site_key'))
        <p>Os formulários de registo e de contacto usam também o <strong>Cloudflare Turnstile</strong>, uma verificação anti-bots da Cloudflare, Inc. (EUA). Ao carregar o formulário, a Cloudflare recebe o seu endereço IP e informações técnicas sobre o navegador para distinguir pessoas de bots. Consulte a <a href="https://www.cloudflare.com/pt-br/privacypolicy/" rel="noopener">política de privacidade da Cloudflare</a>.</p>
    @endif
    <p><strong>Fundamento jurídico:</strong> art. 6.º, n.º 1, alínea f), do RGPD (o nosso interesse legítimo em proteger o site e os seus utilizadores).</p>

    <h2>9. Prestadores de serviços</h2>
    <p>Recorremos aos seguintes subcontratantes, vinculados por acordos de tratamento de dados (art. 28.º do RGPD):</p>
    <ul>
        <li><strong>Vercel Inc.</strong> (EUA): alojamento. Os pedidos são processados em Frankfurt (Alemanha) sempre que possível. <a href="https://vercel.com/legal/privacy-policy" rel="noopener">Política de privacidade</a></li>
        <li><strong>Neon Inc.</strong> (EUA): base de dados. Os dados são guardados {{ config('legal.database_location.pt') }}. <a href="https://neon.tech/privacy-policy" rel="noopener">Política de privacidade</a></li>
        <li><strong>Resend, Inc.</strong> (EUA): envio de e-mails a partir de servidores na UE (Irlanda). <a href="https://resend.com/legal/privacy-policy" rel="noopener">Política de privacidade</a></li>
        @if (config('sentry.dsn'))
            <li><strong>Functional Software, Inc. (Sentry)</strong> (EUA): relatórios de erros, para podermos corrigi-los. Os relatórios contêm detalhes técnicos do erro; desativámos o envio de endereços IP e de outros dados pessoais. <a href="https://sentry.io/privacy/" rel="noopener">Política de privacidade</a></li>
        @endif
    </ul>
    <p>Quando os dados são transferidos para os EUA, a transferência baseia-se no Quadro de Privacidade de Dados UE-EUA se o fornecedor estiver certificado e, caso contrário, nas cláusulas contratuais-tipo da UE (art. 46.º, n.º 2, alínea c), do RGPD).</p>

    <h2>10. Os seus direitos</h2>
    <p>Tem o direito de:</p>
    <ul>
        <li>aceder aos dados pessoais que temos sobre si (art. 15.º do RGPD),</li>
        <li>retificar dados inexatos (art. 16.º do RGPD),</li>
        <li>pedir o apagamento dos seus dados (art. 17.º do RGPD) ou a limitação do tratamento (art. 18.º do RGPD),</li>
        <li>receber os seus dados num formato estruturado, de uso corrente e de leitura automática (art. 20.º do RGPD),</li>
        <li><strong>opor-se</strong> a qualquer momento, por motivos relacionados com a sua situação particular, ao tratamento baseado no nosso interesse legítimo (art. 21.º do RGPD),</li>
        <li>apresentar reclamação a uma autoridade de controlo, em especial no Estado-Membro da UE onde reside ou trabalha (art. 77.º do RGPD); em Portugal, a Comissão Nacional de Proteção de Dados (CNPD).</li>
    </ul>
    <p>Para exercer estes direitos, contacte-nos através dos dados indicados na secção 1. Pode alterar o seu nome e e-mail, e eliminar a sua conta, nas definições do perfil.</p>

    <h2>11. Dados obrigatórios</h2>
    <p>Pode ler o fórum sem conta. Para publicar precisa de uma conta, que requer nome, endereço de e-mail e palavra-passe.</p>

    <h2>12. Sem decisões automatizadas</h2>
    <p>Não utilizamos decisões automatizadas nem definição de perfis na aceção do art. 22.º do RGPD.</p>

    <h2>13. Alterações</h2>
    <p>Atualizamos esta política quando o site ou a lei mudam. A versão em vigor está sempre disponível nesta página.</p>
</x-legal-page>
