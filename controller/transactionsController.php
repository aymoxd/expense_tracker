<?php
require_once 'model/transactions.php';


function dashboardAction(){
    #get the search word from get
    $page =  max(1,(int) ($_GET['page'] ?? 1));
    $limit = 5;
    $offset = ($page - 1) * $limit;
    
    $search = trim($_GET['search'] ?? '');
    $type = $_GET['type'] ?? '';
    $userId = $_SESSION['userId'];

    $totalTransactions = getTotalTransactions($userId);
    $totalPages = ceil($totalTransactions / $limit);
    
    $transactions =  getTransactions($userId,$limit,$offset,$search,$type);
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

    if (
    !isset($_SESSION['csrf_token'], $_POST['csrf_token']) ||
    !is_string($_POST['csrf_token']) ||
    !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])
     ) {
    http_response_code(403);
    exit('Invalid CSRF token');
     }


    $userId = $_SESSION['userId']; 
    $type = trim($_POST['type'] ?? '');
    $amount = trim($_POST['amount'] ?? '');
    $description = trim($_POST['description'] ?? '');
    

      #check if the inputs are empty
      if(empty($amount) || empty($type) || empty($description)){
        $errors[] = "All fields are required.";
      }
        if (strlen($description) > 255) {
        $errors[] = "Description must not exceed 255 characters.";
       }
       
         #chek the amount 
      if (
    !is_string($amount) ||
    !preg_match('/^\d{1,8}(\.\d{1,2})?$/', $amount)
    ) {
        $errors[] = 'Invalid amount.';
    } elseif (preg_match('/^0+(?:\.0{1,2})?$/', $amount)) {
        $errors[] = 'Amount must be greater than zero.';
    }

       #check the type
       $allowedTypes = ['expense','income'];
       if(!in_array($type,$allowedTypes,true)){
               $errors[] = "Invalid transaction type.";
       }
          #check the description
       if ($description === '') {
            $errors[] = 'Description is required.';
        } elseif (mb_strlen($description, 'UTF-8') > 255) {
            $errors[] = 'Description must not exceed 255 characters.';
        }

      #check list of errors 
      if(empty($errors)){
            createTransaction($userId,$type,$amount,$description);
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
     $transactionId = filter_input(INPUT_GET,'id',FILTER_VALIDATE_INT);
 
     if(!$transactionId){
      http_response_code(404);
      exit("Transaction not found");
     }
     $userTransaction = getUserTransaction($userId,$transactionId);
     if (!$userTransaction) {
    http_response_code(404);
    exit('Transaction not found');
      }
     require_once 'view/user/edit.php';
  }

  function updateAction(){
   
     $errors = [];
    if($_SERVER['REQUEST_METHOD'] !== 'POST'){
        header("location: index.php?action=dashboard");
        exit;
    }

   if (
    !isset($_SESSION['csrf_token'], $_POST['csrf_token']) ||
    !is_string($_SESSION['csrf_token']) ||
    !is_string($_POST['csrf_token']) ||
    !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])
    ) {
        http_response_code(403);
        exit('Invalid CSRF token');
    }

    $userId = $_SESSION['userId']; 
    $transactionId = filter_input(
    INPUT_POST,
    'transactionId',
    FILTER_VALIDATE_INT
      );

      if ($transactionId === false || $transactionId === null || $transactionId < 1) {
          http_response_code(400);
          exit('Invalid transaction ID');
      }
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
      if (
    !is_string($amount) ||
    !preg_match('/^\d{1,8}(\.\d{1,2})?$/', $amount)
    ) {
        $errors[] = 'Invalid amount.';
    } elseif (preg_match('/^0+(?:\.0{1,2})?$/', $amount)) {
        $errors[] = 'Amount must be greater than zero.';
    }

       #check the type
       $allowedTypes = ['expense','income'];
       if(!in_array($type,$allowedTypes,true)){
               $errors[] = "Invalid transaction type.";
       }
       #check the description
       if ($description === '') {
            $errors[] = 'Description is required.';
        } elseif (mb_strlen($description, 'UTF-8') > 100) {
            $errors[] = 'Description must not exceed 100 characters.';
        }

      #check list of errors 
      if(empty($errors)){
            #check if user change data or not
            $oldTransaction = getUserTransaction($userId,$transactionId);
            if (!$oldTransaction) {
            http_response_code(404);
            exit('Transaction not found');
        }
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
             header("Location: index.php?action=edit&id=" . $transactionId);
             exit;
        }
  }

  function deleteAction(){
       if($_SERVER['REQUEST_METHOD'] !== "POST"){
                        http_response_code(405);
                        exit("Methode not allowed");
          }
     if (
    !isset($_SESSION['csrf_token'], $_POST['csrf_token']) ||
    !is_string($_POST['csrf_token']) ||
    !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])
     ) {
    http_response_code(403);
    exit('Invalid CSRF token');
     }


    $transactionId = filter_input(
    INPUT_POST,
    'transactionId',
    FILTER_VALIDATE_INT
    );

    if ($transactionId === false || $transactionId === null || $transactionId < 1) {
        http_response_code(400);
        exit('Invalid transaction ID ');
    }
    $userId = $_SESSION['userId'];
    destroy($transactionId,$userId);
    $_SESSION['success'] = "Transaction deleted successfully.";
    header("Location: index.php?action=dashboard");
    exit;
  }


  function displayUserTransactions(){
    $page =  max(1,(int) ($_GET['page'] ?? 1));
    $limit = 10;
    $offset = ($page - 1) * $limit;
    
    $userId = $_SESSION['userId'] ?? null;
    $search = trim($_GET['search'] ?? '');
    $type = $_GET['type'] ?? '';

    $totalTransactions = getTotalTransactions($userId);
    $totalPages = ceil($totalTransactions / $limit);


    $transactions = getTransactions($userId,$limit,$offset,$search,$type);
    require_once 'view/user/userTransactions.php';
  }