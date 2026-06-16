<?php
require_once(__DIR__ . "/../connections/connection.php");
$link = new_db_connection(); // Create a new DB connection
$stmt = mysqli_stmt_init($link); // create a prepared statement
$query = "SELECT id_atividades, nome, sinopse, foto_capa FROM atividades"; // Define the query

if (mysqli_stmt_prepare($stmt, $query)) { // Prepare the statement
    mysqli_stmt_execute($stmt); // Execute the prepared statement
    mysqli_stmt_bind_result($stmt, $id_atividades, $nome, $sinopse, $capa); // Bind results

    while (mysqli_stmt_fetch($stmt)) {// Fetch values
        ?>

        <div class="atividade-card">
            <img class="atividade-img" src="../../assets/basededados/<?php echo $capa; ?>" />
            <div class="atividade-img-placeholder"><i class="ti ti-recycle"></i></div>
            <div class="atividade-label"><?php echo $nome; ?></div>
        </div>

        <?php
    }
} else {
    mysqli_stmt_close($stmt); // Close statement
    echo "Error: " . mysqli_error($link); // Errors related with the query
}
mysqli_close($link);
?>