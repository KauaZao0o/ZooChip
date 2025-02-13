CREATE DATABASE zoo_chip;

USE zoo_chip;

CREATE TABLE cliente (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    registro VARCHAR(50) NOT NULL,
    endereco VARCHAR(255) NOT NULL,
    email VARCHAR(100) NOT NULL,
    senha VARCHAR(255) NOT NULL
);

CREATE TABLE lotes (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    client_id INT(11) NOT NULL,  -- ID do usuário associado
    lote VARCHAR(50) NOT NULL,
    imagem VARCHAR(255) NOT NULL,
    FOREIGN KEY (client_id) REFERENCES cliente(id) ON DELETE CASCADE
);

CREATE TABLE animais (
    id INT AUTO_INCREMENT PRIMARY KEY,
    idade INT NOT NULL,
    raca VARCHAR(50) NOT NULL,
    origem VARCHAR(50) NOT NULL,
    ultima_pesagem DECIMAL(5,2) NOT NULL,
    especificacao TEXT NOT NULL,
    lote_id INT NOT NULL,
    client_id INT NOT NULL

	FOREIGN KEY (client_id) REFERENCES cliente(id) ON DELETE CASCADE
	FOREIGN KEY (lote_id) REFERENCES lotes(id) ON DELETE CASCADE
);

CREATE TABLE mensagem (
	nome VARCHAR(100) NOT NULL,
	email VARCHAR(100) NOT NULL,
	telefone INT(14) NOT NULL,
	mensagem TEXT NOT NULL
);
