document.addEventListener("DOMContentLoaded", function() {
    // A foto de perfil da navbar é renderizada pelo servidor a partir da BD.
    // Removida a antiga sobreposição via localStorage ('fotoPerfilUser'), que
    // mantinha sempre a foto anterior em cache e ignorava a foto atualizada.

    // Limpa o valor obsoleto que possa ter ficado guardado em sessões antigas.
    localStorage.removeItem('fotoPerfilUser');
});
