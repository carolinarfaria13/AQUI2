<?php
session_start();
require_once("../../connections/connection.php");
$link = new_db_connection();

// Segurança: Verificar se o utilizador tem o login feito
if (!isset($_SESSION['id_utilizador'])) {
    // Se não tiver, envia um erro em JSON e pára o código
    echo json_encode(["erro" => "Sessão não iniciada"]);
    exit;
}

$id_utilizador = $_SESSION['id_utilizador'];

$stmt = mysqli_stmt_init($link);
// biografia está na tabela voluntarios (1-para-1 com utilizadores), não em utilizadores
$query = "SELECT u.nome, v.biografia, u.cidade
          FROM utilizadores u
          JOIN voluntarios v ON v.utilizadores_id_utilizadores = u.id_utilizadores
          WHERE u.id_utilizadores = ?";

if (mysqli_stmt_prepare($stmt, $query)) {
    mysqli_stmt_bind_param($stmt, 'i', $id_utilizador);
    mysqli_stmt_execute($stmt);

    // Ligar os resultados a variáveis
    mysqli_stmt_bind_result($stmt, $nomeBD, $biografiaBD, $cidadeBD);

    // Se o fetch encontrar resultados (se o utilizador existir)
    if (mysqli_stmt_fetch($stmt)) {

        // 1. Criamos um "pacote" (Array) com as informações
        $dados_perfil = [
            "nome" => $nomeBD,
            "biografia" => $biografiaBD,
            "cidade" => $cidadeBD
        ];

        // 2. Transformamos o pacote em formato JSON e imprimimos para o JS ler!
        echo json_encode($dados_perfil);

    } else {
        echo json_encode(["erro" => "Utilizador não encontrado na base de dados"]);
    }

    mysqli_stmt_close($stmt);
}
mysqli_close($link);
?>