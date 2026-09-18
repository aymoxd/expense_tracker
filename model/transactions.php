<?php

require_once 'config/db.php';


function getTransactions($userId){
    global $pdo;
    $sqlState = $pdo->prepare("SELECT * FROM transactions WHERE user_id = ?");
    $sqlState->execute([ $userId ]);
    return $sqlState->fetchAll(PDO::FETCH_OBJ);
}

function getIncome($userId){
        global $pdo;
        $sqlState = $pdo->prepare("SELECT SUM(amount) as income FROM transactions Where type = 'income' AND user_id = ?");
        $sqlState->execute([ $userId ]);
        $income = $sqlState->fetch(PDO::FETCH_OBJ);
       return $income = $income->income ?? 0;
}

function getExpense($userId){
        global $pdo;
        $sqlExpense = $pdo->prepare("SELECT SUM(amount) as expense FROM transactions Where type = 'expense' AND user_id = ?");
        $sqlExpense->execute([ $userId ]);
        $expense = $sqlExpense->fetch(PDO::FETCH_OBJ);
        return $expense = $expense->expense ?? 0;
}


function createTransaction($userId,$type,$amount,$description,$date){
        global $pdo;
        $stmt = $pdo->prepare("INSERT INTO transactions(user_id,type,amount,description,created_at) VALUES (?,?,?,?,?)");
        return $stmt->execute([
          $userId,
          $type,
          $amount,
          $description,
          $date
        ]);
}