<?php   
   

    require_once __DIR__ . '/vendor/autoload.php';

    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
    $dotenv->load();

    session_start();
    if(!isset($_SESSION['csrf_token'])){
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }

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
