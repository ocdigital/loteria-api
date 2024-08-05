<?php

namespace App\Services;

use App\Models\Bilhete;
use App\Models\Sorteio;
use App\Helpers\NumberHelper;
use Exception;

class BilheteService
{
    public function __construct(
        private Bilhete $bilhete, 
        private Sorteio $sorteio,
        private NumberHelper $numberHelper)
    {            
    }

    public function getAll(){
        return $this->sorteio->getAll();
    }

    public function create(
        int $sorteio_id,
        int $tripulante_id,
        int $quantidade_dezena, 
        int $quantidade_bilhete,
        bool $premiado = false
    ): string
    {
        $sorteio = $this->sorteio->getById($sorteio_id);
        $bilhetePremiado = array_map('intval', explode(',', $sorteio['bilhete_premiado']));

        $htmlResult = "";

        for ($i = 0; $i < $quantidade_bilhete; $i++) {               
            $numeros = $this->numberHelper->gerarNumerosAleatorios($premiado, $quantidade_dezena);   
            $this->bilhete->setIdSorteio($sorteio_id);  
            $this->bilhete->setIdTripulante($tripulante_id);
            $this->bilhete->setNumeros($numeros);

            $htmlResult .= $this->compararNumerosBilhete($numeros, $bilhetePremiado);

            if (!$this->bilhete->create()) {
                throw new Exception("Erro ao criar bilhete.");
            }
        }
      
        return $this->formataTabela($htmlResult);          
    }

    private function compararNumerosBilhete(string $numeros, array $bilhetePremiado): string
    {
        $numerosBilhete = explode(',', $numeros);
        $numerosBilhete = array_map('intval', $numerosBilhete);
    
        $html = "<tr><td>";
        foreach ($numerosBilhete as $numero) {
            $numero = sprintf('%02d', $numero);
            
            if (in_array($numero, $bilhetePremiado)) {
                $html .= "<span style='color: red; font-weight: bold;'>{$numero}</span> ";
            } else {
                $html .= "{$numero} ";
            }
        }
    
        $html .= "</td></tr>";
        return $html;
    }

    private function formataTabela(string $htmlResult): string
    {
        return "<table><th>Números</th></tr>{$htmlResult}</table>";
    }
}
