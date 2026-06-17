<?php
session_start();
require_once("../../connections/connection.php");

if (!isset($_SESSION['id_utilizador'])) {
    header("Location: ../../index.html");
    exit;
}

$link = new_db_connection();
$id_utilizador = $_SESSION['id_utilizador'];

$nomeBD = "Instituição";
$moradaBD = "Cidade não definida";
$descricaoBD = "Ainda não existe descrição.";
$objetivosBD = "";
$websiteBD = "";
$dataCriacaoBD = "";
$capaBD = "";
$id_instituicao = 0;
$caminho_foto = "../../assets/intituicao.png";
$total_projetos = 0;

$stmt = mysqli_stmt_init($link);
$query = "
    SELECT
        i.id_instituicoes, i.nome, i.descricao, i.objetivos, i.website, i.data_criacao, i.capa,
        u.morada
    FROM utilizadores u
    INNER JOIN instituicoes i ON u.instituicoes_id_instituicoes = i.id_instituicoes
    WHERE u.id_utilizadores = ?
";

if (mysqli_stmt_prepare($stmt, $query)) {
    mysqli_stmt_bind_param($stmt, 'i', $id_utilizador);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $id_instituicao, $nomeBD, $descricaoBD, $objetivosBD, $websiteBD, $dataCriacaoBD, $capaBD, $moradaBD);

    if (mysqli_stmt_fetch($stmt)) {
        if (!empty($capaBD)) {
            $caminho_foto = "../../assets/basededados/" . basename($capaBD);
        }
    }
    mysqli_stmt_close($stmt);
}

$stmt2 = mysqli_stmt_init($link);
mysqli_stmt_prepare($stmt2, "SELECT COUNT(*) FROM projetos WHERE instituicoes_id_instituicoes = ?");
mysqli_stmt_bind_param($stmt2, 'i', $id_instituicao);
mysqli_stmt_execute($stmt2);
mysqli_stmt_bind_result($stmt2, $total_projetos);
mysqli_stmt_fetch($stmt2);
mysqli_stmt_close($stmt2);

mysqli_close($link);

$objetivos_lista = array_filter(array_map('trim', explode(',', $objetivosBD)));
?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Perfil Instituição</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat+Alternates:wght@400;600;700;800&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="../../CSS/estilosGERAL.css">
    <link rel="stylesheet" href="../../CSS/cssMARIANA.css">
</head>
<body>

<nav class="nav-fixa">
    <?php include_once("../../components/cp_navbarbranca.php"); ?>
</nav>

<main class="main-perfis">
    <div class="greeting">
        <h1 id="perfil-nome"><?= htmlspecialchars($nomeBD) ?></h1>
        <p>Instituição ativa</p>
    </div>

    <div class="profile-card">
        <div class="large-profile-container">
            <img id="perfil-img-grande" src="<?= htmlspecialchars($caminho_foto) ?>" onerror="this.src='../../assets/intituicao.png';" alt="Perfil Instituição" class="large-profile-img">
        </div>

        <div class="stats-row">
            <span><?= (int)$total_projetos ?> projetos</span>
            <?php if (!empty($dataCriacaoBD)): ?>
                <div class="divider"></div>
                <span>desde <?= htmlspecialchars($dataCriacaoBD) ?></span>
            <?php endif; ?>
        </div>
        <hr class="stats-hr">
        <div class="stats-row">
            <span><i class="fas fa-map-marker-alt"></i> <span id="perfil-cidade"><?= htmlspecialchars($moradaBD) ?></span></span>
        </div>

        <p id="perfil-biografia" class="bio-text mt-3 mb-0">
            <?= htmlspecialchars($descricaoBD) ?>
        </p>
    </div>

    <div class="action-buttons-container">
        <a href="editarperfilinstituicao.php" class="btn action-btn" style="display: flex; text-decoration: none;">
            <i class="far fa-edit"></i> Editar perfil
        </a>
        <a href="../projetos/adicionarprojeto.php" class="btn action-btn" style="display: flex; text-decoration: none;">
            Adicionar Projeto
        </a>
    </div>
<br>
    <?php if (!empty($objetivos_lista)): ?>
    <div class="tags-section">
        <h3 class="section-subtitle">Objetivos</h3>
        <div class="tags-container">
            <?php foreach ($objetivos_lista as $objetivo): ?>
                <span class="tag-pill"><?= htmlspecialchars($objetivo) ?></span>
            <?php endforeach; ?>
        </div>
    </div>
    <?php endif; ?>

    <div class="tags-section" style="padding-bottom: 90px;">
        <h3 class="section-subtitle" style="margin-bottom: 4px;">Website</h3>
        <?php if (!empty($websiteBD)): ?>
            <a href="<?= htmlspecialchars($websiteBD) ?>" target="_blank" style="color: var(--verdeclaro); text-decoration: underline; font-weight: 500;"><?= htmlspecialchars($websiteBD) ?></a>
        <?php else: ?>
            <p style="color: var(--verdeclaro); margin: 0;">Ainda não definido.</p>
        <?php endif; ?>
    </div>
</main>

<?php $pagina_ativa = 'perfil'; include_once("../../components/cp_bottombar.php"); ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="../../js/main.js"></script>
</body>
</html>
