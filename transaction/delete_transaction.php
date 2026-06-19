<?php

require_once '../config/db.php';
session_start();

$id = $_GET['id'];

$stmt = $pdo->prepare("DELETE FROM transactions WHERE id = ?");
$deleted = $stmt->execute([ $id ]);

if($deleted){
               $_SESSION['msg'] = "transaction deleted seccussfully!";
               $_SESSION['error'] = "noerror";
               header("Location: ../index.php");
               exit;
}else{
               $_SESSION['msg'] = "field delete transaction !";
               $_SESSION['error'] = "error";
               header("Location: ../index.php");
               exit;
}