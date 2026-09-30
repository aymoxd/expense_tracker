<?php

require_once 'config/db.php';


function emailExist($email){
      global $pdo;
      #check if email already exist
      $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
      $stmt->execute([ $email ]);
      return $stmt->fetch(PDO::FETCH_OBJ);
}

function createUser($name,$email,$password){
        global $pdo;
        $stmt = $pdo->prepare("INSERT INTO users(name,email,password) VALUES (?,?,?)");
         $stmt->execute([ 
                $name,
                $email,
                $password
        ]);
        return $pdo->lastInsertId();
}

function getUserByEmail($email){
      global $pdo;
      $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
      $stmt->execute([ $email ]);
      return $stmt->fetch(PDO::FETCH_OBJ);
}