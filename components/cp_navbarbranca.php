<?php
require_once(__DIR__ . "/../connections/connection.php");
$link = new_db_connection(); // Create a new DB connection

session_start(); // remove esta linha se já chamas session_start() noutro sítio antes deste ficheiro

$stmt = mysqli_stmt_init($link); // create a prepared statement
$query = "SELECT nomeutilizador, fotoutilizador FROM utilizadores WHERE id_utilizadores = ?"; // só o utilizador da sessão

if (mysqli_stmt_prepare($stmt, $query)) { // Prepare the statement
    mysqli_stmt_bind_param($stmt, "i", $_SESSION['id_utilizador']); // AJUSTA o nome desta variável de sessão se for diferente
    mysqli_stmt_execute($stmt); // Execute the prepared statement
    mysqli_stmt_bind_result($stmt, $nome, $foto_utilizador); // Bind results
    mysqli_stmt_fetch($stmt); // só precisamos de UMA linha: o utilizador atual
    // Normaliza: a coluna tem valores inconsistentes na BD (uns só o nome do
    // ficheiro, outros já com um caminho relativo incluído).
    $foto_utilizador = basename($foto_utilizador ?? '');

    ?>
    <img src="../../assets/setabackbranca1.png" class="nav-back" onclick="history.back()" style="cursor: pointer;"/>
    <div class="nav-logo">
        <img src="../../assets/logotipobranco.png" class="logo-icon"/>
    </div>
    <div class="nav-avatar">
        <img src="../../assets/<?php echo $foto_utilizador; ?>" onerror="this.src='../../assets/voluntarioperfil.png';" />
    </div>
    <?php

    mysqli_stmt_close($stmt); // Close statement
} else {
    echo "Error: " . mysqli_error($link); // Errors related with the query
}
mysqli_close($link);
?>
