<?php

namespace App\Services;

use App\Models\Sorteio;
use App\Helpers\NumberHelper;
use App\Configs\Config;


class SorteioService{
    private $db;
    private $sorteio;

    public function __construct($db){
        $this->db = $db;
        $this->sorteio = new Sorteio($db);
    }

    public function create(){
        $numeros = NumberHelper::gerarNumerosAleatorios(true,0); 
        $this->sorteio->setBilhetePremiado($numeros);       
        return $this->sorteio->create();
    }

    public function getAll(){
        return $this->sorteio->getAll();
    }

    public function getById($id){
        return $this->sorteio->getById($id);
    }

}