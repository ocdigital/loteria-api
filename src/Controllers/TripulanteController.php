<?php

namespace App\Controllers;

use App\Services\TripulanteService;

class TripulanteController {
    private $tripulanteService;

    public function __construct($db) {
        $this->tripulanteService = new TripulanteService($db);
    }

    public function index() {
        header("Content-Type: application/json; charset=UTF-8");
        $tripulantes = $this->tripulanteService->getAll();
        
        if ($tripulantes) {
            echo json_encode(array("success" => true, "tripulantes" => $tripulantes));
        } else {
            echo json_encode(array("success" => false, "message" => "Erro ao buscar tripulantes."));
        }
    }

    public function create() {
        header("Content-Type: application/json; charset=UTF-8");
        $data = json_decode(file_get_contents("php://input"));
        
        if ($this->tripulanteService->create($data->nome, $data->email)) {
            echo json_encode(array("success" => true, "message" => "Tripulante criado com sucesso!"));
        } else {
            echo json_encode(array("success" => false, "message" => "Não foi possível criar o tripulante."));
        }
    }
    
    public function setTripulanteService($tripulanteService) {
        $this->tripulanteService = $tripulanteService;
    }
}
