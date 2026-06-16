<?php
session_start();
require_once("../../connections/connection.php");
$link = new_db_connection();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(["erro" => "Método não permitido"]);
    exit;
}

$nome = $_POST['nome'] ?? '';
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

// NOTA: id_instituicoes e id_utilizadores não têm AUTO_INCREMENT na BD (falta acrescentar,
// já fica anotado para a alteração de estrutura). Enquanto isso não for corrigido, o próximo
// ID é calculado manualmente — não é à prova de pedidos em simultâneo.
$res = mysqli_query($link, "SELECT COALESCE(MAX(id_instituicoes),0)+1 AS proximo FROM instituicoes");
$id_instituicao = mysqli_fetch_assoc($res)['proximo'];

// PHP 8.1+ faz mysqli lançar exceções em erros SQL em vez de devolver false,
// por isso apanhamos aqui para devolver sempre uma resposta JSON, nunca uma página de erro.
try {
    $stmt = mysqli_stmt_init($link);
    $query = "INSERT INTO instituicoes (id_instituicoes, nome, sinopse, website, instagram, data_criacao, descricao, objetivos, capa)
              VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
    mysqli_stmt_prepare($stmt, $query);
    mysqli_stmt_bind_param($stmt, 'issssssss', $id_instituicao, $nome, $sinopse, $website, $instagram, $data_criacao, $descricao, $objetivos, $capa);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    $res2 = mysqli_query($link, "SELECT COALESCE(MAX(id_utilizadores),0)+1 AS proximo FROM utilizadores");
    $id_utilizador = mysqli_fetch_assoc($res2)['proximo'];

    // NOTA: password guardada em texto simples por agora (ver nota em login.php sobre o
    // tamanho da coluna). Atualizar para password_hash() quando a coluna for alargada.
    $stmt2 = mysqli_stmt_init($link);
    $query2 = "INSERT INTO utilizadores (id_utilizadores, nome, email, nomeutilizador, password, instituicoes_id_instituicoes)
               VALUES (?, ?, ?, ?, ?, ?)";
    mysqli_stmt_prepare($stmt2, $query2);
    mysqli_stmt_bind_param($stmt2, 'issssi', $id_utilizador, $nome, $email, $username, $password, $id_instituicao);
    mysqli_stmt_execute($stmt2);
    mysqli_stmt_close($stmt2);

    $_SESSION['id_utilizador'] = $id_utilizador;
    echo json_encode(["sucesso" => true]);
} catch (mysqli_sql_exception $e) {
    echo json_encode(["erro" => "Erro ao criar conta: " . $e->getMessage()]);
}
mysqli_close($link);
?>
