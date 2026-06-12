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
  if (valido) window.location.href = 'homepage-instituicao.html';
}
