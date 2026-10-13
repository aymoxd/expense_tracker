<?php

$title = "Admin Dashboard";

ob_start();
?>

<header class="admin-header">


    <?php if (!empty($_SESSION['success'])): ?>
            <div class="noerror flashMessage" role="status" aria-live="polite">
                <?= htmlspecialchars($_SESSION['success']) ?>
                <button class="closeMessage" type="button" aria-label="Dismiss message" onclick="this.closest('.flashMessage').remove()">
                    <i class="ri-close-line" aria-hidden="true"></i>
                </button>
            </div>
            <?php unset($_SESSION['success']); ?>
        <?php endif; ?>

        <?php if (!empty($_SESSION['errors'])): ?>
            <div class="error flashMessage" role="alert" aria-live="assertive">
                <ul>
                    <?php foreach ($_SESSION['errors'] as $error): ?>
                        <li><?= htmlspecialchars($error) ?></li>
                    <?php endforeach; ?>
                </ul>
                <button class="closeMessage" type="button" aria-label="Dismiss message" onclick="this.closest('.flashMessage').remove()">
                    <i class="ri-close-line" aria-hidden="true"></i>
                </button>
            </div>
            <?php unset($_SESSION['errors']); ?>
        <?php endif; ?>


        <div>
            <p class="admin-label">Administration</p>
            <h1>Dashboard</h1>
        </div>

      

    </header>


    <!-- Statistics -->
    <section class="admin-stats">

        <div class="admin-card">
            <div class="admin-card-icon">
                <i class="ri-user-line"></i>
            </div>

            <div>
                <p>Total Users</p>
                <h2> <?= htmlspecialchars($totalUsers) ?> </h2>
            </div>
        </div>


        <div class="admin-card">
            <div class="admin-card-icon">
                <i class="ri-exchange-line"></i>
            </div>

            <div>
                <p>Total Transactions</p>
                <h2><?= htmlspecialchars($totalTransactions) ?> </h2>
            </div>
        </div>


        <div class="admin-card">
            <div class="admin-card-icon">
                <i class="ri-arrow-up-circle-line"></i>
            </div>

            <div>
                <p>Total Income</p>
                <h2><?= htmlspecialchars($totalIncome) ?>  MAD</h2>
            </div>
        </div>


        <div class="admin-card">
            <div class="admin-card-icon">
                <i class="ri-arrow-down-circle-line"></i>
            </div>

            <div>
                <p>Total Expenses</p>
                <h2><?= htmlspecialchars($totalExpense) ?>  MAD</h2>
            </div>
        </div>

    </section>


    <!-- Quick actions -->
    <section class="admin-section">

        <div class="section-header">
            <div>
                <p class="admin-label">Management</p>
                <h2>Quick Actions</h2>
            </div>
        </div>

        <div class="quick-actions">

            <a href="index.php?action=adminUsers" class="quick-action">
                <i class="ri-group-line"></i>

                <div>
                    <strong>Manage Users</strong>
                    <span>View and manage application users</span>
                </div>

                <i class="ri-arrow-right-line arrow"></i>
            </a>


            <a href="index.php?action=adminTransactions" class="quick-action">
                <i class="ri-file-list-3-line"></i>

                <div>
                    <strong>Manage Transactions</strong>
                    <span>View and manage all transactions</span>
                </div>

                <i class="ri-arrow-right-line arrow"></i>
            </a>

        </div>

    </section>


    <!-- Recent activity -->
    <section class="admin-section">

        <div class="section-header">
            <div>
                <p class="admin-label">Overview</p>
                <h2>Recent Activity</h2>
            </div>

            <a href="index.php?action=adminTransactions">
                View all
            </a>
        </div>

        <div class="activity-table-wrap">
            <table class="activity-table">
                <thead>
                    <tr>
                        <th scope="col">User</th>
                        <th scope="col">Activity</th>
                        <th scope="col">Amount</th>
                        <th scope="col">desc</th>
                        <th scope="col">Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($recentActivity)): ?>
                        <tr>
                            <td class="activity-empty" colspan="4">
                                <i class="ri-inbox-line" aria-hidden="true"></i>
                                <strong>No recent activity yet</strong>
                                <span>New transactions will appear here.</span>
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($recentActivity as $activity): ?>
                            <?php $isIncome = strtolower((string) $activity->type) === 'income'; ?>
                            <tr>
                                <td>
                                    <span class="activity-user-avatar" aria-hidden="true"><i class="ri-user-line"></i></span>
                                    <span class="activity-user-name"><?= htmlspecialchars($activity->name, ENT_QUOTES, 'UTF-8') ?></span>
                                </td>
                                <td>
                                    <span class="activity-type <?= $isIncome ? 'activity-type-income' : 'activity-type-expense' ?>">
                                        <i class="<?= $isIncome ? 'ri-arrow-down-line' : 'ri-arrow-up-line' ?>" aria-hidden="true"></i>
                                        <?= htmlspecialchars(ucfirst((string) $activity->type), ENT_QUOTES, 'UTF-8') ?>
                                    </span>
                                </td>
                                <td class="activity-amount <?= $isIncome ? 'activity-amount-income' : 'activity-amount-expense' ?>">
                                    <?= $isIncome ? '+' : '−' ?><?= number_format((float) $activity->amount, 2) ?> <span>MAD</span>
                                </td>
                                 <td class="activity-desc">
                                   <?= ((string) $activity->description) ?>
                                </td>
                                <td class="activity-date">
                                    <time datetime="<?= htmlspecialchars(date(DATE_ATOM, strtotime($activity->created_at)), ENT_QUOTES, 'UTF-8') ?>">
                                        <?= htmlspecialchars(date('M j, Y · H:i', strtotime($activity->created_at)), ENT_QUOTES, 'UTF-8') ?>
                                    </time>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>

        <div class="pagination">
        <?php if($page > 1): ?>
            <a href="index.php?action=admin&page=<?= htmlspecialchars( $page - 1 ) ?>">previous</a>
        <?php endif; ?>
        <!-- create the pages -->
         <?php for($i = 1; $i <= $totalPages; $i++): ?>
            <a 
            href="index.php?action=admin&page=<?= htmlspecialchars($i) ?>"
            class="<?= ($page === $i) ? 'active' : '' ?>"
            > <?= $i ?> </a>
         <?php endfor; ?>
          <?php if($page < $totalPages): ?>
           <a href="index.php?action=admin&page=<?= htmlspecialchars( $page + 1 ) ?>">next</a>
          <?php endif; ?>
        </div>


        </div>

    </section>


<?php

$content = ob_get_clean();

require_once 'view/admin/layout.php';
?>
