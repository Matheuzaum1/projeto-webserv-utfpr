
### Reminder `

```markdown
# Projeto Web UTFPR

Este projeto é uma aplicação web desenvolvida em PHP 8+, parte do trabalho de extensão da faculdade. O objetivo do projeto é [descrever o objetivo do seu projeto aqui].

## Estrutura do Projeto

A estrutura do repositório segue as melhores práticas para gerenciamento de código-fonte e organização do desenvolvimento, com o uso do Git para controle de versão.

### Branches

Abaixo está o fluxo de trabalho recomendado para organizar as branches durante o desenvolvimento do projeto:

- **`main`**: Esta é a branch principal, que contém a versão estável do código, pronta para produção.
- **`develop`**: Branch de desenvolvimento, onde as novas funcionalidades serão integradas antes de serem mescladas na `main`.
- **`feature/nome-da-funcionalidade`**: Cada funcionalidade será desenvolvida em uma branch separada, criada a partir da `develop`. Exemplo: `feature/login`, `feature/cadastro`.
- **`hotfix/nome-do-bug`**: Caso surjam erros críticos na produção, serão criadas branches de correção (`hotfix`) diretamente a partir da `main`.

### Fluxo de Trabalho

1. **Configuração Inicial**: Antes de começar, clone o repositório:
   ```bash
   git clone https://github.com/seuusuario/projeto-web-utfpr.git
   cd projeto-web-utfpr
   ```

2. **Criando uma nova branch para funcionalidade**:
   - Sempre crie uma nova branch para cada tarefa/funcionalidade que for implementar.
   - Exemplo para uma funcionalidade de login:
     ```bash
     git checkout develop
     git checkout -b feature/login
     ```

3. **Sincronizando o código**:
   - Antes de começar a trabalhar, sempre puxe as últimas atualizações do repositório remoto:
     ```bash
     git pull origin develop
     ```

4. **Adicionando e Comitando as Mudanças**:
   - Quando terminar uma funcionalidade ou alteração, adicione e comite suas mudanças:
     ```bash
     git add .
     git commit -m "Descrição das mudanças"
     ```

5. **Fazendo o Push das Alterações**:
   - Envie suas mudanças para o repositório remoto:
     ```bash
     git push -u origin feature/login
     ```

6. **Mesclando a Funcionalidade com a Branch `develop`**:
   - Após a conclusão da funcionalidade, faça o merge de volta para a branch `develop`:
     ```bash
     git checkout develop
     git merge feature/login
     git push origin develop
     ```

7. **Gerenciando a Branch Principal (main)**:
   - Quando as alterações na `develop` forem validadas e testadas, elas devem ser mescladas com a `main`.
   - Exemplo:
     ```bash
     git checkout main
     git merge develop
     git push origin main
     ```

### Como Rodar o Projeto Localmente

1. **Instalar as Dependências**: Certifique-se de ter o PHP 8+ instalado.
   
   Para rodar o projeto localmente, basta configurar o ambiente de desenvolvimento com o servidor PHP:
   ```bash
   php -S localhost:8000
   ```

2. **Acessando o Sistema**: Abra o navegador e vá até:
   ```
   http://localhost:8000
   ```

### Tarefas em Andamento

Abaixo, uma lista das funcionalidades e tarefas em andamento ou planejadas.

- [ ] **Feature 1**: [Descrição]
- [ ] **Feature 2**: [Descrição]
- [ ] **Hotfix**: [Descrição]
- [ ] **Testes**: [Descrição]

### Documentação de Instalação e Configuração

1. **Requisitos**:
   - PHP 8+
   - Servidor web (por exemplo, Apache ou PHP embutido)
   - Banco de dados (ex: MySQL ou MariaDB)

2. **Configuração do Banco de Dados**:
   - Descreva aqui os passos para configurar o banco de dados, como criar tabelas e inserir dados iniciais, caso necessário.

---

### Como Contribuir

Se você deseja colaborar com o desenvolvimento do projeto, por favor, siga o seguinte fluxo:

1. Crie uma branch a partir da `develop` para a funcionalidade que deseja implementar.
2. Realize alterações e teste as novas funcionalidades.
3. Crie um Pull Request para que a branch seja revisada antes de ser mesclada.

---

### Notas

- Caso haja algum bug, favor reportar via [GitHub Issues](https://github.com/seuusuario/projeto-web-utfpr/issues).
- Para sugestões ou melhorias, abra um Pull Request com a sua contribuição.

---

**Integrantes do Projeto**:

- [Seu Nome] - [Função]
- [Nome do Colega] - [Função]
```

---
