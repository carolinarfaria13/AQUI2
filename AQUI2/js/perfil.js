// Aguarda que o HTML seja todo carregado
document.addEventListener("DOMContentLoaded", function() {
    console.log("Página de perfil carregada e adaptada ao CSS base!");
});

// Função acionada ao clicar nos botões de ação laranja
function acaoBotao(nomeDoBotao) {
    console.log("Clicaste no botão: " + nomeDoBotao);
    // Aqui poderás colocar a navegação. Exemplo:
    // if(nomeDoBotao === 'Editar perfil') window.location.href = 'editar.html';
}