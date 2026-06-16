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

<header class="header-fixed">
    <nav>
        <?php include_once ("../../components/cp_navbar.php"); ?>
    </nav>

</header>
<h1>Novo Projeto</h1>
<main class="mainnovoprojeto">
    <form>

        <div class="form">
            <label for="nome">Nome do Projeto</label>
            <input type="text" id="nome" placeholder="ex. CLAIM" />
        </div>

        <div class="form">
            <div class="upload-foto">
                <div class="upload-foto-label">
                    <img src="../../assets/iconefoto.png" alt="foto" />
                    <span>Carregar foto do projeto</span>
                </div>
                <button type="button" class="btn-adicionar-foto">+ Adicionar</button>
            </div>
        </div>

        <div class="form">
            <label>Período</label>
            <div class="periodo-row">
                <input type="text" id="periodo-de" placeholder="De" />
                <input type="text" id="periodo-ate" placeholder="Até" />
            </div>
        </div>

        <div class="form">
            <label for="descricao">Descrição</label>
            <textarea id="descricao" placeholder="Descreve o teu projeto.."></textarea>
        </div>

        <div class="form">
            <label for="objetivos">Objetivos</label>
            <input type="text" id="objetivos" placeholder="Adiciona os objetivos do projeto.." />
        </div>

        <div class="form">
            <label>Atividades</label>
            <div class="atividades-tags">
                <span class="tag-atividade" onclick="this.classList.toggle('selected')">Workshop Reciclagem</span>
                <span class="tag-atividade" onclick="this.classList.toggle('selected')">Plantação</span>
                <span class="tag-atividade" onclick="this.classList.toggle('selected')">Limpeza de Praias</span>
            </div>
        </div>

        <div class="form">
            <label for="localizacao">Localização</label>
            <input type="text" id="localizacao" placeholder="Localização do projeto" />
        </div>

        <button type="button" class="btninscreverprojeto">ADICIONAR</button>

    </form>
</main>

<nav>
    <?php include_once ("../../components/cp_bottombar.php"); ?>
</nav>

</body>
</html>