<?php
     ini_set('display_errors', 1);
     ini_set('display_startup_errors' ,1);
     error_reporting(E_ALL);

     #connection with database
     require_once "../config/db.php";
     #get the user_id from the session
     session_start();
     $user_id = $_SESSION['user_id'];

     $errors = [];
     if($_SERVER['REQUEST_METHOD'] == 'POST'){

     $amount = htmlspecialchars($_POST['amount']);
     $type = htmlspecialchars($_POST['type']);
     $description = htmlspecialchars($_POST['description']);


      #check if the inputs are empty
      if(empty($amount) || empty($type) || empty($description)){
        $errors[] = "all inputs are required!";
      }

      #chek the value of inputs
      

      #check list of errors 
      if(empty($errors)){
        #get the date
        $date = date("y-m-d");
        #insert to db her
        $stmt = $pdo->prepare("INSERT INTO transactions(user_id,type,amount,description,created_at) VALUES (?,?,?,?,?)");
        $inserted = $stmt->execute([
          $user_id,
          $type,
          $amount,
          $description,
          $date
        ]);
        if($inserted){
               $_SESSION['msg'] = "transaction added seccussfully!";
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
            echo "<div class='formError'> $e </div>" . "<br>";
            header("Location: ../index.php");
            exit;
        }
      }
  
  }
