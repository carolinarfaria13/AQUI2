<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
require_once("../../connections/connection.php");
$link = new_db_connection();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // 1. Receber Dados do Formulário
    $nome = $_POST['nome'] ?? '';
    $username = $_POST['username'] ?? '';
    $email = $_POST['email'] ?? '';
    $telemovel = $_POST['telemovel'] ?? '';
    $cidade = $_POST['cidade'] ?? '';
    $biografia = $_POST['biografia'] ?? '';
    $competencias = $_POST['competencias'] ?? '';
    $interesses = $_POST['interesses'] ?? '';

    // Tratamento mais seguro da data
    $data_nascimento = null;
    if (!empty($_POST['data_nascimento'])) {
        $data_nascimento = $_POST['data_nascimento'];
    }

    $id_utilizador_logado = $_SESSION['id_utilizador'] ?? 1;

    // 2. Upload da Foto (Simplificado e com verificações)
    $caminho_bd = null;
    if (isset($_FILES['foto_perfil']) && $_FILES['foto_perfil']['error'] === UPLOAD_ERR_OK) {
        $extensao = strtolower(pathinfo($_FILES['foto_perfil']['name'], PATHINFO_EXTENSION));
        $extensoes_permitidas = ['jpg', 'jpeg', 'png', 'gif'];

        if (in_array($extensao, $extensoes_permitidas)) {
            $nome_foto = "user_" . $id_utilizador_logado . "_" . time() . "." . $extensao;
            $pasta_destino = "../../assets/";

            // Verifica se a pasta existe
            if (!is_dir($pasta_destino)) {
                die("ERRO: A pasta destino ($pasta_destino) não existe.");
            }

            $caminho_fisico = $pasta_destino . $nome_foto;

            if (move_uploaded_file($_FILES['foto_perfil']['tmp_name'], $caminho_fisico)) {
                $caminho_bd = $caminho_fisico;
            } else {
                die("ERRO: Falha ao mover o ficheiro para $caminho_fisico");
            }
        } else {
            die("ERRO: Tipo de ficheiro não permitido. Apenas JPG, PNG, GIF.");
        }
    }

    // 3. Atualizar Tabela 'utilizadores'
    $query1 = "UPDATE utilizadores SET nome=?, nomeutilizador=?, email=?, contacto=?, morada=?";
    $tipos1 = "sssss";
    $params1 = [$nome, $username, $email, $telemovel, $cidade];

    if ($caminho_bd) {
        $query1 .= ", fotoutilizador=?";
        $tipos1 .= "s";
        $params1[] = $caminho_bd;
    }

    $query1 .= " WHERE id_utilizadores=?";
    $tipos1 .= "i";
    $params1[] = $id_utilizador_logado;

    $stmt1 = mysqli_stmt_init($link);
    if (!mysqli_stmt_prepare($stmt1, $query1)) {
        die("ERRO ao preparar query utilizadores: " . mysqli_error($link));
    }

    // Bind param dinâmico para lidar com a foto opcional
    mysqli_stmt_bind_param($stmt1, $tipos1, ...$params1);

    if (!mysqli_stmt_execute($stmt1)) {
        die("ERRO ao executar update utilizadores: " . mysqli_error($link));
    }
    mysqli_stmt_close($stmt1);


    // 4. Atualizar Tabela 'voluntarios'
    $query2 = "UPDATE voluntarios SET biografia=?, data_nascimento=?, competencias=?, interesses=? WHERE utilizadores_id_utilizadores=?";
    $stmt2 = mysqli_stmt_init($link);

    if (!mysqli_stmt_prepare($stmt2, $query2)) {
        die("ERRO ao preparar query voluntarios: " . mysqli_error($link));
    }

    mysqli_stmt_bind_param($stmt2, 'ssssi', $biografia, $data_nascimento, $competencias, $interesses, $id_utilizador_logado);

    if (!mysqli_stmt_execute($stmt2)) {
        die("ERRO ao executar update voluntarios: " . mysqli_error($link));
    }
    mysqli_stmt_close($stmt2);

    // 5. Sucesso - Redirecionar
    header("Location: perfil.php");
    exit;
} else {
    die("Página acedida sem submissão de formulário.");
}
mysqli_close($link);
?>