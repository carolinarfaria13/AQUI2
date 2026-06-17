document.addEventListener("DOMContentLoaded", function() {
    console.log("Página de perfil carregada e pronta!");

    // Apenas o efeito da navbar ao fazer scroll
    var navbar = document.querySelector(".nav-fixa");
    if (navbar) {
        window.addEventListener("scroll", function() {
            if (window.scrollY > 20) {
                navbar.classList.add("nav-scrolled");
            } else {
                navbar.classList.remove("nav-scrolled");
            }
        });
    }
});

function acaoBotao(nomeDoBotao) {
    console.log("Clicaste no botão: " + nomeDoBotao);
}