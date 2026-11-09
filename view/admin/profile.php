<?php
$title = 'Admin profile';
$adminName = trim((string) ($_SESSION['username'] ?? 'Administrator'));
$adminInitial = mb_strtoupper(mb_substr($adminName !== '' ? $adminName : 'A', 0, 1, 'UTF-8'), 'UTF-8');
ob_start();
?>
<style>
    .admin-profile-page { width: min(1120px, calc(100% - 64px)); margin: 0 auto; padding: 46px 0 64px; color: #172033; }
    .profile-heading { margin-bottom: 28px; }
    .profile-eyebrow { margin: 0 0 8px; color: #64748b; font-size: .76rem; font-weight: 750; letter-spacing: .1em; text-transform: uppercase; }
    .profile-heading h1 { margin: 0; color: #111827; font-size: clamp(1.8rem, 4vw, 2.45rem); letter-spacing: -.045em; }
    .profile-heading p:last-child { margin: 9px 0 0; color: #64748b; }
    .profile-main-card { display: grid; grid-template-columns: auto minmax(0, 1fr) auto; align-items: center; gap: 22px; padding: clamp(22px, 4vw, 34px); border: 1px solid #e7ebf2; border-radius: 20px; background: linear-gradient(120deg, #fff 40%, #f4f8ff); box-shadow: 0 10px 30px rgba(15, 23, 42, .045); }
    .profile-avatar { display: grid; width: 82px; height: 82px; place-items: center; border: 5px solid #fff; border-radius: 24px; background: linear-gradient(145deg, #dbeafe, #bfdbfe); color: #1d4ed8; font-size: 2rem; font-weight: 800; box-shadow: 0 4px 14px rgba(37, 99, 235, .12); }
    .profile-name { margin: 0; color: #111827; font-size: clamp(1.35rem, 3vw, 1.75rem); letter-spacing: -.03em; overflow-wrap: anywhere; }
    .profile-role { display: inline-flex; align-items: center; gap: 7px; margin-top: 9px; padding: 6px 10px; border-radius: 999px; background: #eff6ff; color: #1d4ed8; font-size: .76rem; font-weight: 750; }
    .profile-role i { font-size: .95rem; }
    .profile-id { align-self: stretch; display: flex; flex-direction: column; justify-content: center; min-width: 120px; padding-left: 22px; border-left: 1px solid #e2e8f0; }
    .profile-id span { color: #64748b; font-size: .75rem; font-weight: 700; letter-spacing: .06em; text-transform: uppercase; }
    .profile-id strong { margin-top: 5px; color: #172033; font-size: 1.05rem; }
    .profile-section { margin-top: 30px; }
    .profile-section-heading { margin-bottom: 15px; }
    .profile-section-heading h2 { margin: 0; color: #172033; font-size: 1.15rem; }
    .profile-section-heading p { margin: 6px 0 0; color: #64748b; font-size: .9rem; }
    .profile-shortcuts { display: grid; grid-template-columns: repeat(3, minmax(0, 1fr)); gap: 15px; }
    .profile-shortcut { display: flex; min-height: 150px; flex-direction: column; align-items: flex-start; padding: 20px; border: 1px solid #e7ebf2; border-radius: 16px; background: #fff; color: inherit; text-decoration: none; box-shadow: 0 4px 15px rgba(15, 23, 42, .025); transition: transform .18s ease, border-color .18s ease, box-shadow .18s ease; }
    .profile-shortcut:hover { transform: translateY(-2px); border-color: #bfdbfe; box-shadow: 0 10px 25px rgba(15, 23, 42, .07); }
    .profile-shortcut-icon { display: grid; width: 42px; height: 42px; place-items: center; border-radius: 13px; background: #eff6ff; color: #2563eb; font-size: 1.3rem; }
    .profile-shortcut strong { margin-top: 17px; color: #172033; font-size: .98rem; }
    .profile-shortcut span:last-child { margin-top: 5px; color: #64748b; font-size: .84rem; line-height: 1.5; }
    .profile-security-note { display: flex; align-items: flex-start; gap: 13px; padding: 18px 20px; border: 1px solid #dbeafe; border-radius: 15px; background: #f5f9ff; }
    .profile-security-note > i { margin-top: 2px; color: #2563eb; font-size: 1.2rem; }
    .profile-security-note strong { color: #1e3a8a; font-size: .9rem; }
    .profile-security-note p { margin: 5px 0 0; color: #526782; font-size: .85rem; line-height: 1.55; }
    @media (max-width: 760px) { .admin-profile-page { width: min(100% - 32px, 1120px); padding-top: 76px; } .profile-main-card { grid-template-columns: auto minmax(0, 1fr); } .profile-id { grid-column: 1 / -1; min-height: 54px; padding: 13px 0 0; border-top: 1px solid #e2e8f0; border-left: 0; } .profile-shortcuts { grid-template-columns: 1fr; } .profile-shortcut { min-height: 0; } }
    @media (max-width: 460px) { .admin-profile-page { width: calc(100% - 28px); } .profile-main-card { gap: 15px; padding: 19px; } .profile-avatar { width: 64px; height: 64px; border-radius: 19px; font-size: 1.6rem; } }
    @media (prefers-reduced-motion: reduce) { .profile-shortcut { transition: none; } }
</style>

<main class="admin-profile-page">
    <header class="profile-heading">
        <p class="profile-eyebrow">Administration</p>
        <h1>Your profile</h1>
        <p>Account overview and useful shortcuts for your workspace.</p>
    </header>

    <section class="profile-main-card" aria-labelledby="profile-name">
        <div class="profile-avatar" aria-hidden="true"><?= htmlspecialchars($adminInitial, ENT_QUOTES, 'UTF-8') ?></div>
        <div>
            <h2 class="profile-name" id="profile-name"><?= htmlspecialchars($adminName !== '' ? $adminName : 'Administrator', ENT_QUOTES, 'UTF-8') ?></h2>
            <span class="profile-role"><i class="ri-shield-user-line" aria-hidden="true"></i> Administrator</span>
        </div>
        <div class="profile-id"><span>Account ID</span><strong>#<?= (int) ($_SESSION['userId'] ?? 0) ?></strong></div>
    </section>

    <section class="profile-section" aria-labelledby="profile-shortcuts-heading">
        <div class="profile-section-heading">
            <h2 id="profile-shortcuts-heading">Helpful shortcuts</h2>
            <p>Jump to the areas you use most.</p>
        </div>
        <div class="profile-shortcuts">
            <a class="profile-shortcut" href="index.php?action=admin">
                <span class="profile-shortcut-icon"><i class="ri-dashboard-line" aria-hidden="true"></i></span>
                <strong>Admin dashboard</strong>
                <span>Review workspace activity and account totals.</span>
            </a>
            <a class="profile-shortcut" href="index.php?action=adminUsers">
                <span class="profile-shortcut-icon"><i class="ri-team-line" aria-hidden="true"></i></span>
                <strong>Manage users</strong>
                <span>Search accounts and review user details.</span>
            </a>
            <a class="profile-shortcut" href="index.php?action=dashboard">
                <span class="profile-shortcut-icon"><i class="ri-wallet-3-line" aria-hidden="true"></i></span>
                <strong>Open expense tracker</strong>
                <span>Go to your personal transaction dashboard.</span>
            </a>
        </div>
    </section>

    <section class="profile-section profile-security-note" aria-label="Account security tip">
        <i class="ri-lock-line" aria-hidden="true"></i>
        <div>
            <strong>Keep your admin account secure</strong>
            <p>Sign out when you finish on a shared device. Use the Logout link in the sidebar to end your session.</p>
        </div>
    </section>
</main>

<?php $content = ob_get_clean(); ?>
<?php require_once 'view/admin/layout.php'; ?>
