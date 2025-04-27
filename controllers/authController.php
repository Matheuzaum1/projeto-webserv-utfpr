<?php
$acao = $_POST['acao'] ?? $_GET['acao'] ?? '';

session_set_cookie_params([
    'lifetime' => 0, // Sessão expira ao fechar o navegador
    'path' => '/',
    'domain' => '',
    'secure' => isset($_SERVER['HTTPS']), // Apenas HTTPS
    'httponly' => true, // Apenas acessível pelo servidor
    'samesite' => 'Strict' // Evita envio em requisições cross-site
]);
session_start();

class AuthController {
    public function login() {
        require_once __DIR__ . '/../config/usuarios.php';

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

                    // Adicionar cookie persistente para login
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

    public function logout() {
        // Remover cookie persistente
        setcookie('user_token', '', time() - 3600, '/', '', isset($_SERVER['HTTPS']), true);

        // Destruir sessão
        session_destroy();

        // Redirecionar para a página de login
        header('Location: /views/auth/Login.php');
        exit;
    }
}
