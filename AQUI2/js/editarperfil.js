document.addEventListener("DOMContentLoaded", function() {
    const btnAdd = document.getElementById("btn-add-interesse");
    const inputNovo = document.getElementById("input-novo-interesse");
    const containerInteresses = document.getElementById("interesses-container");

    if (btnAdd && inputNovo && containerInteresses) {

        btnAdd.addEventListener("click", function() {
            btnAdd.style.display = "none";
            inputNovo.style.display = "block";
            inputNovo.focus();
        });

        inputNovo.addEventListener("keypress", function(evento) {
            if (evento.key === "Enter") {
                evento.preventDefault();

                const novoTexto = inputNovo.value.trim();

                if (novoTexto !== "") {
                    const novaTag = document.createElement("span");
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