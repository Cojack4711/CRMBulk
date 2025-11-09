<?php
class QuoteItem {
    private $conn;
    private $table = 'quote_items';

    public $id;
    public $quote_id;
    public $description;
    public $quantity;
    public $unit_price;
    public $total_price;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function create() {
        $query = 'INSERT INTO ' . $this->table . ' SET quote_id = :quote_id, description = :description, quantity = :quantity, unit_price = :unit_price, total_price = :total_price';
        $stmt = $this->conn->prepare($query);

        $this->quote_id = htmlspecialchars(strip_tags($this->quote_id));
        $this->description = htmlspecialchars(strip_tags($this->description));
        $this->quantity = htmlspecialchars(strip_tags($this->quantity));
        $this->unit_price = htmlspecialchars(strip_tags($this->unit_price));
        $this->total_price = htmlspecialchars(strip_tags($this->total_price));

        $stmt->bindParam(':quote_id', $this->quote_id);
        $stmt->bindParam(':description', $this->description);
        $stmt->bindParam(':quantity', $this->quantity);
        $stmt->bindParam(':unit_price', $this->unit_price);
        $stmt->bindParam(':total_price', $this->total_price);

        if($stmt->execute()) {
            return true;
        }
        return false;
    }
}
