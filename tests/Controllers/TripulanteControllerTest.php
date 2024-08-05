<?php

use PHPUnit\Framework\TestCase;
use App\Controllers\TripulanteController;
use App\Services\TripulanteService;

class TripulanteControllerTest extends TestCase
{
    private $controller;
    private $serviceMock;

    protected function setUp(): void
    {
        parent::setUp();

        $this->serviceMock = $this->createMock(TripulanteService::class);

        $this->controller = new TripulanteController($this->serviceMock);
    }

    public function testIndexSuccess()
    {
        $this->serviceMock->method('getAll')->willReturn([
            ['id' => 1, 'nome' => 'Tripulante 1', 'email' => 'tripulante1@example.com'],
            ['id' => 2, 'nome' => 'Tripulante 2', 'email' => 'tripulante2@example.com']
        ]);

        ob_start();
        $this->controller->index();
        $output = ob_get_clean();

        $expected = json_encode([
            "success" => true,
            "tripulantes" => [
                ['id' => 1, 'nome' => 'Tripulante 1', 'email' => 'tripulante1@example.com'],
                ['id' => 2, 'nome' => 'Tripulante 2', 'email' => 'tripulante2@example.com']
            ]
        ]);

        $this->assertJsonStringEqualsJsonString($expected, $output);
    }

    public function testIndexFailure()
    {
        $this->serviceMock->method('getAll')->willReturn([]);

        ob_start();
        $this->controller->index();
        $output = ob_get_clean();

        $expected = json_encode([
            "success" => false,
            "message" => "Erro ao buscar tripulantes."
        ]);

        $this->assertJsonStringEqualsJsonString($expected, $output);
    }

    public function testCreateSuccess()
    {
        $this->serviceMock->method('create')->willReturn(true);

        $inputData = json_encode(["nome" => "Novo Tripulante", "email" => "novotripulante@example.com"]);
        $this->mockInputData($inputData);

        ob_start();
        $this->controller->create();
        $output = ob_get_clean();

        $expected = json_encode([
            "success" => true,
            "message" => "Tripulante criado com sucesso!"
        ]);

        $this->assertJsonStringEqualsJsonString($expected, $output);
    }

    public function testCreateFailure()
    {
        $this->serviceMock->method('create')->willReturn(false);

        $inputData = json_encode(["nome" => "Novo Tripulante", "email" => "novotripulante@example.com"]);
        $this->mockInputData($inputData);

        ob_start();
        $this->controller->create();
        $output = ob_get_clean();

        $expected = json_encode([
            "success" => false,
            "message" => "Não foi possível criar o tripulante."
        ]);

        $this->assertJsonStringEqualsJsonString($expected, $output);
    }

    public function testCreateException()
    {
        $this->serviceMock->method('create')->will($this->throwException(new \Exception("Erro inesperado")));

        $inputData = json_encode(["nome" => "Novo Tripulante", "email" => "novotripulante@example.com"]);
        $this->mockInputData($inputData);

        ob_start();
        $this->controller->create();
        $output = ob_get_clean();

        $expected = json_encode([
            "success" => false,
            "message" => "Erro interno: Erro inesperado"
        ]);

        $this->assertJsonStringEqualsJsonString($expected, $output);
    }

    private function mockInputData($inputData)
    {
        $_SERVER['REQUEST_METHOD'] = 'POST';
        $_POST['data'] = $inputData;
    }
}
