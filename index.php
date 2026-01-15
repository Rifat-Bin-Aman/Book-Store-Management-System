<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

session_start();

require_once __DIR__ . '/controllers/AuthController.php';
require_once __DIR__ . '/controllers/CustomerController.php';
require_once __DIR__ . '/controllers/AjaxController.php';


$page = $_GET['page'] ?? '';

$auth = new AuthController();
$customer = new CustomerController();

/* 🔐 Authentication guard */
if (!isset($_SESSION['user_id']) && $page !== 'register' && $page !== 'login') {
    $auth->login();
    exit;
}

/* 🚦 Routing */
switch ($page) {

    case 'login':
        $auth->login();
        break;

    case 'register':
        $auth->register();
        break;

    case 'logout':
        $auth->logout();
        break;

    case 'books':
        $customer->books();
        break;

    case 'address':
        $customer->address();
        break;

    case 'orders':
        $customer->orders();
        break;
case 'add_to_cart':
    $customer->addToCart();
    break;

case 'cart':
    $customer->cart();
    break;

case 'remove_order':
    $customer->removeOrder();
    break;
    
case 'confirm_order':
    $customer->confirmOrder();
    break;

    case 'remove_from_cart':
    $customer->removeFromCart();
    break;

    case 'ajax_search_books':
    $ajax = new AjaxController();
    $ajax->searchBooks();
    break;


    default:
        $customer->dashboard();
}
