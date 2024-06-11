<?php

$sql = "
  SELECT dp.codigo_pessoa,
         dp.nome,
         dp.cpf,
         dp.data_nasci,
         dp.username_email,
         cp.contato1,
         cp.contato2,
         e.numero,
         e.complemento,
         r.id_rua,
         r.rua,
         c.id_cep,
         c.cep,
         c2.id_cidade,
         c2.cidade,
         e2.id_estado,
         e2.estado,
         e2.ddd,
         p2.id_pais,
         p2.pais,
         p2.ddi
    FROM paciente p
    JOIN dados_pessoa dp
      ON dp.codigo_pessoa = p.codigo_pessoa
    JOIN contato_pessoa cp
      ON cp.codigo_pessoa = p.codigo_pessoa
    JOIN endereco e
      ON dp.id_end = e.id_end
    JOIN rua r
      ON e.id_rua = r.id_rua
    JOIN cep c
      ON r.id_cep = c.id_cep
    JOIN cidade c2
      ON c.id_cidade = c2.id_cidade
    JOIN estado e2
      ON c2.id_estado = e2.id_estado
    JOIN pais p2
      ON e2.id_pais = p2.id_pais
";

switch (get('acao')) {
  case 'novo':
    require_once 'pacientes_novo.php';
    exit(scripts());
  case 'detalhes':
    require_once 'pacientes_detalhes.php';
    exit(scripts());
}

if (get('flt-nome')) {
  $filtro = $conectar->real_escape_string(get('flt-nome'));
  $sql .= " WHERE dp.nome LIKE '%{$filtro}%'";
}

$qryPacientes = query($sql);

?>

<div>
  <div style="width: 100%;">
    <div class="page p-15">
      <h3>Listagem de Pacientes</h3>
    </div>

    <div class="barra-acoes">
      <!-- <button class="btn">Filtrar pesquisa</button> -->
      <a class="btn" href="?pagina=pacientes&acao=novo">Novo paciente</a>
    </div>
  </div>

  <table>
    <thead>
      <tr>
        <th width="200">Nome</th>
        <th width="120">CPF</th>
        <th width="120">Data de Nasc.</th>
        <th width="200">Email</th>
        <th width="150">Contato</th>
        <th width="350">Endereço</th>
      </tr>
    </thead>
    <tbody>
      <?php

      while ($paciente = $qryPacientes->fetch_assoc()) {
        $cpf = mask($paciente['cpf'], '###.###.###-##');
        $contato = mask($paciente['contato1'], '#####-####');
        $dtNasc = date('d/m/Y', strtotime($paciente['data_nasci']));

        $endereco = "{$paciente['pais']} -";
        $endereco .= " {$paciente['cidade']}";
        $endereco .= ", {$paciente['rua']}";
        $endereco .= ", {$paciente['numero']}";

        echo "
            <tr>
              <td>
                <a class='link' href='?pagina=pacientes&acao=detalhes&paciente={$paciente['codigo_pessoa']}'>
                  {$paciente['nome']}
                </a>
              </td>
              <td>{$cpf}</td>
              <td>{$dtNasc}</td>
              <td>{$paciente['username_email']}</td>
              <td>({$paciente['ddd']}) {$contato}</td>
              <td>{$endereco}</td>
            </tr>
          ";
      }

      ?>
    </tbody>
  </table>
</div>