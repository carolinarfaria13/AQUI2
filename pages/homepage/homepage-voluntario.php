<?php
session_start();
require_once("../../connections/connection.php");
$link = new_db_connection();

if (!isset($_SESSION['id_utilizador'])) {
    header("Location: ../../index.html");
    exit;
}

$id_utilizador = $_SESSION['id_utilizador'];

$stmt = mysqli_stmt_init($link);
mysqli_stmt_prepare($stmt, "SELECT nome, fotoutilizador FROM utilizadores WHERE id_utilizadores = ?");
mysqli_stmt_bind_param($stmt, 'i', $id_utilizador);
mysqli_stmt_execute($stmt);
mysqli_stmt_bind_result($stmt, $nome, $foto);
mysqli_stmt_fetch($stmt);
mysqli_stmt_close($stmt);
$foto = basename($foto ?? '');
if ($foto === '') {
    $foto = 'voluntarioperfil.png';
}

$projetos = [];
$res = mysqli_query($link, "SELECT titulo, sinopse, capa FROM projetos ORDER BY id_projetos DESC LIMIT 2");
while ($row = mysqli_fetch_assoc($res)) {
    $projetos[] = $row;
}
mysqli_close($link);
?>
<!DOCTYPE html>
<html lang="pt">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>AQUI – Homepage Voluntário</title>
  <link href="https://fonts.googleapis.com/css2?family=Montserrat+Alternates:wght@400;600;700;800&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="../../style.css" />
</head>
<body>

<div class="phone hp-phone">


  <div class="hero">
    <div class="hero-overlay">
      <div class="hero-bar">
        <a href="../auth/logout.php" class="hero-logout">Sair</a>
        <img src="../../assets/logotipobranco.png" alt="AQUI" class="hero-logo" />
        <a class="hero-avatar-wrap" href="../perfil/perfil.php"><div class="hero-avatar"><img src="../../assets/<?php echo htmlspecialchars($foto); ?>" alt="Perfil" onerror="this.src='../../assets/voluntarioperfil.png';" /></div><div class="hero-star-badge"><img src="../../assets/estrela_pontos.png" alt="star" /></div></a>
      </div>
    </div>
  </div>


  <div class="hp-content">

    <div class="hero-text">
      <p class="hero-greeting">Olá, <?php echo htmlspecialchars($nome); ?>!</p>
      <h1 class="hero-title">Junta-te a uma comunidade que quer fazer a diferença</h1>
      <p class="hero-sub">Descobre outros projetos de voluntariado. Conecta-te com instituições e encontra pessoas com a mesma vontade de ajudar.</p>
    </div>
    <!-- Partner banner -->
    <div class="partner-banner">
      <img src="../../assets/img1homepage.png" class="partner-photo" alt="Parceiros" />
      <div class="partner-overlay">
        <p class="partner-text">Descobre quem são os nossos parceiros</p>
        <a class="partner-link" href="#">Ver mais &rsaquo;&rsaquo;</a>
      </div>
    </div>


    <div class="forum-section">      <p class="forum-text">A conversa também<br>começa <strong>AQUI.</strong></p>
      <a class="btn btn-short forum-btn" href="../forum/forum.php">Junta-te ao Fórum</a>
    </div>
      <p class="forum-desc">No nosso fórum podes partilhar experiências, tirar dúvidas e dar o primeiro passo para participar em iniciativas que realmente importam.</p>


    <div class="projects-section">
      <h2 class="projects-title">Projetos em curso</h2>

      <?php foreach ($projetos as $projeto): ?>
      <div class="project-card">
        <img src="../../assets/basededados/<?php echo htmlspecialchars($projeto['capa']); ?>" class="project-thumb" alt="<?php echo htmlspecialchars($projeto['titulo']); ?>" />
        <div class="project-info">
          <h3 class="project-name"><?php echo htmlspecialchars($projeto['titulo']); ?></h3>
          <p class="project-desc"><?php echo htmlspecialchars($projeto['sinopse']); ?></p>
        </div>
      </div>
      <?php endforeach; ?>

      <a class="btn-outline" href="../projetos/paginaprojetos.php">MAIS PROJETOS...</a>
    </div>

  </div>

  <?php $pagina_ativa = 'homepage'; include_once("../../components/cp_bottombar.php"); ?>
</div>

</body>
</html>
