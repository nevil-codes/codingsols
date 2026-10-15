@php($lang = 'pt')
<x-legal-page lang="pt" title="Termos de utilização" :updated="config('legal.terms_version')">
    <p>Estes termos aplicam-se à utilização do Codingsols, um fórum gratuito de perguntas e respostas para programadores. Ao criar uma conta, aceita-os. A forma como tratamos os dados pessoais é explicada separadamente na nossa <a href="{{ route('legal.privacy', ['lang' => 'pt']) }}">política de privacidade</a>.</p>

    <h2>1. Responsável pelo site</h2>
    @include('legal.partials.operator')

    <h2>2. O serviço</h2>
    <p>O Codingsols permite ler perguntas e respostas sem conta e, com uma conta, fazer perguntas, responder, votar e denunciar conteúdos. O serviço é gratuito. Procuramos mantê-lo disponível, mas não existe direito a uma disponibilidade ou funcionalidade específica, e podemos alterar ou descontinuar o serviço.</p>

    <h2>3. A sua conta</h2>
    <ul>
        <li>Tem de ter pelo menos 16 anos para criar uma conta.</li>
        <li>Use um endereço de e-mail válido a que tenha acesso. Cada conta destina-se a uma só pessoa.</li>
        <li>Mantenha a sua palavra-passe em segredo. É responsável pela atividade da sua conta; avise-nos de imediato se suspeitar que outra pessoa tem acesso a ela.</li>
    </ul>

    <h2>4. Regras sobre conteúdos e conduta</h2>
    <p>É responsável pelo que publica. Não publique nem faça nada que:</p>
    <ul>
        <li>seja ilegal ou viole direitos de terceiros, como direitos de autor, marcas ou direitos de personalidade;</li>
        <li>assedie, ameace, insulte ou discrimine alguém;</li>
        <li>seja spam, publicidade ou autopromoção sem relação com a pergunta;</li>
        <li>contenha malware, links de phishing ou código destinado a causar danos;</li>
        <li>divulgue dados pessoais, palavras-passe ou segredos de outras pessoas (incluindo as suas próprias chaves de API);</li>
        <li>se faça passar por outra pessoa, ou tente contornar os limites de frequência, violar a segurança do site ou recolher dados em grande escala.</li>
    </ul>
    <p>As respostas são escritas por membros e podem estar erradas ou desatualizadas. Verifique o código antes de o usar, sobretudo em produção. Usa-o por sua conta e risco.</p>

    <h2>5. Direitos sobre os seus conteúdos</h2>
    <p>Os direitos sobre o que publica continuam a ser seus. Concede ao responsável pelo site uma licença gratuita, não exclusiva e mundial para armazenar, mostrar e tornar públicos os seus conteúdos no Codingsols e formatá-los para apresentação, enquanto estiverem publicados no site. Permite também que outros membros usem, copiem e adaptem para qualquer fim os excertos de código que publicar. Publique apenas conteúdos que tenha o direito de partilhar.</p>

    <h2>6. Moderação</h2>
    <p>Pode denunciar conteúdos contrários a estes termos ou à lei com o botão de denúncia de cada publicação ou através do <a href="{{ route('contact') }}">formulário de contacto</a>. Os administradores podem bloquear tópicos ou remover conteúdos contrários a estes termos ou à lei, e suspender ou eliminar contas em casos graves ou repetidos. Quando a lei o exigir, explicamos-lhe porque é que o seu conteúdo foi removido ou a sua conta restringida, e pode contactar-nos para contestar a decisão.</p>

    <h2>7. Responsabilidade</h2>
    <p>Sendo o serviço gratuito, o responsável pelo site só responde por dolo e negligência grave. Esta limitação não se aplica a danos à vida, à integridade física ou à saúde, à responsabilidade nos termos da lei alemã de responsabilidade do produtor (Produkthaftungsgesetz), nem quando tenha sido dada uma garantia. Não assumimos como nossos os conteúdos publicados pelos membros nem respondemos pela sua exatidão.</p>

    <h2>8. Fim da utilização</h2>
    <p>Pode eliminar a sua conta a qualquer momento nas definições do perfil. Podemos pôr fim à sua utilização com um pré-aviso razoável, ou de imediato em caso de violação grave destes termos.</p>

    <h2>9. Alterações a estes termos</h2>
    <p>Podemos atualizar estes termos, por exemplo quando acrescentamos funcionalidades ou a lei muda. Avisaremos os membros registados por e-mail sobre alterações importantes pelo menos quatro semanas antes de entrarem em vigor. Se não concordar, pode eliminar a sua conta antes dessa data.</p>

    <h2>10. Lei aplicável</h2>
    <p>Estes termos regem-se pela lei da República Federal da Alemanha. Se for consumidor, mantém a proteção das normas imperativas do país onde reside habitualmente. Se alguma disposição for inválida, as restantes continuam em vigor.</p>
</x-legal-page>
