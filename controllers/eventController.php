<?php
require_once __DIR__ . '/../database/Conexao.php';
require_once __DIR__ . '/../models/Evento.php';

class EventController {
    private $conn;

    public function __construct() {
        $this->conn = Conexao::get();
    }

    public function listEvents() {
        try {
            $sql = "SELECT e.*, 
                           (SELECT COUNT(*) FROM inscricao i WHERE i.id_evento = e.id) AS participantes 
                    FROM evento e";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            $eventos = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $eventList = [];
            foreach ($eventos as $eventoData) {
                $evento = new Evento(
                    $eventoData['id'],
                    $eventoData['nome'],
                    $eventoData['descricao'],
                    $eventoData['local'],
                    $eventoData['data'],
                    $eventoData['duracao'],
                    $eventoData['max_participantes'],
                    $eventoData['status'],
                    $eventoData['categoria'],
                    $eventoData['preco'],
                    $eventoData['organizador'],
                    $eventoData['participantes'] // novo campo
                );
                $eventList[] = $evento;
            }

            return $eventList;
        } catch (PDOException $e) {
            throw new Exception("Erro ao listar eventos: " . $e->getMessage());
        }
    }

    public function getEventById($id) {
        try {
            $sql = "SELECT * FROM evento WHERE id = :id";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            $eventoData = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$eventoData) {
                throw new Exception('Evento não encontrado.');
            }

            return new Evento(
                $eventoData['id'],
                $eventoData['nome'],
                $eventoData['descricao'],
                $eventoData['local'],
                $eventoData['data'],
                $eventoData['duracao'],
                $eventoData['max_participantes'],
                $eventoData['status'],
                $eventoData['categoria'],
                $eventoData['preco'],
                $eventoData['organizador']
            );
        } catch (PDOException $e) {
            throw new Exception("Erro ao buscar evento: " . $e->getMessage());
        }
    }

    public function createEvent($titulo, $descricao, $local, $dataHora, $duracao, $capacidade, $categoria, $preco, $organizador) {
        try {
            $sql = "INSERT INTO evento (titulo, descricao, local, data_hora, duracao, capacidade, status, categoria, preco, organizador) 
                    VALUES (:titulo, :descricao, :local, :data_hora, :duracao, :capacidade, 'ativo', :categoria, :preco, :organizador)";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':titulo', $titulo);
            $stmt->bindParam(':descricao', $descricao);
            $stmt->bindParam(':local', $local);
            $stmt->bindParam(':data_hora', $dataHora);
            $stmt->bindParam(':duracao', $duracao);
            $stmt->bindParam(':capacidade', $capacidade);
            $stmt->bindParam(':categoria', $categoria);
            $stmt->bindParam(':preco', $preco);
            $stmt->bindParam(':organizador', $organizador);
            $stmt->execute();
        } catch (PDOException $e) {
            throw new Exception("Erro ao criar evento: " . $e->getMessage());
        }
    }

    public function updateEvent($id, $titulo, $descricao, $local, $dataHora, $duracao, $capacidade, $categoria, $preco) {
        try {
            $sql = "UPDATE evento 
                    SET titulo = :titulo, descricao = :descricao, local = :local, data_hora = :data_hora, 
                        duracao = :duracao, capacidade = :capacidade, categoria = :categoria, preco = :preco 
                    WHERE id = :id";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':titulo', $titulo);
            $stmt->bindParam(':descricao', $descricao);
            $stmt->bindParam(':local', $local);
            $stmt->bindParam(':data_hora', $dataHora);
            $stmt->bindParam(':duracao', $duracao);
            $stmt->bindParam(':capacidade', $capacidade);
            $stmt->bindParam(':categoria', $categoria);
            $stmt->bindParam(':preco', $preco);
            $stmt->bindParam(':id', $id);
            $stmt->execute();

            if ($stmt->rowCount() === 0) {
                throw new Exception('Evento não encontrado ou nenhuma alteração realizada.');
            }
        } catch (PDOException $e) {
            throw new Exception("Erro ao atualizar evento: " . $e->getMessage());
        }
    }

    public function deleteEvent($id) {
        try {
            $this->conn->beginTransaction();

            $sqlInscricao = "DELETE FROM inscricao WHERE id_evento = :id_evento";
            $stmtInscricao = $this->conn->prepare($sqlInscricao);
            $stmtInscricao->bindParam(':id_evento', $id);
            $stmtInscricao->execute();

            $sqlEvento = "DELETE FROM evento WHERE id = :id";
            $stmtEvento = $this->conn->prepare($sqlEvento);
            $stmtEvento->bindParam(':id', $id);
            $stmtEvento->execute();

            $this->conn->commit();
        } catch (PDOException $e) {
            $this->conn->rollBack();
            throw new Exception("Erro ao excluir evento: " . $e->getMessage());
        }
    }

    public function registerUser($idEvento, $idUsuario) {
        try {
            $sqlEvento = "SELECT capacidade, 
                                 (SELECT COUNT(*) FROM inscricao WHERE id_evento = :id_evento) AS inscritos 
                          FROM evento WHERE id = :id_evento";
            $stmtEvento = $this->conn->prepare($sqlEvento);
            $stmtEvento->bindParam(':id_evento', $idEvento);
            $stmtEvento->execute();
            $evento = $stmtEvento->fetch(PDO::FETCH_ASSOC);

            if (!$evento) {
                throw new Exception('Evento não encontrado.');
            }

            if ($evento['inscritos'] >= $evento['capacidade']) {
                throw new Exception('Número máximo de participantes atingido.');
            }

            $sqlInscricao = "INSERT INTO inscricao (id_evento, id_usuario, data_inscricao, status, presenca) 
                             VALUES (:id_evento, :id_usuario, :data_inscricao, 'ativa', 0)";
            $stmtInscricao = $this->conn->prepare($sqlInscricao);
            $stmtInscricao->bindParam(':id_evento', $idEvento);
            $stmtInscricao->bindParam(':id_usuario', $idUsuario);
            $stmtInscricao->bindParam(':data_inscricao', date('Y-m-d'));
            $stmtInscricao->execute();
        } catch (PDOException $e) {
            throw new Exception("Erro ao registrar usuário no evento: " . $e->getMessage());
        }
    }

    public function getEventosInscritosUsuario($usuarioId) {
        $sql = "SELECT id_evento FROM inscricao WHERE id_usuario = :usuario_id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':usuario_id', $usuarioId);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_COLUMN, 0);
    }

    public function getNumeroInscritos($idEvento) {
        $sql = "SELECT COUNT(*) as total FROM inscricao WHERE id_evento = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $idEvento);
        $stmt->execute();
        return (int)$stmt->fetchColumn();
    }
}
