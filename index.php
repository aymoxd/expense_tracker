<?php
    require_once 'config/db.php';
    session_start();

    if(!isset($_SESSION['user']) || empty($_SESSION['user'])){
        header("Location: auth/login.php");
        exit;  
    }
    $username = $_SESSION['user'];
    $user_id = $_SESSION['user_id'];
    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="asset/css/index.css">
    <title>Dashbord</title>
</head>
<body>

    <div class="container">
        <div class="<?php echo $_SESSION['error']?> msg">
             <?php if($_SESSION['msg']): ?>
                 <?php  
                 echo $_SESSION['msg'] . "<br>";
                 unset($_SESSION['msg']);
                 unset($_SESSION['error']);
                 ?>
                 <span onclick="document.querySelector('.msg').style.display = 'none';" id="close">✕</span>
             <?php endif; ?>
        </div>
        <div class="header">
               <h2 class="title">welcom <?= htmlspecialchars($username) ?></h2>
               <a href="auth/logout.php">logout</a>
        </div>
        <?php
   
        #get just the income
        $sqlIncome = $pdo->prepare("SELECT SUM(amount) as income FROM transactions Where type = 'income' AND user_id = ?");
        $sqlIncome->execute([ $user_id ]);
        $income = $sqlIncome->fetch(PDO::FETCH_ASSOC);
        $income = $income['income'] ?? 0;

        #get just the expense
        $sqlExpense = $pdo->prepare("SELECT SUM(amount) as expense FROM transactions Where type = 'expense' AND user_id = ?");
        $sqlExpense->execute([ $user_id ]);
        $expense = $sqlExpense->fetch(PDO::FETCH_ASSOC);
        $expense = $expense['expense'] ?? 0;
        

        #calcule the current balance
        $balance = $income - $expense;

        #get the table of transaction
        $stmt = $pdo->prepare("SELECT * FROM transactions WHERE user_id = ?");
        $stmt->execute([ $user_id ]);
        $transactions = $stmt->fetchAll(PDO::FETCH_ASSOC);
     

        
        
        ?>
        <div class="numbersBox">
            <div class="box">
                <p>Income</p>
                <h1><?= htmlspecialchars($income) ?> MAD</h1>
            </div>
               <div class="box">
                <p>Expence</p>
                <h1><?= htmlspecialchars($expense) ?> MAD</h1>
            </div>
              <div class="box gridCustum">
                <p>Current Balance</p>
                <h1><?= htmlspecialchars($balance) ?> MAD</h1>
            </div>
           
        </div>
        <h2>transactions :</h2>
        <div class="table">
            <?php if(count($transactions) > 0):?>
            <table border="1">
                <thead>
                    <tr>
                        <td>date</td>
                        <td>amount</td>
                        <td>type</td>
                        <td>description</td>
                        <td>operations</td>
                    </tr>
                </thead>
                     <tbody>
                    <?php foreach($transactions as $transaction): ?>
                        <tr>
                            <td><?= htmlspecialchars($transaction['created_at']) ?></td>
                            <td>
                                <?php echo $transaction['type'] == 'income' ? '+' : '-' ; ?>
                                <?= htmlspecialchars($transaction['amount']) ?> MAD
                            </td>
                            <td><?= htmlspecialchars($transaction['type']) ?></td>
                            <td><?= htmlspecialchars($transaction['description']) ?></td>
                            <td>
                                <a id="edit" href="transaction/edit_transaction.php?id=<?= $transaction['id'] ?>">Edit</a>
                                <a href="transaction/delete_transaction.php?id=<?= $transaction['id'] ?>" onclick="return confirm('are you sur you want to delete this transaction ?');">Delete</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
               
            </table>
             <?php else:?>
                    <h1 class="tableVide">NO TRANSACTION EXIST!</h1>
             <?php endif; ?>

        </div>
    </div>

    <!-- add transaction btn -->
    <button class="add">+</button>
    <div title="click her to close the popup" class="overlay"></div>
    <div class="popup">
        <span class="closePopup">✕</span>
        <form action="transaction/add_transaction.php" method="post">
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
                <label for="">Description</label>
                <textarea class="description" name="description" id="" placeholder="Description..."></textarea>
            </div>
            <button class="formBTN" type="submit">add transaction</button>
                
        </form>
    </div>

    <script src="asset/scripts/main.js"></script>
</body>
</html>