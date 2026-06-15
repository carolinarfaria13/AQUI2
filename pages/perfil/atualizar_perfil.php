<?php
session_start();

require_once("../connections/connection.php");
$link = new_db_connection();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $nome = $_POST['nome'];
    $username = $_POST['username'];
    $biografia = $_POST['biografia'];
    $email = $_POST['email'];
    $telemovel = $_POST['telemovel'];
    $data_nascimento = $_POST['data_nascimento'];
    $cidade = $_POST['cidade'];

    // NOTA: Para testares agora, vou forçar o ID do utilizador a 1.
    // Quando tiveres o Login a funcionar, deves usar a variável de sessão, ex: $_SESSION['id_utilizador']
    $id_utilizador = isset($_SESSION['id_utilizador']) ? $_SESSION['id_utilizador'] : 1;

    $stmt = mysqli_stmt_init($link);

    // ATENÇÃO: Verifica se o nome da tabela (utilizadores) e das colunas batem certo com o teu MySQL!
    $query = "UPDATE utilizadores SET nome = ?, username = ?, biografia = ?, email = ?, telemovel = ?, data_nascimento = ?, cidade = ? WHERE id = ?";

    if (mysqli_stmt_prepare($stmt, $query)) {
        // 'sssssssi' significa: 7 strings (textos) e 1 integer (o id no final)
        mysqli_stmt_bind_param($stmt, 'sssssssi', $nome, $username, $biografia, $email, $telemovel, $data_nascimento, $cidade, $id_utilizador);

        // Executar a gravação
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);

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