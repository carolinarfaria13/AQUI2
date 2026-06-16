<?php
require_once($_SERVER['DOCUMENT_ROOT'] . "/AQUI2/connections/connection.php");
$link = new_db_connection(); // Create a new DB connection
$stmt = mysqli_stmt_init($link); // create a prepared statement
$query = "SELECT id_projetos, titulo, sinopse, capa FROM projetos"; // Define the query

if (mysqli_stmt_prepare($stmt, $query)) { // Prepare the statement
    mysqli_stmt_execute($stmt); // Execute the prepared statement
    mysqli_stmt_bind_result($stmt, $id_projetos, $titulo, $sinopse, $capa); // Bind results

    while (mysqli_stmt_fetch($stmt)) {// Fetch values
        ?>
        <li class="card">
            <div class="card-logo">
                <img src="../../assets/basededados/<?php echo $capa; ?>" />
                    </div>
                    <div class="card-info">
                <h2><?php echo $titulo; ?></h2>
                <p><?php echo $sinopse; ?></p>
            </div>
        </li>
        <?php
    }
} else {
    mysqli_stmt_close($stmt); // Close statement
    echo "Error: " . mysqli_error($link); // Errors related with the query
}
mysqli_close($link);
?>

