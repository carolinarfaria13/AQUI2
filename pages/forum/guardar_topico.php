<?php
session_start();
require_once(__DIR__ . "/../../connections/connection.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titulo = $_POST['titulo'] ?? '';
    $id_voluntario = $_SESSION['id_utilizador'];
    $data = date('Y-m-d');

    $link = new_db_connection();
    $stmt = mysqli_stmt_init($link);
    $query = "INSERT INTO topicos (titulo, data_criacao, voluntarios_id_voluntarios) VALUES (?, ?, ?)";

    if (mysqli_stmt_prepare($stmt, $query)) {
        mysqli_stmt_bind_param($stmt, 'ssi', $titulo, $data, $id_voluntario);
        mysqli_stmt_execute($stmt);
        echo json_encode(['sucesso' => true, 'id' => mysqli_insert_id($link)]);
    } else {
        echo json_encode(['sucesso' => false]);
    }
    mysqli_close($link);
}
?>
