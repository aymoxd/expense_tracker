<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/expens_tracker/asset/css/index.css">
    <link rel="stylesheet" href="/expens_tracker/asset/css/auth.css">
    <link rel="stylesheet" href="/expens_tracker/asset/css/user-layout.css">
    <?php require_once 'view/includes/header_libraries.php'; ?>
    <title><?= $title ?></title>
</head>
<body>
    

    <div class="user-layout">
        <aside id="user-sidebar" class="user-sidebar" aria-label="Main navigation">
            <a class="user-brand" href="index.php?action=dashboard" aria-label="Expense Tracker home">
                <span class="user-brand-icon"><i class="ri-wallet-3-line" aria-hidden="true"></i></span>
                <span>Expense<span class="user-brand-light">Track</span></span>
            </a>

            <p class="user-nav-label">Workspace</p>
            <nav class="user-nav">
                <a class="user-nav-link" href="index.php?action=dashboard">
                    <i class="ri-layout-grid-line" aria-hidden="true"></i><span>Dashboard</span>
                </a>
                <a class="user-nav-link" href="index.php?action=create">
                    <i class="ri-add-circle-line" aria-hidden="true"></i><span>Add transaction</span>
                </a>
            </nav>

            <div class="user-sidebar-bottom">
                <a class="user-nav-link user-logout" href="index.php?action=logout">
                    <i class="ri-logout-box-r-line" aria-hidden="true"></i><span>Log out</span>
                </a>
            </div>
        </aside>

        <button class="user-sidebar-overlay" type="button" tabindex="-1" aria-label="Close navigation"></button>
        <button class="user-sidebar-toggle" type="button" aria-controls="user-sidebar" aria-expanded="true" aria-label="Hide sidebar" title="Hide sidebar">
            <i class="ri-layout-left-line" aria-hidden="true"></i>
        </button>

        <main class="user-main">
            <?= $content ?>
        </main>
    </div>
    
    <script src="/expens_tracker/asset/scripts/sidebar.js"></script>
</body>
</html>