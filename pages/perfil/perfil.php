<?php
session_start();
require_once("../../connections/connection.php");
$link = new_db_connection();

// Se o utilizador não tiver sessão iniciada, forçamos o 1 para testes
$id_utilizador = isset($_SESSION['id_utilizador']) ? $_SESSION['id_utilizador'] : 1;

$stmt = mysqli_stmt_init($link);

// CORREÇÃO: Alterado de 'u.cidade' para 'u.morada' de acordo com a tua base de dados
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

    // O 'moradaBD' entra no lugar da 'cidade'
    mysqli_stmt_bind_result($stmt, $nomeBD, $moradaBD, $usernameBD, $emailBD, $contactoBD, $fotoBD, $biografiaBD, $dataNascimentoBD, $competenciasBD, $interessesBD);

    if (mysqli_stmt_fetch($stmt)) {

        // Garantir que se o utilizador não tiver foto, vai a padrão
        $caminho_foto = !empty($fotoBD) ? $fotoBD : "../../assets/voluntarioperfil.png";

        $dados_perfil = [
            "nome" => $nomeBD,
            "cidade" => $moradaBD, // Enviamos como "cidade" para o teu JS não quebrar
            "username" => $usernameBD,
            "email" => $emailBD,
            "telemovel" => $contactoBD,
            "foto_perfil" => $caminho_foto,
            "biografia" => $biografiaBD,
            "data_nascimento" => $dataNascimentoBD,
            "competencias" => $competenciasBD,
            "interesses" => $interessesBD
        ];
        echo json_encode($dados_perfil);
    } else {
        echo json_encode(["erro" => "Utilizador não encontrado"]);
    }
    mysqli_stmt_close($stmt);
} else {
    // Se a query falhar (ex: nome de coluna errado), agora consegues ver o erro na consola!
    echo json_encode(["erro" => "Erro na SQL: " . mysqli_error($link)]);
}
mysqli_close($link);
?>