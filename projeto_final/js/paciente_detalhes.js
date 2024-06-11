let DADOS_CLINICOS_ORIGINAL = [];

const TPL_DADOS_CLINICOS_ROW = `
  <div for-dc-id=":id:">
    <div class="flex_d-row align-center">
      <label class="w-30 text-right" for="dc-:id:">
        Dado Clínico (:id:):&nbsp;
      </label>

      <select name="dc-:id:" id="dc-:id:" style="width: 200px">
        :options:
      </select>

      <button
        btn-remover
        class="btn btn-danger"
        style="padding: 8px 12px; margin-left: 5px;"
      >
        <i class="fa-solid fa-trash"></i>
      </button>
    </div>
    <div class="spacing-5"></div>
  </div>
`;

const VALIDACOES = {
  'dados-clinicos': validarDadosClinicos,
};

$(window).on('load', () => {
  $('[btn-tab]').on('click', function() {
    toggleTab(
      this.getAttribute('for')
    );
  });

  $('[add-campo-dc]').on('click', addCampoDadosClinicos);

  $('[buscar-endereco]').on('change', function() {
    buscarEndereco(this);
  });

  $('[salvar-dados]').on('click', function() {
    const msg = 'Confirma a alteração dessa aba?';
    const form = $(this).parent().parent();
    const fnValidacao = $(this).attr('validacao');

    if (!!fnValidacao && !VALIDACOES[fnValidacao](form)) {
      return;
    }

    openConfirm(() => {
      salvarDados(form);
    }, msg);
  });

  loadInicial();
});

function validarDadosClinicos(form) {
  const array = Array
    .from($(form).find('select[name]'))
    .map(input => input.value);
  
  if (hasDuplicates(array)) {
    openAlert('Atenção', 'Dados clínicos repetidos!');
    return false;
  }

  return true;
}

function loadInicial() {
  DADOS_CLINICOS_ORIGINAL = JSON.parse(
    $('#origem-dados-clinicos')
      .val()
      ?.replaceAll("'", '"') || null
  );

  const dcPaciente = $('#paciente-dados-clinicos')
    .val();
  
  if (!!dcPaciente) {
    dcPaciente.split(';').map((codigo, indice) => {
      $('[add-campo-dc]').click();
      $(`[name=dc-${indice + 1}]`).val(codigo);
    });
  }
}

function buscarEndereco(input) {
  const params = {
    codigo_pai: $(input).val(),
    tipo: $(input).attr('id'),
  };

  const config = {
    url: url('rq_funcionario', 'buscar-endereco', params),
  };

  $.ajax(config).done(response => {
    const lista = JSON.parse(response);

    Object.keys(lista).forEach(chave => {
      const options = lista[chave]
        .reduce((prev, current) => prev + `
          <option value="${current.id}">${current.nome}</option>
        `, '');
      
      $(`select[id=${chave}]`).html(options);
    });
  });
}

function getNexIdDadosClinicos() {
  let maxId = $('[for-dc-id]').length;
  $('[for-dc-id]').each((_, current) => {
    const currentId = parseInt($(current).attr('for-dc-id'));

    if (currentId > maxId) {
      maxId = currentId;
    }
  });

  return maxId + 1;
}

function getOptionsDadosClinicos() {
  return DADOS_CLINICOS_ORIGINAL
    .reduce((prev, current) => prev + `
      <option value="${current.codigo_clinico}">${current.nome}</option>
    `, '');
}

function addCampoDadosClinicos() {
  if ($('[for-dc-id]').length == DADOS_CLINICOS_ORIGINAL.length) {
    openAlert('Atenção!', 'Limite máximo atingido.');
    return;
  }

  const id = getNexIdDadosClinicos();
  const idAgrupador = `[for-dc-id=${id}]`;
  
  $('#origem-dados-clinicos').before(
    TPL_DADOS_CLINICOS_ROW
      .replaceAll(':id:', id)
      .replace(':options:', getOptionsDadosClinicos())
  );

  $(idAgrupador)
    .find('[btn-remover]')
    .on('click', () => (
      $(idAgrupador).remove()
    ));
}

function salvarDados(form) {
  openLoader();

  const dados = {};
  const tipo = $(form).attr('id');
  const paciente = getUrlParam('paciente');

  $(form).find('input[name], select[name]').each((_, input) => {
    dados[$(input).attr('name')] = $(input).val();
  });

  const config = {
    url: url('rq_funcionario', 'salvar-paciente'),
    type: 'POST',
    data: { tipo, dados, paciente },
    dataType: 'json',
  };

  $.ajax(config).done(response => {
    setTimeout(() => {
      closeLoader();
      openAlert(response.mensagem);
    }, 1000);
  });
}

function toggleTab(tabAtiva) {
  $(`#${tabAtiva}`).show();
  $(`button[for=${tabAtiva}]`).addClass('btn-active');

  ['dados-basicos', 'contatos', 'endereco', 'dados-clinicos']
    .forEach(tab => {
      if (tabAtiva != tab) {
        $(`#${tab}`).hide();
        $(`button[for=${tab}]`).removeClass('btn-active');
      }
    });
}
