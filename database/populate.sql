-- Script para popular o banco de dados com dados de teste

-- Primeiro limpar todas as tabelas
DELETE FROM inscricao;
DELETE FROM participante;
DELETE FROM admin;
DELETE FROM evento;
DELETE FROM usuario;

-- Popula tabela usuario (com senhas hash realistas - todos com senha '123456')
INSERT INTO usuario (id, nome_completo, email, senha, tipo_usuario) VALUES
(1, 'Administrador Sistema', 'admin@sistema.com', '$2y$10$Ne9RcGRCvBKIgTG1GRAazu4TARzQAF/Oq24kBD.9hMCLTEJsV0YUi', 'admin'),
(2, 'Maria Silva', 'maria@email.com', '$2y$10$Ne9RcGRCvBKIgTG1GRAazu4TARzQAF/Oq24kBD.9hMCLTEJsV0YUi', 'participante'),
(3, 'João Santos', 'joao@email.com', '$2y$10$Ne9RcGRCvBKIgTG1GRAazu4TARzQAF/Oq24kBD.9hMCLTEJsV0YUi', 'participante'),
(4, 'Ana Pereira', 'ana@email.com', '$2y$10$Ne9RcGRCvBKIgTG1GRAazu4TARzQAF/Oq24kBD.9hMCLTEJsV0YUi', 'participante'),
(5, 'Lucas Oliveira', 'lucas@email.com', '$2y$10$Ne9RcGRCvBKIgTG1GRAazu4TARzQAF/Oq24kBD.9hMCLTEJsV0YUi', 'admin');

-- Popula tabela admin
INSERT INTO admin (id, cargo, data_contratacao) VALUES
(1, 'Coordenador Geral', '2023-01-10'),
(5, 'Gerente de Eventos', '2024-03-15');

-- Popula tabela participante
INSERT INTO participante (id, data_nascimento, cpf) VALUES
(2, '1992-05-15', '123.456.789-00'),
(3, '1985-11-22', '987.654.321-00'),
(4, '1998-08-30', '456.789.123-00');

-- Popula tabela evento (com todos os campos obrigatórios)
INSERT INTO evento (titulo, descricao, data_hora, duracao, local, capacidade, categoria, preco, organizador, status) VALUES
('Workshop de Programação Web', 'Aprenda a desenvolver sites modernos com HTML, CSS e JavaScript', '2025-07-15 09:00:00', '04:00:00', 'Auditório Central', 50, 'Tecnologia', 0.00, 1, 'ativo'),
('Palestra sobre Inteligência Artificial', 'Discussão sobre os avanços e desafios da IA no mundo atual', '2025-07-20 14:00:00', '02:00:00', 'Sala 101', 80, 'Tecnologia', 20.00, 5, 'ativo'),
('Curso de Marketing Digital', 'Estratégias para alavancar seu negócio nas redes sociais', '2025-08-05 09:00:00', '08:00:00', 'Laboratório 3', 30, 'Negócios', 50.00, 1, 'ativo'),
('Hackathon de Inovação', 'Desafie-se a criar soluções tecnológicas em 48 horas', '2025-09-10 08:00:00', '48:00:00', 'Centro de Eventos', 100, 'Tecnologia', 0.00, 5, 'ativo'),
('Seminário de Sustentabilidade', 'Práticas sustentáveis para empresas e indivíduos', '2025-10-15 13:00:00', '05:00:00', 'Auditório Verde', 200, 'Meio Ambiente', 15.00, 1, 'ativo'),
('Evento Esgotado', 'Este evento já está com todas as vagas preenchidas', '2025-06-30 18:00:00', '03:00:00', 'Sala VIP', 2, 'Especial', 0.00, 5, 'ativo');

-- Popula tabela inscricao
INSERT INTO inscricao (id_evento, id_usuario, status, presenca, data_inscricao) VALUES
(1, 2, 'ativa', 0, '2025-05-28'),
(1, 3, 'ativa', 0, '2025-05-29'),
(2, 2, 'pendente de pagamento', 0, '2025-06-01'),
(2, 4, 'ativa', 0, '2025-06-02'),
(3, 3, 'cancelada', 0, '2025-06-15'),
(4, 2, 'ativa', 0, '2025-07-01'),
(4, 3, 'ativa', 0, '2025-07-02'),
(4, 4, 'ativa', 0, '2025-07-03'),
(5, 4, 'pendente de pagamento', 0, '2025-08-10'),
(6, 2, 'ativa', 0, '2025-05-01'),
(6, 3, 'ativa', 0, '2025-05-01');

-- Mensagem de confirmação
SELECT 'Banco de dados populado com sucesso!' AS 'Resultado';
