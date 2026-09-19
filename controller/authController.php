<?php

require_once 'model/auth.php';

//requireLogin function
function requireLogin(){
    if(!isset($_SESSION['userId'])){
      header("Location: index.php?action=showLogin");
      exit;
    }
}

function logoutAction(){
   $_SESSION = [];
   session_destroy();
   header("Location: index.php?action=showLogin");
   exit;
}


//register
function registerPage(){
    require_once 'view/register.php';
}

function registerAction(){
    
    $errors = [];
    if($_SERVER['REQUEST_METHOD'] !== 'POST'){
      header("Location: index.php?action=showRegister");
      exit;
    }

      $name = trim($_POST['name']);
      $email = trim($_POST['email']);
      $password = trim($_POST['password']);

      #check if the inputs are empty
      if(empty($name) || empty($email) || empty($password)){
        $errors[] = "All fields are required.";
      }
      #check the password format
       if(strlen($password) < 6){
        $errors[] = "Password must be at least 6 characters long.";
      }

      #check if email already exist
      if(emailExist($email)){
        $errors[] = "An account with this email already exists.";
      }


      #check list of errors 
      if(empty($errors)){
        #hash the password
        $passwordHash = password_hash($password,PASSWORD_DEFAULT);
        $userId = createUser($name,$email,$passwordHash);
        #prepare the session when the register success
        if($userId){
            $_SESSION['userId'] = $userId;
            $_SESSION['username'] = $name;
            header("Location: index.php?action=dashboard");
            exit;
        }

      }else{
        $_SESSION['errors'] = $errors;
        header("Location: index.php?action=showRegister");
        exit;
      }
  
  

}

//login

function loginPage(){
    require_once 'view/login.php';
}

function loginAction(){
    $errors = [];
    if($_SERVER['REQUEST_METHOD'] !== 'POST'){
      header("Location: index.php?action=showLogin");
      exit;
    }

      $email = trim($_POST['email']);
      $password = trim($_POST['password']);

      #check if the inputs are empty
      if(empty($email) || empty($password)){
        $errors[] = "All fields are required.";
      }
      

      #check list of errors 
      if(empty($errors)){
        
      $user = getUserByEmail($email);

      if($user){
          if(password_verify($password,$user->password)){
            
            $_SESSION['username'] = $user->name;
            $_SESSION['userId'] = $user->id;
            header("Location: index.php?action=dashboard");
            exit; 
      }else{
        $errors[] = "The password is incorrect.";
      }
      }else{
            $errors[] = "No account was found with this email address.";
      }
      

      }
      
      if(!empty($errors)){
        $_SESSION['errors'] = $errors;
        header("Location: index.php?action=showLogin");
        exit;
      }
}
