<?php
//var_dump($_GET);
if (isset($_GET["id"])) {
    $id_projeto = $_GET["id"];

    require_once(__DIR__ . "/../connections/connection.php");
    $link = new_db_connection(); // Create a new DB connection
    $stmt = mysqli_stmt_init($link); // create a prepared statement
    $query = "SELECT id_projetos, titulo, descricao, objetivos FROM projetos WHERE id_projetos=?"; // Define the query

    if (mysqli_stmt_prepare($stmt, $query)) { // Prepare the statement

        // Bind variables by type to each parameter
        mysqli_stmt_bind_param($stmt, 'i', $id_projeto);

        mysqli_stmt_execute($stmt); // Execute the prepared statement
        mysqli_stmt_bind_result($stmt, $id_projetos, $titulo, $descricao, $objetivos); // Bind results

        while (mysqli_stmt_fetch($stmt)) {// Fetch values
            ?>
            <div class="info-card">
                <h3>Descrição</h3>
                <p><?php echo $descricao; ?></p>
            </div>

            <div class="info-card">
                <h3>Objetivos</h3>
                <p><?php echo $objetivos; ?></p>
            </div>

            <div class="atividades-section">
                <div class="atividades-grid">
                    <?php include_once("../../components/cp_atividades.php"); ?>
                </div>
            </div>

            <?php
        }
    } else {
        mysqli_stmt_close($stmt); // Close statement
        echo "Error: " . mysqli_error($link); // Errors related with the query
    }
} else {
    echo "Erro no pedido dos detalhes do projeto";
}
?>
