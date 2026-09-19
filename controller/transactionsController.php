<?php
require_once 'model/transactions.php';


function dashboardAction(){
    $userId = $_SESSION['userId'];
    $transactions =  getTransactions($userId);
    $income = getIncome($userId);
    $expense = getExpense($userId);
    $curentBalance = $income - $expense;
    require_once 'view/dashboard.php';
}

function create(){
    require_once 'view/create.php';
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
     $userTransaction = getUserTransaction($userId,$transactionId);
     require_once 'view/edit.php';
  }

  function updateAction(){
     $errors = [];
    if($_SERVER['REQUEST_METHOD'] !== 'POST'){
        header("location: index.php?action=update");
        exit;
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

      #check list of errors 
      if(empty($errors)){
            update($userId,$transactionId,$amount,$type,$description,$date);
            $_SESSION['success'] = "Transaction updated successfully.";
            header("Location: index.php?action=dashboard");
            exit;
      }else{
             $_SESSION['errors'] = $errors;
             header("Location: index.php?action=update");
             exit;
        }
  }

  function deleteAction(){
    $transactionId = $_GET['id'];
    $userId = $_SESSION['userId'];
    destroy($transactionId,$userId);
    $_SESSION['success'] = "Transaction deleted successfully.";
    header("Location: index.php?action=dashboard");
    exit;
  }
