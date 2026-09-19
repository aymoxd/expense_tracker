<?php   


    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);

    session_start();

    require_once 'controller/transactionsController.php';
    require_once 'controller/authController.php';

    //create router
        $action = $_GET['action'] ?? 'dashboard';

        switch($action){
            case 'dashboard':
                     requireLogin();
                     dashboardAction();
            break;
            case 'create':
                     requireLogin();
                     create();
            break;
            case 'store':
                     requireLogin();
                     createAction();
            break;
             case 'edit':
                     requireLogin();
                     editPage();
            break;
            case 'update':
                     requireLogin();
                     updateAction();
            break;
             case 'delete':
                     requireLogin();
                     deleteAction();
            break;
            case 'showRegister':
                     registerPage();
            break;
            case 'showLogin':
                     loginPage();
            break;
            case 'login':
                     loginAction();
            break;
            case 'register':
                     registerAction();
            break;
            case 'logout':
                     requireLogin();
                     logoutAction();
            break;


            default:
            header("Location: index.php?action=dashboard");
            exit;

        
        }
