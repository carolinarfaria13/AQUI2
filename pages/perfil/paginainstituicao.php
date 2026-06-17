<?php

require_once(__DIR__ . "/../../connections/connection.php");
if (isset($_GET["id"])) {
    $nome_instituicao = $_GET["id"];

    $link = new_db_connection();
    $stmt = mysqli_stmt_init($link);
    $query = "SELECT nome FROM instituicoes WHERE id_instituicoes=?";

    if (mysqli_stmt_prepare($stmt, $query)) {
        mysqli_stmt_bind_param($stmt, 'i', $nome_instituicao);

        mysqli_stmt_execute($stmt); // Execute the prepared statement
        mysqli_stmt_bind_result($stmt, $nome_instituicao);
        mysqli_stmt_fetch($stmt);
    }
    mysqli_close($link);
}
?>

<!DOCTYPE html>
<html lang="pt">

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../CSS/estilosGERAL.css">
    <link rel="stylesheet" href="../../CSS/estilosCAROLINAeSERGIA.css">
    <title><?php echo $nome_instituicao; ?></title>
</head>
<body>

<header class="header-fixed">
    <nav>
        <?php include_once ("../../components/cp_navbarbranca.php"); ?>
    </nav>
    <h3 class="subtitle">Instituição</h3>
    <h1><?php echo $nome_instituicao; ?></h1>
</header>
g
<main class="maininstituicao">
    <section class="section-descricao">
        <?php include_once ("../../components/cp_detalhesinstituicao.php"); ?>
    </section>

    <section class="section-projetos">
        <h2>Projetos em Curso</h2>
        <ul class="card-list">
            <?php $limite_projetos = 2; include_once ("../../components/cp_listaprojetos.php"); ?>
        </ul>
        <button class="btn" onclick="window.location='../projetos/paginaprojetos.php'" style="margin-top: 12px;">Ver mais</button>
    </section>

    <section class="section-contactos">
        <?php include_once ("../../components/cp_contactos.php"); ?>
    </section>

</main>

<nav>
    <?php $pagina_ativa = 'instituicoes'; include_once ("../../components/cp_bottombar.php"); ?>
</nav>

<script>
    <?php include_once ("../../components/cp_headerfixo.php"); ?>
</script>

</body>
</html>