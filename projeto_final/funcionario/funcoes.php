<?php

function buscarDadosClinicos(null|int $paciente = null): array
{
  $select = 'SELECT * FROM dados_clinicos ORDER BY nome';

  if (!is_null($paciente)) {
    $paciente = getCodigoPaciente($paciente);

    $select = "
         SELECT dc.*
           FROM dados_clinicos dc
           JOIN dados_clinicos_do_paciente dcp
             ON dc.codigo_clinico = dcp.codigo_clinico
          WHERE dcp.codigo_paciente = {$paciente}
      ORDER BY nome
    ";
  }

  $dadosClinicos = query($select)->fetch_all(MYSQLI_ASSOC);

  return $dadosClinicos;
}

function buscarEndereco(int $codigo, string $tipo): array
{
  $filtro = [$codigo];
  $sql = "SELECT id_{$tipo} AS id, {$tipo} AS nome FROM {$tipo}";

  $relacao = [
    'pais' => null,
    'estado' => 'pais',
    'cidade' => 'estado',
    'cep' => 'cidade',
    'rua' => 'cep',
  ][$tipo];

  if ($tipo == 'pais') {
    $filtro = null;
  } else {
    $sql .= " WHERE id_{$relacao} = ?";
  }

  $sql .= ' ORDER BY 2';

  $resultado = query($sql, $filtro)->fetch_all(MYSQLI_ASSOC);

  return response('Concluído', 'ok', $resultado);
}

function salvarEndereco(int $paciente, array|null $endereco)
{
  $update = "
    UPDATE endereco
       SET numero = ?, complemento = ?, id_rua = ?
     WHERE id_end = (
             SELECT id_end
               FROM dados_pessoa
              WHERE codigo_pessoa = ?)
  ";

  query($update, [
    $endereco['numero'],
    $endereco['complemento'],
    $endereco['rua'],
    $paciente
  ]);
}

function salvarContatos(int $paciente, array|null $contatos)
{
  $update = "
    UPDATE contato_pessoa
       SET contato1 = ?, contato2 = ?
     WHERE codigo_pessoa = ?
  ";

  query($update, [
    $contatos['contato1'],
    $contatos['contato2'],
    $paciente
  ]);
}

function salvarDadosBasicos(int $paciente, array|null $dados)
{
  $update = "
    UPDATE dados_pessoa
       SET nome = ?, username_email = ?
     WHERE codigo_pessoa = ?
  ";

  query($update, [
    $dados['nome'],
    $dados['email'],
    $paciente,
  ]);
}

function salvarDadosClinicos(int $paciente, array|null $dados)
{
  $paciente = getCodigoPaciente($paciente);

  $delete = "
    DELETE
      FROM dados_clinicos_do_paciente
     WHERE codigo_paciente = ?
  ";

  query($delete, [$paciente]);

  if (is_array($dados)) {
    $valores = array_map(function ($item) use ($paciente): string {
      return "({$paciente}, {$item})";
    }, $dados);

    $valores = implode(',', $valores);

    $insert = "
      INSERT INTO dados_clinicos_do_paciente
        (codigo_paciente, codigo_clinico)
      VALUES
        {$valores}
    ";

    query($insert);
  }
}

function salvarPaciente(int $paciente, array|null $dados, string $tipo): array
{
  $retorno = response('Registro alterado com sucesso!');

  switch ($tipo) {
    case 'dados-clinicos':
      salvarDadosClinicos($paciente, $dados);
      break;
    case 'endereco':
      salvarEndereco($paciente, $dados);
      break;
    case 'contatos':
      salvarContatos($paciente, $dados);
      break;
    case 'dados-basicos':
      $select = "
        SELECT codigo_pessoa AS id
          FROM dados_pessoa
         WHERE username_email = ?
      ";

      $existe = query($select, [$dados['email']])->fetch_assoc();

      if (!!$existe && $existe['id'] != $paciente) {
        $retorno = response('E-mail já existe!', 'erro');
      } else {
        salvarDadosBasicos($paciente, $dados);
      }

      break;

  }

  return $retorno;
}

function cadastrarPacienteFromPost()
{
  $insert = "
    INSERT INTO endereco
      (id_rua, numero, complemento)
    VALUES
      (?, ?, ?)
  ";

  query($insert, [
    post('rua'),
    post('numero'),
    post('complemento'),
  ]);

  $idEndereco = lastInsertedId();

  $insert = "
    INSERT INTO dados_pessoa
      (codigo_clinica, id_end, cpf, nome, sexo, data_nasci, username_email, senha)
    VALUES
      (1, ?, ?, ?, 'X', ?, ?, ?)
  ";

  query($insert, [
    $idEndereco,
    post('cpf'),
    post('nome'),
    post('data_nasci'),
    post('email'),
    post('senha'),
  ]);

  $idPessoa = lastInsertedId();

  $insert = "
    INSERT INTO paciente
      (codigo_pessoa, codigo_clinica)
    VALUES
      (?, 1)
  ";

  query($insert, [$idPessoa]);

  $insert = "
    INSERT INTO contato_pessoa
      (codigo_pessoa, contato1, contato2)
    VALUES
      (?, ?, ?)
  ";

  query($insert, [
    $idPessoa,
    post('contato1'),
    post('contato2'),
  ]);

  redirect('?pagina=pacientes&acao=listar');
}
