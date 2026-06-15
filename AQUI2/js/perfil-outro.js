document.addEventListener("DOMContentLoaded", function() {
    console.log("Página de Perfil de Inês carregada com sucesso.");
});

function verMais() {
    console.log("Clicaste em Ver mais projetos!");

}

document.addEventListener("DOMContentLoaded", function() {

    var btnVerMais = document.getElementById("btn-ver-mais-projetos");
    var projetosEscondidos = document.querySelectorAll(".projeto-escondido");

    if (btnVerMais) {
        btnVerMais.addEventListener("click", function() {

            if (btnVerMais.textContent.trim() === "+ Ver mais") {

                // --- MOSTRAR ---
                projetosEscondidos.forEach(function(projeto) {
                    projeto.classList.remove("animacao-esconder");
                    projeto.style.display = "inline-block";
                });

                btnVerMais.textContent = "- Ver menos";

            } else {

                // --- ESCONDER COM ANIMAÇÃO ---
                projetosEscondidos.forEach(function(projeto) {
                    projeto.classList.add("animacao-esconder");

                    setTimeout(function() {
                        if (btnVerMais.textContent.trim() === "+ Ver mais") {
                            projeto.style.display = "none";
                        }
                    }, 300);
                });

                btnVerMais.textContent = "+ Ver mais";
            }
        });
    }
});

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