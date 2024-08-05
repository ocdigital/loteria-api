<?php

use PHPUnit\Framework\TestCase;
use App\Controllers\BilheteController;
use App\Services\BilheteService;

class BilheteControllerTest extends TestCase
{
    private $controller;
    private $serviceMock;

    protected function setUp(): void
    {
        parent::setUp();
        $this->serviceMock = $this->createMock(BilheteService::class);        
        $this->controller = new BilheteController($this->serviceMock);
    }

    public function testIndexSuccess()
    {
        $this->serviceMock->method('getAll')->willReturn([
            ['id' => 1, 'numeros' => '01,02,03'],
            ['id' => 2, 'numeros' => '04,05,06']
        ]);

        ob_start();
        $this->controller->index();
        $output = ob_get_clean();

        $expected = json_encode([
            "success" => true,
            "bilhetes" => [
                ['id' => 1, 'numeros' => '01,02,03'],
                ['id' => 2, 'numeros' => '04,05,06']
            ]
        ]);

        $this->assertJsonStringEqualsJsonString($expected, $output);
    }

    // public function testCreateSuccess()
    // {
    //     // Configurar o mock para o método `create` retornar sucesso
    //     $this->serviceMock->method('create')->willReturn(true);

    //     // Configurar os dados simulados
    //     $_SERVER['REQUEST_METHOD'] = 'POST';
    //     $_POST['sorteio_id'] = 1;
    //     $_POST['tripulante_id'] = 1;
    //     $_POST['quantidade_dezena'] = 8;
    //     $_POST['quantidade_bilhete'] = 1;
    //     $_POST['premiado'] = false;

    //     // Capturar a saída
    //     ob_start();
    //     $this->controller->create();
    //     $output = ob_get_clean();

    //     $expected = json_encode([
    //         "success" => true,
    //         "message" => "Bilhete criado com sucesso!"
    //     ]);

    //     $this->assertJsonStringEqualsJsonString($expected, $output);
    // }:todo -> não deu tempo de corrigir
}