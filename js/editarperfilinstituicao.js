document.addEventListener("DOMContentLoaded", function() {
    var btnAdd = document.getElementById("btn-add-projeto");
    var inputNovo = document.getElementById("input-novo-projeto");
    var containerProjetos = document.getElementById("projetos-container");

    if (btnAdd && inputNovo && containerProjetos) {

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

                    containerProjetos.appendChild(novaTag);
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
});

document.addEventListener("DOMContentLoaded", function() {

    var navbar = document.querySelector(".nav-fixav");

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

document.addEventListener("DOMContentLoaded", function() {
    var inputFotoInst = document.getElementById('input-foto-inst');

    if (inputFotoInst) {
        inputFotoInst.addEventListener('change', function(e) {
            if (e.target.files && e.target.files[0]) {
                var reader = new FileReader();

                reader.onload = function(event) {
                    var imgPreview = document.getElementById('preview-foto-inst');
                    if (imgPreview) {
                        imgPreview.src = event.target.result;
                    }
                };

                reader.readAsDataURL(e.target.files[0]);
            }
        });
    }
});

// Exemplo se estiveres a receber "dados.foto_perfil" do teu PHP
if (dados.foto_perfil && dados.foto_perfil !== "") {
    var imgGrande = document.getElementById('perfil-img-grande');
    var imgPequena = document.getElementById('perfil-img-pequena'); // se tiveres na navbar

    // Adicionamos um timestamp (cache buster) para obrigar o browser a mostrar a foto nova
    var fotoAtualizada = dados.foto_perfil + '?t=' + new Date().getTime();

    if (imgGrande) imgGrande.src = fotoAtualizada;
    if (imgPequena) imgPequena.src = fotoAtualizada;
}

