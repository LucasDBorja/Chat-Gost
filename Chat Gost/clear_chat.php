<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: login.php"); 
    exit;
}
?>

<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "chat gost";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "TRUNCATE TABLE messages";

if ($conn->query($sql) === TRUE) {
    echo "Chat cleared successfully";
} else {
    echo "Error clearing chat: " . $conn->error;
}

$conn->close();
?>
