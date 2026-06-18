<?php
require_once(__DIR__ . "/../connections/connection.php");
$link = new_db_connection();
$stmt = mysqli_stmt_init($link);

$limite = isset($limite_projetos) ? $limite_projetos : 9999;
$id_inst = isset($_GET["id"]) ? (int)$_GET["id"] : 0;

if ($id_inst > 0) {
    $query = "SELECT id_projetos, titulo, sinopse, capa FROM projetos WHERE instituicoes_id_instituicoes = ? LIMIT ?";
    if (mysqli_stmt_prepare($stmt, $query)) {
        mysqli_stmt_bind_param($stmt, 'ii', $id_inst, $limite);
    }
} else {
    $query = "SELECT id_projetos, titulo, sinopse, capa FROM projetos LIMIT ?";
    if (mysqli_stmt_prepare($stmt, $query)) {
        mysqli_stmt_bind_param($stmt, 'i', $limite);
    }
}

mysqli_stmt_execute($stmt);
mysqli_stmt_bind_result($stmt, $id_projetos, $titulo, $sinopse, $capa);

while (mysqli_stmt_fetch($stmt)) {
    ?>
    <li class="card">
        <a href="../projetos/paginaprojeto.php?id=<?php echo $id_projetos; ?>" class="card-link">
            <div class="card-photo">
                <img src="../../assets/basededados/<?php echo $capa; ?>" />
            </div>
            <div class="card-info">
                <h2><?php echo $titulo; ?></h2>
                <p><?php echo $sinopse; ?></p>
            </div>
        </a>
    </li>
    <?php
}
mysqli_close($link);
?>

