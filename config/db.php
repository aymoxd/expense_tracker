<?php

$host = $_ENV['DB_HOST'];
$dbname = $_ENV['DB_NAME'];
$dbuser = $_ENV['DB_USER'];
$dbpass = $_ENV['DB_PASSWORD'];


try{
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;",$dbuser,$dbpass);
    $pdo->setAttribute( PDO::ATTR_ERRMODE , PDO::ERRMODE_EXCEPTION );
}catch(PDOException $e){
      die("connection fieled : " . $e->getMessage());
}
