<?php

require_once 'model/auth.php';



//requireLogin function
function requireLogin(){
    if(!isset($_SESSION['userId'])){
      header("Location: index.php?action=showLogin");
      exit;
    }
}

function requireAdmin(){
 
  if(!isset($_SESSION['userId']) || ($_SESSION['role'] ?? '') !== 'admin'){
     header("Location: index.php?action=dashboard");
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
      $confirmPassword = trim($_POST['confirmPassword']);

      #check if the inputs are empty
      if(empty($name) || empty($email) || empty($password) || empty($confirmPassword)){
        $errors[] = "All fields are required.";
      }
      #check if password match the confirm password
      if($password !== $confirmPassword){
        $errors[] = "you should confirm the password!.";
      }
      #check the password format
       if(strlen($password) < 6){
        $errors[] = "Password must be at least 6 characters long.";
      }

      #check if email already exist
      if(emailExist($email)){
        $errors[] = "Unable to create the account with these details.";
      }


      #check list of errors 
      if(empty($errors)){
        #hash the password
        $passwordHash = password_hash($password,PASSWORD_DEFAULT);
        $userId = createUser($name,$email,$passwordHash);
        #prepare the session when the register success
        if($userId){
            session_regenerate_id(true);
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

          if($user && password_verify($password,$user->password)){
            session_regenerate_id(true);
            $_SESSION['username'] = $user->name;
            $_SESSION['userId'] = $user->id;
            $_SESSION['role'] = $user->role;
           
            if($user->role == 'admin'){
                header("Location: index.php?action=admin");
                exit;
            }
            header("Location: index.php?action=dashboard");
            exit; 
      }else{
            $errors[] = "Invalid email or password.";
      }
      
      if(!empty($errors)){
        $_SESSION['errors'] = $errors;
        header("Location: index.php?action=showLogin");
        exit;
      }
}
 }