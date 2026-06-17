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

        <div class="form">
            <label>Título</label>
            <input type="text" name="nome" placeholder="ex. CLAIM" required />
        </div>

        <div class="form">
            <label>Sinopse</label>
            <input type="text" name="sinopse" placeholder="Resumo curto do projeto (1 frase)" required />
        </div>

        <div class="form">
            <label>Período</label>
            <div class="periodo-row">
                <input type="date" name="periodo-de" required />
                <input type="date" name="periodo-ate" required />
            </div>
        </div>

        <div class="form">
            <label>Descrição</label>
            <textarea name="descricao" placeholder="Descreve o teu projeto.." required></textarea>
        </div>

        <div class="form">
            <label>Objetivos</label>
            <input type="text" name="objetivos" placeholder="Adiciona os objetivos do projeto.." required />
        </div>

        <div class="form">
            <label>Atividades</label>
            <input type="text" name="atividades" placeholder="Que atividades vão acontecer?" required />
        </div>

        <div class="form">
            <label>Localização</label>
            <input type="text" name="localizacao" placeholder="Localização do projeto" />
        </div>

        <div class="upload-foto">
            <label class="upload-foto-label">
                <input type="file" name="capa" accept="image/*" required style="display:none" id="inputCapa"/>
                Foto de capa
            </label>
            <button type="button" class="btn-adicionar-foto" onclick="document.getElementById('inputCapa').click()">Adicionar</button>
        </div>

        <button type="submit" class="btninscreverprojeto">ADICIONAR</button>

    </form>
</main>

<nav>
    <?php $pagina_ativa = 'projetos'; include_once ("../../components/cp_bottombar.php"); ?>
</nav>
<script src="../../js/main.js"></script>
</body>
</html>