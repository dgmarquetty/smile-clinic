<?php

require_once baseDir('funcionario/funcoes.php');

verificaSessao('funcionario');

$acao = get('acao');

switch ($acao) {
  case 'buscar-endereco':
    $resultado = [];
    $codigoPai = (int) get('codigo_pai');
    $tipo = get('tipo');
    $buscas = '/pais/estado/cidade/cep/rua';
    $buscas = explode("{$tipo}/", $buscas)[1];
    $buscas = explode('/', $buscas);

    foreach ($buscas as $busca) {
      $resultado[$busca] = buscarEndereco($codigoPai, $busca)['extra'];
      $codigoPai = $resultado[$busca][0]['id'];
    }

    exit(json_encode($resultado));
  case 'salvar-paciente':
    $dados = post('dados');
    $tipo = post('tipo');
    $paciente = (int) post('paciente');

    $resultado = salvarPaciente($paciente, $dados, $tipo);

    exit(json_encode($resultado));
}
