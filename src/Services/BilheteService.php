<?php
declare(strict_types=1);

namespace App\Services;

use App\Models\Bilhete;
use App\Models\Sorteio;
use App\Helpers\NumberHelper;

class BilheteService
{
    private $bilhete;
    private $sorteio;

    public function __construct($db)
    {
        $this->bilhete = new Bilhete($db);
        $this->sorteio = new Sorteio($db);
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
        $bilhetePremiado = explode(',', $sorteio['bilhete_premiado']);
        $bilhetePremiado = array_map('intval', $bilhetePremiado);

        $htmlResult = "<table><th>Números</th></tr>";

        for ($i = 0; $i < $quantidade_bilhete; $i++) {               
            $numeros = NumberHelper::gerarNumerosAleatorios($premiado, $quantidade_dezena);   
            $this->bilhete->setIdSorteio($sorteio_id);  
            $this->bilhete->setIdTripulante($tripulante_id);
            $this->bilhete->setNumeros($numeros);

            $htmlResult .= $this->compararNumerosBilhete($numeros, $bilhetePremiado);

            if (!$this->bilhete->create()) {
                return "Erro ao criar bilhete.";
            } 
        }

        $htmlResult .= "</table>";
        return $htmlResult;        
    }

    /**
     * Função privada para comparar números de bilhetes com o bilhete premiado.
     *
     * @param string $numeros
     * @param array $bilhetePremiado
     * @return string
     */
    private function compararNumerosBilhete(string $numeros, array $bilhetePremiado): string
    {
        $numerosBilhete = explode(',', $numeros);
        $numerosBilhete = array_map('intval', $numerosBilhete);

        $html = "<tr><td>";
        foreach ($numerosBilhete as $numero) {
            if (in_array($numero, $bilhetePremiado)) {
                $html .= "<span style='color: red; font-weight: bold;'>{$numero}</span> ";
            } else {
                $html .= "{$numero} ";
            }
        }

        $html .= "</td></tr>";
        return $html;
    }
}
