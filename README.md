# Projeto Web UTFPR 
 
Sistema de gerenciamento de eventos desenvolvido para o projeto de extensão da UTFPR. 
 
## Integrantes do Grupo 
<<<<<<< HEAD
- Matheus Henrique Rosendo Medeiros (RA 2605970)
- Lucas Daniel da Silva (RA 2605953) 
=======
- Matheus Henrique Rosendo Medeiros
- Lucas Daniel da Silva
>>>>>>> main
 
## Descrição 
Este sistema web permite o cadastro, edição e gerenciamento de eventos, utilizando PHP 8+, seguindo o padrão MVC básico. 
 
## Funcionalidades 
- Autenticação de usuários (login/logout) 
- Cadastro e listagem de eventos 
- Inscrição de usuários em eventos 
- Área administrativa para gerenciar eventos 
 
## Tecnologias Utilizadas 
- PHP 8+ 
- MySQL ou MariaDB (Nao implementado ainda)
- HTML5, CSS3 
- (Opcional: Bootstrap para estilização) 
 
## Particularidades do Projeto 
- **Bugs conhecidos**: Nenhum no momento. 
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
