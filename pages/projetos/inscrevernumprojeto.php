<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Inscrever em Projeto</title>
    <link rel="stylesheet" href="../../CSS/estilossergiacosta.css">
    <link rel="stylesheet" href="../../CSS/estilosGERAL.css">
</head>

<body class="bodyinscreverprojeto">

<header class="header-fixed">
    <nav>
        <?php include_once ("../../components/cp_navbarbranca.php"); ?>
    </nav>
</header>

<main class="maininscreverprojeto">
    <form>

        <div class="form">
            <label for="nome">Nome Completo</label>
            <input type="text" id="nome" placeholder="Nome Completo" />
        </div>

        <div class="form">
            <label for="data">Data de nascimento</label>
            <input type="text" id="data" placeholder="dd/mm/aaaa" />
        </div>

        <div class="form">
            <label for="telemovel">Número de Telemóvel</label>
            <input type="tel" id="telemovel" placeholder="Número de Telemóvel" />
        </div>

        <div class="form">
            <label for="email">E-mail</label>
            <input type="email" id="email" placeholder="E-mail" />
        </div>

        <div class="form">
            <label for="localizacao">Localização</label>
            <input type="text" id="localizacao" placeholder="Localização Atual" />
        </div>

        <div class="form">
            <label for="motivacao">Motivação para participar no projeto</label>
            <textarea id="motivacao" placeholder="Motivação..."></textarea>
        </div>

        <button type="button" class="btninscreverprojeto">Inscrever</button>

    </form>
</main>

<nav>
    <?php include_once ("../../components/cp_bottombar.php"); ?>
</nav>

</body>
</html>