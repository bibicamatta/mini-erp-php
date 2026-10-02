<?php
require dirname(__DIR__) . '/src/bootstrap.php';
if (!empty($_SESSION['user'])) { header('Location: /index.php'); exit; }
$error = null;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verifyCsrf($_POST['csrf'] ?? null);
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $stmt = db()->prepare('SELECT id, name, email, password FROM users WHERE email = ?');
    $stmt->execute([$email]);
    $user = $stmt->fetch();
    if ($user && password_verify($password, $user['password'])) {
        session_regenerate_id(true);
        $_SESSION['user'] = ['id' => $user['id'], 'name' => $user['name'], 'email' => $user['email']];
        header('Location: /index.php'); exit;
    }
    $error = 'E-mail ou senha inválidos.';
}
?>
<!doctype html>
<html lang="pt-BR"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1"><meta name="description" content="Login do Mini ERP"><title>Mini ERP • Acesso</title><link rel="stylesheet" href="/assets/style.css"></head>
<body class="auth-page">
<div class="auth-layout">
    <section class="auth-visual"><div class="terminal-top"><span></span><span></span><span></span></div><div class="terminal-copy"><span class="eyebrow">SYSTEM / MINI ERP</span><h1>Organize dados.<br><em>Crie soluções.</em></h1><p>Um projeto de portfólio construído com PHP, MySQL, segurança básica e foco em experiência de uso.</p><div class="terminal-line"><span>beatriz@dev</span>:<b>~/mini-erp</b>$ <i>php artisan? não. PHP raiz. 😎</i></div></div></section>
    <main class="auth-wrap"><form class="auth panel" method="post"><div class="auth-brand"><span class="brand-mark">⌘</span><div><strong>mini<span>erp</span></strong><small>portfolio build</small></div></div><span class="eyebrow">AUTHENTICATION</span><h2>Bem-vinda de volta</h2><p class="muted">Entre para acessar o painel.</p><?php if ($error): ?><div class="error">⚠ <?= e($error) ?></div><?php endif; ?><input type="hidden" name="csrf" value="<?= e(csrfToken()) ?>"><label>E-mail<input name="email" type="email" required autocomplete="username" value="demo@mini-erp.local"></label><label>Senha<input name="password" type="password" required autocomplete="current-password" value="password"></label><button class="button auth-button" type="submit">Entrar no painel <span>→</span></button><div class="demo-hint"><span>DEMO ACCESS</span><code>demo@mini-erp.local</code><code>password</code></div></form></main>
</div>
</body></html>
