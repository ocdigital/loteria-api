<?php

require_once __DIR__ . '/vendor/autoload.php';

use App\Database\Connection;

header("Content-Type: application/json; charset=UTF-8");

$uri = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');
$method = $_SERVER['REQUEST_METHOD'];

$db = Connection::getInstance(); 

switch ($uri) {
    case 'tripulantes':
        $controller = new App\Controllers\TripulanteController($db);
        if ($method == 'GET') {
            $controller->index();
        } elseif ($method == 'POST') {
            $controller->create();
        } else {
            http_response_code(405);
            echo json_encode(['error' => '405 - Method Not Allowed']);
        }
        break;    
    case 'bilhetes':
        $controller = new App\Controllers\BilheteController($db);
        if ($method == 'GET') {
            $controller->index();
        } elseif ($method == 'POST') {
            $controller->create();
        } else {
            http_response_code(405);
            echo json_encode(['error' => '405 - Method Not Allowed']);
        }
        break;
    case 'sorteios':
        $controller = new App\Controllers\SorteioController($db);
        if ($method == 'GET') {
            $controller->index();
        } elseif ($method == 'POST') {
            $controller->create();
        } else {
            http_response_code(405);
            echo json_encode(['error' => '405 - Method Not Allowed']);
        }
        break;
    default:
        http_response_code(404);
        echo json_encode(['error' => '404 - Not Found']);
        break;
}
