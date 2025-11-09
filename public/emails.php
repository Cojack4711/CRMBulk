<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST, GET');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

require_once __DIR__ . '/../vendor/autoload.php';

$emailController = new App\Controllers\EmailController();

$method = $_SERVER['REQUEST_METHOD'];

switch($method) {
    case 'GET':
        $emailController->index();
        break;
    case 'POST':
        $data = json_decode(file_get_contents("php://input"));
        $emailController->create($data);
        break;
    default:
        header('HTTP/1.0 405 Method Not Allowed');
        break;
}
