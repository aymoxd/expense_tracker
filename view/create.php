<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);


$title = "Add Transaction";

ob_start();
?>

    <section class="createContainer">
        <form class="createForm" action="index.php?action=store" method="post">
            <h2>Add transaction</h2>
            <div class="inputBox">
                <label for="amount">Amount *</label>
                <input class="amount" id="amount" type="number" name="amount" required>
            </div>
                <div class="inputBox"> 
                <label for="type">type *</label>
                <select id="type" name="type" required>
                    <option value="expense">Expense</option>
                    <option value="income">Income</option>
                </select>
            </div>
            <div class="inputBox">
                <label for="description">Description *</label>
                <textarea class="description" name="description" id="description" placeholder="Description..." required></textarea>
            </div>
            <button class="formBTN" type="submit">add transaction</button>
                
        </form>
    </section>

<?php $content = ob_get_clean() ?>
<?php require_once 'layout.php'; ?>
