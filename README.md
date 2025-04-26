Show, Matheus! 🚀  
Vou montar um modelo de `README.md` **completo e organizado**, focado no que seu professor pediu no enunciado:  
(integrantes, descrição, bugs/conhecimentos, atividades de cada membro, instalação, etc.)

Aqui está o modelo:

---

# Projeto Web UTFPR

## 📋 Descrição do Projeto

Este projeto é um sistema de gerenciamento de eventos desenvolvido em PHP 8+ como parte de um projeto de extensão da UTFPR.  
O sistema permite o cadastro, edição e visualização de eventos, além de um sistema de autenticação para usuários.  

Este projeto é dividido em duas fases, sendo esta a primeira entrega (Trabalho 1), focando no envio de dados via formulários, validações em servidor, autenticação e separação de código usando padrão MVC (Model-View-Controller).

---

## 👥 Integrantes

| Nome                 | RA       |
|----------------------|----------|
| Matheus [Seu Sobrenome] | [RA do Matheus] |
| [Nome do colega]      | [RA do colega] |

---

## 🚀 Funcionalidades Implementadas

- [x] Estrutura de projeto separada (MVC)
- [x] Sistema de login com autenticação via sessão
- [x] Cadastro de eventos
- [x] Listagem de eventos cadastrados
- [x] Validação e tratamento de erros no lado servidor (PHP)
- [x] Interface responsiva (Bootstrap)
- [x] Documentação de instalação e configuração

---

## ⚙️ Como Instalar e Rodar o Projeto

**Pré-requisitos:**
- PHP 8.0+
- MySQL ou MariaDB
- Servidor Apache (ex: XAMPP, WAMP, MAMP ou LAMP)

**Instalação:**

1. Clone o repositório:
   ```bash
   git clone https://github.com/Matheuzaum1/projeto-webserv-utfpr.git
   ```

2. Coloque o projeto na pasta pública do servidor (ex: `htdocs` no XAMPP).

3. Configure o banco de dados:
   - Crie um banco de dados MySQL chamado `projeto_web_utfpr`
   - Execute os scripts de criação de tabelas no diretório `/database` (caso aplicável)

4. Atualize as configurações de conexão no arquivo:
   ```
   config/config.php
   ```

5. Acesse no navegador:
   ```
   http://localhost/projeto-webserv-utfpr/public
   ```

---

## ⚠️ Particularidades e Observações

- Em caso de erros de conexão ao banco, verifique se as credenciais no `config/config.php` estão corretas.
- Funcionalidades planejadas que ainda não foram implementadas:
  - [ ] Sistema de cadastro de categorias de evento
  - [ ] Recuperação de senha
- Testado no navegador Google Chrome.

---

## 📄 Atividades Desenvolvidas por Cada Integrante

| Integrante    | Atividades principais |
|---------------|------------------------|
| Matheus       | Estruturação do projeto (padrão MVC), criação do sistema de login, configuração de banco de dados |
| [Colega]      | Desenvolvimento da interface dos eventos, validação de formulários e documentação de instalação |

---

## 🛠️ Tecnologias Utilizadas

- PHP 8.0+
- MySQL 8.0
- HTML5
- CSS3
- Bootstrap 5.3
- Git/GitHub

---

## 📚 Documentação

A documentação de instalação detalhada está disponível em:

```
/docs/instalacao.md
```

---

> **Obs.:** Este projeto é acadêmico e está em desenvolvimento contínuo conforme cronograma da disciplina.

---
