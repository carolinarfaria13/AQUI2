<?php
$conn = new mysqli("localhost", "root", "", "nome_da_tua_bd");

if(isset($_FILES['foto_perfil']) && $_FILES['foto_perfil']['error'] === 0) {
    $pasta = "../../assets/uploads/";
    $nomeFicheiro = uniqid() . "_" . $_FILES['foto_perfil']['name'];
    $caminhoCompleto = $pasta . $nomeFicheiro;

    if(move_uploaded_file($_FILES['foto_perfil']['tmp_name'], $caminhoCompleto)) {
        $id_utilizador = 1;

        $sql = "UPDATE utilizadores SET foto_perfil = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("si", $caminhoCompleto, $id_utilizador);

        if($stmt->execute()) {
            echo "Foto atualizada com sucesso!";
        }
    }
}
?>