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
    <h3>Descrição</h3>
    <p>
        O projeto CLAIM (Comunicação, Literacia e Informação para um Ambiente Melhor) é uma iniciativa
        que visa sensibilizar a população para questões ambientais, promovendo a literacia mediática e o
        pensamento crítico sobre as alterações climáticas.<br><br>
        Através de campanhas, workshops e conteúdos digitais, o CLAIM incentiva a adoção de
        comportamentos sustentáveis e o combate à desinformação ambiental. O projeto envolve cidadãos,
        organizações e meios de comunicação, criando uma rede colaborativa focada na proteção do
        ambiente e na disseminação de informação credível.<br><br>
        Os participantes podem envolver-se em atividades educativas e interativas, contribuindo para
        uma sociedade mais informada e ambientalmente consciente.
    </p>
</div>

<!-- OBJETIVOS -->
<div class="info-card">
    <h3>Objetivos</h3>
    <p>
        • Promover a literacia ambiental e mediática<br>
        • Combater a desinformação sobre alterações climáticas<br>
        • Incentivar comportamentos sustentáveis no dia-a-dia<br>
        • Envolver jovens e a comunidade em ações informadas e participativas
    </p>
</div>

<!-- LOCALIZAÇÃO -->
<div class="info-card">
    <h3>Localização</h3>
    <p>Portugal (com impacto a nível nacional, incluindo ações locais em várias regiões)</p>
</div>

<!-- ATIVIDADES -->
<div class="atividades-section">
    <div class="atividades-grid">

        <div class="atividade-card">
            <!-- <img class="atividade-img" src="workshop-reciclagem.jpg" alt="Workshop Reciclagem"> -->
            <div class="atividade-img-placeholder"><i class="ti ti-recycle"></i></div>
            <div class="atividade-label">Workshop Reciclagem</div>
        </div>

        <div class="atividade-card">
            <!-- <img class="atividade-img" src="limpeza-espacos.jpg" alt="Limpeza de espaços públicos"> -->
            <div class="atividade-img-placeholder"><i class="ti ti-building-community"></i></div>
            <div class="atividade-label">Limpeza de espaços públicos</div>
        </div>

        <div class="atividade-card">
            <!-- <img class="atividade-img" src="plantacao-arvores.jpg" alt="Plantação de árvores"> -->
            <div class="atividade-img-placeholder"><i class="ti ti-tree"></i></div>
            <div class="atividade-label">Plantação de árvores</div>
        </div>

        <div class="atividade-card">
            <!-- <img class="atividade-img" src="palestras.jpg" alt="Palestras educativas em escolas"> -->
            <div class="atividade-img-placeholder"><i class="ti ti-school"></i></div>
            <div class="atividade-label">Palestras educativas em escolas</div>
        </div>

        <div class="atividade-card atividade-card-center">
            <!-- <img class="atividade-img" src="pontos-reciclagem.jpg" alt="Criação de pontos de reciclagem"> -->
            <div class="atividade-img-placeholder"><i class="ti ti-package"></i></div>
            <div class="atividade-label">Criação de pontos de reciclagem</div>
        </div>

    </div>
</div>

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