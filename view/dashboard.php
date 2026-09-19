<?php
$title = "Dashboard";
ob_start();
?>

    <a href="index.php?action=create" class="add" aria-label="Add a new transaction" title="Add transaction">
        <i class="ri-add-large-line" aria-hidden="true"></i>
        <span>Add transaction</span>
    </a>

  <div class="container">
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
    
      
        <div class="header">
               <h1 class="title">Welcome, <i><?= ucfirst($_SESSION['username']) ?></i></h1>
               <a class="logOut" href="index.php?action=logout"><i class="ri-logout-box-r-line"></i> Log out</a>
        </div>
        
       <div class="numbersBox">
         <div class="box gridCustum">
                <i class="ri-wallet-3-line icon"></i>
                <p>Current Balance</p>
                <h1 class="digit"><?= htmlspecialchars($curentBalance) ?> MAD</h1>
            </div>
                 <div class="box">
                <i class="ri-arrow-up-circle-line icon"></i>
                <p>Expense</p>
                <h1 class="digit"><?= htmlspecialchars($expense) ?> MAD</h1>
            </div>
            <div class="box">
                <i class="ri-arrow-down-circle-line icon"></i>
                <p>Income</p>
                <h1 class="digit"><?=htmlspecialchars($income) ?> MAD</h1>
            </div>
          
             
        </div> 
       


        <h2>Transactions</h2>

       <!-- table  -->
        <div class="table">
            <?php 
             if(count($transactions) > 0):
             ?>
            <?php foreach($transactions as $transaction): ?>

            <div class="row">
                <div class="data">  <?= htmlspecialchars($transaction->created_at) ?>  </div>
                <div class="data">
                     <?php echo $transaction->type == 'income' ? '+' : '-' ; ?>
                     <?= htmlspecialchars($transaction->amount) ?> MAD
                </div>
                <div class="data"><?= htmlspecialchars($transaction->type) ?></div>
                <div class="data"><?= htmlspecialchars($transaction->description) ?></div>
                 <div class="data">
                      <a id="edit" href="index.php?action=edit&id=<?= $transaction->id ?>"><i class="ri-pencil-fill"></i> Edit</a>
                      <a id="delete" href="index.php?action=delete&id=<?= $transaction->id ?>" onclick="return confirm('Are you sure you want to delete this transaction?');"><i class="ri-delete-bin-line"></i> Delete</a>
                 </div>
            </div>

           

           <?php endforeach; ?>
           <?php else:?>
                    <h1 class="tableVide">No transactions yet.</h1>
             <?php endif; ?>
        </div>

    </div>

<?php $content = ob_get_clean(); ?>
<?php include_once 'view/layout.php'; ?>
