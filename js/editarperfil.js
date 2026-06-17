document.addEventListener("DOMContentLoaded", function() {

    fetch('perfil.php?nocache=' + new Date().getTime())
        .then(function(resposta) {
            return resposta.json();
        })
        .then(function(dados) {
            if (dados.erro) {
                console.error("Aviso do Servidor:", dados.erro);
                return;
            }

            function preencherCampo(nomeCampo, valor) {
                var campo = document.querySelector('[name="' + nomeCampo + '"]');
                if (campo && valor) {
                    campo.value = valor;
                }
            }

            preencherCampo("nome", dados.nome);
            preencherCampo("username", dados.username);
            preencherCampo("biografia", dados.biografia);
            preencherCampo("email", dados.email);
            preencherCampo("telemovel", dados.telemovel);
            preencherCampo("data_nascimento", dados.data_nascimento);
            preencherCampo("cidade", dados.cidade);
            preencherCampo("competencias", dados.competencias);

            if (dados.foto_perfil && dados.foto_perfil !== "") {
                var imgPreview = document.getElementById('preview-foto');
                var imgPequena = document.getElementById('perfil-img-pequena');

                if (imgPreview) imgPreview.src = dados.foto_perfil;
                if (imgPequena) imgPequena.src = dados.foto_perfil;
            }

            if (dados.interesses) {
                var containerInteresses = document.getElementById("interesses-container");
                var interessesHidden = document.getElementById("interesses-hidden");

                if (interessesHidden) interessesHidden.value = dados.interesses;

                if (containerInteresses) {
                    containerInteresses.innerHTML = "";

                    var listaInteresses = dados.interesses.split(',');
                    listaInteresses.forEach(function(interesse) {
                        var texto = interesse.trim();
                        if (texto !== "") {
                            var novaTag = document.createElement("span");
                            novaTag.className = "tag-pill";
                            novaTag.textContent = texto;
                            containerInteresses.appendChild(novaTag);
                        }
                    });
                }
            }
        })
        .catch(function(erro) {
            console.error("Erro ao carregar dados:", erro);
        });


    var btnAdd = document.getElementById("btn-add-interesse");
    var inputNovo = document.getElementById("input-novo-interesse");
    var containerInteresses = document.getElementById("interesses-container");
    var interessesHidden = document.getElementById("interesses-hidden");

    if (btnAdd && inputNovo && containerInteresses) {

        btnAdd.addEventListener("click", function() {
            btnAdd.style.display = "none";
            inputNovo.style.display = "block";
            inputNovo.focus();
        });

        inputNovo.addEventListener("keypress", function(evento) {
            if (evento.key === "Enter") {
                evento.preventDefault();

                var novoTexto = inputNovo.value.trim();

                if (novoTexto !== "") {
                    var novaTag = document.createElement("span");
                    novaTag.className = "tag-pill";
                    novaTag.textContent = novoTexto;
                    containerInteresses.appendChild(novaTag);

                    if (interessesHidden) {
                        var interessesAtuais = interessesHidden.value;
                        if (interessesAtuais !== "") {
                            interessesHidden.value = interessesAtuais + "," + novoTexto;
                        } else {
                            interessesHidden.value = novoTexto;
                        }
                    }
                }

                inputNovo.value = "";
                inputNovo.style.display = "none";
                btnAdd.style.display = "inline-block";
            }
        });

        inputNovo.addEventListener("blur", function() {
            if (inputNovo.value.trim() === "") {
                inputNovo.style.display = "none";
                btnAdd.style.display = "inline-block";
            }
        });
    }

    var navbar = document.querySelector(".nav-fixav");
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

var inputFoto = document.getElementById('input-foto');
if (inputFoto) {
    inputFoto.addEventListener('change', function(e) {
        var reader = new FileReader();
        reader.onload = function(event) {
            document.getElementById('preview-foto').src = event.target.result;
        }
        if (e.target.files[0]) {
            reader.readAsDataURL(e.target.files[0]);
        }
    });
}

document.getElementById('input-foto').addEventListener('change', function(e) {
    if (e.target.files && e.target.files[0]) {
        var reader = new FileReader();
        reader.onload = function(event) {
            document.getElementById('preview-foto').src = event.target.result;

            localStorage.setItem('fotoPerfilUser', event.target.result);
        };
        reader.readAsDataURL(e.target.files[0]);
    }
});

document.addEventListener("DOMContentLoaded", function() {
    console.log("Página de edição pronta para carregar dados...");

    // Vai buscar os dados atualizados à base de dados
    fetch('perfil.php?nocache=' + new Date().getTime())
        .then(function(resposta) {
            return resposta.json();
        })
        .then(function(dados) {

            // Preenche as caixas com os dados reais do utilizador
            var inputNome = document.getElementById('nome');
            if (inputNome && dados.nome) inputNome.value = dados.nome;

            var inputUsername = document.getElementById('username');
            if (inputUsername && dados.username) inputUsername.value = dados.username;

            var inputBiografia = document.getElementById('biografia');
            if (inputBiografia && dados.biografia) inputBiografia.value = dados.biografia;

            var inputEmail = document.getElementById('email');
            if (inputEmail && dados.email) inputEmail.value = dados.email;

            var inputTelemovel = document.getElementById('telemovel');
            if (inputTelemovel && dados.telemovel) inputTelemovel.value = dados.telemovel;

            var inputDataNascimento = document.getElementById('data_nascimento');
            if (inputDataNascimento && dados.data_nascimento) inputDataNascimento.value = dados.data_nascimento;

            // ADICIONA ESTAS LINHAS:
            // COMPETÊNCIAS (Caixa de texto normal)
            var inputCompetencias = document.getElementById('competencias');
            if (inputCompetencias && dados.competencias) {
                inputCompetencias.value = dados.competencias;
            }

            // INTERESSES (Sistema de Tags)
            var inputInteresses = document.getElementById('interesses-hidden');
            var containerInteresses = document.getElementById('interesses-container');

            if (inputInteresses && containerInteresses && dados.interesses) {
                // 1. Preenche o campo escondido para o PHP poder guardar depois
                inputInteresses.value = dados.interesses;

                // 2. Limpa a área visual e cria as "bolhas"
                containerInteresses.innerHTML = '';

                // Transforma "Limpeza,Natureza" numa lista e cria uma bolha para cada um
                var listaInteresses = dados.interesses.split(',');
                listaInteresses.forEach(function(interesse) {
                    var textoInteresse = interesse.trim();
                    if (textoInteresse !== "") {
                        var tag = document.createElement('span');
                        tag.className = 'tag-pill';
                        tag.textContent = textoInteresse;
                        // Opcional: Adicionar clique para remover a tag
                        tag.onclick = function() { this.remove(); atualizarInputEscondido(); };
                        containerInteresses.appendChild(tag);
                    }
                });
            }
        .catch(function(erro) {
            console.error("Erro ao carregar dados para edição:", erro);
        });
});