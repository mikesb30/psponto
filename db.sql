-- Criação do Banco de Dados
CREATE DATABASE IF NOT EXISTS controle_ponto;
USE controle_ponto;

-- Tabela de Colaboradores
CREATE TABLE IF NOT EXISTS colaboradores (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    cpf VARCHAR(14) NOT NULL UNIQUE,
    funcao VARCHAR(50) NOT NULL,
    celular VARCHAR(15),
    data_cadastro DATE NOT NULL DEFAULT CURRENT_DATE,
    senha VARCHAR(255) NOT NULL,
    saldo_diario TIME NOT NULL DEFAULT '00:00:00',
    saldo_total TIME NOT NULL DEFAULT '00:00:00'
);

-- Tabela de Pontos
CREATE TABLE IF NOT EXISTS pontos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    colaborador_id INT NOT NULL,
    data DATE NOT NULL,
    inicio_jornada TIME,
    saida_almoco TIME,
    retorno_almoco TIME,
    fim_jornada TIME,
    justificativa VARCHAR(255) NULL,
    FOREIGN KEY (colaborador_id) REFERENCES colaboradores(id) ON DELETE CASCADE
);

-- Adicionando índice para melhorar performance em consultas por colaborador
CREATE INDEX idx_colaborador_id ON pontos(colaborador_id);

-- Tabela de Administradores
CREATE TABLE IF NOT EXISTS admin (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario VARCHAR(50) NOT NULL UNIQUE,
    senha VARCHAR(255) NOT NULL,
    senha_alterada BOOLEAN DEFAULT FALSE
);

-- Inserir um administrador inicial (sem hash)
INSERT INTO admin (usuario, senha, senha_alterada) 
VALUES ('admin', 'admin', FALSE);
