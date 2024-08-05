<?php
declare(strict_types=1);

namespace App\Helpers;

use App\Configs\Config;

class NumberHelper
{
    private int $minValidNumber;
    private int $maxValidNumber;

    public function __construct(int $minValidNumber, int $maxValidNumber)
    {
        $this->minValidNumber = $minValidNumber;
        $this->maxValidNumber = $maxValidNumber;
    }

    public function gerarNumerosAleatorios(bool $premiado, int $quantidade_dezena = 0): string
    {
        $numeros = [];
        $maxNumbers = $premiado ? Config::MAX_NUMBERS_WINNING : $quantidade_dezena;

        while (count($numeros) < $maxNumbers) {
            $numero = rand($this->minValidNumber, $this->maxValidNumber);
            if (!in_array($numero, $numeros)) {
                $numeros[] = $numero;
            }
        }
        sort($numeros);
        $numeros = array_map(function ($numero) {
            return str_pad((string)$numero, 2, '0', STR_PAD_LEFT);
        }, $numeros);

        return implode(',', $numeros);
    }
}
