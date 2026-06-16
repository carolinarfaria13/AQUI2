<?php
session_start();
require_once($_SERVER['DOCUMENT_ROOT'] . "/AQUI2/connections/connection.php");
$link = new_db_connection(); // Create a new DB connection
$stmt = mysqli_stmt_init($link); // create a prepared statement
// NOTA: utilizadores não tem coluna de foto; filtra pelo utilizador da sessão em vez de devolver todos
$id_utilizador = isset($_SESSION['id_utilizador']) ? $_SESSION['id_utilizador'] : 0;
$query = "SELECT nomeutilizador FROM utilizadores WHERE id_utilizadores = ?"; // Define the query

if (mysqli_stmt_prepare($stmt, $query)) { // Prepare the statement
    mysqli_stmt_bind_param($stmt, 'i', $id_utilizador);
    mysqli_stmt_execute($stmt); // Execute the prepared statement
    mysqli_stmt_bind_result($stmt, $nome); // Bind results

    while (mysqli_stmt_fetch($stmt)) {// Fetch values

        ?>
            <img src="../assets/setabackbranca1.png" class="nav-back" onclick="history.back()" style="cursor: pointer;"/>
            <div class="nav-logo">
                <img src="../assets/logotipobranco.png" class="logo-icon"/>
            </div>
            <div class="nav-avatar">
            <img src="../assets/voluntarioperfil.png" alt="<?php echo $nome; ?>"/>
            </div>

      <?php
    }
} else {
    mysqli_stmt_close($stmt); // Close statement
    echo "Error: " . mysqli_error($link); // Errors related with the query
}
mysqli_close($link);
?>