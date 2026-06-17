<?php
session_start();
require_once(__DIR__ . "/../../connections/connection.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $descricao = $_POST['descricao'] ?? '';
    $id_topico = $_POST['id_topico'] ?? 0;
    $id_voluntario = $_SESSION['id_utilizador'];
    $data = date('Y-m-d');

    $link = new_db_connection();
    $stmt = mysqli_stmt_init($link);
    $query = "INSERT INTO comentarios (descricao, data, topicos_id_topicos, comentarios_id_comentarios, voluntarios_id_voluntarios) VALUES (?, ?, ?, 0, ?)";

    if (mysqli_stmt_prepare($stmt, $query)) {
        mysqli_stmt_bind_param($stmt, 'ssii', $descricao, $data, $id_topico, $id_voluntario);
        mysqli_stmt_execute($stmt);
        echo json_encode(['sucesso' => true]);
    } else {
        echo json_encode(['sucesso' => false]);
    }
    mysqli_close($link);
}
?>
