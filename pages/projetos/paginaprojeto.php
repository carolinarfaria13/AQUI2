<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Página Projeto</title>

    <link rel="stylesheet" href="../../CSS/estilossergiacosta.css">
    <link rel="stylesheet" href="../../CSS/estilosGERAL.css">
</head>

<body>
<!-- HEADER -->
<header class="header-fixed">
    <nav>
        <?php include_once ("../../components/cp_navbarbranca.php"); ?>
    </nav>
</header>

<!-- BARRA DE PROGRESSO -->
<div class="progress-section">
    <div class="progress-bar-wrapper">
        <div class="progress-bar-fill"></div>
    </div>
    <div class="progress-labels">
        <span class="progress-label">Setembro</span>
        <span class="progress-label">Junho</span>
    </div>
</div>

<!-- TÍTULO -->
<div class="titulo-section">
    <div class="titulo-sub">Projeto</div>
    <div class="titulo-nome">CLAIM</div>
</div>

<!-- DESCRIÇÃO -->
<div class="info-card">
    <?php include_once ("../../components/cp_detalhesprojetos.php"); ?>

<!-- BOTÃO -->
<div class="btn-section">
    <button class="btn-juntar">JUNTA-TE AO PROJETO!</button>
    <div class="pontos-label">Pontos que podes ganhar:</div>
    <div class="pontos-valor">15 – 40 pontos</div>
</div>

<!-- BOTTOM NAV -->
<nav>
    <?php include_once ("../../components/cp_bottombar.php"); ?>
</nav>

</body>
</html>