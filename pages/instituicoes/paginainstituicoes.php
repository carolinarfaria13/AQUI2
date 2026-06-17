<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../CSS/estilosGERAL.css"/>
    <link rel="stylesheet" href="../../CSS/estilosCAROLINAeSERGIA.css"/>
    <title>Página Instituições</title>
</head>
<body>

<nav>
    <?php include_once("../../components/cp_navbar.php"); ?>
</nav>

<main>
    <h1>Instituições</h1>

    <div class="search-container">
        <?php include_once ("../../components/cp_barrapesquisa.php"); ?>
    </div>

    <ul class="card-list">
        <?php include_once ("../../components/cp_listainstituicoes.php"); ?>
    </ul>
</main>

<nav>
    <?php $pagina_ativa = 'instituicoes'; include_once ("../../components/cp_bottombar.php"); ?>
</nav>
<script src="../../js/main.js"></script>
</body>
</html>