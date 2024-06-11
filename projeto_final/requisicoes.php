<?php

require_once 'funcoes.php';

switch ($_GET['acao']) {
  case 'sair':
    session_destroy();
    exit;
}

