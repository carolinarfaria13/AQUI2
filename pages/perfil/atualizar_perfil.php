<?php
session_start();
require_once("../../connections/connection.php");
$link = new_db_connection();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // --- 1. APANHAR TODOS OS DADOS DO FORMULÁRIO (Com proteção) ---
    // O '??' garante que se o campo falhar, ele assume vazio e não rebenta o código
    $nome = $_POST['nome'] ?? '';
    $username = $_POST['username'] ?? '';
    $email = $_POST['email'] ?? '';
    $telemovel = $_POST['telemovel'] ?? '';
    $cidade = $_POST['cidade'] ?? '';
    $biografia = $_POST['biografia'] ?? '';
    $competencias = $_POST['competencias'] ?? '';
    $interesses = $_POST['interesses'] ?? '';

    // Tratamento seguro da data de nascimento
    $data_nascimento_pt = $_POST['data_nascimento'] ?? '';
    $data_nascimento = !empty($data_nascimento_pt) ? date('Y-m-d', strtotime(str_replace('/', '-', $data_nascimento_pt))) : NULL;

    $id_utilizador_logado = isset($_SESSION['id_utilizador']) ? $_SESSION['id_utilizador'] : 1;

    // --- 2. TRATAR DA FOTOGRAFIA ---
    $caminho_bd = null;

    if (isset($_FILES['foto_perfil']) && $_FILES['foto_perfil']['error'] === UPLOAD_ERR_OK) {
        $extensao = pathinfo($_FILES['foto_perfil']['name'], PATHINFO_EXTENSION);
        $nome_foto = "user_" . $id_utilizador_logado . "_" . time() . "." . $extensao;
        $caminho_fisico = "../../assets/" . $nome_foto;
        $caminho_html = "../../assets/" . $nome_foto;

        if (move_uploaded_file($_FILES['foto_perfil']['tmp_name'], $caminho_fisico)) {
            $caminho_bd = $caminho_html;
        }
    }

    // --- 3. UPDATE NA TABELA 'UTILIZADORES' ---
    if ($caminho_bd !== null) {
        $query1 = "UPDATE utilizadores SET nome = ?, nomeutilizador = ?, email = ?, contacto = ?, morada = ?, fotoutilizador = ? WHERE id_utilizadores = ?";
        $stmt1 = mysqli_stmt_init($link);
        if (mysqli_stmt_prepare($stmt1, $query1)) {
            mysqli_stmt_bind_param($stmt1, 'ssssssi', $nome, $username, $email, $telemovel, $cidade, $caminho_bd, $id_utilizador_logado);
            mysqli_stmt_execute($stmt1);
            mysqli_stmt_close($stmt1);
        }
    } else {
        $query1 = "UPDATE utilizadores SET nome = ?, nomeutilizador = ?, email = ?, contacto = ?, morada = ? WHERE id_utilizadores = ?";
        $stmt1 = mysqli_stmt_init($link);
        if (mysqli_stmt_prepare($stmt1, $query1)) {
            mysqli_stmt_bind_param($stmt1, 'sssssi', $nome, $username, $email, $telemovel, $cidade, $id_utilizador_logado);
            mysqli_stmt_execute($stmt1);
            mysqli_stmt_close($stmt1);
        }
    }

    // --- 4. UPDATE NA TABELA 'VOLUNTARIOS' ---
    $stmt2 = mysqli_stmt_init($link);
    $query2 = "UPDATE voluntarios SET biografia = ?, data_nascimento = ?, competencias = ?, interesses = ? WHERE utilizadores_id_utilizadores = ?";

    if (mysqli_stmt_prepare($stmt2, $query2)) {
        mysqli_stmt_bind_param($stmt2, 'ssssi', $biografia, $data_nascimento, $competencias, $interesses, $id_utilizador_logado);
        mysqli_stmt_execute($stmt2);
        mysqli_stmt_close($stmt2);

        // --- 5. SUCESSO! ---
        header("Location: perfil.html");
        exit;
    } else {
        echo "Erro ao atualizar voluntários: " . mysqli_error($link);
        exit;
    }
}
mysqli_close($link);
?>