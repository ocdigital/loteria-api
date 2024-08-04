<?php

use PHPUnit\Framework\TestCase;
use App\Controllers\TripulanteController;
use App\Services\TripulanteService;

class TripulanteControllerTest extends TestCase
{
    private $tripulanteServiceMock;
    private $controller;

    protected function setUp(): void
    {

        $dbMock = $this->createMock(\stdClass::class); 
        $this->tripulanteServiceMock = $this->createMock(TripulanteService::class);

        $this->controller = new TripulanteController($dbMock);
        $this->controller->setTripulanteService($this->tripulanteServiceMock);
    }

    public function testTripulantes()
    {

        $expectedResult = [
            ['id' => 1, 'nome' => 'John Doe', 'email' => 'john@example.com'],
            ['id' => 2, 'nome' => 'Jane Doe', 'email' => 'jane@example.com']
        ];

        $this->tripulanteServiceMock->method('getAll')->willReturn($expectedResult);

        ob_start();
        $this->controller->index();
        $output = ob_get_clean();

        var_dump($expectedResult);
        $this->assertJsonStringEqualsJsonString(json_encode($expectedResult), $output);
    }

    public function testTripulantesCreate()
    {
        // Dados de entrada
    $data = new \stdClass();
    $data->nome = 'John Doe';
    $data->email = 'john@example.com';

    // Mock do serviço
    $this->tripulanteServiceMock->method('create')->with($data)->willReturn(true);

    // Mock do request para simular a entrada de dados
    $_POST['nome'] = 'John Doe';
    $_POST['email'] = 'john@example.com';

    // Captura a saída do método create
    ob_start();
    $this->controller->create();
    $output = ob_get_clean();

    // Verifica se a saída é a esperada
    $this->assertJsonStringEqualsJsonString(json_encode(['message' => 'Tripulante criado com sucesso!']), $output);
    }


}
