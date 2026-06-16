<?php
session_start();
require_once("../../connections/connection.php");
$link = new_db_connection();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(["erro" => "Método não permitido"]);
    exit;
}

$nome = $_POST['nome'] ?? '';
$telemovel = $_POST['telemovel'] ?? '';
$morada = $_POST['morada'] ?? '';
$website = $_POST['website'] ?? '';
$instagram = $_POST['instagram'] ?? '';
$data_criacao = $_POST['datacriacao'] ?? '';
$descricao = $_POST['descricao'] ?? '';
$objetivos = $_POST['objetivos'] ?? '';
$email = $_POST['email'] ?? '';
$password = $_POST['password'] ?? '';
$username = $_POST['username'] ?? '';

if ($nome === '' || $email === '' || $password === '' || $username === '') {
    echo json_encode(["erro" => "Faltam campos obrigatórios"]);
    exit;
}

// instituicoes.sinopse e instituicoes.capa são NOT NULL na BD, mas o formulário não os pede.
// Usa-se um resumo derivado da descrição e uma imagem por defeito até existir upload de capa.
$sinopse = mb_substr($descricao, 0, 45);
$capa = "intituicao.png"; // imagem placeholder já existente em assets/
$password_hash = password_hash($password, PASSWORD_DEFAULT);

// PHP 8.1+ faz mysqli lançar exceções em erros SQL em vez de devolver false,
// por isso apanhamos aqui para devolver sempre uma resposta JSON, nunca uma página de erro.
try {
    $stmt = mysqli_stmt_init($link);
    $query = "INSERT INTO instituicoes (nome, sinopse, website, instagram, data_criacao, descricao, objetivos, capa)
              VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    mysqli_stmt_prepare($stmt, $query);
    mysqli_stmt_bind_param($stmt, 'ssssssss', $nome, $sinopse, $website, $instagram, $data_criacao, $descricao, $objetivos, $capa);
    mysqli_stmt_execute($stmt);
    $id_instituicao = mysqli_insert_id($link);
    mysqli_stmt_close($stmt);

    $stmt2 = mysqli_stmt_init($link);
    $query2 = "INSERT INTO utilizadores (nome, email, nomeutilizador, password, contacto, morada, instituicoes_id_instituicoes)
               VALUES (?, ?, ?, ?, ?, ?, ?)";
    mysqli_stmt_prepare($stmt2, $query2);
    mysqli_stmt_bind_param($stmt2, 'ssssssi', $nome, $email, $username, $password_hash, $telemovel, $morada, $id_instituicao);
    mysqli_stmt_execute($stmt2);
    $id_utilizador = mysqli_insert_id($link);
    mysqli_stmt_close($stmt2);

    $_SESSION['id_utilizador'] = $id_utilizador;
    $_SESSION['tipo_utilizador'] = 'instituicao';
    echo json_encode(["sucesso" => true]);
} catch (mysqli_sql_exception $e) {
    echo json_encode(["erro" => "Erro ao criar conta: " . $e->getMessage()]);
}
mysqli_close($link);
?>
