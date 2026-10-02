# 🧾 Mini ERP — Gestão de Clientes

> **Projeto de portfólio focado na construção de uma aplicação web de gestão de clientes com interface profissional.**

![PHP](https://img.shields.io/badge/PHP-8%2B-777BB4?style=for-the-badge&logo=php&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-8%2B-4479A1?style=for-the-badge&logo=mysql&logoColor=white)
![PDO](https://img.shields.io/badge/PDO-Prepared%20Statements-00F58A?style=for-the-badge)
![Licença](https://img.shields.io/badge/Licen%C3%A7a-MIT-111111?style=for-the-badge)

## 👾 Sobre o projeto

O **Mini ERP** é uma aplicação de gestão de clientes criada para demonstrar um fluxo completo de desenvolvimento web utilizando **PHP 8+, MySQL e PDO**.

O projeto vai além de um CRUD básico e inclui autenticação, proteção contra CSRF, busca e filtros no servidor, paginação, indicadores no painel, interface responsiva e consultas com prepared statements.

### ✨ O que é possível fazer

- 🔐 Entrar no sistema com autenticação baseada em sessão
- 👥 Cadastrar, editar e excluir clientes
- 🔎 Pesquisar clientes por nome, e-mail ou empresa
- 🟢 Filtrar por status ativo/inativo
- 📄 Navegar pelos resultados com paginação
- 📊 Acompanhar métricas da base no painel
- 📱 Utilizar a interface no computador ou celular

## 🧠 O que este projeto demonstra

| Área | Competências demonstradas |
|---|---|
| Backend | PHP 8+, sessões, validação, prepared statements |
| Banco de dados | MySQL, índices, consultas CRUD, PDO |
| Segurança | `password_hash/password_verify`, token CSRF, escape de saída |
| Frontend | HTML5, CSS responsivo, formulários acessíveis |
| Arquitetura | Separação entre `public/`, `src/` e `database/` |
| Fluxo de desenvolvimento | Estrutura pronta para Git/GitHub e configuração por ambiente |

## 🗂️ Estrutura do projeto

```text
mini-erp-php/
├── database/
│   └── schema.sql
├── public/
│   ├── assets/
│   │   ├── app.js
│   │   └── style.css
│   ├── clients.php
│   ├── index.php
│   ├── login.php
│   └── logout.php
├── src/
│   └── bootstrap.php
├── .env.example
├── .gitignore
└── README.md
```

## ▶️ Como executar localmente

### Requisitos

- PHP 8.0+
- MySQL 8.0+
- Extensão PDO MySQL habilitada

### 1. Clone o repositório

```bash
git clone https://github.com/bibicamatta/mini-erp-php.git
cd mini-erp-php
```

### 2. Configure o banco de dados

Copie `.env.example` para `.env` e ajuste as credenciais, se necessário:

```env
DB_HOST=127.0.0.1
DB_PORT=3306
DB_NAME=mini_erp
DB_USER=root
DB_PASS=
```

### 3. Crie o banco

Importe `database/schema.sql` no MySQL. O script cria o banco, as tabelas e registros de demonstração automaticamente.

### 4. Inicie o servidor PHP

```bash
php -S localhost:8000 -t public
```

Abra no navegador:

`http://localhost:8000/login.php`

### 🔑 Acesso de demonstração

```text
E-mail: demo@mini-erp.local
Senha: password
```

> Essas credenciais existem apenas para demonstração local.

## 🔒 Boas práticas de segurança

Este projeto demonstra algumas práticas defensivas comuns em aplicações PHP:

- Verificação de senha com `password_verify`
- Regeneração do ID da sessão após o login
- Tokens CSRF em requisições que alteram dados
- Prepared statements com PDO
- Escape de HTML com `htmlspecialchars`
- Credenciais configuradas por variáveis de ambiente

Para um sistema em produção, seriam necessárias medidas adicionais, como configuração mais rigorosa de cookies de sessão, controle de permissões, rate limiting, logs de auditoria e gerenciamento centralizado de segredos.

## 🚧 Próximos passos

- [ ] Testes unitários e de integração
- [ ] Controle de permissões por perfil
- [ ] Ambiente com Docker
- [ ] API REST para clientes
- [ ] Exportação para CSV
- [ ] Histórico de alterações

## 💡 Por que criei este projeto

Este projeto faz parte do meu portfólio de desenvolvimento e foi criado para praticar o fluxo completo de uma aplicação: **modelagem do banco de dados → lógica de backend → validação → interface → segurança → estrutura preparada para publicação**.

---

<div align="center">

**Feito com PHP, curiosidade e muitos testes.** 💚

`while (aprendendo) { construir(); melhorar(); repetir(); }`

</div>
