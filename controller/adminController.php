<?php

require_once 'controller/authController.php';
require_once 'model/admin.php';

function adminDashboard(){
    requireAdmin();
    $totalUsers = getTotalUsers();
    $totalTransactions = getTotalTransaction();
    $totalIncome = getTotalIncome();
    $totalExpense = getTotalExpense();
    $recentActivity = getRecentActivity();

    require_once 'view/admin/dashboard.php';
}

function displayUsers(){
    requireAdmin();
    $totalUsers = getTotalUsers();
    $users = getUsers();
    require_once 'view/admin/users.php';
}