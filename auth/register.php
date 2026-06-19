<?php
     session_start();

     ini_set('display_errors', 1);
     ini_set('display_startup_errors' ,1);
     error_reporting(E_ALL);

  #connection with database
  require_once "../config/db.php";
  
  $errors = [];
  if($_SERVER['REQUEST_METHOD'] == 'POST'){

      $name = htmlspecialchars($_POST['name']);
      $email = htmlspecialchars($_POST['email']);
      $password = htmlspecialchars($_POST['password']);

      #check if the inputs are empty
      if(empty($name) || empty($email) || empty($password)){
        $errors[] = "all inputs are required!";
      }
      #check the password format
       if(strlen($password) < 6){
        $errors[] = "password must be more then 6 chars!";
      }
      #check if email already exist
      $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
      $stmt->execute([ $email ]);
      if($stmt->fetch()){
        $errors[] = "email already exist!";
      }


      #check list of errors 
      if(empty($errors)){
        #hash the password
        $passwordHash = password_hash($password,PASSWORD_BCRYPT);

        
        $stmt = $pdo->prepare("INSERT INTO users(name,email,password) VALUES (?,?,?)");
        $inserted = $stmt->execute([ 
                $name,
                $email,
                $passwordHash
        ]);

        #prepare the session when the register success
        if($inserted){
            #get the id of the user
            $stmt = $pdo->prepare("SELECT id,name FROM users WHERE email = ?");
            $stmt->execute([ $email ]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user'] = $user['name'];
            header("Location: ../index.php");
            exit;
        }else{
            header("Location: register.php");
        }

      }else{
        foreach($errors as $e){
            echo "<div class='formError'> $e </div>" . "<br>";
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
    <title>register</title>
</head>
<body>

    <form method="post">
        <h1>Create your account</h1>
          <div class="inputBox">
            <label for="name">name *</label>
            <input type="text" name="name">
        </div>
        <div class="inputBox">
            <label for="email">email *</label>
            <input type="email" name="email">
        </div>
        <div class="inputBox">
            <label for="password">password *</label>
            <input class="password" type="password" name="password">
        </div>
      
        <input class="formBTN" type="submit" name="login" value="Register">
        <p class="formLink">already have an account <a href="login.php">login</a></p>
    </form>
    
</body>
</html>