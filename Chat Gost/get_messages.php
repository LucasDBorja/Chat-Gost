<?php
// Conectar ao banco de dados
$servername = "localhost";
$username_db = "root";
$password_db = "";
$dbname = "chat gost";

$conn = new mysqli($servername, $username_db, $password_db, $dbname);

// Verificar a conexão
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Recuperar mensagens do banco de dados
$sql = "SELECT * FROM messages";  // Removida a cláusula ORDER BY created_at
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Exibir as mensagens
    while($row = $result->fetch_assoc()) {
        echo "<div class='chat-message'>";
        echo "<span class='username'>" . htmlspecialchars($row['username']) . ":</span>";
        echo "<span class='message'>" . htmlspecialchars($row['message']) . "</span>";
        echo "</div>";
    }
} else {
    echo "No messages.";
}

$conn->close();
?>
