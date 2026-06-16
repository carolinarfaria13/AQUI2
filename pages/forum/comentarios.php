<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
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
                <img src="../../assets/users/ariana.jpg" alt="Ariana Lopes"/>
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
    <h3 class="subtitle">@ariana123 | Aveiro | 2min</h3>
    <h1>Como formar uma equipa virtual eficaz?</h1>
</header>

<main class="maincomentarios">
    <button class="btn" id="btnComentar">Comentar</button>

    <h2 class="comentarios-titulo">Comentários (4)</h2>

    <ul class="comentarios-list">
            <?php include_once ("../../components/cp_comentarios.php"); ?>
    </ul>

    <button class="btn">Ver Mais</button>
</main>

<nav>
    <?php $pagina_ativa = 'forum'; include_once ("../../components/cp_bottombar.php"); ?>
</nav>

<?php include_once ("../../components/cp_headerfixo.php"); ?>
<script src="../../js/orverlays.js"></script>

</body>
</html>