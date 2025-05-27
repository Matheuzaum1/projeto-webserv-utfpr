-- Script unificado para setup de testes do projeto WebServ UTFPR
-- Limpa tabelas principais (exceto admin)
SET FOREIGN_KEY_CHECKS = 0;
TRUNCATE TABLE inscricao;
TRUNCATE TABLE evento;
-- Caso queira limpar usuários comuns, descomente:
-- DELETE FROM usuario WHERE tipo_usuario != 'admin';
SET FOREIGN_KEY_CHECKS = 1;

-- Cria usuário admin (id=1)
INSERT IGNORE INTO usuario (id, nome_completo, email, senha, tipo_usuario) VALUES (1, 'Admin', 'admin@admin.com', 'admin', 'admin');

-- Cria usuários de teste
INSERT IGNORE INTO usuario (id, nome_completo, email, senha, tipo_usuario) VALUES
(3, 'Usuario 1', 'user1@gmail.com', '123', 'participante');
-- Adicione mais usuários se necessário

-- Insere eventos de teste (sem duplicar ids)
INSERT IGNORE INTO evento (id, titulo, descricao, data_hora, duracao, local, capacidade, categoria, preco, organizador, status) VALUES
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
(20, 'Workshop de UX/UI Design', 'Descrição padrão', '2027-01-10 09:00:00', '02:00:00', 'Local padrão', 80, 'Categoria', 0.00, 1, 'ativo'),
(28, 'Evento Esgotado 1', 'Evento sem vagas', '2025-06-01 09:00:00', '02:00:00', 'Local Teste', 50, 'Teste', 0.00, 1, 'ativo'),
(29, 'Evento Esgotado 2', 'Evento sem vagas', '2025-06-10 09:00:00', '02:00:00', 'Local Teste', 100, 'Teste', 0.00, 1, 'ativo'),
(30, 'Evento Disponível 1', 'Evento com vagas', '2025-06-15 09:00:00', '02:00:00', 'Local Teste', 50, 'Teste', 0.00, 1, 'ativo'),
(31, 'Evento Disponível 2', 'Evento com vagas', '2025-06-20 09:00:00', '02:00:00', 'Local Teste', 30, 'Teste', 0.00, 1, 'ativo');

-- Preenche eventos esgotados com inscrições
INSERT IGNORE INTO inscricao (id_evento, id_usuario, data_inscricao, status, presenca)
SELECT 28, u.id, '2025-05-30', 'ativa', 0 FROM usuario u WHERE u.id <= 50;
INSERT IGNORE INTO inscricao (id_evento, id_usuario, data_inscricao, status, presenca)
SELECT 29, u.id, '2025-06-05', 'ativa', 0 FROM usuario u WHERE u.id <= 100;

-- Inscrições de teste para usuário 3
INSERT INTO inscricao (id_evento, id_usuario, data_inscricao, status, presenca) VALUES
(1, 3, '2025-05-01', 'ativa', 0),
(3, 3, '2025-09-01', 'ativa', 0),
(5, 3, '2025-11-01', 'ativa', 0),
(28, 3, '2025-06-01', 'ativa', 0),
(30, 3, '2025-06-15', 'ativa', 0);

-- Corrige títulos dos eventos (caso necessário)
UPDATE evento SET titulo = 'Workshop de Desenvolvimento Web' WHERE id = 1;
UPDATE evento SET titulo = 'Seminário de Sustentabilidade' WHERE id = 2;
UPDATE evento SET titulo = 'Hackathon de Inovação' WHERE id = 3;
UPDATE evento SET titulo = 'Congresso de Tecnologia' WHERE id = 4;
UPDATE evento SET titulo = 'Workshop de Design Gráfico' WHERE id = 5;
UPDATE evento SET titulo = 'Palestra sobre Empreendedorismo' WHERE id = 6;
UPDATE evento SET titulo = 'Curso de Programação em Python' WHERE id = 7;
UPDATE evento SET titulo = 'Seminário de Big Data' WHERE id = 8;
UPDATE evento SET titulo = 'Workshop de Fotografia' WHERE id = 9;
UPDATE evento SET titulo = 'Congresso de Educação' WHERE id = 10;
UPDATE evento SET titulo = 'Curso de Marketing Digital' WHERE id = 11;
UPDATE evento SET titulo = 'Palestra sobre Saúde Mental' WHERE id = 12;
UPDATE evento SET titulo = 'Hackathon de Sustentabilidade' WHERE id = 13;
UPDATE evento SET titulo = 'Seminário de Robótica' WHERE id = 14;
UPDATE evento SET titulo = 'Workshop de Desenvolvimento Mobile' WHERE id = 15;
UPDATE evento SET titulo = 'Congresso de Inteligência Artificial' WHERE id = 16;
UPDATE evento SET titulo = 'Curso de Desenvolvimento de Jogos' WHERE id = 17;
UPDATE evento SET titulo = 'Palestra sobre Inovação Tecnológica' WHERE id = 18;
UPDATE evento SET titulo = 'Seminário de Gestão de Projetos' WHERE id = 19;
UPDATE evento SET titulo = 'Workshop de UX/UI Design' WHERE id = 20;
