<?php
require_once __DIR__ . '/../database/Conexao.php';

$acao = $_POST['acao'] ?? $_GET['acao'] ?? '';

if (session_status() === PHP_SESSION_NONE) {
    session_set_cookie_params([
        'lifetime' => 0,
        'path' => '/',
        'domain' => '',
        'secure' => isset($_SERVER['HTTPS']),
        'httponly' => true,
        'samesite' => 'Strict'
    ]);
    session_start();
}

class AuthController {
    private $conn;

    public function __construct() {
        $this->conn = Conexao::get();
    }

    public function login() {
        try {
            $email = trim($_POST['email'] ?? '');
            $senha = trim($_POST['senha'] ?? '');            if (empty($email) || empty($senha)) {
                header('Location: /login?erro=campos_vazios');
                exit;
            }
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                header('Location: /login?erro=email_invalido');
                exit;
            }

            $sql = "SELECT * FROM usuario WHERE email = :email";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':email', $email);
            $stmt->execute();
            $usuarioData = $stmt->fetch(PDO::FETCH_ASSOC);            if (!$usuarioData) {
                header('Location: /login?erro=usuario_nao_encontrado');
                exit;
            }

            if (!password_verify($senha, $usuarioData['senha'])) {
                header('Location: /login?erro=senha_incorreta');
                exit;
            }

            $_SESSION['usuario'] = [
                'id' => $usuarioData['id'],
                'nome' => $usuarioData['nome_completo'],
                'email' => $usuarioData['email'],
                'tipo' => $usuarioData['tipo_usuario']
            ];

            setcookie('user_token', base64_encode(json_encode($_SESSION['usuario'])), time() + (86400 * 30), '/', '', isset($_SERVER['HTTPS']), true);            if ($usuarioData['tipo_usuario'] === 'admin') {
                header('Location: /admin');
            } else {
                header('Location: /dashboard');
            }
            exit;
        } catch (PDOException $e) {
            throw new Exception("Erro ao realizar login: " . $e->getMessage());
        }
    }

    public function register() {
        try {
            $nome = trim($_POST['nome'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $senha = trim($_POST['senha'] ?? '');
            $tipo_usuario = $_POST['tipo_usuario'] ?? 'participante';            if (empty($nome) || empty($email) || empty($senha)) {
                header('Location: /register?erro=campos_vazios');
                exit;
            }
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                header('Location: /register?erro=email_invalido');
                exit;
            }
            if (strlen($senha) < 6) {
                header('Location: /register?erro=senha_curta');
                exit;
            }
            if (strlen($nome) < 3) {
                header('Location: /register?erro=nome_curto');
                exit;
            }
            if (!in_array($tipo_usuario, ['admin', 'participante'])) {
                $tipo_usuario = 'participante';
            }

            $sqlVerifica = "SELECT * FROM usuario WHERE email = :email";
            $stmtVerifica = $this->conn->prepare($sqlVerifica);
            $stmtVerifica->bindParam(':email', $email);
            $stmtVerifica->execute();            if ($stmtVerifica->rowCount() > 0) {
                header('Location: /register?erro=email_ja_cadastrado');
                exit;
            }

            $sql = "INSERT INTO usuario (nome_completo, email, senha, tipo_usuario) 
                    VALUES (:nome, :email, :senha, :tipo_usuario)";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':nome', $nome);
            $stmt->bindParam(':email', $email);
            $senhaHash = password_hash($senha, PASSWORD_DEFAULT);            $stmt->bindParam(':senha', $senhaHash);
            $stmt->bindParam(':tipo_usuario', $tipo_usuario);
            $stmt->execute();
            
            header('Location: /login?success=usuario_cadastrado');
            exit;
        } catch (PDOException $e) {
            throw new Exception("Erro ao registrar usuário: " . $e->getMessage());
        }
    }

    public function logout() {
        try {
            setcookie('user_token', '', time() - 3600, '/', '', isset($_SERVER['HTTPS']), true);

            session_destroy();            header('Location: /login');
            exit;
        } catch (Exception $e) {
            throw new Exception("Erro ao realizar logout: " . $e->getMessage());
        }
    }

    // Métodos para exibir as views
    public function showLoginForm() {
        include __DIR__ . '/../views/auth/Login.php';
    }
    
    public function showRegisterForm() {
        include __DIR__ . '/../views/auth/Register.php';
    }
      public function showDashboardAdmin() {
        if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['tipo'] !== 'admin') {
            header('Location: /login?erro=acesso_negado');
            exit;
        }
        include __DIR__ . '/../views/dashboard/dashboardAdmin.php';
    }
    
    public function showDashboardUser() {
        if (!isset($_SESSION['usuario'])) {
            header('Location: /login?erro=acesso_negado');
            exit;
        }
        include __DIR__ . '/../views/dashboard/dashboardUsuario.php';
    }
}
