<?php

session_start();

function arrReplace(string $text, array $arrReplace)
{
  foreach ($arrReplace as $chave => $valor) {
    $text = str_replace(":{$chave}:", $valor, $text);
  }

  return $text;
}

function baseDir($path)
{
  global $baseDir;
  return $baseDir . '/' . $path;
}

function post($indice = null)
{
  if (is_null($indice)) {
    return $_POST;
  }

  return isset($_POST[$indice]) ? $_POST[$indice] : null;
}

function get($indice)
{
  if (is_null($indice)) {
    return $_GET;
  }

  return isset($_GET[$indice]) ? $_GET[$indice] : null;
}

function session($indice = null)
{
  if (is_null($indice)) {
    return $_SESSION;
  }

  return isset($_SESSION[$indice]) ? $_SESSION[$indice] : null;
}

function getConexao()
{
  static $conexao;

  if (!$conexao) {
    $conexao = new mysqli('localhost', 'root', '', 'clinicav11');
  }

  return $conexao;
}

function query(string $sql, array|null $params = null)
{
  return getConexao()->execute_query($sql, $params);
}

function lastInsertedId()
{
  return query('SELECT LAST_INSERT_ID() AS id')->fetch_assoc()['id'];
}

function jsAlert(string $titulo, string $msg)
{
  echo "
    <script>
      window.addEventListener('load', () => {
        openAlert('{$titulo}', '{$msg}');
      });
    </script>
  ";
}

function verificaSessao($tipoUsuario)
{
  if (!isset($_SESSION['usuario']) || empty($_SESSION['usuario'])) {
    exit('Acesso restrito!');
  }

  if ($_SESSION['tipo'] != $tipoUsuario) {
    exit('Acesso restrito! (Tipo de usuário inválido)');
  }
}

function mask(string $string, string $mask)
{
  $maskared = '';
  $k = 0;

  for ($i = 0; $i <= strlen($mask) - 1; $i++) {
    if ($mask[$i] == '#') {
      if (isset($string[$k]))
        $maskared .= $string[$k++];
    } else {
      if (isset($mask[$i]))
        $maskared .= $mask[$i];
    }
  }
  return $maskared;
}

function redirect($pagina)
{
  exit(header("Location: {$pagina}"));
}

function getCodigoPaciente(int $codigoPessoa)
{
  $select = 'SELECT codigo_paciente AS id FROM paciente WHERE codigo_pessoa = ?';
  return query($select, [$codigoPessoa])->fetch_assoc()['id'];
}

function response(string $msg, string $status = 'ok', mixed $extra = null)
{
  return [
    'mensagem' => $msg,
    'status' => 'ok',
    'extra' => $extra,
  ];
}

function registrarScript($script)
{
  global $scriptsJS;
  if (!array_key_exists($script, $scriptsJS)) {
    $scriptsJS[$script] = "<script src='js/{$script}.js'></script>";
  }
}

function scripts()
{
  global $scriptsJS;
  return implode($scriptsJS);
}

function dump($var)
{
  echo '<pre style="background-color: #fff;padding: 15px;font-weight: bold;">';
  print_r($var);
  echo '</pre>';
}