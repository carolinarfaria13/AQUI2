document.addEventListener("DOMContentLoaded", function() {
    console.log("Página de edição pronta para carregar dados...");

    // 1. FUNÇÃO VITAL PARA OS INTERESSES (Sincroniza as bolhas com o input invisível)
    function atualizarInputEscondido() {
        var tags = document.querySelectorAll('#interesses-container span.tag-pill');
        var arrayInteresses = [];

        tags.forEach(function(tag) {
            arrayInteresses.push(tag.textContent.trim());
        });

        var inputHidden = document.getElementById('interesses-hidden');
        if(inputHidden) {
            inputHidden.value = arrayInteresses.join(',');
        }
    }

    // 2. RECRIAR AS BOLHAS A PARTIR DO PHP
    var containerInteresses = document.getElementById("interesses-container");
    var interessesHidden = document.getElementById("interesses-hidden");

    if (interessesHidden && containerInteresses && interessesHidden.value) {
        var listaInteresses = interessesHidden.value.split(',');
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

    // 3. LÓGICA DO BOTÃO "+ ADICIONAR INTERESSE"
    var btnAdd = document.getElementById("btn-add-interesse");
    var inputNovo = document.getElementById("input-novo-interesse");

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

                    // CLIQUE PARA APAGAR A BOLHA NOVA
                    tag.style.cursor = 'pointer';
                    tag.onclick = function() {
                        this.remove();
                        atualizarInputEscondido();
                    };

                    containerInteresses.appendChild(tag);
                    atualizarInputEscondido();
                }

                inputNovo.value = "";
                inputNovo.style.display = "none";
                btnAdd.style.display = "inline-block";
            }
        });

        // Esconde se clicar fora
        inputNovo.addEventListener("blur", function() {
            if (inputNovo.value.trim() === "") {
                inputNovo.style.display = "none";
                btnAdd.style.display = "inline-block";
            }
        });
    }

    // 4. PREVIEW + COMPRESSÃO DA FOTO
    // O servidor tem upload_max_filesize = 2MB. Fotos de telemóvel passam disso e o
    // envio era descartado em silêncio. Aqui redimensiona-se/comprime-se a imagem no
    // browser antes de submeter, garantindo que fica bem abaixo do limite.
    var inputFoto = document.getElementById('input-foto');
    var imgPreview = document.getElementById('preview-foto');
    var MAX_LADO = 1000;     // dimensão máxima (px) do lado maior
    var QUALIDADE = 0.82;    // qualidade JPEG

    if (inputFoto) {
        inputFoto.addEventListener('change', function(e) {
            var ficheiro = e.target.files && e.target.files[0];
            if (!ficheiro) return;

            var reader = new FileReader();
            reader.onload = function(event) {
                var img = new Image();
                img.onload = function() {
                    // Mostra logo a preview com a imagem original
                    if (imgPreview) imgPreview.src = event.target.result;

                    var escala = Math.min(1, MAX_LADO / Math.max(img.width, img.height));
                    var canvas = document.createElement('canvas');
                    canvas.width = Math.round(img.width * escala);
                    canvas.height = Math.round(img.height * escala);

                    var ctx = canvas.getContext('2d');
                    ctx.drawImage(img, 0, 0, canvas.width, canvas.height);

                    // Substitui o ficheiro do input pela versão comprimida (JPEG)
                    if (canvas.toBlob) {
                        canvas.toBlob(function(blob) {
                            if (!blob) return; // fallback: mantém o ficheiro original
                            try {
                                var nome = (ficheiro.name || 'foto').replace(/\.[^.]+$/, '') + '.jpg';
                                var comprimido = new File([blob], nome, { type: 'image/jpeg' });
                                var dt = new DataTransfer();
                                dt.items.add(comprimido);
                                inputFoto.files = dt.files;
                            } catch (err) {
                                // Browser sem suporte a DataTransfer/File: envia o original
                                console.warn('Não foi possível comprimir a foto:', err);
                            }
                        }, 'image/jpeg', QUALIDADE);
                    }
                };
                img.src = event.target.result;
            };
            reader.readAsDataURL(ficheiro);
        });
    }

    // 5. NAVBAR SCROLL
    var navbarFixaV = document.querySelector(".nav-fixav");
    if (navbarFixaV) {
        window.addEventListener("scroll", function() {
            if (window.scrollY > 20) {
                navbarFixaV.classList.add("nav-scrolled");
            } else {
                navbarFixaV.classList.remove("nav-scrolled");
            }
        });
    }
});