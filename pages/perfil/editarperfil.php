<?php
session_start();
require_once("../../connections/connection.php");
$link = new_db_connection();

$id_utilizador = $_SESSION['id_utilizador'] ?? 1;

// Inicializa variáveis para evitar erros de "undefined"
$nomeBD = $usernameBD = $emailBD = $telemovelBD = $cidadeBD = $fotoBD = "";
$biografiaBD = $dataNascimentoBD = $competenciasBD = $interessesBD = "";
$caminho_foto = "../../assets/voluntarioperfil.png";

$query = "
    SELECT 
        u.nome, u.morada, u.nomeutilizador, u.email, u.contacto, u.fotoutilizador,
        v.biografia, v.data_nascimento, v.competencias, v.interesses
    FROM utilizadores u
    LEFT JOIN voluntarios v ON u.id_utilizadores = v.utilizadores_id_utilizadores
    WHERE u.id_utilizadores = ?
";

$stmt = mysqli_stmt_init($link);
if (mysqli_stmt_prepare($stmt, $query)) {
    mysqli_stmt_bind_param($stmt, 'i', $id_utilizador);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $nomeBD, $cidadeBD, $usernameBD, $emailBD, $telemovelBD, $fotoBD, $biografiaBD, $dataNascimentoBD, $competenciasBD, $interessesBD);
    if (mysqli_stmt_fetch($stmt)) {
        if (!empty($fotoBD)) {
            $caminho_foto = $fotoBD;
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
    <title>Editar Perfil</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat+Alternates:wght@400;600;700;800&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="../../CSS/estilosGERAL.css">
    <link rel="stylesheet" href="../../CSS/cssMARIANA.css">
</head>
<body class="edit-profile-body">

<nav class="nav-fixav" style="background-color: #5B623A;">
    <img src="../../assets/setabackbranca1.png" class="nav-back" onclick="history.back()" style="cursor: pointer;"/>
    <div class="nav-logo">
        <img src="../../assets/logotipobranco.png" class="logo-icon"/>
    </div>
    <a href="perfil.php" class="top-profile-container" style="text-decoration: none; cursor: pointer;">
        <img id="perfil-img-pequena" src="<?php echo htmlspecialchars((string)$caminho_foto); ?>" onerror="this.src='../../assets/voluntarioperfil.png';" alt="Perfil" class="top-profile-img">
        <div class="star-badge-small"><i class="fas fa-star"></i></div>
    </a>
</nav>

<div class="edit-top-wrapper">
    <h1 class="page-title text-center pt-4 mb-0 pb-3">Editar Perfil</h1>
</div>

<main class="edit-main-card">
    <form class="edit-form" action="atualizarperfil.php" method="POST" enctype="multipart/form-data">

        <div class="text-center">
            <label class="edit-photo-container" style="position: relative; cursor: pointer; margin-bottom: 20px; display: inline-block;">
                <input type="file" name="foto_perfil" id="input-foto" style="display: none;" accept="image/*">
                <img src="<?php echo htmlspecialchars((string)$caminho_foto); ?>" onerror="this.src='../../assets/voluntarioperfil.png';" alt="Foto" class="edit-photo-img" id="preview-foto">
                <div class="camera-icon-badge"><i class="fas fa-camera"></i></div>
            </label>
        </div>

        <div class="mb-4">
            <label for="nome" class="form-label">Nome</label>
            <input type="text" class="form-control custom-input" id="nome" name="nome" value="<?php echo htmlspecialchars((string)$nomeBD); ?>">
        </div>

        <div class="mb-4">
            <label for="username" class="form-label">Nome de Utilizador</label>
            <input type="text" class="form-control custom-input" id="username" name="username" value="<?php echo htmlspecialchars((string)$usernameBD); ?>">
        </div>

        <div class="mb-4">
            <label for="biografia" class="form-label">Biografia</label>
            <textarea class="form-control custom-textarea" id="biografia" name="biografia" rows="4"><?php echo htmlspecialchars((string)$biografiaBD); ?></textarea>
        </div>

        <div class="mb-4">
            <label for="email" class="form-label">E-mail</label>
            <input type="email" class="form-control custom-input" id="email" name="email" value="<?php echo htmlspecialchars((string)$emailBD); ?>">
        </div>

        <div class="mb-4">
            <label for="telemovel" class="form-label">Número de Telemóvel</label>
            <input type="text" class="form-control custom-input" id="telemovel" name="telemovel" value="<?php echo htmlspecialchars((string)$telemovelBD); ?>">
        </div>

        <div class="mb-4">
            <label for="data_nascimento" class="form-label">Data de Nascimento</label>
            <input type="date" class="form-control custom-input" id="data_nascimento" name="data_nascimento" value="<?php echo htmlspecialchars((string)$dataNascimentoBD); ?>">
        </div>

        <div class="form-group mb-3">
            <label class="form-label">Cidade</label>
            <input type="text" id="cidade" name="cidade" class="form-control custom-input" value="<?php echo htmlspecialchars((string)$cidadeBD); ?>">
        </div>

        <div class="form-group mb-4">
            <label class="form-label" for="competencias">Competências</label>
            <textarea id="competencias" name="competencias" class="form-control custom-textarea" rows="2"><?php echo htmlspecialchars((string)$competenciasBD); ?></textarea>
        </div>

        <input type="hidden" name="interesses" id="interesses-hidden" value="<?php echo htmlspecialchars((string)$interessesBD); ?>">

        <div class="form-group mb-4">
            <label class="form-label">Interesses</label>
            <div class="tags-container justify-content-center mb-3" id="interesses-container"></div>
            <div class="text-center">
                <button type="button" class="btn-ver-mais" id="btn-add-interesse">+ Adicionar interesse</button>
                <input type="text" id="input-novo-interesse" class="form-control custom-input mx-auto" placeholder="Escreve e clica Enter..." style="display: none; max-width: 250px; text-align: center;">
            </div>
        </div>

        <div class="text-center mt-5">
            <button type="submit" class="btn-guardar">Guardar alterações</button>
        </div>
    </form>
</main>

<nav style="position: fixed; bottom: 0; width: 100%; z-index: 999;">
    <img src="../../assets/projetos_bottombar1.png" />
    <img src="../../assets/instituicoes_bottombar1.png" />
    <img src="../../assets/homepage_bottombar1.png" />
    <img src="../../assets/forum_bottombar1.png" />
    <img src="../../assets/perfil_bottombar1.png"/>
</nav>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="../../js/editarperfil.js"></script>
<script src="../../js/main.js"></script>
</body>
</html>