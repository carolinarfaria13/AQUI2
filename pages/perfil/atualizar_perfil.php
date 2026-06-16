<?php
session_start();
require_once("../../connections/connection.php");
$link = new_db_connection();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // --- 1. APANHAR TODOS OS TEXTOS ---
    $nome = $_POST['nome'];
    $username = $_POST['username'];
    $email = $_POST['email'];
<<<<<<< HEAD
    $telemovel = $_POST['telemovel'];
=======
    // NOTA: não existe coluna de telemóvel em utilizadores nem em voluntarios.
    // A coluna mais próxima (utilizadores.contacto) é tinyint, não cabe um número de telefone.
    // Falta decidir com a equipa como alterar a BD antes disto poder ser gravado.
    $data_nascimento = $_POST['data_nascimento'];
>>>>>>> 134051a049782fa09c4366491b73b1c420092a15
    $cidade = $_POST['cidade'];

    $biografia = $_POST['biografia'];
    $data_nascimento_pt = $_POST['data_nascimento'];
    $data_nascimento = date('Y-m-d', strtotime(str_replace('/', '-', $data_nascimento_pt)));
    $competencias = $_POST['competencias'];
    $interesses = $_POST['interesses'];

<<<<<<< HEAD
    $id_utilizador_logado = isset($_SESSION['id_utilizador']) ? $_SESSION['id_utilizador'] : 1;

    // --- 2. TRATAR DA FOTOGRAFIA (SE TIVER SIDO ENVIADA UMA NOVA) ---
    $caminho_bd = null;

    // Verifica se recebemos um ficheiro de imagem sem erros
    if (isset($_FILES['foto_perfil']) && $_FILES['foto_perfil']['error'] === UPLOAD_ERR_OK) {

        // Vai buscar a extensão do ficheiro (ex: jpg, png)
        $extensao = pathinfo($_FILES['foto_perfil']['name'], PATHINFO_EXTENSION);

        // Cria um nome único para a foto (ex: user_1_167890.jpg) para não apagar fotos de outros
        $nome_foto = "user_" . $id_utilizador_logado . "_" . time() . "." . $extensao;

        // Onde vamos guardar fisicamente o ficheiro (A partir da pasta PHP recua uma vez e entra em assets)
        $caminho_fisico = "../../assets/" . $nome_foto;

        // O caminho que o teu HTML vai precisar de ler para mostrar a imagem
        $caminho_html = "../../assets/" . $nome_foto;

        // Tenta mover a imagem da memória temporária para a pasta assets
        if (move_uploaded_file($_FILES['foto_perfil']['tmp_name'], $caminho_fisico)) {
            $caminho_bd = $caminho_html; // Sucesso! Vamos guardar isto na BD.
        }
    }

    // --- 3. UPDATE NA TABELA 'UTILIZADORES' ---
    // Se a pessoa enviou uma foto nova, atualizamos também a coluna 'fotoutilizador'
    if ($caminho_bd !== null) {
        $query1 = "UPDATE utilizadores SET nome = ?, nomeutilizador = ?, email = ?, contacto = ?, morada = ?, fotoutilizador = ? WHERE id_utilizadores = ?";
        $stmt1 = mysqli_stmt_init($link);
        if (mysqli_stmt_prepare($stmt1, $query1)) {
            // 'ssssssi' = 6 textos + 1 número inteiro
            mysqli_stmt_bind_param($stmt1, 'ssssssi', $nome, $username, $email, $telemovel, $cidade, $caminho_bd, $id_utilizador_logado);
            mysqli_stmt_execute($stmt1);
            mysqli_stmt_close($stmt1);
        }
    } else {
        // Se a pessoa NÃO enviou foto nova, atualizamos apenas os textos
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

        // --- 5. SUCESSO! REDIRECIONAR DE VOLTA ---
        header("Location: perfil.html");
=======
    // nomeutilizador, email e cidade vivem em utilizadores; biografia e data_nascimento em voluntarios
    $stmt = mysqli_stmt_init($link);
    $query = "UPDATE utilizadores SET nome = ?, nomeutilizador = ?, email = ?, cidade = ? WHERE id_utilizadores = ?";

    $stmt2 = mysqli_stmt_init($link);
    $query2 = "UPDATE voluntarios SET biografia = ?, data_nascimento = ? WHERE utilizadores_id_utilizadores = ?";

    if (mysqli_stmt_prepare($stmt, $query) && mysqli_stmt_prepare($stmt2, $query2)) {
        mysqli_stmt_bind_param($stmt, 'ssssi', $nome, $username, $email, $cidade, $id_utilizador);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);

        mysqli_stmt_bind_param($stmt2, 'ssi', $biografia, $data_nascimento, $id_utilizador);
        mysqli_stmt_execute($stmt2);
        mysqli_stmt_close($stmt2);

        // 3. Redirecionar a Ariana de volta para a página do Perfil HTML!
        header("Location: ../pages/perfil/perfil.html");
>>>>>>> 134051a049782fa09c4366491b73b1c420092a15
        exit;
    } else {
        echo "Erro ao atualizar voluntários: " . mysqli_error($link);
        exit;
    }
}
mysqli_close($link);
?>