<?php
require_once 'model/transactions.php';


function dashboardAction(){
    #get the search word from get
    $search = trim($_GET['search'] ?? '');
    $type = $_GET['type'] ?? '';
    $userId = $_SESSION['userId'];
    $transactions =  getTransactions($userId,$search,$type);
    $income = getIncome($userId);
    $expense = getExpense($userId);
    $curentBalance = $income - $expense;
    require_once 'view/user/dashboard.php';
}

function create(){
    require_once 'view/user/create.php';
}

function createAction(){
    $errors = [];
    if($_SERVER['REQUEST_METHOD'] !== 'POST'){
        header("location: index.php?action=create");
        exit;
    }
    $userId = $_SESSION['userId']; 
    $type = trim($_POST['type'] ?? '');
    $amount = trim($_POST['amount'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $date = date("Y-m-d");
    

      #check if the inputs are empty
      if(empty($amount) || empty($type) || empty($description)){
        $errors[] = "All fields are required.";
      }
        if (strlen($description) > 255) {
        $errors[] = "Description must not exceed 255 characters.";
       }
       
       #chek the amount 
       if(!is_numeric($amount)){
        $errors[] = "invalid amount";
       }elseif((float)$amount > 10000000){
         $errors[] = "Amount is too large.";
       }elseif((float)$amount <= 0){
         $errors[] = "Amount must be greater than zero.";
       }

       #check the type
       $allowedTypes = ['expense','income'];
       if(!in_array($type,$allowedTypes,true)){
               $errors[] = "Invalid transaction type.";
       }

      #check list of errors 
      if(empty($errors)){
            createTransaction($userId,$type,$amount,$description,$date);
            $_SESSION['success'] = "Transaction added successfully.";
            header("Location: index.php?action=dashboard");
            exit;
      }else{
             $_SESSION['errors'] = $errors;
             header("Location: index.php?action=create");
             exit;
        }
  }


function editPage(){
     $userId = $_SESSION['userId'];
     $transactionId = $_GET['id'];
     if(!$transactionId){
      http_response_code(404);
      exit("Transaction not found");
     }
     $userTransaction = getUserTransaction($userId,$transactionId);
     require_once 'view/user/edit.php';
  }

  function updateAction(){
   
     $errors = [];
    if($_SERVER['REQUEST_METHOD'] !== 'POST'){
        header("location: index.php?action=dashboard");
        exit;
    }

    if(!isset($_SESSION['csrf_token']) || !isset($_POST['csrf_token']) || !hash_equals($_SESSION['csrf_token'],$_POST['csrf_token'])){
      http_response_code(405);
      exit("Method Not Allowed");
    }

    $userId = $_SESSION['userId']; 
    $transactionId = $_POST['transactionId'];
    $type = trim($_POST['type'] ?? '');
    $amount = trim($_POST['amount'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $date = date("Y-m-d");
    

      #check if the inputs are empty
      if(empty($amount) || empty($type) || empty($description)){
        $errors[] = "All fields are required.";
      }
        if (strlen($description) > 255) {
        $errors[] = "Description must not exceed 255 characters.";
       }

        #chek the amount 
       if(!is_numeric($amount)){
        $errors[] = "invalid amount";
       }elseif((float)$amount > 10000000){
         $errors[] = "Amount is too large.";
       }elseif((float)$amount <= 0){
         $errors[] = "Amount must be greater than zero.";
       }

       #check the type
       $allowedTypes = ['expense','income'];
       if(!in_array($type,$allowedTypes,true)){
               $errors[] = "Invalid transaction type.";
       }

      #check list of errors 
      if(empty($errors)){
            #check if user change data or not
            $oldTransaction = getUserTransaction($userId,$transactionId);
            if($oldTransaction->amount !== $amount ||
               $oldTransaction->type !== $type ||
               $oldTransaction->description !== $description
            ){
            update($userId,$transactionId,$amount,$type,$description,$date);
            $_SESSION['success'] = "Transaction updated successfully.";
            header("Location: index.php?action=dashboard");
            exit;
            }else{
            header("Location: index.php?action=dashboard");
            exit;
            }
           
      }else{
             $_SESSION['errors'] = $errors;
             header("Location: index.php?action=update");
             exit;
        }
  }

  function deleteAction(){
       if($_SERVER['REQUEST_METHOD'] !== "POST"){
                        http_response_code(405);
                        exit("Methode not allowed");
          }
    if(!isset($_SESSION['csrf_token']) || !hash_equals($_SESSION['csrf_token'],$_POST['csrf_token'])){
      die("Invalid CSRF token");
    }
    $transactionId = $_POST['id'];
    $userId = $_SESSION['userId'];
    destroy($transactionId,$userId);
    $_SESSION['success'] = "Transaction deleted successfully.";
    header("Location: index.php?action=dashboard");
    exit;
  }
