--Crie um banco de dados chamado "chat gost" caso não queira criar use essa tabela
CREATE DATABASE IF NOT EXISTS `chat gost`;

USE `chat gost`;

CREATE TABLE IF NOT EXISTS messages (
    id INT(11) NOT NULL AUTO_INCREMENT,
    username VARCHAR(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
    message TEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
    timestamp TIMESTAMP NOT NULL DEFAULT current_timestamp(),
    PRIMARY KEY (id)
);

CREATE TABLE IF NOT EXISTS users (
    id INT(11) NOT NULL AUTO_INCREMENT,
    username VARCHAR(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
    password VARCHAR(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
    PRIMARY KEY (id),
    INDEX (username)
);
