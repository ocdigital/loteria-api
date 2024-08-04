<?php
declare(strict_types=1);

namespace App\Validators;

use App\Configs\Config;

class BilheteValidator{
    public static function validate($data) {
        if (!isset($data->sorteio_id, $data->tripulante_id, $data->quantidade_dezena, $data->quantidade_bilhete)) {
            return ['valid' => false, 'message' => 'Dados incompletos.'];
        }

        if ($data->quantidade_dezena > Config::MAX_NUMBERS) {
            return ['valid' => false, 'message' => 'O bilhete deve conter até 10 dezenas.'];
        }     
        
        if ($data->quantidade_bilhete > Config::MAX_TICKETS) {
            return ['valid' => false, 'message' => 'Cada tripulante pode solicitar até 50 bilhetes.'];
        }

        return ['valid' => true];
    }
    
}
