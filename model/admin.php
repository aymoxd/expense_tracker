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

function getRecentActivity($limit , $offset){
    global $pdo;
    $sql = $pdo->prepare("SELECT 
                          users.name ,
                          transactions.type ,
                          transactions.created_at ,
                          transactions.amount 
                          FROM transactions JOIN users ON
                          transactions.user_id = users.id
                          ORDER BY transactions.created_at 
                          DESC
                          LIMIT ?
                          OFFSET ?");
    $sql->bindValue(1 , $limit ,PDO::PARAM_INT);
    $sql->bindValue(2 , $offset ,PDO::PARAM_INT);
    $sql->execute();
    return $sql->fetchAll(PDO::FETCH_OBJ);

}

function getUsers($limit,$offset,$search = ''){
    global $pdo;
    $sql = "SELECT id,name,email,created_at,role FROM users ";

    if($search !== ''){
      $sql .= " WHERE name LIKE :search";
    }

    $sql .= " ORDER BY created_at DESC LIMIT  :limit OFFSET  :offset";

    $sql = $pdo->prepare($sql);
     if($search !== ''){
     $sql->bindValue(':search', '%' . $search . '%' ,PDO::PARAM_STR);
    }
    $sql->bindValue(':limit',(int) $limit,PDO::PARAM_INT);
    $sql->bindValue(':offset',(int) $offset,PDO::PARAM_INT);

    $sql->execute();
    return $sql->fetchAll(PDO::FETCH_OBJ);
}

function getUser($id){
    global $pdo;
    $sql = $pdo->prepare("SELECT id, name, email, role, created_at
                          FROM users
                          WHERE id = ?");
    $sql->execute([ $id ]);
    return $sql->fetch(PDO::FETCH_OBJ);
}

function deleteUser($userId){
    global $pdo;
    $sql = $pdo->prepare("DELETE from users WHERE id = ?");
    $sql->execute([ $userId ]);
    return $sql->rowCount() > 0;
}