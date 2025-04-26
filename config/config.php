define('DB_HOST', 'localhost'); 
define('DB_NAME', 'nome_do_banco'); 
define('DB_USER', 'usuario'); 
define('DB_PASS', 'senha'); 
 
try { 
    $pdo = new PDO('mysql:host='.DB_HOST.';dbname='.DB_NAME, DB_USER, DB_PASS); 
    $pdo-, PDO::ERRMODE_EXCEPTION); 
} catch (PDOException $e) { 
    die('Erro na conexão com o banco de dados: ' . $e-
} 
