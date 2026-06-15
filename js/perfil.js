document.addEventListener("DOMContentLoaded", function() {
    console.log("Página de perfil carregada e adaptada ao CSS base!");
});
function acaoBotao(nomeDoBotao) {
    console.log("Clicaste no botão: " + nomeDoBotao);
}

document.addEventListener("DOMContentLoaded", function() {

    var navbar = document.querySelector(".nav-fixa");

    if (navbar) {
        window.addEventListener("scroll", function() {

            if (window.scrollY > 20) {
                navbar.classList.add("nav-scrolled");
            }
            else {
                navbar.classList.remove("nav-scrolled");
            }

        });
    }
});

document.getElementById('perfil-img-pequena').src = dados.foto_perfil;
document.getElementById('perfil-img-grande').src = dados.foto_perfil;