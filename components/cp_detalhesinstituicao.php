<?php
//var_dump($_GET);
if (isset($_GET["id"])) {
    $id_instituicao = $_GET["id"];

    require_once($_SERVER['DOCUMENT_ROOT'] . "/AQUI2/connections/connection.php");
    $link = new_db_connection(); // Create a new DB connection
    $stmt = mysqli_stmt_init($link); // create a prepared statement
    $query = "SELECT id_instituicoes, nome, descricao, objetivos FROM instituicoes WHERE id_instituicoes=?"; // Define the query

    if (mysqli_stmt_prepare($stmt, $query)) { // Prepare the statement

        // Bind variables by type to each parameter
        mysqli_stmt_bind_param($stmt, 'i', $id_instituicao);

        mysqli_stmt_execute($stmt); // Execute the prepared statement
        mysqli_stmt_bind_result($stmt, $id_instituicoes, $nome, $descricao, $objetivos); // Bind results

        while (mysqli_stmt_fetch($stmt)) {// Fetch values
            ?>
            <section class="section-descricao">
                <h2>Descrição</h2>
                <p><?php echo $descricao; ?></p>

                <h2>Objetivos</h2>
                <ul class="objetivos-list">
                    <li><?php echo $objetivos; ?></li>
                </ul>
            </section>
            <?php
        }
    } else {
        mysqli_stmt_close($stmt); // Close statement
        echo "Error: " . mysqli_error($link); // Errors related with the query
    }
    mysqli_close($link);
} else {
    echo "Erro no pedido dos detalhes do filme";
}
?>
