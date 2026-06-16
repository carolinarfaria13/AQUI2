document.addEventListener("DOMContentLoaded", function() {
    console.log("Página de perfil carregada e pronta para receber dados!");

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

    fetch('perfil.php?nocache=' + new Date().getTime())
        .then(function(resposta) {
            return resposta.json();
        })
        .then(function(dados) {
            if (dados.erro) {
                console.error("Aviso do Servidor:", dados.erro);
                return;
            }


            var elementoNome = document.getElementById('perfil-nome');
            if (elementoNome && dados.nome) {
                elementoNome.textContent = "Olá, " + dados.nome;
            }

            var elementoCidade = document.getElementById('perfil-cidade');
            if (elementoCidade && dados.cidade) {
                // Usamos innerHTML para não apagar o ícone do mapa (fa-map-marker-alt)
                elementoCidade.innerHTML = '<i class="fas fa-map-marker-alt"></i> ' + dados.cidade;
            }

            var elementoBiografia = document.getElementById('perfil-biografia');
            if (elementoBiografia && dados.biografia) {
                elementoBiografia.textContent = dados.biografia;
            }

            var imgPequena = document.getElementById('perfil-img-pequena');
            var imgGrande = document.getElementById('perfil-img-grande');

            if (dados.foto_perfil && dados.foto_perfil !== "") {
                if (imgPequena) imgPequena.src = dados.foto_perfil;
                if (imgGrande) imgGrande.src = dados.foto_perfil;
            }

            console.log("Dados do utilizador carregados com sucesso!");
        })
        .catch(function(erro) {
            console.error("Erro de comunicação com o servidor:", erro);
        });
});

function acaoBotao(nomeDoBotao) {
    console.log("Clicaste no botão: " + nomeDoBotao);
}