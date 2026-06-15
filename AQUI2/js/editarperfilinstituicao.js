document.addEventListener("DOMContentLoaded", function() {
    // 1. Apanhar os elementos dos PROJETOS
    const btnAdd = document.getElementById("btn-add-projeto");
    const inputNovo = document.getElementById("input-novo-projeto");
    const containerProjetos = document.getElementById("projetos-container");

    // Só avança se encontrar os elementos nesta página
    if (btnAdd && inputNovo && containerProjetos) {

        // 2. Quando clica no botão "+ Adicionar projeto"
        btnAdd.addEventListener("click", function() {
            btnAdd.style.display = "none";
            inputNovo.style.display = "block";
            inputNovo.focus();
        });

        // 3. Quando escreve e clica Enter
        inputNovo.addEventListener("keypress", function(evento) {
            if (evento.key === "Enter") {
                evento.preventDefault(); // Evita o refresh da página

                const novoTexto = inputNovo.value.trim();

                if (novoTexto !== "") {
                    const novaTag = document.createElement("span");
                    novaTag.className = "tag-pill";
                    novaTag.textContent = novoTexto;

                    containerProjetos.appendChild(novaTag);
                }

                // Limpa e volta a mostrar o botão
                inputNovo.value = "";
                inputNovo.style.display = "none";
                btnAdd.style.display = "inline-block";
            }
        });

        // 4. Se a pessoa clicar fora sem escrever nada
        inputNovo.addEventListener("blur", function() {
            if (inputNovo.value.trim() === "") {
                inputNovo.style.display = "none";
                btnAdd.style.display = "inline-block";
            }
        });
    }
});