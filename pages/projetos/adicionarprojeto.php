<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Novo Projeto</title>
    <link rel="stylesheet" href="../../CSS/estilosGERAL.css">
    <link rel="stylesheet" href="../../CSS/estilossergiacosta.css">

</head>

<body class="bodynovoprojeto">

<nav>
    <?php include_once("../../components/cp_navbar.php"); ?>
</nav>

<main class="mainnovoprojeto">
    <form action="guardar_projeto.php" method="POST" enctype="multipart/form-data">

        <input type="text" id="nome" name="nome" placeholder="ex. CLAIM" required />
        <input type="text" id="sinopse" name="sinopse" placeholder="Resumo curto do projeto (1 frase)" required />
        <input type="date" id="periodo-de" name="periodo-de" required />
        <input type="date" id="periodo-ate" name="periodo-ate" required />
        <textarea id="descricao" name="descricao" placeholder="Descreve o teu projeto.." required></textarea>
        <input type="text" id="objetivos" name="objetivos" placeholder="Adiciona os objetivos do projeto.." required />
        <input type="text" id="atividades" name="atividades" placeholder="Que atividades vão acontecer?" required />
        <input type="text" id="localizacao" name="localizacao" placeholder="Localização do projeto" />
        <input type="file" id="capa" name="capa" accept="image/*" required />

        <button type="submit" class="btninscreverprojeto">ADICIONAR</button>

    </form>
</main>

<nav>
    <?php include_once("../../components/cp_bottombar.php"); ?>
</nav>

</body>
</html>