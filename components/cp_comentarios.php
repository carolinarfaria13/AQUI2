<?php
require_once(__DIR__ . "/../connections/connection.php");
$link = new_db_connection();
$stmt = mysqli_stmt_init($link);

$id_topico = isset($_GET['id']) ? (int)$_GET['id'] : 0;

$query = "SELECT c.id_comentarios, c.descricao, c.data, u.nome, u.nomeutilizador, u.morada
           FROM comentarios c
           JOIN voluntarios v ON c.voluntarios_id_voluntarios = v.id_voluntarios
           JOIN utilizadores u ON v.utilizadores_id_utilizadores = u.id_utilizadores
           WHERE c.topicos_id_topicos = ?
           ORDER BY c.data ASC";

if (mysqli_stmt_prepare($stmt, $query)) {
    mysqli_stmt_bind_param($stmt, "i", $id_topico);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $id_comentario, $descricao, $data, $nome, $nomeutilizador, $morada);
    ?>
    <ul class="comentarios-list">
        <?php
        while (mysqli_stmt_fetch($stmt)) {
            ?>
            <li class="comentario-item">
                <div class="topic-avatar">
                    <img src="../../assets/users/ariana.jpg" alt="<?php echo $nome; ?>"/>
                </div>
                <div class="comentario-body">
                    <p class="comentario-texto"><?php echo $descricao; ?></p>
                    <div class="comentario-meta">
                        <span class="topic-meta">@<?php echo $nomeutilizador; ?> | <?php echo $morada; ?> | <?php echo date("d/m/Y", strtotime($data)); ?></span>
                        <div class="topic-stats">
                            <span>0</span>
                            <span class="stat-icon">♡</span>
                        </div>
                    </div>
                </div>
            </li>
            <?php
        }
        ?>
    </ul>
    <?php
} else {
    mysqli_stmt_close($stmt);
    echo "Error: " . mysqli_error($link);
}
mysqli_close($link);
?>
