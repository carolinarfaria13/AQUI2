<?php
require_once(__DIR__ . "/../../connections/connection.php");
$link_topico = new_db_connection();
$stmt_topico = mysqli_stmt_init($link_topico);
$id_topico_header = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$query_topico = "SELECT t.titulo, u.nomeutilizador, u.cidade, t.data_criacao, u.fotoutilizador 
                 FROM topicos t
                 JOIN voluntarios v ON t.voluntarios_id_voluntarios = v.id_voluntarios
                 JOIN utilizadores u ON v.utilizadores_id_utilizadores = u.id_utilizadores
                 WHERE t.id_topicos = ?";
if (mysqli_stmt_prepare($stmt_topico, $query_topico)) {
    mysqli_stmt_bind_param($stmt_topico, 'i', $id_topico_header);
    mysqli_stmt_execute($stmt_topico);
    mysqli_stmt_bind_result($stmt_topico, $titulo_topico, $nomeutilizador_topico, $cidade_topico, $data_topico, $foto_utilizador);
    mysqli_stmt_fetch($stmt_topico);
    mysqli_stmt_close($stmt_topico);
}
mysqli_close($link_topico);
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../CSS/estilosGERAL.css">
    <link rel="stylesheet" href="../../CSS/estilosCAROLINAeSERGIA.css">
    <title>Comentários</title>
</head>
<body>

<!-- OVERLAY -->
<div class="overlay-backdrop" id="overlayBackdrop">
    <div class="overlay-card">
        <h3 class="overlay-titulo">Escreve o teu comentário</h3>
        <div class="overlay-input-row">
            <div class="topic-avatar">
                <img src="../../assets/basededados/<?php echo $foto_utilizador; ?>" alt=""/>
            </div>
            <textarea class="overlay-textarea" id="overlayTextarea" placeholder="Escreve aqui..."></textarea>
        </div>
        <div class="overlay-acoes">
            <button class="overlay-acao-btn">📷 Foto</button>
            <button class="overlay-acao-btn">📎 Anexo</button>
            <button class="overlay-acao-btn">@ Mencionar</button>
        </div>
        <div class="overlay-botoes">
            <button class="btn btn-cancelar" id="btnCancelar">Cancelar</button>
            <button class="btn" id="btnPublicar">Publicar</button>
        </div>
    </div>
</div>

<header class="header-fixed">
    <nav>
        <?php include_once ("../../components/cp_navbarbranca.php"); ?>
    </nav>
    <h3 class="subtitle">@<?php echo $nomeutilizador_topico; ?> | <?php echo $cidade_topico; ?> | <?php echo date("d/m/Y", strtotime($data_topico)); ?></h3>
    <h1><?php echo $titulo_topico; ?></h1>
</header>

<main class="maincomentarios">
    <button class="btn" id="btnComentar">Comentar</button>

    <h2 class="comentarios-titulo">Comentários (<?php
        require_once(__DIR__ . "/../../connections/connection.php");
        $link2 = new_db_connection();
        $stmt2 = mysqli_stmt_init($link2);
        $id_topico = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        $query2 = "SELECT COUNT(*) FROM comentarios WHERE topicos_id_topicos = ?";
        if (mysqli_stmt_prepare($stmt2, $query2)) {
            mysqli_stmt_bind_param($stmt2, 'i', $id_topico);
            mysqli_stmt_execute($stmt2);
            mysqli_stmt_bind_result($stmt2, $total);
            mysqli_stmt_fetch($stmt2);
            echo $total;
            mysqli_stmt_close($stmt2);
        }
        mysqli_close($link2);
        ?>)</h2>

    <ul class="comentarios-list">
            <?php include_once ("../../components/cp_comentarios.php"); ?>
    </ul>

</main>

<nav>
    <?php $pagina_ativa = 'forum'; include_once ("../../components/cp_bottombar.php"); ?>
</nav>

<?php include_once ("../../components/cp_headerfixo.php"); ?>
<script src="../../js/orverlays.js"></script>
<script src="../../js/main.js"></script>

</body>
</html>