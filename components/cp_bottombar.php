<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
// $pagina_ativa deve ser definido antes do include_once: 'projetos', 'instituicoes', 'homepage', 'forum' ou 'perfil'
$pagina_ativa = $pagina_ativa ?? '';
$tipo_utilizador = $_SESSION['tipo_utilizador'] ?? 'voluntario';
$homepage_href = $tipo_utilizador === 'instituicao'
    ? '../homepage/homepage-instituicao.php'
    : '../homepage/homepage-voluntario.php';

$itens_bottombar = [
    'projetos'     => ['icone' => 'projetos_bottombar1.png',     'href' => '../projetos/paginaprojetos.php'],
    'instituicoes' => ['icone' => 'instituicoes_bottombar1.png', 'href' => '../instituicoes/paginainstituicoes.php'],
    'homepage'     => ['icone' => 'homepage_bottombar1.png',     'href' => $homepage_href],
    'forum'        => ['icone' => 'forum_bottombar1.png',        'href' => '../forum/forum.php'],
    'perfil'       => ['icone' => 'perfil_bottombar1.png',       'href' => '../perfil/perfil.php'],
];
?>
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
<nav class="bb-bar">
    <?php foreach ($itens_bottombar as $chave => $item): ?>
        <a href="<?php echo $item['href']; ?>" class="bb-item<?php echo $chave === $pagina_ativa ? ' ativo' : ''; ?>">
            <img src="../../assets/<?php echo $item['icone']; ?>" alt="<?php echo $chave; ?>" />
            <?php if ($chave === $pagina_ativa): ?>
                <span class="bb-halo"></span>
                <span class="bb-badge"><img src="../../assets/<?php echo $item['icone']; ?>" alt="<?php echo $chave; ?>" /></span>
            <?php endif; ?>
        </a>
    <?php endforeach; ?>
</nav>
