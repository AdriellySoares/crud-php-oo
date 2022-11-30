CREATE DATABASE db_escola;
USE db_escola;
CREATE TABLE tb_alunos (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nome VARCHAR(100) NOT NULL,
    matricula VARCHAR(20) UNIQUE NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    status TINYINT NOT NULL,
    genero VARCHAR(20),
    dataNascimento DATETIME NOT NULL,
    cpf CHAR(11) UNIQUE NOT NULL
);
INSERT INTO tb_alunos
(nome, matricula, email, status, genero, dataNascimento, cpf)
VALUES
('Maria', '1234123', 'maria@email.com', true, 'Feminino', '2001-09-12', '12345678901');
CREATE TABLE tb_professores (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nome VARCHAR(100) NOT NULL,
    endereco VARCHAR(100) NOT NULL,
    status TINYINT NOT NULL,
    formacao VARCHAR(50),
    cpf CHAR(11) UNIQUE NOT NULL
);
INSERT INTO tb_professores
(nome, endereco, status, formacao, cpf)
VALUES
('Alessandro', 'rua barca velha, 69', true, 'raw raw raw', '21345678901'),
('Gleidson(Lorão)', 'alameda dos anjos,  45', true, 'Rapaz...','31245678901'),
('Allan', 'rua Idelfonso Albano,  222, ap 1403', true, 'Chuchu, Cachorro e Saboroso', '41235678901');
CREATE TABLE tb_categorias (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nome VARCHAR(50) NOT NULL
);
INSERT INTO tb_categorias (nome) 
VALUES 
('Profissionalizante'),
('Tecnico'),
('Graduação');
CREATE TABLE tb_cursos (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nome VARCHAR(50) NOT NULL,
    cargaHoraria VARCHAR(50) NOT NULL,
    descricao VARCHAR(100) UNIQUE NOT NULL,
    status TINYINT NOT NULL,
    categoria_id INT NOT NULL,
    FOREIGN KEY (categoria_id) REFERENCES tb_categorias(id)
);
INSERT INTO tb_cursos
(nome, cargaHoraria, descricao, status, categoria_id)
VALUES
('FullStack','192','Vai ficar profissional',1,1);
CREATE TABLE tb_usuario (
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(75) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    senha VARCHAR(255) NOT NULL,
    perfil VARCHAR(50) NOT NULL
);
INSERT INTO tb_usuario 
(id, nome, email, senha, perfil) 
VALUES 
('1', 'ademiro', 'ademiro@email.com', '123456', 'admin');
SELECT * FROM tb_cursos INNER JOIN tb_categoria ON tb_cursos.categoria = tb_categoria.id;