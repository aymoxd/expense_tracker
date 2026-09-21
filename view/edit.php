<?php

$title = "Edit Transaction";

ob_start();
?>

    <section class="createContainer">
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
<?php require_once 'layout.php'; ?>
