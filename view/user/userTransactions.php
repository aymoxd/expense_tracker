<?php
    $title = 'all Transactions';
    
    ob_start();
?>
 

<header class="admin-header">


    <div>
        <h1>all transactions</h1>
        <p class="users-page-intro">View all your transactions .</p>
    </div>
   
</header>

<section class="admin-section users-section" aria-labelledby="users-heading">
    <div class="users-toolbar">
        <div class="users-count-block">
            <p class="admin-label">Directory</p>
            <h2 id="users-heading">total Transactions <span><?= htmlspecialchars($totalTransactions) ?></span></h2>
        </div>
        <!--  
        <form class="users-filters"  action="index.php" method="get" role="search">
            <input type="hidden" name="action" value="">
            <label class="users-search">
                <i class="ri-search-line" aria-hidden="true"></i>
                <span class="sr-only">Search users</span>
                <input type="search" name="search" placeholder="Search transactions..." value="<?= htmlspecialchars((string) ($_GET['search'] ?? ''), ENT_QUOTES, 'UTF-8') ?>">
            </label>
            <button class="users-search-button" type="submit">Search</button>
        </form>
        -->
    </div>

    <div class="users-table-wrap">
        <table class="users-table">
            <thead><tr>
                <th scope="col">Date</th>
                <th scope="col">Amount</th>
                <th scope="col">Type</th>
                <th scope="col">Description</th>
            </tr></thead>
            <tbody>
            <?php if (!$transactions): ?>
                <tr><td colspan="6" class="users-empty">
                    <span class="users-empty-icon"><i class="ri-user-search-line" aria-hidden="true"></i></span>
                    <strong>No transactions to display</strong>
                    <span>transactions matching your search will appear here.</span>
                </td></tr>
            <?php else: ?>
                <?php foreach ($transactions as $transaction):  ?>
                <tr>
                        <td><?= htmlspecialchars($transaction->created_at) ?></td>
                        <td><?= htmlspecialchars($transaction->amount) ?></td>
                        <td><?= htmlspecialchars($transaction->type) ?></td>
                        <td><?= htmlspecialchars($transaction->description) ?></td>
                 </tr>
                <?php endforeach; ?>
            <?php endif; ?>
            </tbody>
        </table>
    </div>

    <div class="pagination">
        <?php if($page > 1): ?>
            <a href="index.php?action=userTransactions&page=<?= htmlspecialchars( $page - 1 ) ?>">previous</a>
        <?php endif; ?>
        <!-- create the pages -->
         <?php for($i = 1; $i <= $totalPages; $i++): ?>
            <a 
            href="index.php?action=userTransactions&page=<?= htmlspecialchars($i) ?>"
            class="<?= ($page === $i) ? 'active' : '' ?>"
            > <?= $i ?> </a>
         <?php endfor; ?>
          <?php if($page < $totalPages): ?>
           <a href="index.php?action=userTransactions&page=<?= htmlspecialchars( $page + 1 ) ?>">next</a>
          <?php endif; ?>
    </div>


</section>
<?php
    $content = ob_get_clean();
    require_once 'view/user/layout.php';
?>
