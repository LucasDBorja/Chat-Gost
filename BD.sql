--Crie um banco de dados chamado "chat gost" caso não queira criar use essa tabela

-- Comando para criar o banco de dados, se não existir
CREATE DATABASE IF NOT EXISTS `chat gost`;

-- Comando para usar o banco de dados criado
USE `chat gost`;

-- Comando para criar a tabela `messages`, se não existir
CREATE TABLE IF NOT EXISTS messages (
    id INT(11) NOT NULL AUTO_INCREMENT,
    username VARCHAR(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
    message TEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
    timestamp TIMESTAMP NOT NULL DEFAULT current_timestamp(),
    PRIMARY KEY (id)
);

-- Comando para criar a tabela `users`, se não existir
CREATE TABLE IF NOT EXISTS users (
    id INT(11) NOT NULL AUTO_INCREMENT,
    username VARCHAR(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
    password VARCHAR(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
    PRIMARY KEY (id),
    INDEX (username)
);
