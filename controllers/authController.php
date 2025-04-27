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
    public function login() {
        $usuarios = require_once __DIR__ . '/../config/usuarios.php';

        $email = $_POST['email'] ?? '';
        $senha = $_POST['senha'] ?? '';

        if (empty($email) || empty($senha)) {
            header('Location: /views/auth/login.php?erro=campos_vazios');
            exit;
        }

        $usuarioEncontrado = false;
        foreach ($usuarios as $usuario) {
            if ($usuario['email'] === $email) {
                $usuarioEncontrado = true;
                if ($senha === $usuario['senha']) {
                    $_SESSION['usuario'] = [
                        'id' => $usuario['id'],
                        'nome' => $usuario['nome'],
                        'email' => $usuario['email'],
                        'tipo' => $usuario['tipo']
                    ];

                    setcookie('user_token', base64_encode(json_encode($_SESSION['usuario'])), time() + (86400 * 30), '/', '', isset($_SERVER['HTTPS']), true);

                    if ($usuario['tipo'] === 'admin') {
                        header('Location: /views/dashboard/dashboardAdmin.php');
                    } else {
                        header('Location: /views/dashboard/dashboardUsuario.php');
                    }
                    exit;
                } else {
                    header('Location: /views/auth/login.php?erro=senha_incorreta');
                    exit;
                }
            }
        }

        if (!$usuarioEncontrado) {
            header('Location: /views/auth/login.php?erro=usuario_nao_encontrado');
            exit;
        }
    }

    public function register() {
        $usuarios = require_once __DIR__ . '/../config/usuarios.php';

        $nome = trim($_POST['nome'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $senha = trim($_POST['senha'] ?? '');

        if (empty($nome) || empty($email) || empty($senha)) {
            header('Location: /views/auth/register.php?erro=campos_vazios');
            exit;
        }

        foreach ($usuarios as $usuario) {
            if ($usuario['email'] === $email) {
                header('Location: /views/auth/register.php?erro=email_ja_cadastrado');
                exit;
            }
        }

        $novoUsuario = [
            'id' => count($usuarios) + 1,
            'nome' => $nome,
            'email' => $email,
            'senha' => $senha,
            'tipo' => 'usuario'
        ];

        $usuarios[] = $novoUsuario;

        if (file_put_contents(__DIR__ . '/../config/usuarios.php', '<?php return ' . var_export($usuarios, true) . ';') === false) {
            header('Location: /views/auth/register.php?erro=erro_ao_salvar');
            exit;
        }

        header('Location: /views/auth/login.php?success=usuario_cadastrado');
        exit;
    }
    public function logout() {
        setcookie('user_token', '', time() - 3600, '/', '', isset($_SERVER['HTTPS']), true);
        session_destroy();
        header('Location: /views/auth/Login.php');
        exit;
    }
}
