<?php
// Garantir que a sessão está ativa
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once(__DIR__ . "/../connections/connection.php");
$link = new_db_connection();

$id_utilizador = $_SESSION['id_utilizador'] ?? 0;
$query = "SELECT nomeutilizador, fotoutilizador FROM utilizadores WHERE id_utilizadores = ?";
$stmt = mysqli_stmt_init($link);

if (mysqli_stmt_prepare($stmt, $query)) {
    mysqli_stmt_bind_param($stmt, "i", $id_utilizador);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $nome, $foto_utilizador);
    mysqli_stmt_fetch($stmt);

    // Caminho da foto (ajusta se a pasta estiver noutro nível)
    $caminho_foto = (!empty($foto_utilizador)) ? "../../assets/" . $foto_utilizador : "../../assets/voluntarioperfil.png";
    ?>

    <!-- Esta é a estrutura da tua nav-fixa -->
    <img src="../../assets/setaback1.png" class="nav-back" onclick="history.back()" style="cursor: pointer;"/>

    <div class="nav-logo">
        <img src="../../assets/logotipo.png" class="logo-icon"/>
    </div>

    <!-- Link para perfil.php -->
    <a href="../perfil/perfil.php" class="top-profile-container" style="text-decoration: none; cursor: pointer;">
        <img id="perfil-img-pequena"
             src="<?php echo htmlspecialchars($caminho_foto); ?>"
             onerror="this.src='../../assets/voluntarioperfil.png';"
             alt="Perfil"
             class="top-profile-img">
        <div class="star-badge-small"><i class="fas fa-star"></i></div>
    </a>

    <?php
    mysqli_stmt_close($stmt);
}
mysqli_close($link);
?>