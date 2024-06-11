<?php

require_once 'funcoes.php';

if (!!session('usuario')) {
  redirect('sistema.php?pagina=menu');
}

$erro = false; // Inicializando a variável $erro

if (!!post('username_email')) {
  $usuario = post('username_email');
  $senha = post('senha');
  $tipoUsuario = post('tipo_usuario');
  
  $sql = "
    SELECT *
      FROM dados_pessoa dp
      JOIN {$tipoUsuario} f
        ON dp.codigo_pessoa = f.codigo_pessoa
     WHERE username_email = ?
       AND senha = ?
  ";

  $usuario = query($sql, [
    $usuario,
    $senha
  ])->fetch_assoc();

  if (!!$usuario) {
    $_SESSION['usuario'] = $usuario;
    $_SESSION['tipo'] = $tipoUsuario;

    redirect('sistema.php?pagina=menu');
  }

  $erro = true;
}

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login de Usuário</title>
  <link rel="stylesheet" href="css/main.css">
  <link rel="stylesheet" href="css/login.css">
</head>
<body>

  <div class="login-container">
    <form method="post" action="index.php">
      <h1 id="title">Login de Usuário</h1>
      <span></span>
      <?=$erro ? "<div class='erro'>Login inválido!</div>" : '' ?>
      <div class="form-row">
        <label for="email">Email:</label>
        <input id="email" type="email" name="username_email" required>
      </div>

      <div class="form-row">
        <label for="password">Senha:</label>
        <input id="password" type="password" name="senha" required>
      </div>
      
      <div class="form-row">
        <label>Tipo de usuário:</label>
        <div class="radio-group">
          <label for="tipo_usuario2">
            <input type="radio" name="tipo_usuario" value="paciente" id="tipo_usuario2" checked> Paciente
          </label>
          <label for="tipo_usuario1">
            <input type="radio" name="tipo_usuario" value="funcionario" id="tipo_usuario1"> Funcionário
          </label>
        </div>
      </div>
      <button class="btn" type="submit">Entrar</button>
    </form>
  </div>
</body>
</html>
