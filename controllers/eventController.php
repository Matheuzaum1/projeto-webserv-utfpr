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
            $sql = "SELECT * FROM evento";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            $eventos = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $eventList = [];
            foreach ($eventos as $eventoData) {
                $evento = new Evento(
                    $eventoData['id'],
                    $eventoData['titulo'],
                    $eventoData['data_hora'],
                    $eventoData['capacidade'],
                    $eventoData['status'],
                    $eventoData['organizador']
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
                header('Location: /views/eventos/eventos.php?erro=evento_nao_encontrado');
                exit;
            }

            return new Evento(
                $eventoData['id'],
                $eventoData['titulo'],
                $eventoData['data_hora'],
                $eventoData['capacidade'],
                $eventoData['status'],
                $eventoData['organizador']
            );
        } catch (PDOException $e) {
            throw new Exception("Erro ao buscar evento: " . $e->getMessage());
        }
    }

    public function createEvent($titulo, $dataHora, $organizador, $capacidade) {
        try {
            $status = 'ativo';
            $sql = "INSERT INTO evento (titulo, data_hora, organizador, capacidade, status)
                    VALUES (:titulo, :data_hora, :organizador, :capacidade, :status)";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':titulo', $titulo);
            $stmt->bindParam(':data_hora', $dataHora);
            $stmt->bindParam(':organizador', $organizador);
            $stmt->bindParam(':capacidade', $capacidade);
            $stmt->bindParam(':status', $status);
            $stmt->execute();
            if ($stmt->rowCount() === 0) {
                throw new Exception('Erro ao criar evento. Verifique os dados informados.');
            }
        } catch (PDOException $e) {
            throw new Exception("Erro ao criar evento: " . $e->getMessage());
        }
    }

    public function updateEvent($id, $titulo, $dataHora, $capacidade) {
        try {
            $sql = "UPDATE evento 
                    SET titulo = :titulo, data_hora = :data_hora, 
                        capacidade = :capacidade 
                    WHERE id = :id";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':titulo', $titulo);
            $stmt->bindParam(':data_hora', $dataHora);
            $stmt->bindParam(':capacidade', $capacidade);
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
            $dataInscricao = date('Y-m-d');
            $stmtInscricao->bindParam(':data_inscricao', $dataInscricao);
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
