<?php

require_once 'config/db.php';
class TransactionController{
    
    private $model;
    private $transaction;
    private $totalAmount;
    
    public function __construct($conn)
    {
        $this->model = new TransactionModel($conn);
    }
    public function index($page = 1,) {
        
        $itemsPerPage = isset($_GET['itemsPerPage']) ? (int)$_GET['itemsPerPage'] : 10;
        $transactionsData = $this->model->getTransactions($page, $itemsPerPage);

        $transactions = isset($transactionsData['transactions']) ? $transactionsData['transactions'] : [];
        $totalPages = isset($transactionsData['totalPages']) ? $transactionsData['totalPages'] : 0;
        $totalAmount = $this->model->getTotalAmount();
    

        include "view/trans_index.php";
    }
    
    
    public function create()
    {
   
        if ($_SERVER['REQUEST_METHOD'] === "POST") {
            
            $description = $_POST['description'];
            $amount = $_POST['amount'];
            $category = $_POST['category'];
            $date = $_POST['date'];
       
            if (empty($description) || empty($amount) || empty($category) || empty($date)) {
           
                $error_message = "All fields are required.";
            } else {
   
                $success = $this->model->create($description, $amount, $category, $date);
                
                if ($success) {
   
                    header('Location: index.php?action=index');
                    exit;
                } else {
                    $error_message = "Failed to create the transaction. Please try again.";
                }
            }
        }
    
        include 'view/create.php';
    }
    
    public function update($id)
    {

        if ($_SERVER['REQUEST_METHOD'] === "POST") {
         
            $description = $_POST['description'];
            $amount = $_POST['amount'];
            $category = $_POST['category'];
            $date = $_POST['date'];
            $updated = $this->model->update($id, $description, $amount, $category, $date);
    
            if ($updated) {
               
                header('Location: index.php?action=index');
                exit;
            } else {
                $error_message = "Failed to update the transaction.";
            }
        }

        $transaction = $this->model->find($id);
        include 'view/update.php';
        
    }
    
    public function delete($id)
    {
        $this->model->delete($id);    
       
        $transaction = $this->model->find($id);
        if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_delete'])){
            include 'view/trans_index.php';
        }else{
            include 'view/delete.php';
        }

    }

    public function search() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_search'])) {
          
            $searchTerm = isset($_POST['search']) ? $_POST['search'] : '';  
            $category = isset($_POST['category']) ? $_POST['category'] : '';  
    
            if ($category && !$searchTerm) {
                $transactions = $this->model->search($category); 
            } else {
                $transactions = $this->model->search($searchTerm);
            }
            
            $totalAmount = $this->model->getTotalAmount();
            include 'view/trans_index.php';
            exit;
        
        }
    }
    public function searchdescript() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_searchdes'])) {
           
            $description = isset($_POST['description']) ? $_POST['description'] : '';  

            if ($description) {
                $transactions = $this->model->searchdescript($description); 
            } 
            
            
             $totalAmount = $this->model->getTotalAmount();
             include 'view/trans_index.php';
            exit;
        }
    }
    public function dates() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_date'])) {
            
            $mindate = $_POST['min_date'];
            $maxdate = $_POST['max_date'];
            
            $transactions = $this->model->dates($maxdate, $mindate);
            $totalAmount = $this->model->getTotalAmount();
            include 'view/trans_index.php';
            exit;
        }
    }
 
}
 


?>