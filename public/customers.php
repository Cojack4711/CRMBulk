<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST, GET, PUT, DELETE');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

require_once __DIR__ . '/../vendor/autoload.php';

$customerController = new App\Controllers\CustomerController();

$method = $_SERVER['REQUEST_METHOD'];

switch($method) {
    case 'GET':
        $customerController->index();
        break;
    case 'POST':
        $data = json_decode(file_get_contents("php://input"));
        $customerController->create($data);
        break;
    case 'PUT':
        $data = json_decode(file_get_contents("php://input"));
        $customerController->update($data);
        break;
    case 'DELETE':
        $data = json_decode(file_get_contents("php://input"));
        $customerController->delete($data);
        break;
    default:
        header('HTTP/1.0 405 Method Not Allowed');
        break;
}
