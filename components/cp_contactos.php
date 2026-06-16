<?php
require_once($_SERVER['DOCUMENT_ROOT'] . "/AQUI2/connections/connection.php");
$link = new_db_connection(); // Create a new DB connection
$id_instituicao = isset($_GET["id"]) ? $_GET["id"] : 0;
$stmt = mysqli_stmt_init($link); // create a prepared statement
// utilizadores.instituicoes_id_instituicoes é a FK que liga ao dono da instituição, não o id_utilizadores
$query = "SELECT u.id_utilizadores, u.morada, u.contacto, u.email, i.website FROM utilizadores u
          JOIN instituicoes i ON u.instituicoes_id_instituicoes = i.id_instituicoes
          WHERE i.id_instituicoes = ?";

if (mysqli_stmt_prepare($stmt, $query)) { // Prepare the statement
    mysqli_stmt_bind_param($stmt, 'i', $id_instituicao);
    mysqli_stmt_execute($stmt); // Execute the prepared statement
    mysqli_stmt_bind_result($stmt, $id_utilizadores, $morada, $contacto, $email, $website); // Bind results

    while (mysqli_stmt_fetch($stmt)) {// Fetch values
        ?>
        <h2>Contactos</h2>
        <p><strong>Localização:</strong> <?php echo $morada; ?></p>
        <p><strong>Email:</strong> <?php echo $email; ?></p>
        <p><strong>Telefone:</strong> <?php echo $contacto; ?></p>
        <p><strong>Website:</strong> <?php echo $website; ?></p>
        <?php
    }
} else {
    mysqli_stmt_close($stmt); // Close statement
    echo "Error: " . mysqli_error($link); // Errors related with the query
}
mysqli_close($link);
?>
