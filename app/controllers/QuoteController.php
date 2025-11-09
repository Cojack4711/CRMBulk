<?php
namespace App\Controllers;

use App\Config\Database;
use App\Models\Quote;
use App\Models\QuoteItem;
use PDO;

class QuoteController {
    public function index() {
        $db = Database::getInstance()->getConnection();
        if(!$db) {
            http_response_code(500);
            echo json_encode(['message' => 'Database connection error']);
            return;
        }
        $quote = new Quote($db);
        $result = $quote->read();
        $num = $result->rowCount();

        if($num > 0) {
            $quotes_arr = array();
            $quotes_arr['data'] = array();

            while($row = $result->fetch(PDO::FETCH_ASSOC)) {
                extract($row);
                $quote_item = array(
                    'id' => $id,
                    'customer_id' => $customer_id,
                    'quote_number' => $quote_number,
                    'status' => $status,
                    'total_amount' => $total_amount,
                    'valid_until' => $valid_until
                );
                array_push($quotes_arr['data'], $quote_item);
            }
            echo json_encode($quotes_arr);
        } else {
            echo json_encode(array('message' => 'No Quotes Found'));
        }
    }

    public function create($data) {
        $db = Database::getInstance()->getConnection();
        if(!$db) {
            http_response_code(500);
            echo json_encode(['message' => 'Database connection error']);
            return;
        }
        $quote = new Quote($db);

        $quote->customer_id = $data->customer_id;
        $quote->quote_number = 'Q' . date('Ymd') . rand(100, 999);
        $quote->status = 'draft';
        $quote->total_amount = $data->total_amount;
        $quote->valid_until = $data->valid_until;

        if($quote->create()) {
            foreach($data->items as $item) {
                $quoteItem = new QuoteItem($db);
                $quoteItem->quote_id = $quote->id;
                $quoteItem->description = $item->description;
                $quoteItem->quantity = $item->quantity;
                $quoteItem->unit_price = $item->unit_price;
                $quoteItem->total_price = $item->quantity * $item->unit_price;
                $quoteItem->create();
            }
            echo json_encode(array('message' => 'Quote Created'));
        } else {
            echo json_encode(array('message' => 'Quote Not Created'));
        }
    }
}
