<?php
require_once __DIR__ . '/eventController.php';
require_once __DIR__ . '/../database/Conexao.php';

class InscricaoController {
    private $conn;

    public function __construct() {
        $this->conn = Conexao::get();
    }
    
    public function inscrever() {
        if (!isset($_SESSION['usuario'])) {
            header('Location: /index.php?action=showLogin&error=unauthorized');
            exit;
        }

        $usuarioId = $_SESSION['usuario']['id'];
        $eventoId = $_GET['id'] ?? null;

        if (!$eventoId) {
            header('Location: /index.php?action=showDashboardUser&error=invalid_event');
            exit;
        }

        try {
            $eventController = new EventController();
            $evento = $eventController->getEventById($eventoId);
            
            if (!$evento) {
                header('Location: /index.php?action=showDashboardUser&error=event_not_found');
                exit;
            }
            
            $inscricoes = $this->getAllInscricoes($eventoId);
            
            $this->registerUser($eventoId, $usuarioId);
            header('Location: /index.php?action=showDashboardUser&success=inscricao');
            exit;
        } catch (Exception $e) {
            if (strpos($e->getMessage(), 'já está inscrito') !== false) {
                header('Location: /index.php?action=showDashboardUser&info=ja_inscrito');
                exit;
            }
            header('Location: /index.php?action=showDashboardUser&error=inscricao_failed');
            exit;
        }
    }

    public function cancelarInscricao() {
        if (!isset($_SESSION['usuario'])) {
            header('Location: /index.php?action=showLogin&error=unauthorized');
            exit;
        }

        $usuarioId = $_SESSION['usuario']['id'];
        $eventoId = $_GET['id'] ?? null;

        if (!$eventoId) {
            header('Location: /index.php?action=showDashboardUser&error=invalid_event');
            exit;
        }

        try {
            $this->cancelarInscricaoEvento($eventoId, $usuarioId);
            header('Location: /index.php?action=showDashboardUser&success=desinscricao');
            exit;
        } catch (Exception $e) {
            header('Location: /index.php?action=showDashboardUser&error=cancelamento_failed');
            exit;
        }
    }

    public function getAllInscricoes($idEvento) {
        try{
            $query = "SELECT COUNT(id_evento) as total_inscricoes FROM inscricao WHERE id_evento = :id_evento";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':id_evento', $idEvento);
            $stmt->execute();

            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            return $result ?? throw new PDOException("Erro ao obter inscrições");
        } catch (PDOException $e) {
            throw new Exception("Erro ao obter inscrições: " . $e->getMessage());
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

            $sqlVerificaInscricao = "SELECT * FROM inscricao WHERE id_evento = :id_evento AND id_usuario = :id_usuario";
            $stmtVerifica = $this->conn->prepare($sqlVerificaInscricao);
            $stmtVerifica->bindParam(':id_evento', $idEvento);
            $stmtVerifica->bindParam(':id_usuario', $idUsuario);
            $stmtVerifica->execute();

            if ($stmtVerifica->rowCount() > 0) {
                throw new Exception('Você já está inscrito neste evento.');
            }

            $sqlInscricao = "INSERT INTO inscricao (id_evento, id_usuario, data_inscricao, status, presenca) 
                             VALUES (:id_evento, :id_usuario, :data_inscricao, 'ativa', 0)";
            $stmtInscricao = $this->conn->prepare($sqlInscricao);
            $stmtInscricao->bindParam(':id_evento', $idEvento);
            $stmtInscricao->bindParam(':id_usuario', $idUsuario);
            $dataInscricao = date('Y-m-d');
            $stmtInscricao->bindParam(':data_inscricao', $dataInscricao);
            $stmtInscricao->execute();

            return "Inscrição realizada com sucesso!";
        } catch (PDOException $e) {
            throw new Exception("Erro ao registrar usuário no evento: " . $e->getMessage());
        }
    }

    public function cancelarInscricaoEvento($eventoId, $usuarioId) {
        $sql = "DELETE FROM inscricao WHERE id_evento = :id_evento AND id_usuario = :id_usuario";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id_evento', $eventoId);
        $stmt->bindParam(':id_usuario', $usuarioId);
        $stmt->execute();
    }
}