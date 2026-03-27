CREATE DATABASE barbearia;

USE barbearia;

CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(50) NOT NULL,
    email VARCHAR(255),
    telefone VARCHAR(20),
    role enum('ADMIN', 'USUARIO') DEFAULT 'USUARIO' NOT NULL,
    senha VARCHAR(255) NOT NULL
);