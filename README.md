# Projeto Web UTFPR 
 
Sistema de gerenciamento de eventos desenvolvido para o projeto de extensão da UTFPR. 
 
## Integrantes do Grupo 
- Matheus Henrique Rosendo Medeiros (RA 2605970)
- Lucas Daniel da Silva (RA 2605953)
 
## Descrição 
Este sistema web permite o cadastro, edição e gerenciamento de eventos, utilizando PHP 8+, seguindo o padrão MVC básico. 
 
## Funcionalidades 
- Autenticação de usuários (login/logout) 
- Cadastro e listagem de eventos 
- Inscrição de usuários em eventos 
- Área administrativa para gerenciar eventos 
 
## Tecnologias Utilizadas 
- PHP 8+ 
- MySQL/MariaDB
- HTML5, CSS3
- Bootstrap para estilização
 
## Pré-requisitos para funcionamento básico
- PHP 8.0 ou superior
- MySQL/MariaDB
- Extensão PDO habilitada no PHP
- Composer (opcional, para dependências)
- **Funcionalidades faltantes**: Nenhuma prevista. 
- **Observações**: Sistema utiliza sessão para autenticação. 
 
## Como Instalar 
Leia o arquivo `docs/instalacao.md` para ver os passos de instalação e configuração. 
 
## Organização do Projeto 
- `controllers/`: Contém os controladores responsáveis pela lógica do sistema.
- `models/`: Contém os modelos que representam os dados e regras de negócio.
- `views/`: Contém as visualizações (arquivos HTML e PHP).
- `public/`: Arquivos acessíveis pelo navegador (index.php, css, js).
- `config/`: Arquivos de configuração.
- `README.md`: Este arquivo.
- `.gitignore`: Arquivos e pastas ignorados no repositório.

## Pré-requisitos para funcionamento básico
- PHP 8.0 ou superior
- MySQL/MariaDB
- Extensão PDO habilitada no PHP
- Composer (opcional, para dependências)

## Configuração rápida para testes

### Populando o banco de dados
Para configurar rapidamente o banco de dados com dados de teste, execute:
```
php database/setup_db.php
```

### Iniciando o servidor
Para iniciar o servidor PHP embutido com suporte a URLs amigáveis:
```
php -S localhost:8000 router.php
```

### Credenciais para teste
**Administradores:**
- Email: admin@sistema.com / Senha: 123456
- Email: lucas@email.com / Senha: 123456

**Participantes:**
- Email: maria@email.com / Senha: 123456
- Email: joao@email.com / Senha: 123456
- Email: ana@email.com / Senha: 123456

## Configuração da conexão com o banco de dados
O arquivo `config/config.php` deve conter as informações corretas de acesso ao banco:

```php
// ...existing code...
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_DATABASE', 'projeto_web');
// ...existing code...
```

A string de conexão já está configurada para usar UTF-8:
```php
$conn = new PDO("mysql:host=".DB_SERVER.";dbname=".DB_DATABASE.";charset=utf8", DB_USERNAME, DB_PASSWORD);
```

## Corrigindo textos corrompidos dos eventos
Se os títulos dos eventos estiverem com caracteres estranhos, rode o script SQL abaixo no seu banco de dados para corrigir:

```sql
source scripts/fix_event_titles.sql;
```

Ou copie e cole o conteúdo do arquivo `scripts/fix_event_titles.sql` no seu cliente MySQL/phpMyAdmin.
