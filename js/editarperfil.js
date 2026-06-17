document.addEventListener("DOMContentLoaded", function() {
    console.log("Página de edição pronta para carregar dados...");

    // 1. FUNÇÃO VITAL PARA OS INTERESSES (Sincroniza as bolhas com o input invisível)
    function atualizarInputEscondido() {
        var tags = document.querySelectorAll('#interesses-container span');
        var arrayInteresses = [];

        tags.forEach(function(tag) {
            arrayInteresses.push(tag.textContent.trim());
        });

        var inputHidden = document.getElementById('interesses-hidden');
        if(inputHidden) {
            inputHidden.value = arrayInteresses.join(',');
        }
    }

    // 2. BUSCAR DADOS À BASE DE DADOS (Nome, Email, Telemóvel, Interesses, etc.)
    fetch('perfil.php?nocache=' + new Date().getTime())
        .then(function(resposta) {
            return resposta.json();
        })
        .then(function(dados) {
            if (dados.erro) {
                console.error("Aviso do Servidor:", dados.erro);
                return;
            }

            // Função auxiliar para preencher caixas de texto normais
            function preencherCampo(idOuNome, valor) {
                var campo = document.getElementById(idOuNome) || document.querySelector('[name="' + idOuNome + '"]');
                if (campo && valor) {
                    campo.value = valor;
                }
            }

            // Preenchemos tudo com uma linha cada!
            preencherCampo("nome", dados.nome);
            preencherCampo("username", dados.username);
            preencherCampo("biografia", dados.biografia);
            preencherCampo("email", dados.email);
            preencherCampo("telemovel", dados.telemovel);
            preencherCampo("data_nascimento", dados.data_nascimento);
            preencherCampo("cidade", dados.cidade);
            preencherCampo("competencias", dados.competencias);

            // Preencher Foto de Perfil
            if (dados.foto_perfil && dados.foto_perfil !== "") {
                var imgPreview = document.getElementById('preview-foto');
                var imgPequena = document.getElementById('perfil-img-pequena');
                if (imgPreview) imgPreview.src = dados.foto_perfil;
                if (imgPequena) imgPequena.src = dados.foto_perfil;
            }

            // Preencher Interesses (Bolhas / Tags)
            var containerInteresses = document.getElementById("interesses-container");
            var interessesHidden = document.getElementById("interesses-hidden");

            if (interessesHidden && containerInteresses && dados.interesses) {
                interessesHidden.value = dados.interesses;
                containerInteresses.innerHTML = "";

                var listaInteresses = dados.interesses.split(',');
                listaInteresses.forEach(function(interesse) {
                    var texto = interesse.trim();
                    if (texto !== "") {
                        var tag = document.createElement("span");
                        tag.className = "tag-pill";
                        tag.textContent = texto;

                        // CLIQUE PARA APAGAR AS BOLHAS CARREGADAS DA BASE DE DADOS
                        tag.style.cursor = 'pointer';
                        tag.onclick = function() {
                            this.remove();
                            atualizarInputEscondido();
                        };

                        containerInteresses.appendChild(tag);
                    }
                });
            }
        })
        .catch(function(erro) {
            console.error("Erro ao carregar dados:", erro);
        });


    // 3. LÓGICA DO BOTÃO "+ ADICIONAR INTERESSE"
    var btnAdd = document.getElementById("btn-add-interesse");
    var inputNovo = document.getElementById("input-novo-interesse");
    var containerInteresses = document.getElementById("interesses-container");

    if (btnAdd && inputNovo && containerInteresses) {

        // Mostrar a caixa para escrever
        btnAdd.addEventListener("click", function() {
            btnAdd.style.display = "none";
            inputNovo.style.display = "block";
            inputNovo.focus();
        });

        // Quando se carrega em ENTER
        inputNovo.addEventListener("keypress", function(evento) {
            if (evento.key === "Enter") {
                evento.preventDefault();
                var novoTexto = inputNovo.value.trim();

                if (novoTexto !== "") {
                    var tag = document.createElement("span");
                    tag.className = "btn tag-pill";
                    tag.style.backgroundColor = "#F5B759";
                    tag.style.color = "#fff";
                    tag.style.borderRadius = "20px";
                    tag.style.padding = "5px 15px";
                    tag.style.margin = "5px";
                    tag.style.display = "inline-block";
                    tag.textContent = novoTexto;

                    // CLIQUE PARA APAGAR A BOLHA NOVA QUE ACABOU DE SER ESCRITA
                    tag.style.cursor = 'pointer';
                    tag.onclick = function() {
                        this.remove();
                        atualizarInputEscondido();
                    };

                    containerInteresses.appendChild(tag);
                    atualizarInputEscondido(); // Guarda o novo interesse no input invisível!
                }

                inputNovo.value = "";
                inputNovo.style.display = "none";
                btnAdd.style.display = "inline-block";
            }
        });

        // Se o utilizador clicar fora sem escrever nada, esconde a caixa
        inputNovo.addEventListener("blur", function() {
            if (inputNovo.value.trim() === "") {
                inputNovo.style.display = "none";
                btnAdd.style.display = "inline-block";
            }
        });
    }

    // 4. LÓGICA DA PREVIEW DE FOTO QUANDO ESCOLHES UM FICHEIRO
    var inputFoto = document.getElementById('input-foto');
    if (inputFoto) {
        inputFoto.addEventListener('change', function(e) {
            if (e.target.files && e.target.files[0]) {
                var reader = new FileReader();
                reader.onload = function(event) {
                    var imgPreview = document.getElementById('preview-foto');
                    if (imgPreview) imgPreview.src = event.target.result;
                    localStorage.setItem('fotoPerfilUser', event.target.result);
                };
                reader.readAsDataURL(e.target.files[0]);
            }
        });
    }

    // 5. NAVBAR SCROLL
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