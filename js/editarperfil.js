document.addEventListener("DOMContentLoaded", function() {
    var btnAdd = document.getElementById("btn-add-interesse");
    var inputNovo = document.getElementById("input-novo-interesse");
    var containerInteresses = document.getElementById("interesses-container");

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

document.getElementById('input-foto').addEventListener('change', function(e) {
    var reader = new FileReader();
    reader.onload = function(event) {
        document.getElementById('preview-foto').src = event.target.result;
    }
    reader.readAsDataURL(e.target.files[0]);
});