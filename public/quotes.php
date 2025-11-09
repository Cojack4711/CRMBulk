<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST, GET');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

include_once '../app/controllers/QuoteController.php';

$quoteController = new QuoteController();

$method = $_SERVER['REQUEST_METHOD'];

switch($method) {
    case 'GET':
        $quoteController->index();
        break;
    case 'POST':
        $data = json_decode(file_get_contents("php://input"));
        $quoteController->create($data);
        break;
    default:
        header('HTTP/1.0 405 Method Not Allowed');
        break;
}
