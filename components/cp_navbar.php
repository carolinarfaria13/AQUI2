<<?php
session_start();
require_once($_SERVER['DOCUMENT_ROOT'] . "/AQUI2/connections/connection.php");
$link = new_db_connection();

$stmt = mysqli_stmt_init($link);
$id_utilizador = isset($_SESSION['id_utilizador']) ? $_SESSION['id_utilizador'] : 0;
$query = "SELECT nomeutilizador, fotoutilizador FROM utilizadores WHERE id_utilizadores = ?";

if (mysqli_stmt_prepare($stmt, $query)) {
    mysqli_stmt_bind_param($stmt, "i", $id_utilizador);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $nome, $foto_utilizador);
    mysqli_stmt_fetch($stmt);

    ?>
    <img src="../assets/setabackbranca1.png" class="nav-back" onclick="history.back()" style="cursor: pointer;"/>
    <div class="nav-logo">
        <img src="../assets/logotipobranco.png" class="logo-icon"/>
    </div>
    <div class="nav-avatar">
        <img src="../assets/<?php echo $foto_utilizador; ?>"
             id="perfil-img-pequena"
             class="top-profile-img"
             onerror="this.src='../assets/voluntarioperfil.png';"
             alt="Perfil">
    </div>
    <?php

    mysqli_stmt_close($stmt);
} else {
    echo "Error: " . mysqli_error($link);
}
mysqli_close($link);
?>