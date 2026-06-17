<?php
if (isset($_GET["id"])) {
    $id_projeto = $_GET["id"];

    require_once(__DIR__ . "/../connections/connection.php");
    $link = new_db_connection();
    $stmt = mysqli_stmt_init($link);
    $query = "SELECT id_projetos, titulo, descricao, objetivos FROM projetos WHERE id_projetos=?";

    if (mysqli_stmt_prepare($stmt, $query)) {
        mysqli_stmt_bind_param($stmt, 'i', $id_projeto);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $id_projetos, $titulo, $descricao, $objetivos);

        if (mysqli_stmt_fetch($stmt)) {
            ?>
            <div class="info-card">
                <h3>Descrição</h3>
                <p><?php echo $descricao; ?></p>
            </div>

            <div class="info-card">
                <h3>Objetivos</h3>
                <p><?php echo $objetivos; ?></p>
            </div>
            <?php
            mysqli_stmt_close($stmt);
            mysqli_close($link);
            ?>
            <div class="atividades-section">
                <div class="atividades-grid">
                    <?php
                    $id_projeto_atividades = $id_projeto;
                    include("../../components/cp_atividades.php");
                    ?>
                </div>
            </div>
            <?php
        }
    } else {
        mysqli_stmt_close($stmt);
        echo "Error: " . mysqli_error($link);
        mysqli_close($link);
    }
} else {
    echo "Erro no pedido dos detalhes do projeto";
}
?>
