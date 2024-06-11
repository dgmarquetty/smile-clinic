const BASE_URL = 'http://localhost/projeto_final/sistema.php';

window.addEventListener('load', () => {
  document
    .getElementById('logout')
    ?.addEventListener('click', () => {
      if (confirm('Você realmente deseja sair?')) {
        sair();
      }
    });
  
  document
    .querySelectorAll('[btn-voltar]')
    .forEach(e => {
      e.addEventListener('click', voltarPagina);
    });

  $('[close-alert]').on('click', () => {
    $('#alert').hide();
    $('#backdrop').hide();
  });

  $('#confirm [value="no"]').on('click', closeConfirm);
});

function openLoader() {
  $('#loader').show();
  $('#backdrop-loader').show();
}

function closeLoader() {
  $('#backdrop-loader').hide();
  $('#loader').hide();
}

function openConfirm(callback, titulo, msg) {
  $('#confirm [value=no]').before(`
    <button confirm value="yes" class="btn" style="margin-right: 5px;">Sim</button>
  `);

  $('#confirm [value=yes]').on('click', () => {
    callback();
    closeConfirm();
  });

  $('#confirm h2').html(!!msg && titulo || '');
  $('#confirm p').html(!!msg && msg || titulo);

  $('#confirm').show();
  $('#backdrop').show();
}

function closeConfirm() {
  $('#backdrop').hide();
  $('#confirm').hide();
  $('#confirm [value=yes]').remove();
}

function openAlert(titulo, msg) {
  if (!msg) {
    msg = titulo;
    titulo = '';
  }

  $('#alert section').html(`
    <div class="p-5">
      <h3>${titulo}</h3>
      <p>${msg}</p>
    </div>
  `);

  $('#alert').show();
  $('#backdrop').show();
}

function url(pagina, acao, extraParams) {
  if (!extraParams) extraParams = {};

  extraParams = Object.keys(extraParams)
    .map(param => `${param}=${extraParams[param]}`)
    .join('&');

  return `${BASE_URL}?ajax=t&pagina=${pagina}&acao=${acao}&${extraParams}`;
}

function sair() {
  fetch('requisicoes.php?acao=sair')
    .then(() => {
      window.location.href = 'http://localhost/projeto_unificado/';
    });
}

function voltarPagina() {
  window.history.go(-1);
}

function getUrlParam(param) {
  const url = window.location.search.replace('?', '');
  let valor = null;

  url.split('&').forEach(str => {
    if (str.includes(param)) {
      valor = str.split('=')[1]
    }
  });

  return valor;
}

function hasDuplicates(array) {
  const todos = [];

  for (let i = 0; i < array.length; ++i) {
    const valor = array[i];

    if (todos.indexOf(valor) !== -1) {
      return true;
    }
    
    todos.push(valor);
  }
  
  return false;
}
