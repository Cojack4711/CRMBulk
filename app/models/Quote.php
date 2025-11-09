<?php
namespace App\Models;

class Quote {
    private $conn;
    private $table = 'quotes';

    public $id;
    public $customer_id;
    public $quote_number;
    public $status;
    public $total_amount;
    public $valid_until;
    public $created_at;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function read() {
        $query = 'SELECT * FROM ' . $this->table . ' ORDER BY created_at DESC';
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function create() {
        $query = 'INSERT INTO ' . $this->table . ' SET customer_id = :customer_id, quote_number = :quote_number, status = :status, total_amount = :total_amount, valid_until = :valid_until';
        $stmt = $this->conn->prepare($query);

        $this->customer_id = htmlspecialchars(strip_tags($this->customer_id));
        $this->quote_number = htmlspecialchars(strip_tags($this->quote_number));
        $this->status = htmlspecialchars(strip_tags($this->status));
        $this->total_amount = htmlspecialchars(strip_tags($this->total_amount));
        $this->valid_until = htmlspecialchars(strip_tags($this->valid_until));

        $stmt->bindParam(':customer_id', $this->customer_id);
        $stmt->bindParam(':quote_number', $this->quote_number);
        $stmt->bindParam(':status', $this->status);
        $stmt->bindParam(':total_amount', $this->total_amount);
        $stmt->bindParam(':valid_until', $this->valid_until);

        if($stmt->execute()) {
            $this->id = $this->conn->lastInsertId();
            return true;
        }
        return false;
    }
}
