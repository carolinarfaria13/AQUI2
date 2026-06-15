<?php
require_once($_SERVER['DOCUMENT_ROOT'] . "/AQUI2/connections/connection.php");
$link = new_db_connection(); // Create a new DB connection
$stmt = mysqli_stmt_init($link); // create a prepared statement
$query = "SELECT id_utilizadores, nomeutilizaodr, cidade FROM utilizadores"; // Define the query

if (mysqli_stmt_prepare($stmt, $query)) { // Prepare the statement
    mysqli_stmt_execute($stmt); // Execute the prepared statement
    mysqli_stmt_bind_result($stmt, $id_utilizador, $nome_utilizador, $cidade); // Bind results

    while (mysqli_stmt_fetch($stmt)) {// Fetch values
        ?>
        <li class="topic-card">
            <div class="topic-avatar">
                <img src="../../assets/users/ariana.jpg" alt="Ariana Lopes"/>
            </div>
            <div class="topic-info">
                <p class="topic-title">Como formar uma equipa virtual eficaz?</p>
                <p class="topic-meta">@ariana123 | Aveiro | 2min</p>
                <div class="topic-tags">
                    <span class="tag">#equipa</span>
                    <span class="tag">#voluntariado</span>
                </div>
                <div class="topic-stats">
                    <span>4 respostas</span>
                    <span class="stat-icon">💬</span>
                    <span>2</span>
                    <span class="stat-icon">♡</span>
                </div>
            </div>
        </li>
        <?php
    }
} else {
    mysqli_stmt_close($stmt); // Close statement
    echo "Error: " . mysqli_error($link); // Errors related with the query
}
mysqli_close($link);
?>
