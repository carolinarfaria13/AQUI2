document.addEventListener("DOMContentLoaded", function() {

    // --- 1. LÓGICA DOS INTERESSES ---
    var btnAdd = document.getElementById("btn-add-interesse");
    var inputNovo = document.getElementById("input-novo-interesse");
    var containerInteresses = document.getElementById("interesses-container");
    var interessesHidden = document.getElementById("interesses-hidden"); // O campo invisível para a BD

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
                    // A) Criar a bolinha visual (tag-pill)
                    var novaTag = document.createElement("span");
                    novaTag.className = "tag-pill";
                    novaTag.textContent = novoTexto;
                    containerInteresses.appendChild(novaTag);

                    // B) Adicionar a palavra ao input escondido (para ir para a Base de Dados)
                    if (interessesHidden) {
                        var interessesAtuais = interessesHidden.value;
                        if (interessesAtuais !== "") {
                            interessesHidden.value = interessesAtuais + "," + novoTexto;
                        } else {
                            interessesHidden.value = novoTexto;
                        }
                    }
                }

                // C) Restaurar a UI depois de carregar Enter
                inputNovo.value = "";
                inputNovo.style.display = "none";
                btnAdd.style.display = "inline-block";
            }
        });

        // D) Esconder se o utilizador clicar fora da caixa sem escrever nada
        inputNovo.addEventListener("blur", function() {
            if (inputNovo.value.trim() === "") {
                inputNovo.style.display = "none";
                btnAdd.style.display = "inline-block";
            }
        });
    }

    // --- 2. LÓGICA DA NAVBAR (SCROLL) ---
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

// --- 3. LÓGICA DA FOTOGRAFIA (PREVIEW) ---
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