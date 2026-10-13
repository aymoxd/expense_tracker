<?php

require_once 'controller/authController.php';
require_once 'model/admin.php';

function adminDashboard(){
    requireAdmin();

    $page =  max(1,(int) ($_GET['page'] ?? 1));
    $limit = 5;
    //calcule offset
    $offset = ($page - 1) * $limit;



    $totalUsers = getTotalUsers();
    $totalPages = ceil($totalUsers / $limit);

    $totalTransactions = getTotalTransaction();
    $totalIncome = getTotalIncome();
    $totalExpense = getTotalExpense();
    $recentActivity = getRecentActivity($limit , $offset);

    require_once 'view/admin/dashboard.php';
}

function displayUsers(){
    requireAdmin();

    $search = trim($_GET['search'] ?? '');
    $page = max(1,(int) ($_GET['page'] ?? 1));
    $limit = 5;
    //calcule offset
    $offset = ($page - 1) * $limit;

    $totalUsers = getTotalUsers($search);

    $totalPages = ceil($totalUsers / $limit);

    $users = getUsers($limit ,$offset,$search);
    require_once 'view/admin/users.php';
}

function displayUserDetaille(){
  requireAdmin();

  $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
    if (!$id || $id < 1) {
        header('Location: index.php?action=adminUsers');
        exit;
    }
  $detailUser = getUser($id);
  if(!$detailUser){
     header('Location: index.php?action=adminUsers');
     exit;
  }
  require_once 'view/admin/userDetaille.php';
}

function adminDeleteUser(){
  requireAdmin();
  $errors[] = '';
  if($_SERVER['REQUEST_METHOD'] !== 'POST'){
        http_response_code(405);
        exit('Method Not Allowed');
  }
  $token = $_POST['csrf_token'] ?? '';

  if(!isset($token) || !hash_equals($_SESSION['csrf_token'] , $token)){
    http_response_code(403);
    exit('Invalid CSRF token');
  }

  $userId = filter_input(INPUT_POST,'id',FILTER_VALIDATE_INT);


  if(!$userId || $userId < 1){
        header('Location: index.php?action=adminUsers');
        exit;
  }

   if($userId === (int) $_SESSION['userId']){
    $_SESSION['errors'] = 'You cant remove the admin account';
     header('Location: index.php?action=adminUserDetail&id=' . $userId);
     exit;
  }

  if(deleteUser($userId)){
    $_SESSION['success'] = "User deleted successfully.";
    header("location: index.php?action=adminUsers");
    exit;
  }
     $_SESSION['errors'] = "somthing wont wrong!!";
     header('Location: index.php?action=adminUserDetail&id=' . $userId);
    exit;
  
  
}