<?php
require_once($_SERVER['DOCUMENT_ROOT'] . "/AQUI2/connections/connection.php");
$link = new_db_connection(); // Create a new DB connection
$stmt = mysqli_stmt_init($link); // create a prepared statement
$query = "SELECT nomeutilizador, fotoutilizador FROM utilizadores"; // Define the query

if (mysqli_stmt_prepare($stmt, $query)) { // Prepare the statement
    mysqli_stmt_execute($stmt); // Execute the prepared statement
    mysqli_stmt_bind_result($stmt, $nome, $foto_utilizador ); // Bind results

    while (mysqli_stmt_fetch($stmt)) {
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
    }
} else {
    mysqli_stmt_close($stmt); // Close statement
    echo "Error: " . mysqli_error($link); // Errors related with the query
}
mysqli_close($link);
?>