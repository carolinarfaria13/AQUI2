<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
require_once("../../connections/connection.php");

// Proteção: apenas instituições podem aceder
if (!isset($_SESSION['id_instituicao'])) {
    header("Location: ../../index.html");
    exit;
}

$link = new_db_connection();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // 1. Receber Dados do Formulário (correspondentes às colunas da tua tabela)
    $nome = $_POST['nome'] ?? '';
    $sinopse = $_POST['sinopse'] ?? '';
    $website = $_POST['website'] ?? '';
    $instagram = $_POST['instagram'] ?? '';
    $data_criacao = $_POST['data_criacao'] ?? '';
    $descricao = $_POST['descricao'] ?? '';
    $objetivos = $_POST['objetivos'] ?? '';

    $id_inst_logada = $_SESSION['id_instituicao'];

    // 2. Upload da Foto (Coluna 'capa' na tabela 'instituicoes')
    $caminho_bd = null;
    if (isset($_FILES['foto_perfil_inst']) && $_FILES['foto_perfil_inst']['error'] === UPLOAD_ERR_OK) {
        $extensao = strtolower(pathinfo($_FILES['foto_perfil_inst']['name'], PATHINFO_EXTENSION));
        $nome_foto = "inst_" . $id_inst_logada . "_" . time() . "." . $extensao;
        $pasta_destino = "../../assets/";

        if (move_uploaded_file($_FILES['foto_perfil_inst']['tmp_name'], $pasta_destino . $nome_foto)) {
            $caminho_bd = $nome_foto; // Guarda apenas o nome do ficheiro ou caminho relativo
        }
    }

    // 3. Atualizar Tabela 'instituicoes'
    $query = "UPDATE instituicoes SET nome=?, sinopse=?, website=?, instagram=?, data_criacao=?, descricao=?, objetivos=?";
    $tipos = "sssssss";
    $params = [$nome, $sinopse, $website, $instagram, $data_criacao, $descricao, $objetivos];

    if ($caminho_bd) {
        $query .= ", capa=?";
        $tipos .= "s";
        $params[] = $caminho_bd;
    }

    $query .= " WHERE id_instituicoes=?";
    $tipos .= "i";
    $params[] = $id_inst_logada;

    $stmt = mysqli_stmt_init($link);
    if (!mysqli_stmt_prepare($stmt, $query)) {
        die("ERRO na query: " . mysqli_error($link));
    }

    mysqli_stmt_bind_param($stmt, $tipos, ...$params);

    if (mysqli_stmt_execute($stmt)) {
        header("Location: paginainstituicao.php"); // Redireciona para o perfil da instituição
        exit;
    } else {
        die("ERRO ao atualizar: " . mysqli_error($link));
    }
    mysqli_stmt_close($stmt);
}
mysqli_close($link);
?>