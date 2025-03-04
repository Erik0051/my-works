<?php

include 'controllers/TransactionController.php';
include 'models/TransactionModel.php';
require_once 'config/db.php';


$database = new Database();
$conn = $database->getConnection();
$controller = new TransactionController($conn);


$currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;

$itemsPerPage = isset($_GET['itemsPerPage']) ? (int)$_GET['itemsPerPage'] : 10; 
$totalPages = isset($_GET['totalPages']) ? (int)$_GET['totalPages'] : 10; 


$transactions = isset($transactionsData['transactions']) ? $transactionsData['transactions'] : [];
$transaction = isset($transactionId);

$action = isset($_GET['action']) ? $_GET['action'] : 'index'; 

switch ($action) {

    case 'index':
        $controller->index($currentPage,$itemsPerPage,); 
        break;

    case 'create':
        $controller->create();
        break;

    case 'update':
        $id = isset($_GET['id']) ? $_GET['id'] : 0;
        $controller->update($id);  
        break;

    case 'delete':
        $id = isset($_GET['id']) ? $_GET['id'] : 0;
        $controller->delete($id);  
        break;

    case 'dates':
            $controller->dates();
            break;

    case 'search':
            $controller->search();
            break;

    case 'searchdescript':
            $controller->searchdescript();
            break;
    case 'modul':
     
            $controller->modul();
            break;
    default:
        echo "Action not found!";
        break;
}

?>