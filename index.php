<?php   
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);
   
   

    require_once __DIR__ . '/vendor/autoload.php';

    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
    $dotenv->load();

    session_start();
    if(!isset($_SESSION['csrf_token'])){
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }

    require_once 'controller/transactionsController.php';
    require_once 'controller/authController.php';
    require_once 'controller/adminController.php';

    //create router
        $action = $_GET['action'] ?? 'dashboard';

        switch($action){
            case 'dashboard':
                     requireLogin();
                     dashboardAction();
            break;
              case 'admin':
                     adminDashboard();
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
             case 'adminUsers':
                     requireLogin();
                     displayUsers();
            break;


            default:
            header("Location: index.php?action=dashboard");
            exit;

        
        }
