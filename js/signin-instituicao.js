function validarFormulario() {
  const campos = ['nome','telemovel','descricao','objetivos','email','password','username'];
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
  ['nome','telemovel','localizacao','instagram','website','datacriacao','descricao','objetivos','email','password','username'].forEach(function(id) {
    const input = document.getElementById(id);
    if (input) dados.append(id, input.value);
  });

  fetch('registo-instituicao.php', { method: 'POST', body: dados })
    .then(function(res) { return res.json(); })
    .then(function(resp) {
      if (resp.sucesso) {
        window.location.href = '../homepage/homepage-instituicao.html';
      } else {
        alert(resp.erro || 'Não foi possível criar a conta.');
      }
    })
    .catch(function() {
      alert('Erro de ligação ao servidor.');
    });
}
