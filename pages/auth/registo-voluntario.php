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
$nascimento = $_POST['nascimento'] ?? ''; // formato dd/mm/aaaa no formulário
$cidade = $_POST['cidade'] ?? '';
$bio = $_POST['bio'] ?? '';
$competencias = $_POST['competencias'] ?? '';
$interesses = $_POST['interesses'] ?? '';
$email = $_POST['email'] ?? '';
$password = $_POST['password'] ?? '';
$username = $_POST['username'] ?? '';

if ($nome === '' || $email === '' || $password === '' || $username === '') {
    echo json_encode(["erro" => "Faltam campos obrigatórios"]);
    exit;
}

// Converte dd/mm/aaaa (formato do formulário) para aaaa-mm-dd (formato do MySQL).
// Não se guarda a idade: é um valor derivado que ficaria desatualizado com o
// tempo (calcula-se sempre a partir de data_nascimento quando for preciso mostrá-la).
$data_nascimento = null;
if (preg_match('#^(\d{2})/(\d{2})/(\d{4})$#', $nascimento, $m)) {
    $data_nascimento = "{$m[3]}-{$m[2]}-{$m[1]}";
}

$password_hash = password_hash($password, PASSWORD_DEFAULT);

// PHP 8.1+ faz mysqli lançar exceções em erros SQL em vez de devolver false,
// por isso apanhamos aqui para devolver sempre uma resposta JSON, nunca uma página de erro.
try {
    $stmt = mysqli_stmt_init($link);
    $query = "INSERT INTO utilizadores (nome, email, nomeutilizador, password, contacto, cidade)
              VALUES (?, ?, ?, ?, ?, ?)";
    mysqli_stmt_prepare($stmt, $query);
    mysqli_stmt_bind_param($stmt, 'ssssss', $nome, $email, $username, $password_hash, $telemovel, $cidade);
    mysqli_stmt_execute($stmt);
    $id_utilizador = mysqli_insert_id($link);
    mysqli_stmt_close($stmt);

    $stmt2 = mysqli_stmt_init($link);
    $query2 = "INSERT INTO voluntarios (data_nascimento, biografia, competencias, interesses, utilizadores_id_utilizadores)
               VALUES (?, ?, ?, ?, ?)";
    mysqli_stmt_prepare($stmt2, $query2);
    mysqli_stmt_bind_param($stmt2, 'ssssi', $data_nascimento, $bio, $competencias, $interesses, $id_utilizador);
    mysqli_stmt_execute($stmt2);
    mysqli_stmt_close($stmt2);

    $_SESSION['id_utilizador'] = $id_utilizador;
    $_SESSION['tipo_utilizador'] = 'voluntario';
    echo json_encode(["sucesso" => true]);
} catch (mysqli_sql_exception $e) {
    echo json_encode(["erro" => "Erro ao criar conta: " . $e->getMessage()]);
}
mysqli_close($link);
?>
