<?php
session_start();
require_once("../../connections/connection.php");

if (!isset($_SESSION['id_utilizador'])) {
    header("Location: ../../index.html");
    exit;
}

$link = new_db_connection();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // utilizadores.instituicoes_id_instituicoes é a FK que liga ao dono da instituição
    $stmt_inst = mysqli_stmt_init($link);
    mysqli_stmt_prepare($stmt_inst, "SELECT instituicoes_id_instituicoes FROM utilizadores WHERE id_utilizadores = ?");
    mysqli_stmt_bind_param($stmt_inst, 'i', $_SESSION['id_utilizador']);
    mysqli_stmt_execute($stmt_inst);
    mysqli_stmt_bind_result($stmt_inst, $id_instituicao);
    mysqli_stmt_fetch($stmt_inst);
    mysqli_stmt_close($stmt_inst);

    $nome = $_POST['nome'] ?? '';
    $username = $_POST['username'] ?? '';
    $descricao = $_POST['descricao'] ?? '';
    $email = $_POST['email'] ?? '';
    $telemovel = $_POST['telemovel'] ?? '';
    $data_criacao = $_POST['datacriacao'] ?? '';
    $cidade = $_POST['cidade'] ?? '';
    $objetivos = $_POST['objetivos'] ?? '';
    $instagram = $_POST['instagram'] ?? '';
    $website = $_POST['website'] ?? '';

    // Verifica se foi enviada uma imagem e se não tem erros
    $caminho_bd = null;
    if (isset($_FILES['foto_perfil_inst']) && $_FILES['foto_perfil_inst']['error'] === UPLOAD_ERR_OK) {

        // Extrai a extensão original (ex: jpg, png)
        $extensao = pathinfo($_FILES['foto_perfil_inst']['name'], PATHINFO_EXTENSION);

        // Cria um nome único para não haver ficheiros sobrepostos
        $nome_foto = "inst_" . $id_instituicao . "_" . time() . "." . $extensao;

        // Caminhos
        $caminho_fisico = "../../assets/basededados/" . $nome_foto; // Onde o ficheiro é guardado

        // Move a foto da pasta temporária para a pasta final
        if (move_uploaded_file($_FILES['foto_perfil_inst']['tmp_name'], $caminho_fisico)) {
            $caminho_bd = $nome_foto; // O texto que vai para a BD
        }
    }

    // Atualiza a tabela 'instituicoes'
    $query1 = "UPDATE instituicoes SET nome=?, descricao=?, data_criacao=?, objetivos=?, instagram=?, website=?";
    $tipos1 = "ssssss";
    $params1 = [$nome, $descricao, $data_criacao, $objetivos, $instagram, $website];

    if ($caminho_bd) {
        $query1 .= ", capa=?";
        $tipos1 .= "s";
        $params1[] = $caminho_bd;
    }

    $query1 .= " WHERE id_instituicoes=?";
    $tipos1 .= "i";
    $params1[] = $id_instituicao;

    $stmt1 = mysqli_stmt_init($link);
    if (mysqli_stmt_prepare($stmt1, $query1)) {
        mysqli_stmt_bind_param($stmt1, $tipos1, ...$params1);
        mysqli_stmt_execute($stmt1);
        mysqli_stmt_close($stmt1);
    }

    // Atualiza a tabela 'utilizadores'
    $query2 = "UPDATE utilizadores SET nomeutilizador=?, email=?, contacto=?, morada=? WHERE id_utilizadores=?";
    $stmt2 = mysqli_stmt_init($link);
    if (mysqli_stmt_prepare($stmt2, $query2)) {
        mysqli_stmt_bind_param($stmt2, 'ssssi', $username, $email, $telemovel, $cidade, $_SESSION['id_utilizador']);
        mysqli_stmt_execute($stmt2);
        mysqli_stmt_close($stmt2);
    }

    // Após gravar tudo, redireciona de volta para o perfil da instituição
    header("Location: perfilinstituicao.php");
    exit;
}

mysqli_close($link);
?>
