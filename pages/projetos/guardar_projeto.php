<?php
session_start();
require_once(__DIR__ . "/../../connections/connection.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titulo = $_POST['nome'] ?? '';
    $sinopse = $_POST['sinopse'] ?? '';
    $descricao = $_POST['descricao'] ?? '';
    $objetivos = $_POST['objetivos'] ?? '';
    $data_inicio = $_POST['periodo-de'] ?? '';
    $data_fim = $_POST['periodo-ate'] ?? '';
    $atividades = $_POST['atividades'] ?? '';
    $id_instituicao = $_SESSION['id_instituicao'] ?? 1;

    // upload da capa
    $capa = '';
    if (isset($_FILES['capa']) && $_FILES['capa']['error'] === 0) {
        $nome_ficheiro = basename($_FILES['capa']['name']);
        $destino = __DIR__ . "/../../assets/basededados/" . $nome_ficheiro;
        move_uploaded_file($_FILES['capa']['tmp_name'], $destino);
        $capa = $nome_ficheiro;
    }

    $link = new_db_connection();
    $stmt = mysqli_stmt_init($link);
    $query = "INSERT INTO projetos (titulo, sinopse, descricao, objetivos, data_inicio, data_fim, atividades, capa, instituicoes_id_instituicoes) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

    if (mysqli_stmt_prepare($stmt, $query)) {
        mysqli_stmt_bind_param($stmt, 'ssssssssi', $titulo, $sinopse, $descricao, $objetivos, $data_inicio, $data_fim, $atividades, $capa, $id_instituicao);
        if (mysqli_stmt_execute($stmt)) {
            $novo_id = mysqli_insert_id($link);
            mysqli_stmt_close($stmt);
            mysqli_close($link);
            header("Location: ../projetos/paginaprojeto.php?id=" . $novo_id);
            exit();
        } else {
            echo "Erro: " . mysqli_stmt_error($stmt);
        }
    } else {
        echo "Erro: " . mysqli_error($link);
    }
    mysqli_close($link);
}
?>
