<?php
require_once __DIR__ . '/eventController.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['usuario'])) {
    http_response_code(403);
    echo "Acesso negado. Faça login para se inscrever.";
    exit;
}

$usuarioId = $_SESSION['usuario']['id'];
$eventoId = $_GET['id'] ?? null;

if (!$eventoId) {
    http_response_code(400);
    echo "ID do evento não fornecido.";
    exit;
}

$eventController = new EventController();
$evento = $eventController->getEventById($eventoId);

if (!$evento) {
    http_response_code(404);
    echo "Evento não encontrado.";
    exit;
}

$inscricaoController = new InscricaoController($eventoId);
$inscricoes = $inscricaoController->getAllInscricoes();

if ($evento->getCapacidade() <= $inscricoes['total_inscricoes']){
    http_response_code(403);
    echo "Número máximo de participantes atingido.";
    exit;
}

$action = $_GET['action'] ?? null;

if ($action === 'cancelar') {
    $inscricaoController->unsubscribeUser($eventoId, $usuarioId);
    header('Location: /views/dashboard/dashboardUsuario.php?success=desinscricao');
    exit;
}

try{
    $mensagem = $inscricaoController->registerUser($eventoId, $usuarioId);
    header('Location: /views/dashboard/dashboardUsuario.php?success=inscricao');
    exit;
} catch (Exception $e) {
    if (strpos($e->getMessage(), 'já está inscrito') !== false) {
        header('Location: /views/dashboard/dashboardUsuario.php?info=ja_inscrito');
        exit;
    }
    http_response_code(500);
    echo "Erro ao se inscrever: " . $e->getMessage();
}

class InscricaoController {
    private $conn, $idEvento;

    public function __construct($idEvento) {
        $this->idEvento = $idEvento;
        $this->conn = Conexao::get();
    }

    public function getAllInscricoes() {
        try{
            $query = "SELECT COUNT(id_evento) as total_inscricoes FROM inscricao WHERE id_evento = :id_evento";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':id_evento', $this->idEvento);
            $stmt->execute();

            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            return $result ?? throw new PDOException("Erro ao obter inscrições");
        } catch (PDOException $e) {
            throw new Exception("Erro ao obter inscrições: " . $e->getMessage());
        }
    }

    public function registerUser($idEvento, $idUsuario) {
        try {
            $sqlEvento = "SELECT max_participantes, 
                                 (SELECT COUNT(*) FROM inscricao WHERE id_evento = :id_evento) AS inscritos 
                          FROM evento WHERE id = :id_evento";
            $stmtEvento = $this->conn->prepare($sqlEvento);
            $stmtEvento->bindParam(':id_evento', $idEvento);
            $stmtEvento->execute();
            $evento = $stmtEvento->fetch(PDO::FETCH_ASSOC);

            if (!$evento) {
                throw new Exception('Evento não encontrado.');
            }

            if ($evento['inscritos'] >= $evento['max_participantes']) {
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

    public function unsubscribeUser($idEvento, $idUsuario){
        try {
            $sql = "DELETE FROM inscricao WHERE id_evento = :id_evento AND id_usuario = :id_usuario";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':id_evento', $idEvento);
            $stmt->bindParam(':id_usuario', $idUsuario);
            $stmt->execute();
            header('Location: /views/dashboard/dashboardUsuario.php?success=desinscricao');
            exit;
        } catch (PDOException $e) {
            throw new Exception("Erro ao cancelar inscrição: " . $e->getMessage());
        }
    }
}