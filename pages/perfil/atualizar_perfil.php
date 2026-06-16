<?php
session_start();

require_once("../connections/connection.php");
$link = new_db_connection();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $nome = $_POST['nome'];
    $username = $_POST['username'];
    $biografia = $_POST['biografia'];
    $email = $_POST['email'];
    // NOTA: não existe coluna de telemóvel em utilizadores nem em voluntarios.
    // A coluna mais próxima (utilizadores.contacto) é tinyint, não cabe um número de telefone.
    // Falta decidir com a equipa como alterar a BD antes disto poder ser gravado.
    $data_nascimento = $_POST['data_nascimento'];
    $cidade = $_POST['cidade'];

    // NOTA: Para testares agora, vou forçar o ID do utilizador a 1.
    // Quando tiveres o Login a funcionar, deves usar a variável de sessão, ex: $_SESSION['id_utilizador']
    $id_utilizador = isset($_SESSION['id_utilizador']) ? $_SESSION['id_utilizador'] : 1;

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
        exit;
    } else {
        echo "Erro ao preparar a query: " . mysqli_error($link);
    }
}

// Fechar ligação
mysqli_close($link);
?>