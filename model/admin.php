<?php

require_once 'config/db.php';


function getTotalUsers(){
    global $pdo;
    $sql = $pdo->query("SELECT COUNT(*) FROM users");
    return $sql->fetchColumn();
}

function getTotalTransaction(){
    global $pdo;
    $sql = $pdo->query("SELECT COUNT(*) FROM transactions");
    return $sql->fetchColumn();
}

function getTotalIncome(){
    global $pdo;
    $sql = $pdo->query("SELECT COALESCE(SUM(amount), 0) FROM transactions WHERE type = 'income'");
    return $sql->fetchColumn();
}

function getTotalExpense(){
    global $pdo;
    $sql = $pdo->query("SELECT COALESCE(SUM(amount), 0) FROM transactions WHERE type = 'expense'");
    return $sql->fetchColumn();
}

function getRecentActivity(){
    global $pdo;
    $sql = $pdo->query("SELECT 
                          users.name ,
                          transactions.type ,
                          transactions.created_at ,
                          transactions.amount 
                          FROM transactions JOIN users ON
                          transactions.user_id = users.id
                          ORDER BY transactions.created_at 
                          DESC
                          LIMIT 10");
    return $sql->fetchAll(PDO::FETCH_OBJ);

}

function getUsers(){
    global $pdo;
    $sql = $pdo->query("SELECT name,email,created_at,role FROM users ORDER BY created_at DESC");
    return $sql->fetchAll(pdo::FETCH_OBJ);
}