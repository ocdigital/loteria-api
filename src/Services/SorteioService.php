<?php

namespace App\Services;

use App\Models\Sorteio;
use App\Helpers\NumberHelper;

class SorteioService{

    public function __construct(
        private Sorteio $sorteio, 
        private NumberHelper $numberHelper)
    { 
    }

    public function create(){
        $numeros = $this->numberHelper->gerarNumerosAleatorios(true,0); 
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