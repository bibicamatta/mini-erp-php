<?php
require dirname(__DIR__) . '/src/bootstrap.php';
requireLogin();

$pdo = db();
$total = (int) $pdo->query('SELECT COUNT(*) FROM clients')->fetchColumn();
$active = (int) $pdo->query("SELECT COUNT(*) FROM clients WHERE status = 'active'")->fetchColumn();
$inactive = $total - $active;
$companies = (int) $pdo->query("SELECT COUNT(DISTINCT NULLIF(company, '')) FROM clients")->fetchColumn();
$recent = $pdo->query('SELECT * FROM clients ORDER BY created_at DESC LIMIT 6')->fetchAll();
$flash = flash();
$activationRate = $total > 0 ? round(($active / $total) * 100) : 0;
?>
<!doctype html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Mini ERP para gestão de clientes desenvolvido em PHP e MySQL.">
    <title>Mini ERP • Dashboard</title>
    <link rel="stylesheet" href="/assets/style.css">
</head>
<body>
<div class="app-shell">
    <aside class="sidebar">
        <div>
            <a class="brand" href="/index.php">
                <span class="brand-mark">⌘</span>
                <span><strong>mini<span>erp</span></strong><small>portfolio build</small></span>
            </a>
            <nav class="side-nav" aria-label="Navegação principal">
                <a class="active" href="/index.php"><span>⌂</span> Dashboard</a>
                <a href="/clients.php"><span>◈</span> Clientes</a>
            </nav>
        </div>
        <div class="sidebar-footer">
            <div class="profile-mini">
                <div class="avatar"><?= e(strtoupper(substr($_SESSION['user']['name'] ?? 'B', 0, 1))) ?></div>
                <div><strong><?= e($_SESSION['user']['name'] ?? 'Usuário') ?></strong><small>Administrador</small></div>
            </div>
            <a class="logout-link" href="/logout.php">↪ Sair</a>
        </div>
    </aside>

    <main class="main-content">
        <header class="topbar">
            <div>
                <span class="eyebrow">OVERVIEW / <?= strtoupper(date('M Y')) ?></span>
                <h1>Olá, <?= e($_SESSION['user']['name'] ?? 'Beatriz') ?> <span class="wave">👋</span></h1>
                <p>Acompanhe os principais dados do seu relacionamento com clientes.</p>
            </div>
            <a class="button" href="/clients.php#novo-cliente">+ Novo cliente</a>
        </header>

        <?php if ($flash): ?><div class="flash"><span>✓</span><?= e($flash) ?><button type="button" onclick="this.parentElement.remove()" aria-label="Fechar">×</button></div><?php endif; ?>

        <section class="metrics">
            <article class="metric-card">
                <div class="metric-icon">◫</div>
                <div><span>Total de clientes</span><strong><?= $total ?></strong><small>base cadastrada</small></div>
            </article>
            <article class="metric-card accent">
                <div class="metric-icon">✓</div>
                <div><span>Clientes ativos</span><strong><?= $active ?></strong><small><?= $activationRate ?>% da base</small></div>
            </article>
            <article class="metric-card">
                <div class="metric-icon muted-icon">○</div>
                <div><span>Clientes inativos</span><strong><?= $inactive ?></strong><small>podem ser reativados</small></div>
            </article>
            <article class="metric-card">
                <div class="metric-icon">⌂</div>
                <div><span>Empresas</span><strong><?= $companies ?></strong><small>vínculos cadastrados</small></div>
            </article>
        </section>

        <section class="dashboard-grid">
            <article class="panel chart-card">
                <div class="panel-head">
                    <div><span class="eyebrow">HEALTH CHECK</span><h2>Base de clientes</h2></div>
                    <span class="live-badge"><i></i> Atualizado agora</span>
                </div>
                <div class="donut-wrap">
                    <div class="donut" style="--progress: <?= $activationRate ?>%"><div><strong><?= $activationRate ?>%</strong><span>ativos</span></div></div>
                    <div class="legend">
                        <div><span class="dot active-dot"></span><strong><?= $active ?></strong><span>Ativos</span></div>
                        <div><span class="dot inactive-dot"></span><strong><?= $inactive ?></strong><span>Inativos</span></div>
                    </div>
                </div>
            </article>

            <article class="panel insight-card">
                <span class="eyebrow">PORTFOLIO NOTE</span>
                <h2>Construído para demonstrar prática.</h2>
                <p>Autenticação, CRUD, prepared statements, filtros, validação e uma interface responsiva em PHP + MySQL.</p>
                <div class="tech-row"><span>PHP 8+</span><span>PDO</span><span>MySQL</span><span>CSS</span></div>
                <a class="text-link" href="/clients.php">Explorar clientes →</a>
            </article>
        </section>

        <section class="panel">
            <div class="panel-head">
                <div><span class="eyebrow">RECENT</span><h2>Clientes recentes</h2></div>
                <a class="text-link" href="/clients.php">Ver todos →</a>
            </div>
            <div class="table-wrap">
                <table>
                    <thead><tr><th>Cliente</th><th>Empresa</th><th>Status</th><th>Cadastrado</th></tr></thead>
                    <tbody>
                    <?php if (!$recent): ?>
                        <tr><td colspan="4" class="empty">Ainda não existem clientes cadastrados.</td></tr>
                    <?php else: ?>
                        <?php foreach ($recent as $client): ?>
                            <tr>
                                <td><div class="client-cell"><span class="client-avatar"><?= e(strtoupper(substr($client['name'], 0, 1))) ?></span><div><strong><?= e($client['name']) ?></strong><small><?= e($client['email']) ?></small></div></div></td>
                                <td><?= e($client['company'] ?: '—') ?></td>
                                <td><span class="badge <?= e($client['status']) ?>"><?= $client['status'] === 'active' ? 'Ativo' : 'Inativo' ?></span></td>
                                <td class="muted"><?= e(date('d/m/Y', strtotime($client['created_at']))) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </section>
    </main>
</div>
<script src="/assets/app.js"></script>
</body>
</html>
