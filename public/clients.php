<?php
require dirname(__DIR__) . '/src/bootstrap.php';
requireLogin();
$pdo = db();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verifyCsrf($_POST['csrf'] ?? null);
    $action = $_POST['action'] ?? '';

    if ($action === 'save') {
        $id = (int) ($_POST['id'] ?? 0);
        $name = trim($_POST['name'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $phone = trim($_POST['phone'] ?? '');
        $company = trim($_POST['company'] ?? '');
        $status = ($_POST['status'] ?? 'active') === 'inactive' ? 'inactive' : 'active';

        if ($name === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            flash('Informe um nome e um e-mail válido.');
        } elseif ($id > 0) {
            $stmt = $pdo->prepare('UPDATE clients SET name=?, email=?, phone=?, company=?, status=? WHERE id=?');
            $stmt->execute([$name, $email, $phone, $company, $status, $id]);
            flash('Cliente atualizado com sucesso.');
        } else {
            $stmt = $pdo->prepare('INSERT INTO clients (name,email,phone,company,status) VALUES (?,?,?,?,?)');
            $stmt->execute([$name, $email, $phone, $company, $status]);
            flash('Cliente cadastrado com sucesso.');
        }
        header('Location: /clients.php'); exit;
    }

    if ($action === 'delete') {
        $stmt = $pdo->prepare('DELETE FROM clients WHERE id = ?');
        $stmt->execute([(int) $_POST['id']]);
        flash('Cliente removido.');
        header('Location: /clients.php'); exit;
    }
}

$edit = null;
if (isset($_GET['edit'])) {
    $stmt = $pdo->prepare('SELECT * FROM clients WHERE id = ?');
    $stmt->execute([(int) $_GET['edit']]);
    $edit = $stmt->fetch() ?: null;
}

$search = trim($_GET['q'] ?? '');
$statusFilter = $_GET['status'] ?? '';
$page = max(1, (int) ($_GET['page'] ?? 1));
$perPage = 8;
$offset = ($page - 1) * $perPage;

$where = [];
$params = [];
if ($search !== '') {
    $where[] = '(name LIKE :search OR email LIKE :search OR company LIKE :search)';
    $params['search'] = '%' . $search . '%';
}
if (in_array($statusFilter, ['active', 'inactive'], true)) {
    $where[] = 'status = :status';
    $params['status'] = $statusFilter;
}
$whereSql = $where ? ' WHERE ' . implode(' AND ', $where) : '';
$countStmt = $pdo->prepare("SELECT COUNT(*) FROM clients{$whereSql}");
$countStmt->execute($params);
$totalFiltered = (int) $countStmt->fetchColumn();
$totalPages = max(1, (int) ceil($totalFiltered / $perPage));
$page = min($page, $totalPages);
$offset = ($page - 1) * $perPage;

$listStmt = $pdo->prepare("SELECT * FROM clients{$whereSql} ORDER BY id DESC LIMIT :limit OFFSET :offset");
foreach ($params as $key => $value) {
    $listStmt->bindValue(':' . $key, $value);
}
$listStmt->bindValue(':limit', $perPage, PDO::PARAM_INT);
$listStmt->bindValue(':offset', $offset, PDO::PARAM_INT);
$listStmt->execute();
$clients = $listStmt->fetchAll();
$flash = flash();
?>
<!doctype html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="CRUD de clientes do Mini ERP.">
    <title>Mini ERP • Clientes</title><link rel="stylesheet" href="/assets/style.css">
</head>
<body>
<div class="app-shell">
    <aside class="sidebar">
        <div>
            <a class="brand" href="/index.php"><span class="brand-mark">⌘</span><span><strong>mini<span>erp</span></strong><small>portfolio build</small></span></a>
            <nav class="side-nav" aria-label="Navegação principal"><a href="/index.php"><span>⌂</span> Dashboard</a><a class="active" href="/clients.php"><span>◈</span> Clientes</a></nav>
        </div>
        <div class="sidebar-footer"><div class="profile-mini"><div class="avatar"><?= e(strtoupper(substr($_SESSION['user']['name'] ?? 'B', 0, 1))) ?></div><div><strong><?= e($_SESSION['user']['name'] ?? 'Usuário') ?></strong><small>Administrador</small></div></div><a class="logout-link" href="/logout.php">↪ Sair</a></div>
    </aside>

    <main class="main-content">
        <header class="topbar compact-topbar">
            <div><span class="eyebrow">CRM / CLIENTES</span><h1>Clientes</h1><p>Cadastre, pesquise e mantenha sua base organizada.</p></div>
            <a class="button" href="#novo-cliente">+ Novo cliente</a>
        </header>

        <?php if ($flash): ?><div class="flash"><span>✓</span><?= e($flash) ?><button type="button" onclick="this.parentElement.remove()" aria-label="Fechar">×</button></div><?php endif; ?>

        <section id="novo-cliente" class="panel form-panel">
            <div class="panel-head"><div><span class="eyebrow"><?= $edit ? 'EDIT MODE' : 'QUICK CREATE' ?></span><h2><?= $edit ? 'Editar cliente' : 'Novo cliente' ?></h2></div><?php if ($edit): ?><a class="text-link" href="/clients.php">Cancelar edição</a><?php endif; ?></div>
            <form class="grid-form" method="post">
                <input type="hidden" name="csrf" value="<?= e(csrfToken()) ?>"><input type="hidden" name="action" value="save"><input type="hidden" name="id" value="<?= (int) ($edit['id'] ?? 0) ?>">
                <label>Nome<input name="name" required placeholder="Ex.: Marina Oliveira" value="<?= e($edit['name'] ?? '') ?>"></label>
                <label>E-mail<input name="email" type="email" required placeholder="marina@empresa.com" value="<?= e($edit['email'] ?? '') ?>"></label>
                <label>Telefone<input name="phone" placeholder="(11) 99999-9999" value="<?= e($edit['phone'] ?? '') ?>"></label>
                <label>Empresa<input name="company" placeholder="Nome da empresa" value="<?= e($edit['company'] ?? '') ?>"></label>
                <label>Status<select name="status"><option value="active" <?= (($edit['status'] ?? 'active') === 'active') ? 'selected' : '' ?>>Ativo</option><option value="inactive" <?= (($edit['status'] ?? '') === 'inactive') ? 'selected' : '' ?>>Inativo</option></select></label>
                <div class="form-actions"><button class="button" type="submit"><?= $edit ? 'Salvar alterações' : 'Cadastrar cliente' ?></button></div>
            </form>
        </section>

        <section class="panel">
            <div class="panel-head table-title"><div><span class="eyebrow">DATABASE</span><h2>Base de clientes</h2></div><span class="muted"><?= $totalFiltered ?> registro<?= $totalFiltered === 1 ? '' : 's' ?></span></div>
            <form class="filters" method="get">
                <div class="search-box"><span>⌕</span><input name="q" value="<?= e($search) ?>" placeholder="Buscar por nome, e-mail ou empresa..."></div>
                <select name="status"><option value="">Todos os status</option><option value="active" <?= $statusFilter === 'active' ? 'selected' : '' ?>>Ativos</option><option value="inactive" <?= $statusFilter === 'inactive' ? 'selected' : '' ?>>Inativos</option></select>
                <button class="button ghost-dark" type="submit">Filtrar</button>
                <?php if ($search !== '' || $statusFilter !== ''): ?><a class="button ghost" href="/clients.php">Limpar</a><?php endif; ?>
            </form>
            <div class="table-wrap">
                <table>
                    <thead><tr><th>Cliente</th><th>Empresa</th><th>Telefone</th><th>Status</th><th class="align-right">Ações</th></tr></thead>
                    <tbody>
                    <?php if (!$clients): ?><tr><td colspan="5" class="empty"><strong>Nenhum cliente encontrado.</strong><span>Tente outro termo de busca ou cadastre um novo cliente.</span></td></tr><?php else: ?>
                        <?php foreach ($clients as $client): ?>
                        <tr>
                            <td><div class="client-cell"><span class="client-avatar"><?= e(strtoupper(substr($client['name'], 0, 1))) ?></span><div><strong><?= e($client['name']) ?></strong><small><?= e($client['email']) ?></small></div></div></td>
                            <td><?= e($client['company'] ?: '—') ?></td><td><?= e($client['phone'] ?: '—') ?></td>
                            <td><span class="badge <?= e($client['status']) ?>"><?= $client['status'] === 'active' ? 'Ativo' : 'Inativo' ?></span></td>
                            <td><div class="actions"><a href="?edit=<?= (int) $client['id'] ?>#novo-cliente">Editar</a><form method="post" onsubmit="return confirm('Remover este cliente?')"><input type="hidden" name="csrf" value="<?= e(csrfToken()) ?>"><input type="hidden" name="action" value="delete"><input type="hidden" name="id" value="<?= (int) $client['id'] ?>"><button type="submit">Excluir</button></form></div></td>
                        </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                    </tbody>
                </table>
            </div>
            <?php if ($totalPages > 1): ?>
            <div class="pagination"><span>Página <?= $page ?> de <?= $totalPages ?></span><div><?php if ($page > 1): ?><a class="page-link" href="?q=<?= urlencode($search) ?>&status=<?= urlencode($statusFilter) ?>&page=<?= $page-1 ?>">← Anterior</a><?php endif; ?><?php if ($page < $totalPages): ?><a class="page-link" href="?q=<?= urlencode($search) ?>&status=<?= urlencode($statusFilter) ?>&page=<?= $page+1 ?>">Próxima →</a><?php endif; ?></div></div>
            <?php endif; ?>
        </section>
    </main>
</div>
<script src="/assets/app.js"></script>
</body>
</html>
