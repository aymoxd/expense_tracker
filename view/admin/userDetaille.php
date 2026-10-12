<?php
$title = 'User Details';

ob_start();
?>
<header class="admin-header user-detail-header">
    <div>
        <p class="admin-label">Administration</p>
        <h1>User Details</h1>
        <p class="users-page-intro">Account information for your workspace member.</p>
    </div>
    <a class="user-detail-back" href="index.php?action=adminUsers">
        <i class="ri-arrow-left-line" aria-hidden="true"></i> Back to users
    </a>
</header>

<?php if (!empty($detailUser)): ?>
    <div class="user-detail-grid">
        <section class="user-detail-card user-detail-profile" aria-labelledby="user-detail-name">
            <div class="user-detail-cover" aria-hidden="true"></div>
            <div class="user-detail-profile-body">
                <span class="user-detail-avatar" aria-hidden="true"><?= htmlspecialchars(mb_strtoupper(mb_substr($detailUser->name ?? '?', 0, 1)), ENT_QUOTES, 'UTF-8') ?></span>
                <h2 id="user-detail-name"><?= htmlspecialchars($detailUser->name ?? 'Unnamed user', ENT_QUOTES, 'UTF-8') ?></h2>
                <p class="user-detail-email"><?= htmlspecialchars($detailUser->email ?? '', ENT_QUOTES, 'UTF-8') ?></p>
                <span class="users-role <?= strtolower($detailUser->role ?? '') === 'admin' ? 'users-role-admin' : '' ?>"><?= htmlspecialchars(ucfirst($detailUser->role ?? 'user'), ENT_QUOTES, 'UTF-8') ?></span>
                <div class="user-detail-member">
                    <i class="ri-calendar-line" aria-hidden="true"></i>
                    <span>Joined <?= !empty($detailUser->created_at) ? htmlspecialchars(date('M j, Y', strtotime($detailUser->created_at)), ENT_QUOTES, 'UTF-8') : 'Not available' ?></span>
                </div>
            </div>
        </section>

        <section class="user-detail-card" aria-labelledby="user-detail-account">
            <div class="user-detail-card-heading">
                <span class="user-detail-heading-icon"><i class="ri-user-settings-line" aria-hidden="true"></i></span>
                <div>
                    <h2 id="user-detail-account">Account information</h2>
                    <p>Personal details and workspace role.</p>
                </div>
            </div>
            <dl class="user-detail-fields">
                <div><dt>Full name</dt><dd><?= htmlspecialchars($detailUser->name ?? 'Not available', ENT_QUOTES, 'UTF-8') ?></dd></div>
                <div><dt>Email address</dt><dd><?= htmlspecialchars($detailUser->email ?? 'Not available', ENT_QUOTES, 'UTF-8') ?></dd></div>
                <div><dt>User ID</dt><dd>#<?= (int) $detailUser->id ?></dd></div>
                <div><dt>Account role</dt><dd><?= htmlspecialchars(ucfirst($detailUser->role ?? 'user'), ENT_QUOTES, 'UTF-8') ?></dd></div>
                <div><dt>Joined on</dt><dd><?= !empty($detailUser->created_at) ? htmlspecialchars(date('M j, Y', strtotime($detailUser->created_at)), ENT_QUOTES, 'UTF-8') : 'Not available' ?></dd></div>
                   <form  
                    action="index.php?action=adminDeleteUser"
                    method="post"
                    onsubmit="return confirm('are you sur you want to delete this user ?');">
                    
                            <input type="hidden" name="id" value="<?= $detailUser->id ?>">
                            <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
                            <button id="delete" type="submit">
                                <i class="ri-delete-bin-line"></i>
                                 Delete
                            </button>
                    </form>
            </dl>
        </section>
    </div>
<?php else: ?>
    <section class="user-detail-card user-detail-empty" aria-labelledby="user-detail-empty-heading">
        <span class="users-empty-icon"><i class="ri-user-search-line" aria-hidden="true"></i></span>
        <h2 id="user-detail-empty-heading">User details unavailable</h2>
        <p>Return to the directory to select a user.</p>
        <a class="user-detail-back" href="index.php?action=adminUsers">Back to users <i class="ri-arrow-right-line" aria-hidden="true"></i></a>
    </section>
<?php endif; ?>

<?php
$content = ob_get_clean();
require 'view/admin/layout.php';
?>
