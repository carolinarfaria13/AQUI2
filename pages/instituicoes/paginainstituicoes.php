<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <link rel="stylesheet" href="../../CSS/estilosGERAL.css"/>
    <link rel="stylesheet" href="../../CSS/estilosCAROLINA.css"/>
    <title>Página Instituições</title>
</head>
<body>

<nav>
    <?php include_once ("components/cp_navbar.php"); ?>
</nav>

<main>
    <h1>Instituições</h1>

    <div class="search-container">
        <input type="text" placeholder="Pesquise aqui..." />
    </div>

    <ul class="card-list">
        <?php include_once ("components/cp_listainstituicoes.php"); ?>
    </ul>
</main>

<nav>
    <img src="../../assets/projetos_bottombar.png" />
    <img src="../../assets/instituicoes_bottombar.png" />
    <img src="../../assets/homepage_bottombar.png" />
    <img src="../../assets/forum_bottombar.png" />
    <img src="../../assets/perfil_bottombar.png"/>
</nav>
</body>
</html>