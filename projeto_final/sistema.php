<?php

$baseDir = str_replace('\\', '/', dirname(__FILE__));

require_once $baseDir . '/funcoes.php';
require_once $baseDir . '/paginas.php';

verificaSessao(session('tipo'));

$pagina = trim(get('pagina') ?? 'menu');

if (!isset($paginas[$pagina])) {
  $pagina = 'menu';
}

$script = arrReplace($paginas[$pagina], [
  'tipo' => session('tipo'),
]);

if (get('ajax') == 't') {
  require_once baseDir($script);
  exit;
}

$btnVoltarVisivel = ($pagina == 'menu') ? 'style="visibility: hidden;"' : '';

$scriptsJS = [
  '0' => '<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>',
  '1' => '<script src="https://kit.fontawesome.com/5403b8c370.js" crossorigin="anonymous"></script>',
  'main' => '<script src="js/main.js"></script>',
];

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Área Restrita | Funcionário</title>
  <link rel="stylesheet" href="css/main.css">
  <link rel="stylesheet" href="css/menu.css">
  <link rel="stylesheet" href="css/loader.css">
</head>

<body>
  <div id="backdrop" style="display: none">
    <div id="alert" style="display: none">
      <section></section>

      <div class="spacing-10"></div>

      <div class="flex justify-end">
        <button close-alert class="btn">Fechar</button>
      </div>
    </div>

    <div id="confirm" style="display: none">
      <div class="p-5">
        <h2></h2>
        <p></p>
      </div>

      <div class="spacing-10"></div>

      <div class="flex justify-end">
        <button confirm value="no" class="btn">Não</button>
      </div>
    </div>
  </div>

  <div id="backdrop-loader" style="display: none">
    <div id="loader" style="display: none;">
      <div class="loader"></div>
    </div>
  </div>

  <div id="main">
    <div id="main-header">
      <button btn-voltar <?= $btnVoltarVisivel ?>>Voltar</button>
      <button id="logout">Sair do sistema</button>
    </div>

    <?php require_once $script; ?>

    <?= scripts() ?>
  </div>
</body>

</html>