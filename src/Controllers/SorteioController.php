<?php

namespace App\Controllers;


use App\Services\SorteioService;


class SorteioController{
    private $db;
    private $sorteioService;

    public function __construct($db){
        $this->db = $db;
        $this->sorteioService = new SorteioService($db);
    }

    public function index() {
        header("Content-Type: application/json; charset=UTF-8");
        $sorteios = $this->sorteioService->getAll();
        
        if ($sorteios) {
            echo json_encode(array("success" => true, "sorteios" => $sorteios));
        } else {
            echo json_encode(array("success" => false, "message" => "Erro ao buscar tripulantes."));
        }
    }

    public function create(){
        header("Content-Type: application/json; charset=UTF-8");
        if($this->sorteioService->create()){
            echo json_encode(array("success" => true, "message" => "Sorteio criado com sucesso!"));
        } else {
            echo json_encode(array("success" => false, "message" => "Não foi possível criar o sorteio."));
        }
    }
    

}