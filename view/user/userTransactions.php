<?php
$title = 'All transactions';
$lastPage = max(1, (int) ($totalPages ?? 1));
$currentPage = min($lastPage, max(1, (int) ($page ?? 1)));
$searchTerm = trim($_GET['search'] ?? '');
$selectedType = $_GET['type'] ?? '';
$pageNumbers = range(max(1, $currentPage - 2), min($lastPage, $currentPage + 2));
$pageUrl = static function (int $targetPage) use ($searchTerm, $selectedType): string {
    return 'index.php?' . http_build_query([
        'action' => 'userTransactions',
        'page' => $targetPage,
        'search' => $searchTerm,
        'type' => $selectedType,
    ]);
};
ob_start();
?>
<style>
    .transactions-page { padding: 42px 0 64px; color: #172033; }
    .transactions-heading { display: flex; align-items: flex-end; justify-content: space-between; gap: 24px; margin: 0 0 28px; }
    .transactions-eyebrow { margin: 0 0 8px; color: #64748b; font-size: .76rem; font-weight: 750; letter-spacing: .1em; text-transform: uppercase; }
    .transactions-heading h1 { margin: 0; color: #111827; font-size: clamp(1.8rem, 4vw, 2.5rem); letter-spacing: -.045em; }
    .transactions-heading p:last-child { margin: 9px 0 0; color: #64748b; }
    .transactions-add { display: inline-flex; min-height: 46px; flex: 0 0 auto; align-items: center; justify-content: center; gap: 9px; padding: 0 17px; border-radius: 12px; background: #2563eb; color: #fff; font-weight: 700; text-decoration: none; box-shadow: 0 8px 18px rgba(37, 99, 235, .18); transition: background .16s ease, transform .16s ease; }
    .transactions-add:hover { transform: translateY(-1px); background: #1d4ed8; }
    .transactions-toolbar { display: flex; flex-wrap: wrap; align-items: center; gap: 10px; margin-bottom: 22px; padding: 14px; border: 1px solid #e7ebf2; border-radius: 16px; background: #fff; }
    .transactions-search { display: flex; min-width: min(280px, 100%); flex: 1 1 300px; align-items: center; gap: 10px; padding: 0 13px; border: 1px solid #e2e8f0; border-radius: 10px; background: #f8fafc; color: #94a3b8; }
    .transactions-search input { width: 100%; min-height: 42px; border: 0; outline: 0; background: transparent; color: #172033; font: inherit; }
    .transactions-toolbar select { min-height: 44px; min-width: 140px; padding: 0 34px 0 12px; border: 1px solid #e2e8f0; border-radius: 10px; background: #fff; color: #334155; font: inherit; }
    .transactions-filter-button { min-height: 44px; padding: 0 18px; border: 0; border-radius: 10px; background: #172033; color: #fff; font: inherit; font-weight: 700; cursor: pointer; }
    .transactions-filter-button:hover { background: #26354f; }
    .transaction-grid { display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 16px; }
    .transaction-card { position: relative; min-width: 0; padding: 20px; overflow: hidden; border: 1px solid #e7ebf2; border-radius: 17px; background: #fff; box-shadow: 0 5px 18px rgba(15, 23, 42, .035); transition: border-color .18s ease, box-shadow .18s ease, transform .18s ease; }
    .transaction-card:hover { transform: translateY(-2px); border-color: #cbd5e1; box-shadow: 0 12px 28px rgba(15, 23, 42, .075); }
    .transaction-card-top, .transaction-card-bottom { display: flex; align-items: center; justify-content: space-between; gap: 14px; }
    .transaction-kind { display: inline-flex; align-items: center; gap: 8px; color: #475569; font-size: .78rem; font-weight: 750; letter-spacing: .035em; text-transform: uppercase; }
    .transaction-kind-icon { display: grid; width: 38px; height: 38px; flex: 0 0 auto; place-items: center; border-radius: 12px; font-size: 1.2rem; }
    .transaction-card.is-income .transaction-kind-icon { background: #e9f9f0; color: #16834c; }
    .transaction-card.is-expense .transaction-kind-icon { background: #fff0ed; color: #d44c36; }
    .transaction-date { color: #7b8798; font-size: .83rem; text-align: right; }
    .transaction-amount { margin: 18px 0 6px; color: #172033; font-size: clamp(1.45rem, 3vw, 1.8rem); font-weight: 800; letter-spacing: -.04em; overflow-wrap: anywhere; }
    .transaction-card.is-income .transaction-amount { color: #16834c; }
    .transaction-card.is-expense .transaction-amount { color: #d44c36; }
    .transaction-description { min-height: 1.5em; margin: 0 0 20px; color: #64748b; line-height: 1.5; overflow-wrap: anywhere; }
    .transaction-card-bottom { padding-top: 14px; border-top: 1px solid #f0f2f6; }
    .transaction-badge { padding: 6px 10px; border-radius: 999px; background: #f1f5f9; color: #475569; font-size: .75rem; font-weight: 700; }
    .transaction-actions { display: flex; align-items: center; gap: 8px; }
    .transaction-action { display: inline-flex; min-height: 34px; align-items: center; justify-content: center; gap: 6px; padding: 0 10px; border: 1px solid #e2e8f0; border-radius: 9px; background: #fff; color: #475569; font: inherit; font-size: .8rem; font-weight: 650; text-decoration: none; cursor: pointer; }
    .transaction-action:hover { border-color: #cbd5e1; background: #f8fafc; color: #172033; }
    .transaction-action-delete:hover { border-color: #fecaca; background: #fff1f2; color: #b42318; }
    .transaction-action-form { margin: 0; }
    .transactions-empty { grid-column: 1 / -1; padding: 54px 20px; border: 1px dashed #cbd5e1; border-radius: 17px; background: #fff; text-align: center; }
    .transactions-empty i { color: #94a3b8; font-size: 2rem; }
    .transactions-empty h2 { margin: 12px 0 6px; color: #172033; font-size: 1.1rem; }
    .transactions-empty p { margin: 0; color: #64748b; }
    .transactions-pagination { display: flex; flex-wrap: wrap; align-items: center; justify-content: center; gap: 7px; margin-top: 28px; }
    .transactions-pagination a, .transactions-pagination span { display: grid; min-width: 38px; height: 38px; place-items: center; padding: 0 10px; border: 1px solid #e2e8f0; border-radius: 10px; background: #fff; color: #475569; font-size: .86rem; font-weight: 650; text-decoration: none; }
    .transactions-pagination a:hover { border-color: #93c5fd; color: #1d4ed8; }
    .transactions-pagination a[aria-current="page"] { border-color: #2563eb; background: #2563eb; color: #fff; }
    .transactions-pagination .pagination-ellipsis { border-color: transparent; background: transparent; }
    .transactions-flash { margin-bottom: 18px; }
    @media (max-width: 760px) { .transactions-page { padding-top: 72px; } .transaction-grid { grid-template-columns: 1fr; } }
    @media (max-width: 520px) { .transactions-heading { align-items: flex-start; flex-direction: column; gap: 16px; } .transactions-add { width: 100%; } .transactions-toolbar { align-items: stretch; padding: 11px; } .transactions-search { flex-basis: 100%; } .transactions-toolbar select, .transactions-filter-button { flex: 1; } .transaction-card { padding: 17px; } .transaction-card-top { align-items: flex-start; } .transaction-date { max-width: 45%; } .transaction-actions { gap: 5px; } .transaction-action { padding: 0 8px; } }
    @media (prefers-reduced-motion: reduce) { .transactions-add, .transaction-card { transition: none; } }
</style>

<main class="container transactions-page">
    <?php if (!empty($_SESSION['success'])): ?>
        <div class="noerror flashMessage transactions-flash" role="status" aria-live="polite">
            <?= htmlspecialchars($_SESSION['success'], ENT_QUOTES, 'UTF-8') ?>
            <button class="closeMessage" type="button" aria-label="Dismiss message" onclick="this.closest('.flashMessage').remove()"><i class="ri-close-line" aria-hidden="true"></i></button>
        </div>
        <?php unset($_SESSION['success']); ?>
    <?php endif; ?>
    <?php if (!empty($_SESSION['errors'])): ?>
        <div class="error flashMessage transactions-flash" role="alert" aria-live="assertive">
            <ul><?php foreach ($_SESSION['errors'] as $error): ?><li><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></li><?php endforeach; ?></ul>
            <button class="closeMessage" type="button" aria-label="Dismiss message" onclick="this.closest('.flashMessage').remove()"><i class="ri-close-line" aria-hidden="true"></i></button>
        </div>
        <?php unset($_SESSION['errors']); ?>
    <?php endif; ?>

    <header class="transactions-heading">
        <div>
            <p class="transactions-eyebrow">Your activity</p>
            <h1>Transactions</h1>
            <p>Every income and expense, all in one place.</p>
        </div>
        <a href="index.php?action=create" class="transactions-add"><i class="ri-add-line" aria-hidden="true"></i> Add transaction</a>
    </header>

    <form class="transactions-toolbar" action="index.php" method="get" role="search">
        <input type="hidden" name="action" value="userTransactions">
        <label class="transactions-search"><i class="ri-search-line" aria-hidden="true"></i><input type="search" name="search" placeholder="Search transactions..." value="<?= htmlspecialchars($searchTerm, ENT_QUOTES, 'UTF-8') ?>" aria-label="Search transactions"></label>
        <select name="type" aria-label="Filter by transaction type">
            <option value="">All types</option>
            <option value="income" <?= $selectedType === 'income' ? 'selected' : '' ?>>Income</option>
            <option value="expense" <?= $selectedType === 'expense' ? 'selected' : '' ?>>Expense</option>
        </select>
        <button class="transactions-filter-button" type="submit">Filter</button>
    </form>

    <section class="transaction-grid" aria-label="Your transactions">
        <?php if (!empty($transactions)): ?>
            <?php foreach ($transactions as $transaction): ?>
                <?php $isIncome = $transaction->type === 'income'; ?>
                <article class="transaction-card <?= $isIncome ? 'is-income' : 'is-expense' ?>">
                    <div class="transaction-card-top">
                        <div class="transaction-kind">
                            <span class="transaction-kind-icon"><i class="<?= $isIncome ? 'ri-arrow-down-left-line' : 'ri-arrow-up-right-line' ?>" aria-hidden="true"></i></span>
                            <?= $isIncome ? 'Money in' : 'Money out' ?>
                        </div>
                        <time class="transaction-date" datetime="<?= htmlspecialchars(date('Y-m-d', strtotime($transaction->created_at)), ENT_QUOTES, 'UTF-8') ?>">
                            <?= htmlspecialchars(date('M d, Y', strtotime($transaction->created_at)), ENT_QUOTES, 'UTF-8') ?>
                        </time>
                    </div>
                    <p class="transaction-amount"><?= $isIncome ? '+' : '−' ?><?= htmlspecialchars($transaction->amount, ENT_QUOTES, 'UTF-8') ?> MAD</p>
                    <p class="transaction-description"><?= htmlspecialchars($transaction->description ?: 'No description', ENT_QUOTES, 'UTF-8') ?></p>
                    <div class="transaction-card-bottom">
                        <span class="transaction-badge"><?= $isIncome ? 'Income' : 'Expense' ?></span>
                        <div class="transaction-actions">
                            <a class="transaction-action" href="index.php?action=edit&amp;id=<?= (int) $transaction->id ?>"><i class="ri-pencil-line" aria-hidden="true"></i><span>Edit</span></a>
                            <form class="transaction-action-form" action="index.php?action=delete" method="post" onsubmit="return confirm('Are you sure you want to delete this transaction?');">
                                <input type="hidden" name="transactionId" value="<?= (int) $transaction->id ?>">
                                <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
                                <button class="transaction-action transaction-action-delete" type="submit"><i class="ri-delete-bin-line" aria-hidden="true"></i><span>Delete</span></button>
                            </form>
                        </div>
                    </div>
                </article>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="transactions-empty">
                <i class="ri-receipt-line" aria-hidden="true"></i>
                <h2>No transactions found</h2>
                <p>Try changing your search or add your first transaction.</p>
            </div>
        <?php endif; ?>
    </section>

    <?php if ($lastPage > 1): ?>
        <nav class="transactions-pagination" aria-label="Transaction pages">
            <?php if ($currentPage > 1): ?><a href="<?= htmlspecialchars($pageUrl($currentPage - 1), ENT_QUOTES, 'UTF-8') ?>" aria-label="Previous page"><i class="ri-arrow-left-s-line" aria-hidden="true"></i> Previous</a><?php endif; ?>
            <?php if ($pageNumbers[0] > 1): ?>
                <a href="<?= htmlspecialchars($pageUrl(1), ENT_QUOTES, 'UTF-8') ?>">1</a>
                <?php if ($pageNumbers[0] > 2): ?><span class="pagination-ellipsis" aria-hidden="true">…</span><?php endif; ?>
            <?php endif; ?>
            <?php foreach ($pageNumbers as $number): ?>
                <a href="<?= htmlspecialchars($pageUrl($number), ENT_QUOTES, 'UTF-8') ?>" <?= $number === $currentPage ? 'aria-current="page"' : '' ?>><?= $number ?></a>
            <?php endforeach; ?>
            <?php if (end($pageNumbers) < $lastPage): ?>
                <?php if (end($pageNumbers) < $lastPage - 1): ?><span class="pagination-ellipsis" aria-hidden="true">…</span><?php endif; ?>
                <a href="<?= htmlspecialchars($pageUrl($lastPage), ENT_QUOTES, 'UTF-8') ?>"><?= $lastPage ?></a>
            <?php endif; ?>
            <?php if ($currentPage < $lastPage): ?><a href="<?= htmlspecialchars($pageUrl($currentPage + 1), ENT_QUOTES, 'UTF-8') ?>" aria-label="Next page">Next <i class="ri-arrow-right-s-line" aria-hidden="true"></i></a><?php endif; ?>
        </nav>
    <?php endif; ?>
</main>

<?php $content = ob_get_clean(); ?>
<?php include_once 'view/user/layout.php'; ?>
