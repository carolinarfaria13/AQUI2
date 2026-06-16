<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <link rel="stylesheet" href="../../CSS/estilosGERAL.css"/>
    <link rel="stylesheet" href="../../CSS/estilosCAROLINAeSERGIA.css"/>
    <title>Página Projetos</title>
</head>
<body>

<nav>
    <?php include_once("../../components/cp_navbar.php"); ?>
</nav>

<main>
    <h1>Projetos</h1>

    <div class="search-container">
        <?php include_once ("../../components/cp_barrapesquisa.php"); ?>
    </div>

    <ul class="card-list">
        <?php include_once ("../../components/cp_listaprojetos.php"); ?>
    </ul>
</main>

<nav>
    <?php $pagina_ativa = 'projetos'; include_once ("../../components/cp_bottombar.php"); ?>
</nav>
</body>

</html>