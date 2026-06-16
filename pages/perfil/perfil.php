<?php
session_start();
require_once("../../connections/connection.php");
$link = new_db_connection();

// Forçamos o ID 1 para testes
$_SESSION['id_utilizador'] = 1;

$id_utilizador = $_SESSION['id_utilizador'];

$stmt = mysqli_stmt_init($link);
<<<<<<< HEAD

$query = "
    SELECT 
        u.nome, u.cidade, u.nomeutilizador, u.email, u.contacto, u.fotoutilizador,
        v.biografia, v.data_nascimento, v.competencias, v.interesses
    FROM utilizadores u
    INNER JOIN voluntarios v ON u.id_utilizadores = v.utilizadores_id_utilizadores
    WHERE u.id_utilizadores = ?
";
=======
// biografia está na tabela voluntarios (1-para-1 com utilizadores), não em utilizadores
$query = "SELECT u.nome, v.biografia, u.cidade
          FROM utilizadores u
          JOIN voluntarios v ON v.utilizadores_id_utilizadores = u.id_utilizadores
          WHERE u.id_utilizadores = ?";
>>>>>>> 134051a049782fa09c4366491b73b1c420092a15

if (mysqli_stmt_prepare($stmt, $query)) {
    mysqli_stmt_bind_param($stmt, 'i', $id_utilizador);
    mysqli_stmt_execute($stmt);

    mysqli_stmt_bind_result($stmt, $nomeBD, $cidadeBD, $usernameBD, $emailBD, $contactoBD, $fotoBD, $biografiaBD, $dataNascimentoBD, $competenciasBD, $interessesBD);

    if (mysqli_stmt_fetch($stmt)) {
        $dados_perfil = [
            "nome" => $nomeBD,
            "cidade" => $cidadeBD,
            "username" => $usernameBD,
            "email" => $emailBD,
            "telemovel" => $contactoBD,
            "foto_perfil" => $fotoBD, // Aqui envia a foto!
            "biografia" => $biografiaBD,
            "data_nascimento" => $dataNascimentoBD,
            "competencias" => $competenciasBD,
            "interesses" => $interessesBD // Aqui envia os interesses!
        ];
        echo json_encode($dados_perfil);
    } else {
        echo json_encode(["erro" => "Utilizador não encontrado"]);
    }
    mysqli_stmt_close($stmt);
}
mysqli_close($link);
?>