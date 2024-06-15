<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "chat gost";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$username = $_POST['username'];
$message = $_POST['message'];
$file = $_FILES['file']; 

if (!empty($file['name'])) {
    $target_dir = "uploads/";

    $target_file = $target_dir . basename($file["name"]);

    if (move_uploaded_file($file["tmp_name"], $target_file)) {
        $message .= " <a href='" . $target_file . "'>Download file</a>";
    } else {
        echo "Error uploading file.";
    }
}

$sql = "INSERT INTO messages (username, message) VALUES (?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $username, $message);

if ($stmt->execute() === TRUE) {
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$stmt->close();
$conn->close();
