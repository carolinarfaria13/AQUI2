<?php
session_start();
require_once($_SERVER['DOCUMENT_ROOT'] . "/AQUI2/connections/connection.php");
$link = new_db_connection();

// ============================================================
// AJUSTA AQUI: nome da variável de sessão da instituição logada.
// Tem de ser EXATAMENTE igual ao que o teu login.php define
// (ex: $_SESSION['id_instituicoes'], $_SESSION['id_user'], etc.)
// ============================================================
if (!isset($_SESSION['id_instituicoes'])) {
    header("Location: ../login/login.php");
    exit;
}
$id_instituicao = $_SESSION['id_instituicoes'];

// ============================================================
// AJUSTA AQUI: pasta onde as imagens de capa devem ser guardadas.
// Tem de ser a mesma pasta de onde a paginaprojeto.php /
// cp_detalhesprojetos.php vão ler o campo "capa" para mostrar a imagem.
// ============================================================
$pasta_uploads = $_SERVER['DOCUMENT_ROOT'] . "/AQUI2/uploads/projetos/";

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: adicionarprojeto.php");
    exit;
}

// --- Recolher e validar os campos de texto ---
$titulo      = trim($_POST['nome'] ?? '');
$sinopse     = trim($_POST['sinopse'] ?? '');
$descricao   = trim($_POST['descricao'] ?? '');
$objetivos   = trim($_POST['objetivos'] ?? '');
$atividades  = trim($_POST['atividades'] ?? '');
$data_inicio = trim($_POST['periodo-de'] ?? '');
$data_fim    = trim($_POST['periodo-ate'] ?? '');
// "localizacao" não tem coluna correspondente na tabela "projetos" -- ignorado por agora.

if ($titulo === '' || $sinopse === '' || $descricao === '' || $objetivos === '' ||
    $atividades === '' || $data_inicio === '' || $data_fim === '') {
    die("Por favor preenche todos os campos obrigatórios.");
}

// --- Tratar o upload da imagem de capa ---
if (!isset($_FILES['capa']) || $_FILES['capa']['error'] !== UPLOAD_ERR_OK) {
    die("Erro no upload da imagem de capa.");
}

$extensoes_permitidas = ['jpg', 'jpeg', 'png', 'webp'];
$extensao = strtolower(pathinfo($_FILES['capa']['name'], PATHINFO_EXTENSION));

if (!in_array($extensao, $extensoes_permitidas)) {
    die("Formato de imagem não permitido. Usa JPG, PNG ou WEBP.");
}

$nome_ficheiro_capa = uniqid('projeto_', true) . '.' . $extensao;
$caminho_destino = $pasta_uploads . $nome_ficheiro_capa;

if (!is_dir($pasta_uploads)) {
    mkdir($pasta_uploads, 0755, true);
}

if (!move_uploaded_file($_FILES['capa']['tmp_name'], $caminho_destino)) {
    die("Não foi possível guardar a imagem de capa.");
}

// --- Inserir o projeto na base de dados ---
$sql = "INSERT INTO projetos
            (titulo, sinopse, descricao, objetivos, data_inicio, data_fim, atividades, capa, instituicoes_id_instituicoes)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

$stmt = mysqli_prepare($link, $sql);

if (!$stmt) {
    die("Erro ao preparar a query: " . mysqli_error($link));
}

mysqli_stmt_bind_param(
    $stmt,
    "ssssssssi",
    $titulo,
    $sinopse,
    $descricao,
    $objetivos,
    $data_inicio,
    $data_fim,
    $atividades,
    $nome_ficheiro_capa,
    $id_instituicao
);

if (!mysqli_stmt_execute($stmt)) {
    die("Erro ao guardar o projeto: " . mysqli_stmt_error($stmt));
}

$novo_id = mysqli_insert_id($link);

mysqli_stmt_close($stmt);
mysqli_close($link);

// --- Redirecionar para a página do projeto recém-criado ---
header("Location: paginaprojeto.php?id=" . $novo_id);
exit;