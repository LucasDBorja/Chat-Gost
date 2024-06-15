<?php
$servername = "localhost";
$username_db = "root";
$password_db = "";
$dbname = "chat gost";

$conn = new mysqli($servername, $username_db, $password_db, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM messages";  
$result = $conn->query($sql);

if ($result->num_rows > 0) {
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
