<?php
require_once 'model/transactions.php';


function dashboardAction(){
    $userId = $_SESSION['user_id'];
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
        header("location: index.php");
        exit;
    }
    $userId = $_SESSION['user_id']; 
    $amount = trim($_POST['amount'] ?? '');
    $type = trim($_POST['type'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $date = date("Y-m-d");
    

      #check if the inputs are empty
      if(empty($amount) || empty($type) || empty($description)){
        $errors[] = "all inputs are required!";
      }
        if (strlen($description) > 255) {
        $errors[] = "Description is too long.";
       }

      #check list of errors 
      if(empty($errors)){
            createTransaction($userId,$amount,$type,$description,$date);
            header("Location: index.php");
            exit;
      }else{
             $_SESSION['errors'] = $errors;
             header("Location: create.php");
             exit;
        }
  }
