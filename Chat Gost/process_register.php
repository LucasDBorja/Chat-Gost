<?php
session_start();

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

// Verificar se o formulário foi enviado e os campos não estão vazios
if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST["username"]) && !empty($_POST["password"])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Hash da senha
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Preparar e executar a consulta SQL usando uma instrução preparada
    $stmt = $conn->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
    $stmt->bind_param("ss", $username, $hashed_password);
    $stmt->execute();

    // Redirecionar para a página de login após o registro bem-sucedido
    header("Location: login.php");
    exit();
} else {
    // Se algum campo estiver vazio, redirecionar de volta para o formulário de registro com uma mensagem de erro
    header("Location: register.php?error=empty_fields");
    exit();
}
?>
