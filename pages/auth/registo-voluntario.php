<?php
session_start();
require_once("../../connections/connection.php");
$link = new_db_connection();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(["erro" => "Método não permitido"]);
    exit;
}

$nome = $_POST['nome'] ?? '';
$nascimento = $_POST['nascimento'] ?? ''; // formato dd/mm/aaaa no formulário
$cidade = $_POST['cidade'] ?? '';
$bio = $_POST['bio'] ?? '';
$competencias = $_POST['competencias'] ?? '';
$email = $_POST['email'] ?? '';
$password = $_POST['password'] ?? '';
$username = $_POST['username'] ?? '';

if ($nome === '' || $email === '' || $password === '' || $username === '') {
    echo json_encode(["erro" => "Faltam campos obrigatórios"]);
    exit;
}

// Converte dd/mm/aaaa (formato do formulário) para aaaa-mm-dd (formato do MySQL)
$data_nascimento = null;
if (preg_match('#^(\d{2})/(\d{2})/(\d{4})$#', $nascimento, $m)) {
    $data_nascimento = "{$m[3]}-{$m[2]}-{$m[1]}";
}

// NOTA: id_utilizadores e id_voluntarios não têm AUTO_INCREMENT na BD (falta acrescentar).
$res = mysqli_query($link, "SELECT COALESCE(MAX(id_utilizadores),0)+1 AS proximo FROM utilizadores");
$id_utilizador = mysqli_fetch_assoc($res)['proximo'];

// ATENÇÃO: utilizadores.instituicoes_id_instituicoes é NOT NULL na BD atual, mas um
// voluntário independente não tem instituição associada. Este INSERT só vai funcionar
// depois de tornarem essa coluna opcional (alteração já decidida para fazerem em equipa).
// Até lá, o erro do MySQL vai aparecer no "erro" da resposta abaixo.
// PHP 8.1+ faz mysqli lançar exceções em erros SQL em vez de devolver false,
// por isso apanhamos aqui para devolver sempre uma resposta JSON, nunca uma página de erro.
try {
    $stmt = mysqli_stmt_init($link);
    $query = "INSERT INTO utilizadores (id_utilizadores, nome, email, nomeutilizador, password, cidade)
              VALUES (?, ?, ?, ?, ?, ?)";
    mysqli_stmt_prepare($stmt, $query);
    mysqli_stmt_bind_param($stmt, 'isssss', $id_utilizador, $nome, $email, $username, $password, $cidade);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    // ATENÇÃO: voluntarios.comentarios_id_comentarios também é NOT NULL na BD atual, mas um
    // voluntário novo ainda não tem comentários. Mesma alteração necessária (tornar opcional).
    $res2 = mysqli_query($link, "SELECT COALESCE(MAX(id_voluntarios),0)+1 AS proximo FROM voluntarios");
    $id_voluntario = mysqli_fetch_assoc($res2)['proximo'];

    $stmt2 = mysqli_stmt_init($link);
    $query2 = "INSERT INTO voluntarios (id_voluntarios, data_nascimento, biografia, competencias, utilizadores_id_utilizadores)
               VALUES (?, ?, ?, ?, ?)";
    mysqli_stmt_prepare($stmt2, $query2);
    mysqli_stmt_bind_param($stmt2, 'isssi', $id_voluntario, $data_nascimento, $bio, $competencias, $id_utilizador);
    mysqli_stmt_execute($stmt2);
    mysqli_stmt_close($stmt2);

    $_SESSION['id_utilizador'] = $id_utilizador;
    echo json_encode(["sucesso" => true]);
} catch (mysqli_sql_exception $e) {
    echo json_encode(["erro" => "Erro ao criar conta: " . $e->getMessage() . " (provavelmente falta tornar instituicoes_id_instituicoes e/ou comentarios_id_comentarios opcionais, como já discutido)"]);
}
mysqli_close($link);
?>
