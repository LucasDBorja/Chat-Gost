<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: login.php"); // Redirecionar para a página de login se o usuário não estiver autenticado
    exit;
}

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

// Verificar se o formulário foi enviado e a mensagem não está vazia
if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST["message"])) {
    $username = $_SESSION['username']; // Obter o nome de usuário da sessão
    $message = $_POST['message'];

    // Verificar se um arquivo foi enviado
    if (!empty($_FILES['file']['name'])) {
        // Diretório onde os arquivos são armazenados
        $target_dir = "uploads/";

        // Nome do arquivo e caminho completo
        $target_file = $target_dir . basename($_FILES["file"]["name"]);

        // Mover o arquivo para o diretório de uploads
        if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
            // Arquivo enviado com sucesso, adicionar link do arquivo à mensagem
            $message .= " <a href='" . $target_file . "'>Download file</a>";
        } else {
            echo "Error uploading file.";
        }
    }

    // Preparar e executar a consulta SQL para inserir a mensagem
    $stmt = $conn->prepare("INSERT INTO messages (username, message) VALUES (?, ?)");
    $stmt->bind_param("ss", $username, $message);
    
    if ($stmt->execute()) {
        // Mensagem inserida com sucesso
    } else {
        // Erro ao inserir mensagem
        echo "Error: " . $stmt->error;
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat Room</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f2f2f2;
        }
        #chat-container {
            max-width: 800px;
            margin: 20px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .chat-message {
            margin-bottom: 10px;
        }
        .chat-message .username {
            font-weight: bold;
            color: #333;
        }
        .chat-message .message {
            display: block;
            margin-top: 5px;
            word-wrap: break-word;
        }
        .chat-message img {
            max-width: 100%;
            height: auto;
            margin-top: 10px;
        }
        .chat-message video {
            max-width: 100%;
            height: auto;
            margin-top: 10px;
        }
        #message {
            width: calc(100% - 70px);
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            resize: none;
            margin-right: 10px;
        }
        button {
            padding: 8px 16px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            background-color: #007bff;
            color: #fff;
            transition: background-color 0.3s ease;
            margin-right: 5px;
        }
        button:hover {
            background-color: #0056b3;
        }
        .message-container {
            display: flex;
            align-items: center;
            margin-bottom: 10px;
        }
        .attachment-icon {
            width: 24px;
            height: 24px;
            cursor: pointer;
            margin-right: 10px;
        }
        .control-buttons {
            display: flex;
            justify-content: space-between;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <div id="chat-container">
        <div id="messages"></div> <!-- Contêiner para mensagens -->
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
            <input type="hidden" id="username" name="username" value="<?php echo $_SESSION['username']; ?>">
            <div class="message-container">
                <textarea id="message" name="message" placeholder="Type your message"></textarea>
                <label for="file-upload" class="file-upload-label">
                    <img src="ar.webp" alt="Attachment" class="attachment-icon">
                </label>
                <input id="file-upload" type="file" name="file" style="display: none;">
                <button type="submit">Send</button>
            </div>
        </form>

        <div class="control-buttons">
            <button onclick="toggleDarkMode()">Toggle Dark Mode</button>
            <button onclick="clearChat()">Exit</button>
        </div>
    </div>
    <script src="scripts.js"></script>
</body>
</html>