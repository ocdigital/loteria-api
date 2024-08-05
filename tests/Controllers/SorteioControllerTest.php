<?php

use PHPUnit\Framework\TestCase;
use App\Controllers\SorteioController;
use App\Services\SorteioService;

class SorteioControllerTest extends TestCase
{
    private $controller;
    private $serviceMock;

    protected function setUp(): void
    {
        parent::setUp();

        $this->serviceMock = $this->createMock(SorteioService::class);

        $this->controller = new SorteioController($this->serviceMock);
    }

    public function testIndexSuccess()
    {
        $this->serviceMock->method('getAll')->willReturn([
            ['id' => 1, 'bilhete_premiado' => '10,20,30'],
            ['id' => 2, 'bilhete_premiado' => '15,25,35']
        ]);

        ob_start();
        $this->controller->index();
        $output = ob_get_clean();

        $expected = json_encode([
            "success" => true,
            "sorteios" => [
                ['id' => 1, 'bilhete_premiado' => '10,20,30'],
                ['id' => 2, 'bilhete_premiado' => '15,25,35']
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
            "message" => "Erro ao buscar sorteios."
        ]);

        $this->assertJsonStringEqualsJsonString($expected, $output);
    }

    public function testCreateSuccess()
    {
        $this->serviceMock->method('create')->willReturn(true);

        ob_start();
        $this->controller->create();
        $output = ob_get_clean();

        $expected = json_encode([
            "success" => true,
            "message" => "Sorteio criado com sucesso!"
        ]);

        $this->assertJsonStringEqualsJsonString($expected, $output);
    }

    public function testCreateFailure()
    {
        $this->serviceMock->method('create')->willReturn(false);

        ob_start();
        $this->controller->create();
        $output = ob_get_clean();

        $expected = json_encode([
            "success" => false,
            "message" => "Não foi possível criar o sorteio."
        ]);

        $this->assertJsonStringEqualsJsonString($expected, $output);
    }

    public function testSetSorteioService()
    {
        $newServiceMock = $this->createMock(SorteioService::class);

        $this->controller->setSorteioService($newServiceMock);

        $reflection = new ReflectionClass($this->controller);
        $property = $reflection->getProperty('sorteioService');
        $property->setAccessible(true);

        $this->assertSame($newServiceMock, $property->getValue($this->controller));
    }
}
