<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Novo Projeto</title>
    <link rel="stylesheet" href="../../CSS/estilossergiacosta.css">
    <link rel="stylesheet" href="../../CSS/estilosGERAL.css">
</head>

<body class="bodynovoprojeto">

<nav>
    <?php include_once("../../components/cp_navbar.php"); ?>
</nav>

<main class="mainnovoprojeto">
    <form action="guardar_projeto.php" method="POST">

        <input type="text" id="nome" name="nome" placeholder="ex. CLAIM" />
        <input type="text" id="periodo-de" name="periodo-de" placeholder="De" />
        <input type="text" id="periodo-ate" name="periodo-ate" placeholder="Até" />
        <textarea id="descricao" name="descricao" placeholder="Descreve o teu projeto.."></textarea>
        <input type="text" id="objetivos" name="objetivos" placeholder="Adiciona os objetivos do projeto.." />
        <input type="text" id="localizacao" name="localizacao" placeholder="Localização do projeto" />

        <button type="submit" class="btninscreverprojeto">ADICIONAR</button>

    </form>
</main>

<nav>
    <?php include_once("../../components/cp_bottombar.php"); ?>
</nav>

</body>
</html>