<?php
session_start();
require_once("../../connections/connection.php");
$link = new_db_connection();

$id_utilizador = isset($_SESSION['id_utilizador']) ? $_SESSION['id_utilizador'] : 1;

$nomeBD = "Voluntário";
$moradaBD = "Cidade não definida";
$biografiaBD = "Ainda não tens uma biografia escrita.";
$caminho_foto = "../../assets/voluntarioperfil.png";

$stmt = mysqli_stmt_init($link);
$query = "
    SELECT 
        u.nome, u.morada, u.nomeutilizador, u.email, u.contacto, u.fotoutilizador,
        v.biografia, v.data_nascimento, v.competencias, v.interesses
    FROM utilizadores u
    INNER JOIN voluntarios v ON u.id_utilizadores = v.utilizadores_id_utilizadores
    WHERE u.id_utilizadores = ?
";

if (mysqli_stmt_prepare($stmt, $query)) {
    mysqli_stmt_bind_param($stmt, 'i', $id_utilizador);
    mysqli_stmt_execute($stmt);

    mysqli_stmt_bind_result($stmt, $nomeBD, $moradaBD, $usernameBD, $emailBD, $contactoBD, $fotoBD, $biografiaBD, $dataNascimentoBD, $competenciasBD, $interessesBD);

    if (mysqli_stmt_fetch($stmt)) {
        // Se a base de dados tiver foto, usamos essa. Juntamos o time() para forçar a atualizar a cache
        if (!empty($fotoBD)) {
            $caminho_foto = $fotoBD . '?t=' . time();
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
    <title>Perfil</title>
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
        <h1 id="perfil-nome">Olá, <?= htmlspecialchars($nomeBD) ?></h1>
        <p>Voluntária ativa</p>
    </div>

    <div class="profile-card">
        <div class="large-profile-container">
            <img id="perfil-img-grande" src="<?= htmlspecialchars($caminho_foto) ?>" onerror="this.src='../../assets/voluntarioperfil.png';" alt="Foto de Perfil" class="large-profile-img">
            <div class="star-badge-large"><i class="fas fa-star"></i></div>
        </div>

        <div class="stats-row">
            <span><i class="far fa-clock"></i> 120h</span>
            <div class="divider"></div>
            <span>30 projetos</span>
        </div>
        <hr class="stats-hr">
        <div class="stats-row">
            <span><i class="fas fa-star"></i> 120 pontos</span>
            <div class="divider"></div>
            <span><i class="fas fa-map-marker-alt"></i> <span id="perfil-cidade"><?= htmlspecialchars($moradaBD) ?></span></span>
        </div>

        <p id="perfil-biografia" class="bio-text mt-3 mb-0">
            <?= htmlspecialchars($biografiaBD) ?>
        </p>
    </div>

    <div class="impact-card">
        <h2 class="impact-title">O teu impacto</h2>
        <div class="impact-grid">
            <div class="impact-pill">
                <img src="../../assets/arvore.png" alt="Árvore" style="width: 20px; height: 20px; margin-right: 8px;"> 35
            </div>
            <div class="impact-pill">
                <img src="../../assets/pessoas.png" alt="Pessoas" style="width: 20px; height: 20px; margin-right: 8px;"> 120
            </div>
            <div class="impact-pill">
                <img src="../../assets/dinheiro.png" alt="Dinheiro" style="width: 20px; height: 20px; margin-right: 8px;"> 500€
            </div>
        </div>
    </div>

    <div class="action-buttons-container">
        <a href="editarperfil.php" class="btn action-btn" style="display: flex; text-decoration: none;">
            <i class="far fa-edit"></i> Editar perfil
        </a>
        <button class="btn action-btn" onclick="acaoBotao('Notificações')">
            <i class="far fa-bell"></i> Notificações
        </button>
        <button class="btn action-btn" onclick="acaoBotao('Projetos')">
            <i class="far fa-user"></i> Projetos
        </button>
        <button class="btn action-btn" onclick="acaoBotao('Log out')">
            <i class="fas fa-sign-out-alt"></i> Log out
        </button>
    </div>
</main>

<style>
    .bb-bar {
        position: sticky;
        bottom: 14px;
        margin: 0 auto;
        width: calc(100% - 32px);
        max-width: 358px;
        height: 60px;
        background: #5B623A;
        border-radius: 30px;
        display: flex;
        align-items: center;
        justify-content: space-around;
        z-index: 999;
        box-shadow: 0 6px 16px rgba(0,0,0,0.18);
    }
    .bb-item {
        position: relative;
        display: flex;
        align-items: center;
        justify-content: center;
        width: 44px;
        height: 44px;
        text-decoration: none;
    }
    .bb-item img { width: 24px; height: 24px; object-fit: contain; display: block; }
    .bb-item.ativo > img { visibility: hidden; }
    .bb-halo {
        position: absolute;
        top: -20px;
        left: 50%;
        transform: translateX(-50%);
        width: 54px;
        height: 54px;
        background: #fdf8e8;
        border-radius: 50%;
        z-index: 1;
    }
    .bb-badge {
        position: absolute;
        top: -17px;
        left: 50%;
        transform: translateX(-50%);
        width: 46px;
        height: 46px;
        background: #f5a623;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 2;
        box-shadow: 0 4px 10px rgba(0,0,0,0.15);
    }
    .bb-badge img { width: 30px; height: 30px; object-fit: contain; }
</style>
<?php include_once("../../components/cp_bottombar.php"); ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="../../js/perfil.js"></script>
<script src="../../js/main.js"></script>
</body>
</html>