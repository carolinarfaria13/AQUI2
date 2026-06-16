document.addEventListener("DOMContentLoaded", function() {
    var imgNavbar = document.getElementById('perfil-img-pequena');

    var fotoGuardada = localStorage.getItem('fotoPerfilUser');

    if (imgNavbar && fotoGuardada) {
        imgNavbar.src = fotoGuardada;
    }
});