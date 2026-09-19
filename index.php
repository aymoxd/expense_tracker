<?php   


    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);

    session_start();

    require_once 'controller/transactionsController.php';

    //create router
    if(isset($_GET['action'])){
        $action = $_GET['action'];
        switch($action){
            case 'dashboard':
                     dashboardAction();
            break;
            case 'create':
                     create();
            break;
            case 'store':
                     createAction();
            break;
             case 'edit':
                     editPage();
            break;
            case 'update':
                     updateAction();
            break;
             case 'delete':
                     deleteAction();
            break;
        
        }

    }



    if(!isset($_SESSION['user']) || empty($_SESSION['user'])){
        header("Location: auth/login.php");
        exit;  
    }
    $username = $_SESSION['user'];
    $user_id = $_SESSION['user_id'];
    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="asset/css/index.css">
    <title></title>
</head>
<body>

  

    <!-- add transaction btn -->
    <a href="index.php?action=create" class="add"><i class="ri-add-large-line add-tr"></i></a>

</body>
</html>