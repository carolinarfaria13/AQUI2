<?php
session_start();
require_once("../../connections/connection.php");

if (!isset($_SESSION['id_utilizador'])) {
    header("Location: ../../index.html");
    exit;
}

$link = new_db_connection();
$id_utilizador = $_SESSION['id_utilizador'];

$nomeBD = $usernameBD = $emailBD = $telemovelBD = $cidadeBD = "";
$descricaoBD = $dataCriacaoBD = $objetivosBD = $instagramBD = $websiteBD = $capaBD = "";
$caminho_foto = "../../assets/intituicao.png";

$stmt = mysqli_stmt_init($link);
$query = "
    SELECT
        i.nome, u.nomeutilizador, i.descricao, u.email, u.contacto, i.data_criacao,
        u.morada, i.objetivos, i.instagram, i.website, i.capa
    FROM utilizadores u
    INNER JOIN instituicoes i ON u.instituicoes_id_instituicoes = i.id_instituicoes
    WHERE u.id_utilizadores = ?
";

if (mysqli_stmt_prepare($stmt, $query)) {
    mysqli_stmt_bind_param($stmt, 'i', $id_utilizador);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $nomeBD, $usernameBD, $descricaoBD, $emailBD, $telemovelBD, $dataCriacaoBD, $cidadeBD, $objetivosBD, $instagramBD, $websiteBD, $capaBD);
    if (mysqli_stmt_fetch($stmt)) {
        if (!empty($capaBD)) {
            $caminho_foto = "../../assets/basededados/" . basename($capaBD);
        }
    }
    mysqli_stmt_close($stmt);
}
mysqli_close($link);
?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Editar Perfil - Instituição</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <link href="https://fonts.googleapis.com/css2?family=Montserrat+Alternates:wght@400;600;700;800&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="../../CSS/estilosGERAL.css">
    <link rel="stylesheet" href="../../CSS/cssMARIANA.css">
</head>
<body class="edit-profile-body">

<nav class="nav-fixav">
    <?php include_once("../../components/cp_navbarbranca.php"); ?>
</nav>

<div class="edit-top-wrapper">
    <h1 class="page-title text-center pt-4 mb-0 pb-3">Editar Perfil</h1>
</div>
<main class="edit-main-card main-perfis">

    <form class="edit-form" action="atualizarperfilinstituicao.php" method="POST" enctype="multipart/form-data">

        <div class="text-center">
            <label class="edit-photo-container" style="position: relative; cursor: pointer; margin-bottom: 20px; display: inline-block;">
                <input type="file" name="foto_perfil_inst" id="input-foto-inst" style="display: none;" accept="image/*">

                <img src="<?= htmlspecialchars($caminho_foto) ?>" onerror="this.src='../../assets/intituicao.png';" alt="Logo" class="edit-photo-img" id="preview-foto-inst">

                <div class="camera-icon-badge">
                    <i class="fas fa-camera"></i>
                </div>
            </label>
        </div>

        <div class="form-group mb-3">
            <label class="form-label" for="nome">Nome</label>
            <input type="text" class="form-control custom-input" id="nome" name="nome" value="<?= htmlspecialchars($nomeBD) ?>">
        </div>

        <div class="form-group mb-3">
            <label class="form-label" for="username">Nome de Utilizador</label>
            <input type="text" class="form-control custom-input" id="username" name="username" value="<?= htmlspecialchars($usernameBD) ?>">
        </div>

        <div class="form-group mb-3">
            <label class="form-label" for="descricao">Descrição</label>
            <textarea class="form-control custom-textarea" id="descricao" name="descricao" rows="4"><?= htmlspecialchars($descricaoBD) ?></textarea>
        </div>

        <div class="form-group mb-3">
            <label class="form-label" for="email">E-mail</label>
            <input type="email" class="form-control custom-input" id="email" name="email" value="<?= htmlspecialchars($emailBD) ?>">
        </div>

        <div class="form-group mb-3">
            <label class="form-label" for="telemovel">Número de Telemóvel</label>
            <input type="tel" class="form-control custom-input" id="telemovel" name="telemovel" value="<?= htmlspecialchars($telemovelBD) ?>">
        </div>

        <div class="form-group mb-3">
            <label class="form-label" for="datacriacao">Data de Criação</label>
            <input type="text" class="form-control custom-input" id="datacriacao" name="datacriacao" placeholder="dd/mm/aaaa" value="<?= htmlspecialchars($dataCriacaoBD) ?>">
        </div>

        <div class="form-group mb-3">
            <label class="form-label" for="cidade">Cidade</label>
            <input type="text" class="form-control custom-input" id="cidade" name="cidade" value="<?= htmlspecialchars($cidadeBD) ?>">
        </div>

        <div class="form-group mb-4">
            <label class="form-label" for="objetivos">Objetivos</label>
            <textarea class="form-control custom-textarea" id="objetivos" name="objetivos" rows="2"><?= htmlspecialchars($objetivosBD) ?></textarea>
        </div>

        <div class="form-group mb-4">
            <label class="form-label" for="instagram">Redes Sociais (Instagram)</label>
            <textarea class="form-control custom-textarea" id="instagram" name="instagram" rows="2"><?= htmlspecialchars($instagramBD) ?></textarea>
        </div>

        <div class="form-group mb-4">
            <label class="form-label" for="website">Website</label>
            <textarea class="form-control custom-textarea" id="website" name="website" rows="1"><?= htmlspecialchars($websiteBD) ?></textarea>
        </div>

        <div class="text-center mt-5">
            <button type="submit" class="btn-guardar">Guardar alterações</button>
        </div>
    </form>
</main>

<?php $pagina_ativa = 'perfil'; include_once("../../components/cp_bottombar.php"); ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="../../js/editarperfilinstituicao.js"></script>
<script src="../../js/main.js"></script>
</body>
</html>
