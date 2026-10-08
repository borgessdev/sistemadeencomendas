CREATE DATABASE IF NOT EXISTS encomendas CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE encomendas;

CREATE TABLE IF NOT EXISTS pedidos (
  id INT AUTO_INCREMENT PRIMARY KEY,
  cliente VARCHAR(100) NOT NULL,
  telefone VARCHAR(20),
  descricao VARCHAR(255) NOT NULL,
  valor DECIMAL(10,2) NOT NULL DEFAULT 0,
  data_entrega DATE NOT NULL,
  status ENUM('pendente','pronto','entregue') NOT NULL DEFAULT 'pendente',
  criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO pedidos (cliente, telefone, descricao, valor, data_entrega, status) VALUES
('Marina Souza', '21999990001', 'Bolo de cenoura com brigadeiro (2kg)', 120.00, CURDATE() + INTERVAL 1 DAY, 'pendente'),
('Carlos Lima', '21999990002', '50 brigadeiros gourmet', 150.00, CURDATE(), 'pronto'),
('Ana Paula', '21999990003', 'Bolo de aniversario 3 andares', 380.00, CURDATE() + INTERVAL 5 DAY, 'pendente');
