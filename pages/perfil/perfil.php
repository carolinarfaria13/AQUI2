<?php
session_start();
require_once("../../connections/connection.php");
$link = new_db_connection();

// A ÚNICA ALTERAÇÃO NECESSÁRIA:
// Se não existir sessão, redirecionamos ou paramos (não force o 1 em produção)
if (!isset($_SESSION['id_utilizador'])) {
    echo json_encode(["erro" => "Utilizador não autenticado"]);
    exit;
}

$id_utilizador = $_SESSION['id_utilizador'];

$stmt = mysqli_stmt_init($link);

$query = "
    SELECT 
        u.nome, u.morada, u.nomeutilizador, u.email, u.contacto, u.fotoutilizador,
        v.biografia, v.data_nascimento, v.competencias, v.interesses
    FROM utilizadores u
    INNER JOIN voluntarios v ON u.id_utilizadores = v.utilizadores_id_utilizadores
    WHERE u.id_utilizadores = ?
";

if (mysqli_stmt_prepare($stmt, $query)) {
    mysqli_stmt_bind_param($stmt, 'i', $id_utilizador);
    mysqli_stmt_execute($stmt);

    mysqli_stmt_bind_result($stmt, $nomeBD, $moradaBD, $usernameBD, $emailBD, $contactoBD, $fotoBD, $biografiaBD, $dataNascimentoBD, $competenciasBD, $interessesBD);

    if (mysqli_stmt_fetch($stmt)) {
        $caminho_foto = !empty($fotoBD) ? $fotoBD : "../../assets/voluntarioperfil.png";

        echo json_encode([
            "nome" => $nomeBD,
            "cidade" => $moradaBD,
            "username" => $usernameBD,
            "email" => $emailBD,
            "telemovel" => $contactoBD,
            "foto_perfil" => $caminho_foto,
            "biografia" => $biografiaBD,
            "data_nascimento" => $dataNascimentoBD,
            "competencias" => $competenciasBD,
            "interesses" => $interessesBD
        ]);
    } else {
        echo json_encode(["erro" => "Utilizador não encontrado"]);
    }
    mysqli_stmt_close($stmt);
}
mysqli_close($link);
?>