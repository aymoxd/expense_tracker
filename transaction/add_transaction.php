<?php
     ini_set('display_errors', 1);
     ini_set('display_startup_errors' ,1);
     error_reporting(E_ALL);

     #connection with database
     require_once "../config/db.php";
     #get the user_id from the session
     session_start();
     $user_id = $_SESSION['user_id'];

     $errors = [];
     if($_SERVER['REQUEST_METHOD'] == 'POST'){

     
  
  }
