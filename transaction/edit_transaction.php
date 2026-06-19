<?php

require_once '../config/db.php';
session_start();
$id = $_GET['id'];

#get the trasaction info from the table
$stmt = $pdo->prepare("SELECT * FROM transactions WHERE id = ? ");
$stmt->execute([ $id ]);
$transaction = $stmt->fetch(PDO::FETCH_ASSOC);

#get the new info from the user
$errors = [];
if($_SERVER['REQUEST_METHOD'] == 'POST'){
      $amount = htmlspecialchars(trim($_POST['amount']));
      $type = htmlspecialchars(trim($_POST['type']));
      $description = htmlspecialchars(trim($_POST['description']));

      #check if the inputs are empty
      if(empty($amount) || empty($type) || empty($description)){
        $errors[] = "all inputs are required!";
      }



       #check list of errors 
      if(empty($errors)){
        #get the date
        $date = date("y-m-d");
        #update to db her
        $stmt = $pdo->prepare("UPDATE transactions SET amount = ? , type = ? , description = ? , created_at = ? WHERE id = ?");
        $updated = $stmt->execute([
          $amount,
          $type,
          $description,
          $date,
          $id
        ]);
        if($updated){
               $_SESSION['msg'] = "transaction updated seccussfully!";
               $_SESSION['error'] = "noerror";
               header("Location: ../index.php");
               exit;
        }else{
               $_SESSION['msg'] = "field add transaction";
               $_SESSION['error'] = "error";
                header("Location: ../index.php");
               exit;
        }


      }else{
        foreach($errors as $e){
            echo "<div class='formError'> $e </div>";
        }
      }
      
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../asset/css/index.css">
    <title>Edit</title>
</head>
<body>
    <div class="editContainer">
        <form class="editForm" method="post">
        <a href="../index.php" class="back">back⟶</a>
            <h2>Edit transaction</h2>
            <div class="inputBox">
                <label for="amount">Amount *</label>
                <input class="amount" type="number" name="amount" value="<?= htmlspecialchars($transaction['amount']) ?>">
            </div>
                <div class="inputBox"> 
                <label for="type">type *</label>
                <select name="type">
                    <option <?php echo $transaction['type'] == 'expend' ? 'selected' : ''; ?> value="expense">Expense</option>
                    <option <?php echo $transaction['type'] == 'income' ? 'selected' : ''; ?> value="income">Income</option>
                </select>
            </div>
            <div class="inputBox">
                <label for="">Description</label>
                <textarea class="description" name="description" id="" placeholder="Description..."><?= htmlspecialchars($transaction['description']) ?></textarea>
            </div>
            <button class="formBTN" type="submit">Edit transaction</button>
                
        </form>
    </div>
</body>
</html>

















