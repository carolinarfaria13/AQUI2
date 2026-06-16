const inputNascimento = document.getElementById('nascimento');
inputNascimento.addEventListener('input', function () {
  let digitos = inputNascimento.value.replace(/\D/g, '').slice(0, 8);
  let formatado = digitos;
  if (digitos.length > 4) {
    formatado = digitos.slice(0, 2) + '/' + digitos.slice(2, 4) + '/' + digitos.slice(4);
  } else if (digitos.length > 2) {
    formatado = digitos.slice(0, 2) + '/' + digitos.slice(2);
  }
  inputNascimento.value = formatado;
});

function tornarTagSelecionavel(tag) {
  tag.title = 'Clicar para selecionar/desselecionar';
  tag.addEventListener('click', function () {
    tag.classList.toggle('selected');
  });
}

document.querySelectorAll('#interesses-wrap .tag').forEach(tornarTagSelecionavel);

const modalInteresse = document.getElementById('modal-interesse');
const inputNovoInteresse = document.getElementById('input-novo-interesse');
const erroNovoInteresse = document.getElementById('err-novo-interesse');
const SO_LETRAS = /^[A-Za-zÀ-ÖØ-öø-ÿ]+( [A-Za-zÀ-ÖØ-öø-ÿ]+)*$/;

function adicionarInteresse() {
  const texto = inputNovoInteresse.value.trim();
  if (!SO_LETRAS.test(texto)) {
    inputNovoInteresse.classList.add('input-error');
    erroNovoInteresse.classList.add('visible');
    return;
  }
  inputNovoInteresse.classList.remove('input-error');
  erroNovoInteresse.classList.remove('visible');

  const tag = document.createElement('span');
  tag.className = 'tag selected';
  tag.textContent = texto;
  tornarTagSelecionavel(tag);
  document.getElementById('btn-add-interesse').insertAdjacentElement('beforebegin', tag);
  modalInteresse.classList.remove('ativo');
}

document.getElementById('btn-add-interesse').addEventListener('click', function () {
  inputNovoInteresse.value = '';
  inputNovoInteresse.classList.remove('input-error');
  erroNovoInteresse.classList.remove('visible');
  modalInteresse.classList.add('ativo');
  inputNovoInteresse.focus();
});

document.getElementById('btn-confirmar-interesse').addEventListener('click', adicionarInteresse);

document.getElementById('btn-cancelar-interesse').addEventListener('click', function () {
  modalInteresse.classList.remove('ativo');
});

modalInteresse.addEventListener('click', function (e) {
  if (e.target === modalInteresse) modalInteresse.classList.remove('ativo');
});

inputNovoInteresse.addEventListener('keydown', function (e) {
  if (e.key === 'Enter') {
    e.preventDefault();
    adicionarInteresse();
  }
});

function validarFormulario() {
  const campos = ['nome','telemovel','nascimento','competencias','email','password','username'];
  let valido = true;
  campos.forEach(function(id) {
    const input = document.getElementById(id);
    const erro = document.getElementById('err-' + id);
    if (!input.value.trim()) {
      input.classList.add('input-error');
      erro.classList.add('visible');
      valido = false;
    } else {
      input.classList.remove('input-error');
      erro.classList.remove('visible');
    }
  });
  if (!valido) return;

  const dados = new FormData();
  ['nome','telemovel','nascimento','cidade','bio','competencias','email','password','username'].forEach(function(id) {
    const input = document.getElementById(id);
    if (input) dados.append(id, input.value);
  });

  const interesses = Array.from(document.querySelectorAll('#interesses-wrap .tag.selected'))
    .map(function(tag) { return tag.textContent; });
  dados.append('interesses', interesses.join(', '));

  fetch('registo-voluntario.php', { method: 'POST', body: dados })
    .then(function(res) { return res.json(); })
    .then(function(resp) {
      if (resp.sucesso) {
        window.location.href = '../homepage/homepage-voluntario.html';
      } else {
        alert(resp.erro || 'Não foi possível criar a conta.');
      }
    })
    .catch(function() {
      alert('Erro de ligação ao servidor.');
    });
}
