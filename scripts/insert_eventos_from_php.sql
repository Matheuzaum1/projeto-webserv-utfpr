-- Script para popular a tabela evento com os dados do config/eventos.php
-- Edite os campos fictícios conforme necessário

INSERT INTO evento (id, titulo, descricao, data_hora, duracao, local, capacidade, categoria, preco, organizador, status)
VALUES
(1, 'Workshop de Desenvolvimento Web', 'Descrição padrão', '2025-05-15 09:00:00', '02:00:00', 'Local padrão', 1000, 'Categoria', 0.00, 1, 'ativo'),
(2, 'Seminário de Sustentabilidade', 'Descrição padrão', '2025-07-20 09:00:00', '02:00:00', 'Local padrão', 200, 'Categoria', 0.00, 1, 'ativo'),
(3, 'Hackathon de Inovação', 'Descrição padrão', '2025-09-15 09:00:00', '02:00:00', 'Local padrão', 300, 'Categoria', 0.00, 1, 'ativo'),
(4, 'Congresso de Tecnologia', 'Descrição padrão', '2025-10-10 09:00:00', '02:00:00', 'Local padrão', 1000, 'Categoria', 0.00, 1, 'ativo'),
(5, 'Workshop de Design Gráfico', 'Descrição padrão', '2025-11-05 09:00:00', '02:00:00', 'Local padrão', 150, 'Categoria', 0.00, 1, 'ativo'),
(6, 'Palestra sobre Empreendedorismo', 'Descrição padrão', '2025-12-01 09:00:00', '02:00:00', 'Local padrão', 200, 'Categoria', 0.00, 1, 'ativo'),
(7, 'Curso de Programação em Python', 'Descrição padrão', '2025-12-15 09:00:00', '02:00:00', 'Local padrão', 50, 'Categoria', 0.00, 1, 'ativo'),
(8, 'Seminário de Big Data', 'Descrição padrão', '2026-01-10 09:00:00', '02:00:00', 'Local padrão', 500, 'Categoria', 0.00, 1, 'ativo'),
(9, 'Workshop de Fotografia', 'Descrição padrão', '2026-02-05 09:00:00', '02:00:00', 'Local padrão', 100, 'Categoria', 0.00, 1, 'ativo'),
(10, 'Congresso de Educação', 'Descrição padrão', '2026-03-15 09:00:00', '02:00:00', 'Local padrão', 500, 'Categoria', 0.00, 1, 'ativo'),
(11, 'Curso de Marketing Digital', 'Descrição padrão', '2026-04-10 09:00:00', '02:00:00', 'Local padrão', 80, 'Categoria', 0.00, 1, 'ativo'),
(12, 'Palestra sobre Saúde Mental', 'Descrição padrão', '2026-05-20 09:00:00', '02:00:00', 'Local padrão', 150, 'Categoria', 0.00, 1, 'ativo'),
(13, 'Hackathon de Sustentabilidade', 'Descrição padrão', '2026-06-15 09:00:00', '02:00:00', 'Local padrão', 250, 'Categoria', 0.00, 1, 'ativo'),
(14, 'Seminário de Robótica', 'Descrição padrão', '2026-07-10 09:00:00', '02:00:00', 'Local padrão', 200, 'Categoria', 0.00, 1, 'ativo'),
(15, 'Workshop de Desenvolvimento Mobile', 'Descrição padrão', '2026-08-05 09:00:00', '02:00:00', 'Local padrão', 100, 'Categoria', 0.00, 1, 'ativo'),
(16, 'Congresso de Inteligência Artificial', 'Descrição padrão', '2026-09-15 09:00:00', '02:00:00', 'Local padrão', 800, 'Categoria', 0.00, 1, 'ativo'),
(17, 'Curso de Desenvolvimento de Jogos', 'Descrição padrão', '2026-10-10 09:00:00', '02:00:00', 'Local padrão', 100, 'Categoria', 0.00, 1, 'ativo'),
(18, 'Palestra sobre Inovação Tecnológica', 'Descrição padrão', '2026-11-05 09:00:00', '02:00:00', 'Local padrão', 300, 'Categoria', 0.00, 1, 'ativo'),
(19, 'Seminário de Gestão de Projetos', 'Descrição padrão', '2026-12-01 09:00:00', '02:00:00', 'Local padrão', 200, 'Categoria', 0.00, 1, 'ativo'),
(20, 'Workshop de UX/UI Design', 'Descrição padrão', '2027-01-10 09:00:00', '02:00:00', 'Local padrão', 80, 'Categoria', 0.00, 1, 'ativo');
