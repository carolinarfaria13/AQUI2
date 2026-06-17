<?php
require_once(__DIR__ . "/../connections/connection.php");
$link = new_db_connection();
$stmt = mysqli_stmt_init($link);

$id_projeto = isset($_GET["id"]) ? (int)$_GET["id"] : 0;

$query = "SELECT id_atividades, nome, sinopse, foto_capa FROM atividades WHERE projetos_id_projetos = ?";

if (mysqli_stmt_prepare($stmt, $query)) {
    mysqli_stmt_bind_param($stmt, 'i', $id_projeto);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $id_atividades, $nome, $sinopse, $capa);

    while (mysqli_stmt_fetch($stmt)) {
        ?>
        <div class="atividade-card">
            <img class="atividade-img" src="../../assets/basededados/<?php echo $capa; ?>" />
            <div class="atividade-label"><?php echo $nome; ?></div>
        </div>
        <?php
    }
} else {
    mysqli_stmt_close($stmt);
    echo "Error: " . mysqli_error($link);
}
mysqli_close($link);
?>