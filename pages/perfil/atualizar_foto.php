<?php
session_start();
require_once("../../connections/connection.php");
$link = new_db_connection();

// NOTA: a tabela utilizadores não tem nenhuma coluna para guardar a foto de perfil.
// O upload do ficheiro funciona e fica em assets/uploads/, mas falta a equipa decidir
// como/onde adicionar essa coluna à BD antes disto poder ser guardado de forma persistente.
if (isset($_FILES['foto_perfil']) && $_FILES['foto_perfil']['error'] === 0) {
    $pasta = "../../assets/uploads/";
    $nomeFicheiro = uniqid() . "_" . $_FILES['foto_perfil']['name'];
    $caminhoCompleto = $pasta . $nomeFicheiro;

    if (move_uploaded_file($_FILES['foto_perfil']['tmp_name'], $caminhoCompleto)) {
        echo json_encode(["aviso" => "Ficheiro guardado, mas ainda não é possível associá-lo ao utilizador: falta coluna foto_perfil na BD"]);
    } else {
        echo json_encode(["erro" => "Falha ao guardar o ficheiro"]);
    }
}

mysqli_close($link);
?>