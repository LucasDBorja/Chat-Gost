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

    // Preparar e executar a consulta SQL usando uma instrução preparada
    $stmt = $conn->prepare("SELECT username, password FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $hashed_password = $row['password'];

        // Verificar se a senha inserida corresponde ao hash armazenado
        if (password_verify($password, $hashed_password)) {
            // Senha correta, iniciar a sessão e redirecionar para a página de chat
            $_SESSION['username'] = $username;
            header("Location: index.php");
            exit();
        } else {
            // Senha incorreta, redirecionar de volta para a página de login com uma mensagem de erro
            header("Location: login.php?error=wrong_password");
            exit();
        }
    } else {
        // Usuário não encontrado, redirecionar de volta para a página de login com uma mensagem de erro
        header("Location: login.php?error=user_not_found");
        exit();
    }
} else {
    // Se algum campo estiver vazio, redirecionar de volta para a página de login com uma mensagem de erro
    header("Location: login.php?error=empty_fields");
    exit();
}
?>
