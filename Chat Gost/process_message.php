<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "chat gost";

// Conectar ao banco de dados
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar a conexão
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Obter dados do formulário
$username = $_POST['username'];
$message = $_POST['message'];
$file = $_FILES['file']; // Dados do arquivo enviado

// Verificar se um arquivo foi enviado
if (!empty($file['name'])) {
    // Diretório onde os arquivos são armazenados
    $target_dir = "uploads/";

    // Nome do arquivo e caminho completo
    $target_file = $target_dir . basename($file["name"]);

    // Mover o arquivo para o diretório de uploads
    if (move_uploaded_file($file["tmp_name"], $target_file)) {
        // Arquivo enviado com sucesso, adicionar link do arquivo à mensagem
        $message .= " <a href='" . $target_file . "'>Download file</a>";
    } else {
        echo "Error uploading file.";
    }
}

// Preparar e executar a consulta SQL para inserir a mensagem
$sql = "INSERT INTO messages (username, message) VALUES (?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $username, $message);

if ($stmt->execute() === TRUE) {
    // Mensagem inserida com sucesso
    // Redirecionar de volta para a página principal ou fazer qualquer outra coisa necessária
} else {
    // Erro ao inserir mensagem
    echo "Error: " . $sql . "<br>" . $conn->error;
}

// Fechar a conexão com o banco de dados
$stmt->close();
$conn->close();
