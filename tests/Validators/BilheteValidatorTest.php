<?php

declare(strict_types=1);

namespace Tests\Validators;

use PHPUnit\Framework\TestCase;
use App\Validators\BilheteValidator;
use App\Configs\Config;

class BilheteValidatorTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
    }

    public function testValidateSuccess()
    {
        $data = (object)[
            'sorteio_id' => 1,
            'tripulante_id' => 2,
            'quantidade_dezena' => 8,
            'quantidade_bilhete' => 1
        ];

        $result = BilheteValidator::validate($data);
        $this->assertTrue($result['valid']);
        $this->assertArrayNotHasKey('message', $result);
    }

    public function testValidateMissingFields()
    {
        $data = (object)[
            'sorteio_id' => 1,
            'tripulante_id' => 2,
            'quantidade_dezena' => 5
        ];

        $result = BilheteValidator::validate($data);
        $this->assertFalse($result['valid']);
        $this->assertEquals('Dados incompletos.', $result['message']);
    }

    public function testValidateExceedsDezenas()
    {
        $data = (object)[
            'sorteio_id' => 1,
            'tripulante_id' => 2,
            'quantidade_dezena' => Config::MAX_NUMBERS + 1,  
            'quantidade_bilhete' => 1
        ];

        $result = BilheteValidator::validate($data);
        $this->assertFalse($result['valid']);
        $this->assertEquals('O bilhete deve conter até 10 dezenas.', $result['message']);
    }
 
    public function testValidateLessThanDezenas()
    {
        $data = (object)[
            'sorteio_id' => 1,
            'tripulante_id' => 2,
            'quantidade_dezena' => Config::MIN_NUMBERS - 1, 
            'quantidade_bilhete' => 1
        ];

        $result = BilheteValidator::validate($data);
        $this->assertFalse($result['valid']);
        $this->assertEquals('O bilhete deve conter no mínimo 6 dezenas.', $result['message']);
    }
    
    public function testValidateExceedsBilhetes()
    {
        $data = (object)[
            'sorteio_id' => 1,
            'tripulante_id' => 2,
            'quantidade_dezena' => 8,
            'quantidade_bilhete' => Config::MAX_TICKETS + 1  
        ];

        $result = BilheteValidator::validate($data);
        $this->assertFalse($result['valid']);
        $this->assertEquals('Cada tripulante pode solicitar até 50 bilhetes.', $result['message']);
    }
}
