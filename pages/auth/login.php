<?php
session_start();
require_once("../../connections/connection.php");
$link = new_db_connection();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(["erro" => "Método não permitido"]);
    exit;
}

$identificador = $_POST['email'] ?? '';
$password = $_POST['password'] ?? '';

if ($identificador === '' || $password === '') {
    echo json_encode(["erro" => "Preenche o email e a password"]);
    exit;
}

$stmt = mysqli_stmt_init($link);
$query = "SELECT id_utilizadores, password FROM utilizadores WHERE email = ? OR nomeutilizador = ?";

if (mysqli_stmt_prepare($stmt, $query)) {
    mysqli_stmt_bind_param($stmt, 'ss', $identificador, $identificador);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $id_utilizador, $password_bd);

    if (mysqli_stmt_fetch($stmt) && password_verify($password, $password_bd)) {
        $_SESSION['id_utilizador'] = $id_utilizador;
        mysqli_stmt_close($stmt);

        // Distingue voluntário de instituição pela existência de registo em voluntarios
        // (não usar instituicoes_id_instituicoes para isto: é NOT NULL para todos os utilizadores
        // na BD atual, mesmo voluntários, por isso não serve para identificar o tipo de conta).
        $stmt2 = mysqli_stmt_init($link);
        mysqli_stmt_prepare($stmt2, "SELECT 1 FROM voluntarios WHERE utilizadores_id_utilizadores = ?");
        mysqli_stmt_bind_param($stmt2, 'i', $id_utilizador);
        mysqli_stmt_execute($stmt2);
        mysqli_stmt_store_result($stmt2);
        $tipo = mysqli_stmt_num_rows($stmt2) > 0 ? "voluntario" : "instituicao";
        mysqli_stmt_close($stmt2);
        $_SESSION['tipo_utilizador'] = $tipo;

        echo json_encode(["sucesso" => true, "tipo" => $tipo]);
    } else {
        echo json_encode(["erro" => "Credenciais inválidas"]);
        mysqli_stmt_close($stmt);
    }
}
mysqli_close($link);
?>
