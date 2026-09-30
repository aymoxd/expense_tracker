<?php
    $title = 'Manage Users';
    
    ob_start();
?>
<header class="admin-header">
    <div>
        <p class="admin-label">Administration</p>
        <h1>Manage Users</h1>
        <p class="users-page-intro">View account details and activity across your workspace.</p>
    </div>
    <div class="admin-user">
        <i class="ri-admin-line" aria-hidden="true"></i>
        <a href="index.php?action=adminProfile">
            <strong><?= htmlspecialchars($_SESSION['username'] ?? 'Admin', ENT_QUOTES, 'UTF-8') ?></strong>
            <small>Administrator</small>
        </a>
    </div>
</header>

<section class="admin-section users-section" aria-labelledby="users-heading">
    <div class="users-toolbar">
        <div class="users-count-block">
            <p class="admin-label">Directory</p>
            <h2 id="users-heading">Users <span><?= htmlspecialchars($totalUsers) ?></span></h2>
        </div>
        <form class="users-filters" method="get" action="index.php" role="search">
            <input type="hidden" name="action" value="users">
            <label class="users-search">
                <i class="ri-search-line" aria-hidden="true"></i>
                <span class="sr-only">Search users</span>
                <input type="search" name="search" placeholder="Search users..." value="<?= htmlspecialchars((string) ($_GET['search'] ?? ''), ENT_QUOTES, 'UTF-8') ?>">
            </label>
            <label class="users-role-filter">
                <span class="sr-only">Filter by role</span>
                <select name="role" onchange="this.form.submit()">
                    <?php $selectedRole = (string) ($_GET['role'] ?? ''); ?>
                    <option value="" <?= $selectedRole === '' ? 'selected' : '' ?>>All roles</option>
                    <option value="user" <?= $selectedRole === 'user' ? 'selected' : '' ?>>User</option>
                    <option value="admin" <?= $selectedRole === 'admin' ? 'selected' : '' ?>>Admin</option>
                </select>
                <i class="ri-arrow-down-s-line" aria-hidden="true"></i>
            </label>
            <button class="users-search-button" type="submit">Search</button>
        </form>
    </div>

    <div class="users-table-wrap">
        <table class="users-table">
            <thead><tr>
                <th scope="col">User</th>
                <th scope="col">Email</th>
                <th scope="col">Role</th>
                <th scope="col">Joined</th>
                <th scope="col" class="users-actions-heading">Actions</th>
            </tr></thead>
            <tbody>
            <?php if (!$users): ?>
                <tr><td colspan="6" class="users-empty">
                    <span class="users-empty-icon"><i class="ri-user-search-line" aria-hidden="true"></i></span>
                    <strong>No users to display</strong>
                    <span>Users matching your search will appear here.</span>
                </td></tr>
            <?php else: ?>
                <?php foreach ($users as $user):  ?>
                <tr>
                    <td><div class="users-identity"><span class="users-avatar" aria-hidden="true"><?= htmlspecialchars(mb_strtoupper(mb_substr($user->name, 0, 1)), ENT_QUOTES, 'UTF-8') ?></span><strong><?= htmlspecialchars($user->name, ENT_QUOTES, 'UTF-8') ?></strong></div></td>
                    <td class="users-email"><?= htmlspecialchars($user->email, ENT_QUOTES, 'UTF-8') ?></td>
                    <td><span class="users-role <?= strtolower($user->role) === 'admin' ? 'users-role-admin' : '' ?>"><?= htmlspecialchars(ucfirst($user->role), ENT_QUOTES, 'UTF-8') ?></span></td>
                    <td class="users-date"><?= $user->created_at ? htmlspecialchars( date('M j, Y',(string)strtotime($user->created_at)) ,ENT_QUOTES,'UTF-8') : "---" ?></td>
                    <td class="users-actions"><a href="index.php?action=usersDetaille" aria-label="User actions for <?= htmlspecialchars($user->name, ENT_QUOTES, 'UTF-8') ?>" title="User actions"><i class="ri-eye-line" aria-hidden="true"></i></a></td>
                </tr>
                <?php endforeach; ?>
            <?php endif; ?>
            </tbody>
        </table>
    </div>

    
</section>
<?php
    $content = ob_get_clean();
    require_once 'view/admin/layout.php';
?>
