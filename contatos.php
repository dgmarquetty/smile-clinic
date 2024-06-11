<html lang="pt-BR">
<head>

    <link rel="stylesheet" href="style/contatos.css">
</head>

<body>
<header class="header">
    <span class="logo-text">Smile Clínica</span>
    
    <button style="display: none;" class="header__btnMenu"> <i class="fas fa-bars fa-2x"></i> <span class="sr-only">Menu</span></button>
    
    <nav class="header__nav">
    <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="projeto_final\index.php">LOGIN</a></li>
                <li><a href="tratamentos.php">TRATAMENTOS</a></li>
                <li><a href="dicas.php">DICAS</a></li>
                <li><a href="contatos.php">CONTATOS</a></li>
                
            </ul>
    </nav>
    </header>

    <section class="hero2">
      <div class="hero__content">
          <h1 class="hero__inicio">Fale Conosco</h1>
          <h2>Canais para você entrar em contato com a gente e buscar informações</h2>
      </div>
      <img src="img/faleconosco.jpg">
  </section>


    <div class="allcards">
      <div class="card1">
        <img src="img/whatsapp.png">
        <h1>WhatsApp</h1>
        <button type="button" onclick="scrollToContact('contact-whatsapp')">Mandar mensagem</button>
    </div>
    <div class="card2">
        <img src="img/telefone.png">
        <h1>Telefones</h1>
        <button type="button" onclick="scrollToContact('contact-telefone')">Ver números</button>
    </div>
    <div class="card3">
        <img src="img/email.png">
        <h1>E-mail</h1>
        <button type="button" onclick="scrollToContact('contact-email')">Ver e-mails</button>
    </div>
  </div>


  <section id="contact-whatsapp" class="hero3">
      <img src="img/whats_imagem.png">
      <h1>Contatos WhatsApp</h1>

      <h2>Contatos para WhatsApp da Smile</h2>
      <p>Tire dúvidas, solicite agendamentos, documentos e mais a partir dos telefones para contato via WhatsApp encontrados a seguir.</p>

      <p>(99) 99999-9999</p>
      <p>(88) 88888-8888</p>
      <p>(98) 98989-8989</p>

  </section>
  <section id="contact-telefone" class="hero3">
      <img src="img/telefone_imagem.png">
      <h1>Contatos Telefone</h1>

      <h2>Telefones para contatos com a Smile</h2>
      <p>Tire dúvidas, solicite agendamentos, documentos e mais a partir dos telefones encontrados a seguir.</p>
      <p>0800 9999 9999</p>
      <p>0800 8888 8888</p>
      <p>0800 9898 9898</p>
      

  </section>
  <section id="contact-email" class="hero3">
      <img src="img/email_imagem.png">
      
      <h1>Contatos E-mail</h1>

      <h2>E-mails para Contato com a Smile</h2>
      <p>Tire dúvidas, solicite agendamentos, documentos e mais a partir dos E-mails encontrados a seguir.</p>

      <p>user1234@emailprovider.com</p>
      <p>example1@example.com</p>
      <p>random@emailserver.net</p>

  </section>
  

  <footer class="footer">
    <div class="container">
        <h2 class="footer__logo">Smile Clinica</h2>

        <p>Nam mi enim, auctor non ultricies a, fringilla eu risus. 
          Praesent vitae lorem et elit tincidunt accumsan suscipit eu libero. Maecenas diam est, venenatis vitae dui in, 
          vestibulum mollis arcu. Donec eu nibh tincidunt, dapibus sem eu, aliquam dolor. Cum sociis natoque penatibus et 
          magnis dis parturient montes, nascetur ridiculus mus. Vestibulum consectetur commodo eros, vitae laoreet lectus aliq</p>

      <ul class="footer__links">
        <li><a href="#">List One</a></li>
        <li><a href="#">Page Two</a></li>
        <li><a href="#">Design</a></li>
        <li><a href="#">Work</a></li>
        <li><a href="#">Contact Me</a></li>
      </ul>
    </div>
</footer>

  <button id="scrollTopBtn" onclick="scrollToTop()" class="scrollTopBtn" title="Voltar ao Topo">Voltar ao Topo</button>

  <script src="js/contatos.js"></script>
  <script src="js/menu.js"></script>        

</body>

</html>
