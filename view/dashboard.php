<?php
$title = "dashboard";
ob_start();
?>

  <div class="container">
    <!--   <div class="<?php echo $_SESSION['error']?> msg">
             <?php if($_SESSION['msg']): ?>
                 <?php  
                 echo $_SESSION['msg'] . "<br>";
                 unset($_SESSION['msg']);
                 unset($_SESSION['error']);
                 ?>
                 <span onclick="document.querySelector('.msg').style.display = 'none';" id="close">✕</span>
             <?php endif; ?>
        </div>
   -->
      
        <div class="header">
               <h1 class="title">Welcom <i> <?= ucfirst($_SESSION['user']) ?> </i> </h1>
               <a class="logOut" href="auth/logout.php"><i class="ri-logout-box-r-line"></i> logout</a>
        </div>
        
       <div class="numbersBox">
            <div class="box">
                <i class="ri-arrow-down-circle-line icon"></i>
                <p>Income</p>
                <h1 class="digit"><?=htmlspecialchars($income) ?> MAD</h1>
            </div>
               <div class="box">
                <i class="ri-arrow-up-circle-line icon"></i>
                <p>Expence</p>
                <h1 class="digit"><?= htmlspecialchars($expense) ?> MAD</h1>
            </div>
              <div class="box gridCustum">
                <i class="ri-wallet-3-line icon"></i>
                <p>Current Balance</p>
                <h1 class="digit"><?= htmlspecialchars($curentBalance) ?> MAD</h1>
            </div>
        </div> 
       


        <h2>transactions :</h2>

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
                      <a id="edit" href="transaction/edit_transaction.php?id=<?= $transaction->id ?>"><i class="ri-pencil-fill"></i> Edit</a>
                      <a id="delete" href="transaction/delete_transaction.php?id=<?= $transaction->id ?>" onclick="return confirm('are you sur you want to delete this transaction ?');"><i class="ri-delete-bin-line"></i> Delete</a>
                 </div>
            </div>

           

           <?php endforeach; ?>
           <?php else:?>
                    <h1 class="tableVide">NO TRANSACTION EXIST!</h1>
             <?php endif; ?>
        </div>

    </div>

<?php $content = ob_get_clean(); ?>
<?php include_once 'view/layout.php'; ?>