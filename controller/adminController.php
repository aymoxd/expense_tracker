<?php

require_once 'controller/authController.php';
require_once 'model/admin.php';

function adminDashboard(){
    requireAdmin();

    $page = (int) ($_GET['page'] ?? 1);
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

    $totalUsers = getTotalUsers();

    $totalPages = ceil($totalUsers / $limit);

    $users = getUsers($limit ,$offset,$search);
    require_once 'view/admin/users.php';
}

function displayUserDetaille(){
  requireAdmin();

  $id = (int) ($_GET['id'] ?? 0);
  $detailUser = getUser($id);
  require_once 'view/admin/userDetaille.php';
}

function adminDeleteUser(){
  requireAdmin();

  if($_SERVER['REQUEST_METHOD'] !== 'POST'){
        http_response_code(405);
        exit('Method Not Allowed');
  }
  $token = $_POST['csrf_token'] ?? '';

  if(!is_string($token) || !hash_equals($_SESSION['csrf_token'] , $token)){
    http_response_code(403);
    exit('Invalid CSRF token');
  }

  $userId = filter_input(INPUT_POST,'id',FILTER_VALIDATE_INT);


  if(!$userId || $userId < 1){
        header('Location: index.php?action=adminUsers');
        exit;
  }

   if($userId === (int) $_SESSION['userId']){
     header('Location: index.php?action=adminUserDetail&id=' . $userId);
     exit;
  }

  if(deleteUser($userId)){
    header("location: index.php?action=adminUsers");
    exit;
  }
     header('Location: index.php?action=adminUserDetail&id=' . $userId);
    exit;
  
  
}