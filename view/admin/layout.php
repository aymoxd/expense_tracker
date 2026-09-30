<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/expens_tracker/asset/css/index.css">
    <link rel="stylesheet" href="/expens_tracker/asset/css/auth.css">
    <link rel="stylesheet" href="/expens_tracker/asset/css/user-layout.css">
    <link rel="stylesheet" href="/expens_tracker/asset/css/admin-users.css">
    <?php require_once 'view/includes/header_libraries.php'; ?>
    <title><?= $title ?></title>
</head>
<body>

    <div class="admin-layout user-layout">
        <aside id="user-sidebar" class="admin-sidebar user-sidebar" aria-label="Admin navigation">
            <div class="admin-brand user-brand">
                <i class="ri-shield-user-line user-brand-icon" aria-hidden="true"></i>
                <span>Admin Panel</span>
            </div>

            <p class="user-nav-label">Workspace</p>
            <nav class="admin-nav user-nav">
                <a href="index.php?action=admin" class="admin-nav-link user-nav-link<?= ($_GET['action'] ?? 'admin') === 'admin' ? ' active' : '' ?>"<?= ($_GET['action'] ?? 'admin') === 'admin' ? ' aria-current="page"' : '' ?>>
                    <i class="ri-dashboard-line" aria-hidden="true"></i>
                    <span>Dashboard</span>
                </a>
                <a href="index.php?action=adminUsers" class="admin-nav-link user-nav-link<?= ($_GET['action'] ?? '') === 'users' ? ' active' : '' ?>"<?= ($_GET['action'] ?? '') === 'users' ? ' aria-current="page"' : '' ?>>
                    <i class="ri-user-line" aria-hidden="true"></i>
                    <span>Users</span>
                </a>
                <a href="index.php?action=adminTransactions" class="admin-nav-link user-nav-link<?= ($_GET['action'] ?? '') === 'adminTransactions' ? ' active' : '' ?>"<?= ($_GET['action'] ?? '') === 'adminTransactions' ? ' aria-current="page"' : '' ?>>
                    <i class="ri-wallet-3-line" aria-hidden="true"></i>
                    <span>Transactions</span>
                </a>
                <a href="index.php?action=dashboard" class="admin-nav-link user-nav-link">
                    <i class="ri-arrow-left-line" aria-hidden="true"></i>
                    <span>Back to App</span>
                </a>
                <hr>
                 <a href="index.php?action=dashboard" class="admin-nav-link user-nav-link">
                    <i class="ri-arrow-left-line" aria-hidden="true"></i>
                    <span>Profile</span>
                </a>
                   <a href="index.php?action=dashboard" class="admin-nav-link user-nav-link">
                    <i class="ri-arrow-left-line" aria-hidden="true"></i>
                    <span>Setting</span>
                </a>
            </nav>

            <div class="user-sidebar-bottom">
                <a href="index.php?action=logout" class="admin-logout user-nav-link user-logout">
                    <i class="ri-logout-box-r-line" aria-hidden="true"></i>
                    <span>Logout</span>
                </a>
            </div>
        </aside>

        <button class="user-sidebar-overlay" type="button" tabindex="-1" aria-label="Close navigation"></button>
        <button class="user-sidebar-toggle" type="button" aria-controls="user-sidebar" aria-expanded="true" aria-label="Hide sidebar" title="Hide sidebar">
            <i class="ri-layout-left-line" aria-hidden="true"></i>
        </button>

        <main class="admin-main">
            <?= $content ?>
        </main>
    </div>
    <script src="/expens_tracker/asset/scripts/sidebar.js"></script>
</body>
</html>
