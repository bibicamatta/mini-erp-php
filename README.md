# 🧾 Mini ERP — Customer Management

> **A portfolio project focused on building a real-world CRUD application with a polished business interface.**

![PHP](https://img.shields.io/badge/PHP-8%2B-777BB4?style=for-the-badge&logo=php&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-8%2B-4479A1?style=for-the-badge&logo=mysql&logoColor=white)
![PDO](https://img.shields.io/badge/PDO-Prepared%20Statements-00F58A?style=for-the-badge)
![License](https://img.shields.io/badge/License-MIT-111111?style=for-the-badge)

## 👾 About the project

Mini ERP is a customer management application created to demonstrate an end-to-end web development flow using **PHP 8+, MySQL and PDO**.

The project goes beyond a basic CRUD: it includes authentication, CSRF protection, server-side search and filtering, pagination, dashboard indicators, responsive UI and prepared statements.

### ✨ What you can do

- 🔐 Authenticate with session-based login
- 👥 Create, edit and delete customers
- 🔎 Search customers by name, e-mail or company
- 🟢 Filter by active/inactive status
- 📄 Navigate through paginated results
- 📊 Track customer metrics from the dashboard
- 📱 Use the interface on desktop or mobile

## 🧠 What this project demonstrates

| Area | Demonstrated skills |
|---|---|
| Backend | PHP 8+, sessions, validation, prepared statements |
| Database | MySQL, indexes, CRUD queries, PDO |
| Security | `password_hash/password_verify`, CSRF token, output escaping |
| Frontend | HTML5, responsive CSS, accessible forms |
| Architecture | Separation between `public/`, `src/` and `database/` |
| Dev workflow | Git/GitHub-ready structure and environment configuration |

## 🗂️ Project structure

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

## ▶️ Running locally

### Requirements

- PHP 8.0+
- MySQL 8.0+
- PDO MySQL extension

### 1. Clone

```bash
git clone https://github.com/bibicamatta/mini-erp-php.git
cd mini-erp-php
```

### 2. Configure the database

Copy `.env.example` to `.env` and adjust the credentials if necessary:

```env
DB_HOST=127.0.0.1
DB_PORT=3306
DB_NAME=mini_erp
DB_USER=root
DB_PASS=
```

### 3. Create the database

Import `database/schema.sql` into MySQL. The script creates the database, tables and demo records automatically.

### 4. Start PHP

```bash
php -S localhost:8000 -t public
```

Open:

`http://localhost:8000/login.php`

### 🔑 Demo account

```text
E-mail: demo@mini-erp.local
Senha: password
```

> This credential exists only for local demonstration.

## 🔒 Security notes

This project intentionally demonstrates a few defensive practices commonly used in PHP applications:

- Password verification with `password_verify`
- Session ID regeneration after login
- CSRF tokens on state-changing requests
- PDO prepared statements
- HTML escaping with `htmlspecialchars`
- Credentials stored through environment variables

For a production system, the application would require additional hardening such as stronger session cookie configuration, authorization policies, rate limiting, audit logs and centralized environment/secret management.

## 🚧 Roadmap

- [ ] Unit and integration tests
- [ ] Role-based permissions
- [ ] Docker environment
- [ ] REST API for customers
- [ ] Export to CSV
- [ ] Audit history

## 💡 Why I built it

This project is part of my developer portfolio and was created to practice the complete path from **database design → backend logic → validation → UI → security → deployment-ready structure**.

---

<div align="center">

**Built with PHP, curiosity and a lot of debugging.** 💚

`while (learning) { build(); improve(); repeat(); }`

</div>
