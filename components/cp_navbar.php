<?php
// Garantir que a sessão está ativa
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once(__DIR__ . "/../connections/connection.php");
$link = new_db_connection();

$stmt = mysqli_stmt_init($link);
$id_utilizador = isset($_SESSION['id_utilizador']) ? $_SESSION['id_utilizador'] : 0;
$query = "SELECT nomeutilizador, fotoutilizador FROM utilizadores WHERE id_utilizadores = ?";

if (mysqli_stmt_prepare($stmt, $query)) {
    mysqli_stmt_bind_param($stmt, "i", $id_utilizador);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $nome, $foto_utilizador);
    mysqli_stmt_fetch($stmt);
    // Normaliza: a coluna tem valores inconsistentes na BD (uns só o nome do
    // ficheiro, outros já com um caminho relativo incluído) — fica só o nome
    // do ficheiro, e o caminho certo é sempre construído aqui.
    $foto_utilizador = basename($foto_utilizador ?? '');

    ?>
    <img src="../../assets/setaback1.png" class="nav-back" onclick="history.back()" style="cursor: pointer;"/>
    <div class="nav-logo">
        <img src="../../assets/logotipo.png" class="logo-icon"/>
    </div>
    <a href="../perfil/perfil.php" class="nav-avatar" style="text-decoration: none;">
        <img src="../../assets/<?php echo $foto_utilizador; ?>"
             id="perfil-img-pequena"
             class="top-profile-img"
             onerror="this.src='../../assets/voluntarioperfil.png';"
             alt="Perfil">
    </a>

    <?php

    mysqli_stmt_close($stmt);
} else {
    echo "Error: " . mysqli_error($link);
}
mysqli_close($link);
?>