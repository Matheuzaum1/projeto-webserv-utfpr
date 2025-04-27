# Instruções de Instalação - Projeto Web UTFPR

## Requisitos
- PHP 8.0 ou superior
- MySQL ou MariaDB
- Servidor Web (Apache ou similar)
- Git instalado
- Composer (opcional)

## Passos para Instalação

1. **Clone o repositório:**
   ```bash
   git clone https://github.com/SEU_USUARIO/projeto-web-utfpr.git
   cd projeto-web-utfpr
   ```

2. **Configure o ambiente:**
   - Certifique-se de que o diretório `public/` é a raiz pública do servidor.
   - Configure o arquivo `config/config.php` com as credenciais do banco de dados.

3. **Crie o banco de dados:**
   - Importe o arquivo `database.sql` (caso exista) para o banco de dados MySQL ou MariaDB.
   - Certifique-se de que as tabelas necessárias foram criadas corretamente.

4. **Permissões de Pastas:**
   - Garanta que o servidor tenha permissões de escrita nas pastas necessárias, como `config/` e `public/`.

5. **Inicie o servidor:**
   - Utilize o servidor embutido do PHP para rodar o projeto localmente:
     ```bash
     php -S localhost:8000 -t public
     ```
   - Ou configure o servidor Apache/Nginx para apontar para o diretório `public/`.

6. **Acesse o sistema:**
   - Abra o navegador e acesse:
     ```
     http://localhost:8000
     ```

## Observações
- Certifique-se de que o PHP está configurado corretamente no ambiente.
- Caso encontre problemas, verifique os logs do servidor e as permissões de arquivos.
- Para contribuições ou dúvidas, consulte o arquivo `README.md`.
