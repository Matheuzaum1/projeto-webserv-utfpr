<?php
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
            $senha = trim($_POST['senha'] ?? '');

            if (empty($email) || empty($senha)) {
                header('Location: /views/auth/login.php?erro=campos_vazios');
                exit;
            }
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                header('Location: /views/auth/login.php?erro=email_invalido');
                exit;
            }

            $sql = "SELECT * FROM usuario WHERE email = :email";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':email', $email);
            $stmt->execute();
            $usuarioData = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$usuarioData) {
                header('Location: /views/auth/login.php?erro=usuario_nao_encontrado');
                exit;
            }

            if (!password_verify($senha, $usuarioData['senha'])) {
                header('Location: /views/auth/login.php?erro=senha_incorreta');
                exit;
            }

            $_SESSION['usuario'] = [
                'id' => $usuarioData['id'],
                'nome' => $usuarioData['nome_completo'],
                'email' => $usuarioData['email'],
                'tipo' => $usuarioData['tipo_usuario']
            ];

            setcookie('user_token', base64_encode(json_encode($_SESSION['usuario'])), time() + (86400 * 30), '/', '', isset($_SERVER['HTTPS']), true);

            if ($usuarioData['tipo_usuario'] === 'admin') {
                header('Location: /views/dashboard/dashboardAdmin.php');
            } else {
                header('Location: /views/dashboard/dashboardUsuario.php');
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

            if (empty($nome) || empty($email) || empty($senha)) {
                header('Location: /views/auth/register.php?erro=campos_vazios');
                exit;
            }
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                header('Location: /views/auth/register.php?erro=email_invalido');
                exit;
            }
            if (strlen($senha) < 6) {
                header('Location: /views/auth/register.php?erro=senha_curta');
                exit;
            }
            if (strlen($nome) < 3) {
                header('Location: /views/auth/register.php?erro=nome_curto');
                exit;
            }

            $sqlVerifica = "SELECT * FROM usuario WHERE email = :email";
            $stmtVerifica = $this->conn->prepare($sqlVerifica);
            $stmtVerifica->bindParam(':email', $email);
            $stmtVerifica->execute();

            if ($stmtVerifica->rowCount() > 0) {
                header('Location: /views/auth/register.php?erro=email_ja_cadastrado');
                exit;
            }

            $sql = "INSERT INTO usuario (nome_completo, email, senha, tipo_usuario) 
                    VALUES (:nome, :email, :senha, 'participante')";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':nome', $nome);
            $stmt->bindParam(':email', $email);
            $senhaHash = password_hash($senha, PASSWORD_DEFAULT);
            $stmt->bindParam(':senha', $senhaHash);
            $stmt->execute();

            header('Location: /views/auth/login.php?success=usuario_cadastrado');
            exit;
        } catch (PDOException $e) {
            throw new Exception("Erro ao registrar usuário: " . $e->getMessage());
        }
    }

    public function logout() {
        try {
            setcookie('user_token', '', time() - 3600, '/', '', isset($_SERVER['HTTPS']), true);

            session_destroy();

            header('Location: /views/auth/login.php');
            exit;
        } catch (Exception $e) {
            throw new Exception("Erro ao realizar logout: " . $e->getMessage());
        }
    }
}
