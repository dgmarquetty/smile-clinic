<?php

require_once baseDir('paciente/funcoes.php');

registrarScript('paciente_detalhes');

$id = (int) get('paciente');
$sql .= "WHERE dp.codigo_pessoa = 1";
$qryPaciente = query($sql, [$id]);
$paciente = $qryPaciente->fetch_assoc();
$cpf = mask($paciente['cpf'], '###.###.###-##');
$dtNasc = date('d/m/Y', strtotime($paciente['data_nasci']));

$dadosClinicos = buscarDadosClinicos();
$dadosClinicosPaciente = buscarDadosClinicos($id);

$paises = buscarEndereco(0, 'pais')['extra'];
$estados = buscarEndereco($paciente['id_pais'], 'estado')['extra'];
$cidades = buscarEndereco($paciente['id_estado'], 'cidade')['extra'];
$ceps = buscarEndereco($paciente['id_cidade'], 'cep')['extra'];
$ruas = buscarEndereco($paciente['id_cep'], 'rua')['extra'];

$htmlOption = "<option value=':id:' :selected:>:nome:</option>";

?>

<div>
  <div style="width: 100%;">
    <div class="page p-15">
      <h3>Detalhes do Paciente</h3>
    </div>
  </div>

  <div class="barra-acoes">
    <button class="btn btn-active" btn-tab for="dados-basicos">Dados Básicos</button>
    <button class="btn" btn-tab for="contatos">Contatos</button>
    <button class="btn" btn-tab for="endereco">Endereço</button>
    <button class="btn" btn-tab for="dados-clinicos">Dados Clínicos</button>
  </div>

  <section id="dados-basicos" class="page p-10 flex_d-column">
    <div class="spacing-5"></div>

    <div class="flex_d-row align-center">
      <label class="w-30 text-right" for="cpf">CPF:&nbsp;</label>
      <input type="text" id="cpf" value="<?= $cpf ?>" style="width: 130px" disabled>
    </div>

    <div class="spacing-5"></div>

    <div class="flex_d-row align-center">
      <label class="w-30 text-right" for="dt_nasc">Data de Nasc.:&nbsp;</label>
      <input type="text" id="dt_nasc" value="<?= $dtNasc ?>" style="width: 80px" disabled>
    </div>

    <div class="spacing-5"></div>

    <div class="flex_d-row align-center">
      <label class="w-30 text-right" for="email">E-mail:&nbsp;</label>
      <input type="email" id="email" name="email" value="<?= $paciente['username_email'] ?>" style="width: 200px">
    </div>

    <div class="spacing-5"></div>

    <div class="flex_d-row align-center">
      <label class="w-30 text-right" for="nome">Nome:&nbsp;</label>
      <input type="text" id="nome" name="nome" value="<?= $paciente['nome'] ?>" style="width: 300px">
    </div>

    <div class="hr spacing-15"></div>
    <div class="spacing-10"></div>

    <div class="flex_d-row">
      <button class="btn" salvar-dados>
        <i class="fa-solid fa-check"></i> Salvar Alterações da Aba
      </button>
    </div>
  </section>

  <section id="contatos" class="page p-10 display-none">
    <div class="spacing-5"></div>

    <div class="flex_d-row align-center">
      <label class="w-30 text-right" for="contato1">Contato Principal:&nbsp;</label>
      <input type="number" id="contato1" name="contato1" value="<?= $paciente['contato1'] ?>" style="width: 150px">
    </div>

    <div class="spacing-5"></div>

    <div class="flex_d-row align-center">
      <label class="w-30 text-right" for="contato2">Contato Secundário:&nbsp;</label>
      <input type="number" id="contato2" name="contato2" value="<?= $paciente['contato2'] ?>" style="width: 150px">
    </div>

    <div class="hr spacing-15"></div>
    <div class="spacing-10"></div>

    <div class="flex_d-row">
      <button class="btn" salvar-dados>
        <i class="fa-solid fa-check"></i> Salvar Alterações da Aba
      </button>
    </div>
  </section>

  <section id="endereco" class="page p-10 display-none">
    <div class="spacing-5"></div>

    <div class="flex_d-row align-center">
      <label class="w-30 text-right" for="pais">Pais:&nbsp;</label>
      <select buscar-endereco id="pais" style="width: 150px">
        <?php

        foreach ($paises as $pais) {
          $pais['selected'] = '';

          if ($pais['id'] == $paciente['id_pais']) {
            $pais['selected'] = 'selected';
          }

          echo arrReplace($htmlOption, $pais);
        }

        ?>
      </select>
    </div>

    <div class="spacing-5"></div>

    <div class="flex_d-row align-center">
      <label class="w-30 text-right" for="estado">Estado:&nbsp;</label>
      <select buscar-endereco id="estado" style="width: 170px">
        <?php

        foreach ($estados as $estado) {
          $estado['selected'] = '';

          if ($estado['id'] == $paciente['id_estado']) {
            $estado['selected'] = 'selected';
          }

          echo arrReplace($htmlOption, $estado);
        }

        ?>
      </select>
    </div>

    <div class="spacing-5"></div>

    <div class="flex_d-row align-center">
      <label class="w-30 text-right" for="cidade">Cidade:&nbsp;</label>
      <select buscar-endereco id="cidade" style="width: 150px">
        <?php

        foreach ($cidades as $cidade) {
          $cidade['selected'] = '';

          if ($cidade['id'] == $paciente['id_cidade']) {
            $cidade['selected'] = 'selected';
          }

          echo arrReplace($htmlOption, $cidade);
        }

        ?>
      </select>
    </div>

    <div class="spacing-5"></div>

    <div class="flex_d-row align-center">
      <label class="w-30 text-right" for="cep">CEP:&nbsp;</label>
      <select buscar-endereco id="cep" style="width: 150px">
        <?php

        foreach ($ceps as $cep) {
          $cep['selected'] = '';
          $cep['nome'] = mask($cep['nome'], '#####-###');

          if ($cep['id'] == $paciente['id_cep']) {
            $cep['selected'] = 'selected';
          }

          echo arrReplace($htmlOption, $cep);
        }

        ?>
      </select>
    </div>

    <div class="spacing-5"></div>

    <div class="flex_d-row align-center">
      <label class="w-30 text-right" for="rua">Rua:&nbsp;</label>
      <select name="rua" id="rua" style="width: 300px">
        <?php

        foreach ($ruas as $rua) {
          $rua['selected'] = '';

          if ($rua['id'] == $paciente['id_rua']) {
            $rua['selected'] = 'selected';
          }

          echo arrReplace($htmlOption, $rua);
        }

        ?>
      </select>
    </div>

    <div class="spacing-5"></div>

    <div class="flex_d-row align-center">
      <label class="w-30 text-right" for="numero">Número:&nbsp;</label>
      <input type="number" id="numero" name="numero" value="<?= $paciente['numero'] ?>" style="width: 100px">
    </div>

    <div class="spacing-5"></div>

    <div class="flex_d-row align-center">
      <label class="w-30 text-right" for="complemento">Complemento:&nbsp;</label>
      <input type="text" id="complemento" name="complemento" value="<?= $paciente['complemento'] ?>"
        style="width: 200px">
    </div>

    <div class="hr spacing-15"></div>
    <div class="spacing-10"></div>

    <div class="flex_d-row">
      <button class="btn" salvar-dados id="btn-endereco">
        <i class="fa-solid fa-check"></i> Salvar Alterações da Aba
      </button>
    </div>
  </section>

  <section id="dados-clinicos" class="page p-10 display-none">
    <div class="spacing-5"></div>

    <?php

    $codigos = array_map(function ($dados) {
      return $dados['codigo_clinico'];
    }, $dadosClinicosPaciente);

    $codigos = implode(';', $codigos);

    ?>

    <input type="hidden" id="paciente-dados-clinicos" value="<?= $codigos ?>">

    <input type="hidden" id="origem-dados-clinicos"
      value="<?= str_replace('"', "'", json_encode($dadosClinicos, JSON_UNESCAPED_UNICODE)) ?>">

    <div class="hr spacing-15"></div>
    <div class="spacing-10"></div>

    <div class="flex_d-row">
      <button class="btn" validacao="dados-clinicos" salvar-dados>
        <i class="fa-solid fa-check"></i> Salvar Alterações da Aba
      </button>
      <div class="p-5"></div>
      <button class="btn" add-campo-dc>
        <i class="fa-solid fa-add"></i> Adicionar dado clínico
      </button>
    </div>
  </section>

  <br>
</div>