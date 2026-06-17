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

            var textoCidade = document.getElementById('perfil-cidade');
            if (textoCidade && dados.cidade) {
                textoCidade.textContent = dados.cidade;
            }

            var elementoNome = document.getElementById('perfil-nome');
            if (elementoNome && dados.nome) {
                elementoNome.textContent = "Olá, " + dados.nome;
            }

            // Atualiza APENAS o texto, porque o ícone já está protegido no HTML!
            var elementoCidade = document.getElementById('perfil-cidade');
            if (elementoCidade && dados.cidade) {
                elementoCidade.textContent = dados.cidade;
            }

            var elementoBiografia = document.getElementById('perfil-biografia');
            if (elementoBiografia && dados.biografia) {
                elementoBiografia.textContent = dados.biografia;
            }

            var imgPequena = document.getElementById('perfil-img-pequena');
            var imgGrande = document.getElementById('perfil-img-grande');

            if (dados.foto_perfil && dados.foto_perfil !== "") {
                console.log("Caminho da foto que veio da BD: ", dados.foto_perfil);

                // O TRUQUE: Adicionar um timestamp falso para obrigar o browser a ir buscar a foto nova
                var fotoComCacheBuster = dados.foto_perfil + '?t=' + new Date().getTime();

                if (imgPequena) imgPequena.src = fotoComCacheBuster;
                if (imgGrande) imgGrande.src = fotoComCacheBuster;
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