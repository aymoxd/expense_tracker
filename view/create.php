<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);


$title = "Add Transaction";

ob_start();
?>

 <form action="index.php?action=dashboard" method="post">
            <h2>Add transaction</h2>
            <div class="inputBox">
                <label for="amount">Amount *</label>
                <input class="amount" type="number" name="amount">
            </div>
                <div class="inputBox"> 
                <label for="type">type *</label>
                <select name="type">
                    <option value="expense">Expense</option>
                    <option value="income">Income</option>
                </select>
            </div>
            <div class="inputBox">
                <label for="">Description *</label>
                <textarea class="description" name="description" id="" placeholder="Description..."></textarea>
            </div>
            <button class="formBTN" type="submit">add transaction</button>
                
        </form>

<?php $content = ob_get_clean() ?>
<?php require_once 'view/layout.php'; ?>