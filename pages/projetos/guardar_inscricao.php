<?php
session_start();
require_once(__DIR__ . "/../../connections/connection.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_projeto = $_POST['id_projeto'] ?? 0;
    $id_voluntario = $_SESSION['id_utilizador'];
    $data = date('Y-m-d');
    $estado = 'Pendente';
    $nome = $_POST['nome'] ?? '';
    $data_nascimento = $_POST['data_nascimento'] ?? '';
    $telemovel = $_POST['telemovel'] ?? '';
    $email = $_POST['email'] ?? '';
    $localizacao = $_POST['localizacao'] ?? '';
    $motivacao = $_POST['motivacao'] ?? '';

    $link = new_db_connection();
    $stmt = mysqli_stmt_init($link);
    $query = "INSERT INTO inscricoes (data, estado, voluntarios_id_voluntarios, projetos_id_projetos, nome, data_nascimento, telemovel, email, localizacao, motivacao) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    if (mysqli_stmt_prepare($stmt, $query)) {
        mysqli_stmt_bind_param($stmt, 'ssiissssss', $data, $estado, $id_voluntario, $id_projeto, $nome, $data_nascimento, $telemovel, $email, $localizacao, $motivacao);
        if (mysqli_stmt_execute($stmt)) {
            echo json_encode(['sucesso' => true]);
        } else {
            echo json_encode(['sucesso' => false, 'erro' => mysqli_stmt_error($stmt)]);
        }
        mysqli_stmt_close($stmt);
    } else {
        echo json_encode(['sucesso' => false, 'erro' => mysqli_error($link)]);
    }
    mysqli_close($link);
}
?>
