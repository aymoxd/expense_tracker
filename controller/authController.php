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
    
  if($_SERVER['REQUEST_METHOD'] !== 'POST'){
    header("Location: index.php?action=showRegister");
    exit;
    }
     $token = $_POST['csrf_token'] ?? null;

  if (
    !isset($token) ||
    !isset($_SESSION['csrf_token']) ||
    !hash_equals($_SESSION['csrf_token'], $token)
) {
    http_response_code(403);
    exit('Invalid CSRF token');
}
    
    $errors = [];
      $name = trim($_POST['name'] ?? '');
      $lastName = trim($_POST['lastName'] ?? '');
      $email = trim($_POST['email'] ?? '');
      $password = $_POST['password'] ?? '';
      $confirmPassword = $_POST['confirmPassword'] ?? '';

      #check if the inputs are empty
      if(empty($name) || empty($lastName) || empty($email) || empty($password) || empty($confirmPassword)){
        $errors[] = "All fields are required.";
      }
       if(!filter_var($email,FILTER_VALIDATE_EMAIL)){
        $errors[] = "Email is not valid.!";
      }
      #check if password match the confirm password
      if($password !== $confirmPassword){
        $errors[] = "you should confirm the password!.";
      }
      #check the password format
       if(strlen($password) < 8){
        $errors[] = "Password must be at least 8 characters long.";
      }
      if(mb_strlen($name, 'UTF-8') > 50 || mb_strlen($lastName, 'UTF-8') > 50){
        $errors[] = 'Name and last name must not exceed 50 characters.';
      }

      if(strlen($name))
      #check if email already exist
      if(emailExist($email)){
        $errors[] = "Unable to create the account with these details.";
      }


      #check list of errors 
      if(empty($errors)){
        #hash the password
        $passwordHash = password_hash($password,PASSWORD_DEFAULT);
        $userId = createUser($name,$lastName,$email,$passwordHash);
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

    $token = $_POST['csrf_token'] ?? null;

  if (
    !isset($token) ||
    !isset($_SESSION['csrf_token']) ||
    !hash_equals($_SESSION['csrf_token'], $token)
) {
    http_response_code(403);
    exit('Invalid CSRF token');
}

      $email = trim($_POST['email']);
      $password = $_POST['password'];

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