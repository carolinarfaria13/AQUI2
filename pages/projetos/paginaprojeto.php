<?php

require_once(__DIR__ . "/../../connections/connection.php");
if (isset($_GET["id"])) {
    $nome_projeto = $_GET["id"];

    $link = new_db_connection();
    $stmt = mysqli_stmt_init($link);
    $query = "SELECT titulo FROM projetos WHERE id_projetos=?";

    if (mysqli_stmt_prepare($stmt, $query)) {
        mysqli_stmt_bind_param($stmt, 'i', $nome_projeto);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $titulo);
        mysqli_stmt_fetch($stmt);
        mysqli_stmt_close($stmt);
    }
    mysqli_close($link);
}
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Página Projeto</title>

    <link rel="stylesheet" href="../../CSS/estilossergiacosta.css">
    <link rel="stylesheet" href="../../CSS/estilosGERAL.css">
    <link rel="stylesheet" href="../../CSS/estilosCAROLINAeSERGIA.css">
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
<br>
<!-- TÍTULO -->
<div class="titulo-section">
    <div class="titulo-sub">Projeto</div>
    <div class="titulo-nome"><?php echo $titulo; ?></div>
</div>

<!-- DESCRIÇÃO -->
<?php include_once ("../../components/cp_detalhesprojetos.php"); ?>

<!-- BOTÃO -->
<div class="btn-section">
    <button class="btn-juntar" onclick="window.location='../projetos/inscrevernumprojeto.php?id=<?php echo $nome_projeto; ?>'">JUNTA-TE AO PROJETO!</button>
    <div class="pontos-label">Pontos que podes ganhar:</div>
    <div class="pontos-valor">15 – 40 pontos</div>
</div>

<!-- BOTTOM NAV -->
<nav>
    <?php $pagina_ativa = 'projetos'; include_once ("../../components/cp_bottombar.php"); ?>
</nav>

<script src="../../js/main.js"></script>
</body>
</html>