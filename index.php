<?php

require_once __DIR__ . '/vendor/autoload.php';

use App\Database\Connection;
use App\Models\Bilhete;
use App\Models\Sorteio;
use App\Models\Tripulante;
use App\Helpers\NumberHelper;
use App\Configs\Config;
use App\Services\BilheteService;
use App\Services\SorteioService;
use App\Services\TripulanteService;


header("Content-Type: application/json; charset=UTF-8");

$uri = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');
$method = $_SERVER['REQUEST_METHOD'];

$db = Connection::getInstance();
$bilhete = new Bilhete($db);
$sorteio = new Sorteio($db);
$tripulante = new Tripulante($db);
$numberHelper = new NumberHelper(
    Config::MIN_VALID_NUMBER, 
    Config::MAX_VALID_NUMBER
);

$bilheteService = new BilheteService($bilhete, $sorteio, $numberHelper);
$sorteioService = new SorteioService($sorteio, $numberHelper);
$tripulanteService = new TripulanteService($tripulante);

try {
    $controller = match ($uri) {
        'tripulantes' => new App\Controllers\TripulanteController($tripulanteService),
        'bilhetes' => new App\Controllers\BilheteController($bilheteService),
        'sorteios' => new App\Controllers\SorteioController($sorteioService),
        default => throw new Exception('404 - Not Found', 404),
    };

    match ($method) {
        'GET' => $controller->index(),
        'POST' => $controller->create(),
        default => throw new Exception('405 - Method Not Allowed', 405),
    };
} catch (Exception $e) {
    http_response_code($e->getCode());
    echo json_encode(['error' => $e->getMessage()]);
}