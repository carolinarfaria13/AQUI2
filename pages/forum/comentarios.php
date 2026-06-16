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
        <?php include_once ("components/cp_navbar.php"); ?>
    </nav>
    <h3 class="subtitle">@ariana123 | Aveiro | 2min</h3>
    <h1>Como formar uma equipa virtual eficaz?</h1>
</header>

<main class="maincomentarios">

    <button class="btn" id="btnComentar">Comentar</button>

    <h2 class="comentarios-titulo">Comentários (4)</h2>

    <ul class="comentarios-list">

        <li class="comentario-item">
            <div class="topic-avatar">
                <img src="../../assets/users/ines.jpg" alt="Inês Castro"/>
            </div>
            <div class="comentario-body">
                <p class="comentario-texto">Formar uma equipa virtual eficaz passa por definir objetivos claros, distribuir bem os papéis, garantir boa comunicação e manter todos motivados e alinhados.</p>
                <div class="comentario-meta">
                    <span class="topic-meta">@inescastro | Ílhavo | 1min</span>
                    <div class="topic-stats">
                        <span>2</span>
                        <span class="stat-icon">♡</span>
                    </div>
                </div>
            </div>
        </li>

        <li class="comentario-item">
            <div class="topic-avatar">
                <img src="../../assets/users/augusto.jpg" alt="Augusto Ferreira"/>
            </div>
            <div class="comentario-body">
                <p class="comentario-texto">Uma equipa virtual eficaz constrói-se com organização, comunicação consistente e colaboração entre membros com competências complementares.</p>
                <div class="comentario-meta">
                    <span class="topic-meta">@augustoferreira | Ílhavo | 10seg</span>
                    <div class="topic-stats">
                        <span>4</span>
                        <span class="stat-icon">♡</span>
                    </div>
                </div>
            </div>
        </li>

        <li class="comentario-item">
            <div class="topic-avatar">
                <img src="../../assets/users/ines.jpg" alt="Inês Castro"/>
            </div>
            <div class="comentario-body">
                <p class="comentario-texto">Formar uma equipa virtual eficaz passa por definir objetivos claros, distribuir bem os papéis, garantir boa comunicação e manter todos motivados e alinhados.</p>
                <div class="comentario-meta">
                    <span class="topic-meta">@inescastro | Ílhavo | 1min</span>
                    <div class="topic-stats">
                        <span>2</span>
                        <span class="stat-icon">♡</span>
                    </div>
                </div>
            </div>
        </li>

        <li class="comentario-item">
            <div class="topic-avatar">
                <img src="../../assets/users/augusto.jpg" alt="Augusto Ferreira"/>
            </div>
            <div class="comentario-body">
                <p class="comentario-texto">Uma equipa virtual eficaz constrói-se com organização, comunicação consistente e colaboração entre membros com competências complementares.</p>
                <div class="comentario-meta">
                    <span class="topic-meta">@augustoferreira | Ílhavo | 10seg</span>
                    <div class="topic-stats">
                        <span>4</span>
                        <span class="stat-icon">♡</span>
                    </div>
                </div>
            </div>
        </li>

    </ul>

    <button class="btn">Ver Mais</button>

</main>

<nav>
    <?php include_once ("components/cp_bottombar.php"); ?>
</nav>

<script src="../../js/orverlays.js"></script>

</body>
</html>