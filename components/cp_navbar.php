<?php
session_start();
require_once(__DIR__ . "/../connections/connection.php");
$link = new_db_connection(); // Create a new DB connection

$stmt = mysqli_stmt_init($link); // create a prepared statement
$id_utilizador = isset($_SESSION['id_utilizador']) ? $_SESSION['id_utilizador'] : 0;
$query = "SELECT nomeutilizador, fotoutilizador FROM utilizadores WHERE id_utilizadores = ?"; // só o utilizador da sessão

if (mysqli_stmt_prepare($stmt, $query)) { // Prepare the statement
    mysqli_stmt_bind_param($stmt, "i", $id_utilizador);
    mysqli_stmt_execute($stmt); // Execute the prepared statement
    mysqli_stmt_bind_result($stmt, $nome, $foto_utilizador); // Bind results
    mysqli_stmt_fetch($stmt); // só precisamos de UMA linha: o utilizador atual

    ?>
    <img src="../../assets/setaback1.png" class="nav-back" onclick="history.back()" style="cursor: pointer;"/>
    <div class="nav-logo">
        <img src="../../assets/logotipo.png" class="logo-icon"/>
    </div>
    <div class="nav-avatar">
        <img src="../assets/<?php echo $foto_utilizador; ?>" />
    </div>
    <?php

    mysqli_stmt_close($stmt); // Close statement
} else {
    echo "Error: " . mysqli_error($link); // Errors related with the query
}
mysqli_close($link);
?>
