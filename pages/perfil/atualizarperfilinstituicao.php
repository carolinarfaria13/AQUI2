<?php
session_start();
require_once("../../connections/connection.php");
$link = new_db_connection();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // NOTA: Usa o ID da sessão se houver, ou '1' para testes (tal como fizemos no voluntário)
    $id_instituicao = isset($_SESSION['id_instituicao']) ? $_SESSION['id_instituicao'] : 1;

    // Verifica se foi enviada uma imagem e se não tem erros
    if (isset($_FILES['foto_perfil_inst']) && $_FILES['foto_perfil_inst']['error'] === UPLOAD_ERR_OK) {

        // Extrai a extensão original (ex: jpg, png)
        $extensao = pathinfo($_FILES['foto_perfil_inst']['name'], PATHINFO_EXTENSION);

        // Cria um nome único para não haver ficheiros sobrepostos
        $nome_foto = "inst_" . $id_instituicao . "_" . time() . "." . $extensao;

        // Caminhos
        $caminho_fisico = "../../assets/" . $nome_foto; // Onde o ficheiro é guardado
        $caminho_bd = "../../assets/" . $nome_foto; // O texto que vai para a BD

        // Move a foto da pasta temporária para a pasta final
        if (move_uploaded_file($_FILES['foto_perfil_inst']['tmp_name'], $caminho_fisico)) {

            // Faz o UPDATE na Base de Dados na tabela de instituições
            $query = "UPDATE instituicoes SET foto_instituicao = ? WHERE id_instituicoes = ?";
            $stmt = mysqli_stmt_init($link);

            if (mysqli_stmt_prepare($stmt, $query)) {
                mysqli_stmt_bind_param($stmt, 'si', $caminho_bd, $id_instituicao);
                mysqli_stmt_execute($stmt);
                mysqli_stmt_close($stmt);
            }
        }
    }

    // Após gravar tudo (com ou sem foto), redireciona de volta para o perfil da instituição
    header("Location: paginainstituicao.php");
    exit;
}

mysqli_close($link);
?>