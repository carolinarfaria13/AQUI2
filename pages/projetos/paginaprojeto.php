<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Página Projeto</title>
    <link rel="stylesheet" href="../../CSS/estilosGERAL.css">
    <link rel="stylesheet" href="../../CSS/estilossergiacosta.css">

</head>

<body>

<!-- HEADER -->
<nav>
    <?php include_once("../../components/cp_navbar.php"); ?>
</nav>

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

<?php include_once ("../../components/cp_detalhesprojetos.php"); ?>

<!-- BOTÃO -->
<div class="btn-section">
    <a href='inscrevernumprojeto.php?id=<?php echo $_GET["id"]; ?>' class="btn-juntar">JUNTA-TE AO PROJETO!</a>
    <div class="pontos-label">Pontos que podes ganhar:</div>
    <div class="pontos-valor">15 – 40 pontos</div>
</div>

<!-- BOTTOM NAV -->
<nav>
    <?php include_once ("../../components/cp_bottombar.php"); ?>
</nav>

</body>
</html>