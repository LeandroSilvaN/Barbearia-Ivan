CREATE DATABASE barbearia_ivan;
USE barbearia_ivan;

-- TABELA DE USUÁRIO

CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,

    nome VARCHAR(100) NOT NULL,

    email VARCHAR(150) NOT NULL UNIQUE,

    telefone VARCHAR(20),

    role ENUM('ADMIN', 'USER')
    DEFAULT 'USER',

    status ENUM('ATIVO', 'INATIVO')
    DEFAULT 'ATIVO',

    senha VARCHAR(255) NOT NULL,

    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    ON UPDATE CURRENT_TIMESTAMP
);

-- TABELA DE SERVIÇOS

CREATE TABLE servico (
    id INT AUTO_INCREMENT PRIMARY KEY,

    nome VARCHAR(100) NOT NULL,

    descricao TEXT,

    preco DECIMAL(10,2) NOT NULL,

    duracao INT NOT NULL,

    status ENUM('ATIVO', 'INATIVO')
    DEFAULT 'ATIVO',

    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    ON UPDATE CURRENT_TIMESTAMP
);

-- TABELA DE HORÁRIOS

CREATE TABLE horario_funcionamento (
    id INT AUTO_INCREMENT PRIMARY KEY,

    dia_semana ENUM(
        'SEGUNDA',
        'TERCA',
        'QUARTA',
        'QUINTA',
        'SEXTA',
        'SABADO',
        'DOMINGO'
    ) NOT NULL,

    hora_inicio TIME NOT NULL,

    hora_fim TIME NOT NULL,

    status ENUM('ATIVO', 'INATIVO')
    DEFAULT 'ATIVO'
);

-- TABELA DE AGENDAMENTOS

CREATE TABLE agendamento (
    id INT AUTO_INCREMENT PRIMARY KEY,

    data DATE NOT NULL,

    horario TIME NOT NULL,

    observacoes TEXT,

    status ENUM(
        'PENDENTE',
        'CONFIRMADO',
        'CANCELADO',
        'FINALIZADO'
    ) DEFAULT 'PENDENTE',

    cliente_id INT NOT NULL,

    servico_id INT NOT NULL,

    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    ON UPDATE CURRENT_TIMESTAMP,

    FOREIGN KEY (cliente_id)
    REFERENCES usuarios(id),

    FOREIGN KEY (servico_id)
    REFERENCES servico(id)
);

-- TRIGGER - IMPEDIR HORÁRIO DUPLICADO

DELIMITER $$

CREATE TRIGGER verificar_horario
BEFORE INSERT ON agendamento
FOR EACH ROW
BEGIN

    IF EXISTS (
        SELECT 1
        FROM agendamento
        WHERE data = NEW.data
        AND horario = NEW.horario
        AND status IN ('PENDENTE', 'CONFIRMADO')
    ) THEN

        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'Horario indisponivel';

    END IF;

END $$

DELIMITER ;

-- TRIGGER - BLOQUEAR FORA DO EXPEDIENTE

DELIMITER $$

CREATE TRIGGER validar_expediente
BEFORE INSERT ON agendamento
FOR EACH ROW
BEGIN

    IF NEW.horario < '09:00:00'
    OR NEW.horario > '19:00:00' THEN

        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'Fora do horario de funcionamento';

    END IF;

END $$

DELIMITER ;

-- USUÁRIOS INICIAIS

INSERT INTO usuarios (
    nome,
    email,
    telefone,
    role,
    senha
)
VALUES
(
    'Administrador',
    'admin@barbearia.com',
    '11999999999',
    'ADMIN',
    '123456'
),
(
    'Michael',
    'user@email.com',
    '11988888888',
    'USER',
    '123456'
);

-- SERVIÇOS INICIAIS

INSERT INTO servico (
    nome,
    descricao,
    preco,
    duracao
)
VALUES
(
    'Corte Degrade',
    'Corte moderno em degrade',
    35.00,
    40
),
(
    'Barba',
    'Modelagem completa da barba',
    25.00,
    30
),
(
    'Corte + Barba',
    'Pacote completo',
    55.00,
    60
);

-- HORÁRIOS DE FUNCIONAMENTO

INSERT INTO horario_funcionamento (
    dia_semana,
    hora_inicio,
    hora_fim
)
VALUES
('SEGUNDA', '09:00:00', '19:00:00'),
('TERCA', '09:00:00', '19:00:00'),
('QUARTA', '09:00:00', '19:00:00'),
('QUINTA', '09:00:00', '19:00:00'),
('SEXTA', '09:00:00', '19:00:00'),
('SABADO', '09:00:00', '14:00:00');

ALTER TABLE agendamento
ADD preco DECIMAL(10,2) NOT NULL
AFTER servico_id;

UPDATE agendamento ag

INNER JOIN servico ser
    ON ag.servico_id = ser.id

SET ag.preco = ser.preco

WHERE ag.preco = 0;

-- AGENDAMENTOS EXEMPLO PARA SIMULAR AGENDA CHEIA

INSERT INTO agendamento
(
    data,
    horario,
    observacoes,
    status,
    cliente_id,
    servico_id,
    preco
)
VALUES
('2026-05-15','09:00:00','não pagou', 'PENDENTE',2,1,35.00),
('2026-05-12','12:00:00','não pagou', 'PENDENTE',2,1,35.00),
('2026-05-22','09:00:00','não apareceu', 'CANCELADO',2,1,35.00),
('2026-05-16','09:00:00','não pagou', 'PENDENTE',2,1,35.00),
('2026-05-22','17:00:00','', 'CONFIRMADO',2,1,35.00),
('2026-06-01','09:00:00','', 'CONFIRMADO',2,1,35.00),
('2026-06-01','09:30:00','', 'CONFIRMADO',2,1,35.00),
('2026-06-01','10:00:00','', 'CONFIRMADO',2,1,35.00),
('2026-06-01','10:30:00','', 'CONFIRMADO',2,1,35.00),
('2026-06-01','11:00:00','', 'CONFIRMADO',2,1,35.00),
('2026-06-01','11:30:00','', 'CONFIRMADO',2,1,35.00),
('2026-06-01','12:00:00','', 'CONFIRMADO',2,1,35.00),
('2026-06-01','12:30:00','', 'CONFIRMADO',2,1,35.00),
('2026-06-01','13:00:00','', 'CONFIRMADO',2,1,35.00),
('2026-06-01','13:30:00','', 'CONFIRMADO',2,1,35.00),
('2026-06-01','14:00:00','', 'CONFIRMADO',2,1,35.00),
('2026-06-01','14:30:00','', 'CONFIRMADO',2,1,35.00),
('2026-06-01','15:00:00','', 'CONFIRMADO',2,1,35.00),
('2026-06-01','15:30:00','', 'CONFIRMADO',2,1,35.00),
('2026-06-01','16:00:00','', 'CONFIRMADO',2,1,35.00),
('2026-06-01','16:30:00','', 'CONFIRMADO',2,1,35.00),
('2026-06-01','17:00:00','', 'CONFIRMADO',2,1,35.00),
('2026-06-01','17:30:00','', 'CONFIRMADO',2,1,35.00),
('2026-06-01','18:00:00','', 'CONFIRMADO',2,1,35.00),
('2026-06-01','18:30:00','', 'CONFIRMADO',2,1,35.00);
