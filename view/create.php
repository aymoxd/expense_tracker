<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);


$title = "Add Transaction";

ob_start();
?>

    <section class="createContainer">

          <?php if (!empty($_SESSION['errors'])): ?>
          <div class="authAlert authAlert--error" role="alert" aria-live="assertive">
            <i class="ri-error-warning-line" aria-hidden="true"></i>
            <div>
              <p class="authAlert__title">Unable to create Transaction</p>
              <ul>
                <?php foreach ($_SESSION['errors'] as $error): ?>
                  <li><?= htmlspecialchars($error) ?></li>
                <?php endforeach; ?>
              </ul>
            </div>
          </div>
          <?php unset($_SESSION['errors']); ?>
        <?php endif; ?>

        <form class="createForm" action="index.php?action=store" method="post">
            <h2>Add Transaction</h2>
            <div class="inputBox">
                <label for="amount">Amount *</label>
                <input class="amount" id="amount" type="number" name="amount" required>
            </div>
                <div class="inputBox"> 
                <label for="type">Type *</label>
                <select id="type" name="type" required>
                    <option value="expense">Expense</option>
                    <option value="income">Income</option>
                </select>
            </div>
            <div class="inputBox">
                <label for="description">Description *</label>
                <textarea class="description" name="description" id="description" placeholder="Description..." required></textarea>
            </div>
            <button class="formBTN" type="submit">Add Transaction</button>
                
        </form>
    </section>

<?php $content = ob_get_clean() ?>
<?php require_once 'layout.php'; ?>
