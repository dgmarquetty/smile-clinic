<?php

require_once baseDir('funcionario/funcoes.php');

registrarScript('paciente_detalhes');

if (!!post('email')) {
  $select = "
    SELECT codigo_pessoa AS id
      FROM dados_pessoa
     WHERE username_email = ?
  ";

  $emailExiste = !!query($select, [post('email')])->fetch_assoc();

  if ($emailExiste) {
    jsAlert('Erro ao inserir paciente!', 'E-mail já cadastrado');
  } else {
    cadastrarPacienteFromPost();
  }
}

$paises = buscarEndereco(0, 'pais')['extra'];
$estados = buscarEndereco(1, 'estado')['extra'];
$cidades = buscarEndereco(1, 'cidade')['extra'];
$ceps = buscarEndereco(1, 'cep')['extra'];
$ruas = buscarEndereco(1, 'rua')['extra'];

$htmlOption = "<option value=':id:' :selected:>:nome:</option>";

?>

<form method="post" action="?pagina=pacientes&acao=novo">
  <div style="width: 100%;">
    <div class="page p-15">
      <h3>Novo Paciente</h3>
    </div>
  </div>

  <br>

  <section class="page p-10 flex_d-column">
    <h4 style="color: #32429e">• Dados Básicos</h4>

    <div class="hr spacing-5"></div>
    <div class="spacing-15"></div>

    <div class="flex_d-row align-center">
      <label class="w-30 text-right" for="cpf">CPF:&nbsp;</label>
      <input type="text" id="cpf" name="cpf" style="width: 130px" required>
    </div>

    <div class="spacing-5"></div>

    <div class="flex_d-row align-center">
      <label class="w-30 text-right" for="dt_nasc">Data de Nasc.:&nbsp;</label>
      <input type="date" id="dt_nasc" name="data_nasci" style="width: 110px" max="2010-01-01" required>
    </div>

    <div class="spacing-5"></div>

    <div class="flex_d-row align-center">
      <label class="w-30 text-right" for="email">E-mail:&nbsp;</label>
      <input type="email" id="email" name="email" style="width: 200px" required>
    </div>

    <div class="spacing-5"></div>

    <div class="flex_d-row align-center">
      <label class="w-30 text-right" for="senha">Senha:&nbsp;</label>
      <input type="password" id="senha" name="senha" style="width: 200px" required>
    </div>

    <div class="spacing-5"></div>

    <div class="flex_d-row align-center">
      <label class="w-30 text-right" for="nome">Nome:&nbsp;</label>
      <input type="text" id="nome" name="nome" style="width: 300px" required>
    </div>

    <div class="spacing-15"></div>
  </section>

  <div class="spacing-10"></div>

  <section class="page p-10 flex_d-column">
    <h4 style="color: #32429e">• Contatos</h4>

    <div class="hr spacing-5"></div>
    <div class="spacing-15"></div>

    <div class="flex_d-row align-center">
      <label class="w-30 text-right" for="contato1">Contato Principal:&nbsp;</label>
      <input type="number" id="contato1" name="contato1" style="width: 150px" required>
    </div>

    <div class="spacing-5"></div>

    <div class="flex_d-row align-center">
      <label class="w-30 text-right" for="contato2">Contato Secundário:&nbsp;</label>
      <input type="number" id="contato2" name="contato2" style="width: 150px">
    </div>

    <div class="spacing-15"></div>
  </section>

  <div class="spacing-10"></div>

  <section class="page p-10">
    <h4 style="color: #32429e">• Endereço</h4>

    <div class="hr spacing-5"></div>
    <div class="spacing-15"></div>

    <div class="flex_d-row align-center">
      <label class="w-30 text-right" for="pais">Pais:&nbsp;</label>
      <select buscar-endereco id="pais" style="width: 150px">
        <?php

        foreach ($paises as $pais) {
          if ($pais['id'] == 1) {
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
          if ($estado['id'] == 1) {
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
          if ($cidade['id'] == 1) {
            $cidade['selected'] = 'selected';
          }
          echo arrReplace($htmlOption, $cidade);
        }

        ?>
      </select>
    </div>

    <div class="spacing-5"></div>

    <div class="flex_d-row align-center">
      <label class="w-30 text-right" for="rua">CEP:&nbsp;</label>
      <select buscar-endereco id="cep" style="width: 130px">
        <?php

        foreach ($ceps as $cep) {
          if ($cep['id'] == 1) {
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
      <select name="rua" id="rua" name="rua" style="width: 300px">
        <?php

        foreach ($ruas as $rua) {
          if ($rua['id'] == 1) {
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
      <input type="number" id="numero" name="numero" style="width: 100px" required>
    </div>

    <div class="spacing-5"></div>

    <div class="flex_d-row align-center">
      <label class="w-30 text-right" for="complemento">Complemento:&nbsp;</label>
      <input type="text" id="complemento" name="complemento" style="width: 200px">
    </div>

    <div class="spacing-15"></div>
  </section>

  <div class="spacing-10"></div>

  <div class="flex justify-center">
    <button class="btn" type="submit">Confirmar</button>
  </div>

  <br>
</form>