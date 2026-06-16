<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <link rel="stylesheet" href="../../CSS/estilosGERAL.css">
    <link rel="stylesheet" href="../../CSS/estilosCAROLINAeSERGIA.css">
    <title>Fórum da Comunidade</title>
</head>
<body>

<!-- OVERLAY -->
<div class="overlay-backdrop" id="overlayBackdrop">
    <div class="overlay-card">
        <h3 class="overlay-titulo">Cria o teu Tópico</h3>
        <div class="overlay-input-row">
            <div class="topic-avatar">
                <img src="../../assets/basededados/arianalopes.jpg" alt="Ariana Lopes"/>
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
    <h1>Fórum da Comunidade</h1>
    <h3 class="subtitle">Local onde as conversas geram impacto real</h3>
</header>

<main class="maininstituicao">

    <button class="btn" id="btnComentar">Cria o teu Tópico</button>

    <h2>Tópicos Recentes</h2>

    <ul class="topic-list">
        <?php include_once ("../../components/cp_topicos.php"); ?>
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