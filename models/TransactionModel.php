<?php

class TransactionModel{
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

   
    public function all() {
        $query = "SELECT * FROM transactions";
        $result = $this->conn->query($query);
        
        $transactions = [];
        while ($row = $result->fetch_assoc()) {
            $transactions[] = $row;
        }

        return $transactions;
    }

 
    public function create($description, $amount, $category, $date) {
        $query = "INSERT INTO transactions (description, amount, category, date) 
                  VALUES (?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("sdss", $description, $amount, $category, $date);
        return $stmt->execute();
    }

    
    public function update($id, $description, $amount, $category, $date) {
        $query = "UPDATE transactions SET description = ?, amount = ?, category = ?, date = ? WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param('sdssi', $description, $amount, $category, $date, $id);
        return $stmt->execute();
    }


    public function delete($id) {
        $query = "DELETE FROM transactions WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param('i', $id);
        $stmt->execute();
    }

    public function find($id) {
        $query = "SELECT * FROM transactions WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $id);  
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            return $result->fetch_assoc();  
        }

        return null;  
    }

    public function getTotalAmount() {
        $query = "SELECT SUM(amount) AS total FROM transactions";
        $result = $this->conn->query($query);
        $totalAmount = 0;
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $totalAmount = $row['total'];  
        }
        return $totalAmount;
    }

    public function dates($maxdate, $mindate) {
        $query = "SELECT * FROM transactions WHERE date BETWEEN ? AND ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("ss", $mindate, $maxdate); 
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
    }
    
    public function search($category) {
        $query = "SELECT * FROM transactions WHERE category = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("s", $category);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function searchdescript($description) {

        $query = "SELECT * FROM transactions WHERE description = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("s", $description);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }
 
    public function getTransactions($page = 1, $itemsPerPage = 10) {
  
        $offset = ($page - 1) * $itemsPerPage;
        $query = "SELECT * FROM transactions LIMIT ? OFFSET ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param('ii', $itemsPerPage, $offset);
        $stmt->execute();
        $result = $stmt->get_result();
        
        $transactions = $result->fetch_all(MYSQLI_ASSOC);

        $totalTransactions = $this->getTotalTransactionsCount();
        $totalPages = $totalTransactions;
     
    
        return ['transactions' => $transactions, 'totalPages' => $totalPages];
    }
    
    
    public function getTotalTransactionsCount() {
        
        $query = "SELECT COUNT(*) FROM transactions";

        $stmt = $this->conn->prepare($query);
        if ($stmt === false) {
            die('MySQL prepare error: ' . $this->conn->error);
        } 
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result === false) {
            die('Error executing query: ' . $stmt->error);
        }
     
        $count = $result->fetch_row();
        return $count[0];
    }
    
}

?>