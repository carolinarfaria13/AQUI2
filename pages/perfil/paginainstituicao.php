<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <link rel="stylesheet" href="../../CSS/estilosGERAL.css">
    <link rel="stylesheet" href="../../CSS/estilosCAROLINAeSERGIA.css">
    <title>Apoio ao Emigrante</title>
</head>
<body>

<header class="header-fixed">
    <nav>
        <?php include_once ("components/cp_navbar.php"); ?>
    </nav>
    <h3 class="subtitle">Instituição</h3>
    <h1>Apoio ao Emigrante</h1>
</header>
g
<main class="maininstituicao">
    <section class="section-descricao">
        <?php include_once ("components/cp_detalhesinstituicao.php"); ?>
    </section>

    <section class="section-projetos">
        <h2>Projetos em Curso</h2>

        <ul class="card-list">
            <?php include_once ("components/cp_listaprojetos.php"); ?>
        </ul>
    </section>

    <section class="section-contactos">
        <?php include_once ("../../components/cp_contactos.php"); ?>
    </section>

</main>

<nav>
    <?php include_once ("components/cp_bottombar.php"); ?>
</nav>

<script>
    window.addEventListener('scroll', () => {
        const header = document.querySelector('.header-fixed');
        if (window.scrollY > 40) {
            header.classList.add('shrink');
        } else {
            header.classList.remove('shrink');
        }
    });
</script>

</body>
</html>