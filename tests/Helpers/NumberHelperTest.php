<?php

use PHPUnit\Framework\TestCase;
use App\Helpers\NumberHelper;

class NumberHelperTest extends TestCase
{
    private $numberHelper;

    protected function setUp(): void
    {
        $maxNumbersWinning = 6;
        $minValidNumber = 1;
        $maxValidNumber = 60;

        $this->numberHelper = new NumberHelper($maxNumbersWinning, $minValidNumber, $maxValidNumber);
    }

    public function testGerarNumerosAleatoriosPremiado()
    {
        $result = $this->numberHelper->gerarNumerosAleatorios(true);
        $numeros = explode(',', $result);

        $this->assertCount(6, $numeros);
        $this->assertEquals(array_unique($numeros), $numeros);
        $this->assertTrue(min($numeros) >= 1 && max($numeros) <= 60);
    }

    public function testGerarNumerosAleatoriosNaoPremiado()
    {
        $result = $this->numberHelper->gerarNumerosAleatorios(false, 5);
        $numeros = explode(',', $result);

        $this->assertCount(5, $numeros);
        $this->assertEquals(array_unique($numeros), $numeros);
        $this->assertTrue(min($numeros) >= 1 && max($numeros) <= 60);
    }

}
