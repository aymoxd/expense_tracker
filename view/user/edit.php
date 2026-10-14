<?php

$title = "Edit Transaction";

ob_start();
?>

    <section class="createContainer">
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
        <form class="createForm" action="index.php?action=update" method="post">
            <h2>Edit Transaction</h2>
            <div class="inputBox">
                <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
                <input type="hidden" name="transactionId" value="<?= htmlspecialchars($userTransaction->id) ?>">
                <label for="amount">Amount *</label>
                <input class="amount" id="amount" type="number" name="amount" value="<?= htmlspecialchars($userTransaction->amount) ?>" required>
            </div>
                <div class="inputBox"> 
                <label for="type">Type *</label>
                <select id="type" name="type" required>
                    <option <?=  $userTransaction->type === 'expense'? 'selected' : '' ?> value="expense">Expense</option>
                    <option  <?= $userTransaction->type === 'income'? 'selected' : '' ?>  value="income">Income</option>
                </select>
            </div>
            <div class="inputBox">
                <label for="description">Description *</label>
                <textarea class="description" name="description" id="description" placeholder="Description..."  required><?= htmlspecialchars($userTransaction->description) ?></textarea>
            </div>
            <button class="formBTN" type="submit">Edit transaction</button>
                
        </form>
    </section>

<?php $content = ob_get_clean() ?>
<?php require_once 'view/user/layout.php'; ?>
