<?php
//var_dump($_GET);
if (isset($_GET["id"])) {
    $id_filme = $_GET["id"];

    require_once("connections/connection.php"); // We need the function!
    $link = new_db_connection(); // Create a new DB connection
    $stmt = mysqli_stmt_init($link); // create a prepared statement
    $query = "SELECT id_filmes, titulo,ano, sinopse, capa FROM filmes WHERE id_filmes=?"; // Define the query

    if (mysqli_stmt_prepare($stmt, $query)) { // Prepare the statement

        // Bind variables by type to each parameter
        mysqli_stmt_bind_param($stmt, 'i', $id_filme);

        mysqli_stmt_execute($stmt); // Execute the prepared statement
        mysqli_stmt_bind_result($stmt, $id, $titulo, $ano, $sinopse, $capa); // Bind results

        while (mysqli_stmt_fetch($stmt)) {// Fetch values
            ?>
            <section class="pb-5" id="filme-detalhes">
                <div class="container px-lg-5 pt-3">
                    <?php include_once "components/cp_listaprojectos.php?local=aveiro"; ?>
                    <a class="btn btn-info" href="filmes.php">Voltar</a>
                    <h1 class="pt-5 pb-3"><?php echo $titulo; ?></h1>
                    <div class="row d-flex flex-row justify-content-between">
                        <div class="col">
                            <img class="img-fluid mb-3" src="assets/capas/<?php echo $capa; ?>"/>
                        </div>
                        <div class="col">
                            <h4 class="text-primary"><span class="text-black50"><?php echo $ano; ?></span> | {tipo}</h4>
                            <div class="card pb-2 mt-4 shadow rounded">
                                <div class="card-body">
                                    <h4 class="text-uppercase text-primary m0 mt-2">Sinopse</h4>
                                    <hr class="my-3 mx-auto"/>
                                    <p class="mb-0"><?php echo $sinopse; ?></p>
                                </div>
                                <a class="d-block btn btn-outline-primary mt4" href="{url_trailer}" target="_blank">Trailer</a>
                                <a class="d-block btn btn-outline-primary mt4" href="{url_imdb}"
                                   target="_blank">IMDb</a>
                            </div>
                        </div>
                    </div>
                </div>
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
