<?php
require_once($_SERVER['DOCUMENT_ROOT'] . "/AQUI2/connections/connection.php");
$link = new_db_connection();
$stmt = mysqli_stmt_init($link);

$query = "SELECT t.id_topicos, t.titulo, t.data_criacao, u.nome, u.nomeutilizador, v.id_voluntarios,
                 COUNT(c.id_comentarios) AS total_comentarios
           FROM topicos t
           JOIN voluntarios v ON t.voluntarios_id_voluntarios = v.id_voluntarios
           JOIN utilizadores u ON v.utilizadores_id_utilizadores = u.id_utilizadores
           LEFT JOIN comentarios c ON c.topicos_id_topicos = t.id_topicos
           GROUP BY t.id_topicos, t.titulo, t.data_criacao, u.nome, u.nomeutilizador, v.id_voluntarios";

if (mysqli_stmt_prepare($stmt, $query)) {
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $id_topico, $titulo, $data_criacao, $nome, $nomeutilizador, $id_voluntario, $total_comentarios);

    while (mysqli_stmt_fetch($stmt)) {
        ?>
        <li class="topic-card" onclick="window.location='comentarios.php?id=<?php echo $id_topico; ?>'" style="cursor:pointer;">
            <div class="topic-avatar">
                <img src="../../assets/users/ariana.jpg" alt="<?php echo $nome; ?>"/>
            </div>
            <div class="topic-info">
                <p class="topic-title"><?php echo $titulo; ?></p>
                <p class="topic-meta">@<?php echo $nomeutilizador; ?> | <?php echo date("d/m/Y", strtotime($data_criacao)); ?></p>
                <div class="topic-tags">
                    <span class="tag">#voluntariado</span>
                </div>
                <div class="topic-stats">
                    <span><?php echo $total_comentarios; ?> respostas</span>
                    <span class="stat-icon">💬</span>
                    <span>0</span>
                    <span class="stat-icon">♡</span>
                </div>
            </div>
        </li>
        <?php
    }
} else {
    mysqli_stmt_close($stmt);
    echo "Error: " . mysqli_error($link);
}
mysqli_close($link);
?>
