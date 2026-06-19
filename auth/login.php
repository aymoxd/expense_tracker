<?php

     session_start();
     #connection with database
     require_once "../config/db.php";
  
  $errors = [];
  if($_SERVER['REQUEST_METHOD'] == 'POST'){

      $email = htmlspecialchars($_POST['email']);
      $password = htmlspecialchars($_POST['password']);

      #check if the inputs are empty
      if(empty($email) || empty($password)){
        $errors[] = "all inputs are required!";
      }
      

      #check list of errors 
      if(empty($errors)){
        
      $stmt = $pdo->prepare("SELECT id,name,email,password FROM users WHERE email = ?");
      $stmt->execute([ $email ]);
      $user = $stmt->fetch();
      
      if(password_verify($password,$user['password'])){
            
            $_SESSION['user'] = $user['name'];
            $_SESSION['user_id'] = $user['id'];
            header("Location: ../index.php");
            exit; 
      }else{
         echo "<div class='formError'> password incorrect </div>";
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
    <link rel="stylesheet" href="../asset/css/auth.css">
    <title>login</title>
</head>
<body>

    <form method="post">
        <h1>Welcom back!</h1>
        <div class="inputBox">
            <label for="email">email *</label>
            <input type="email" name="email">
        </div>
        <div class="inputBox">
            <label for="email">password *</label>
            <input type="password" name="password">
        </div>
        <input class="formBTN" type="submit" name="login" value="Log In">
        <p class="formLink">Don't have an account? <a href="register.php">Create an account</a></p>
    </form>
    
</body>
</html>